<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

function load_server_config(): void {
    $path = getenv('ATRADIMAI_CONFIG_PATH') ?: '/etc/atradimai/atradimai.env';
    if (!is_readable($path)) {
        throw new RuntimeException('Missing private server configuration.');
    }
    $settings = parse_ini_file($path, false, INI_SCANNER_RAW);
    if (!is_array($settings)) {
        throw new RuntimeException('Invalid private server configuration.');
    }
    foreach ($settings as $key => $value) {
        if (is_string($key) && is_scalar($value) && getenv($key) === false) {
            putenv($key . '=' . (string) $value);
        }
    }
}

function env_required(string $name): string {
    $value = getenv($name);
    if ($value === false || trim($value) === '') {
        throw new RuntimeException("Missing server setting: {$name}");
    }
    return trim($value);
}

function json_response(int $status, array $payload): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function input(string $name, int $max = 3000): string {
    $value = trim((string) ($_POST[$name] ?? ''));
    return mb_substr($value, 0, $max);
}

function ensure_directory(string $path): void {
    if (!is_dir($path) && !mkdir($path, 0700, true) && !is_dir($path)) {
        throw new RuntimeException('Cannot create private data directory.');
    }
}

function rate_limit(string $directory): void {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $file = $directory . '/rate-' . hash('sha256', $ip) . '.json';
    $now = time();
    $history = is_file($file) ? json_decode((string) file_get_contents($file), true) : [];
    $history = array_values(array_filter(is_array($history) ? $history : [], fn ($time) => $time > $now - 3600));
    if (count($history) >= 8) {
        json_response(429, ['success' => false, 'message' => 'Per daug bandymų. Bandykite vėliau.']);
    }
    $history[] = $now;
    file_put_contents($file, json_encode($history), LOCK_EX);
    chmod($file, 0600);
}

function upload_contract(string $directory): ?array {
    if (!isset($_FILES['contract']) || $_FILES['contract']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES['contract'];
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024 || !is_uploaded_file($file['tmp_name'])) {
        json_response(422, ['success' => false, 'message' => 'Nepavyko priimti failo.']);
    }
    $extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
    $allowed = ['pdf' => ['application/pdf'], 'png' => ['image/png'], 'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip']];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($allowed[$extension]) || !in_array($mime, $allowed[$extension], true)) {
        json_response(422, ['success' => false, 'message' => 'Leidžiami tik PDF, PNG ir DOCX failai.']);
    }
    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = $directory . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Cannot store uploaded file.');
    }
    chmod($destination, 0600);
    return ['path' => $destination, 'original_name' => basename((string) $file['name'])];
}

function send_mail(string $recipient, string $replyTo, string $subject, string $body, ?array $attachment): void {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = env_required('SMTP_HOST');
    $mail->Port = (int) env_required('SMTP_PORT');
    $mail->SMTPAuth = true;
    $mail->Username = env_required('SMTP_USERNAME');
    $mail->Password = env_required('SMTP_PASSWORD');
    $mail->SMTPSecure = env_required('SMTP_ENCRYPTION');
    $mail->CharSet = 'UTF-8';
    $mail->setFrom(env_required('MAIL_FROM_EMAIL'), getenv('MAIL_FROM_NAME') ?: 'Atradimai.lt');
    $mail->addAddress($recipient);
    $mail->addReplyTo($replyTo);
    if ($attachment !== null) {
        $mail->addAttachment($attachment['path'], $attachment['original_name']);
    }
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->send();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(405, ['success' => false, 'message' => 'Netinkamas užklausos metodas.']);
}

if (input('website_url') !== '') {
    json_response(200, ['success' => true, 'redirect' => 'thank-you.html']);
}

try {
    load_server_config();
    $autoload = __DIR__ . '/vendor/autoload.php';
    if (!is_file($autoload)) {
        throw new RuntimeException('PHP dependencies are not installed.');
    }
    require_once $autoload;
    $dataDirectory = env_required('FORM_DATA_DIR');
    $uploadDirectory = env_required('FORM_UPLOAD_DIR');
    ensure_directory($dataDirectory);
    ensure_directory($uploadDirectory);
    rate_limit($dataDirectory);

    $email = input('email', 254);
    $name = input('name', 200);
    $phone = input('phone', 100);
    $message = input('message', 3000);
    $source = input('source', 120) ?: 'Bendra užklausa';
    $consent = input('newsletter') === 'yes';
    $consentVersion = input('newsletter_consent_version', 30);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        json_response(422, ['success' => false, 'message' => 'Neteisingas el. pašto adresas.']);
    }

    $redirects = [
        'D.U.K. puslapio registracija' => 'registracijos-patvirtinimas.html',
        '1 € bandomoji registracija' => 'registracijos-patvirtinimas-isbandyk.html',
        'Pagrindinė registracija' => 'registracijos-patvirtinimas.html',
    ];
    $redirect = $redirects[$source] ?? 'thank-you.html';
    $attachment = upload_contract($uploadDirectory);
    $record = [date(DATE_ATOM), $source, $name, $email, $phone, $message, $consent ? 'yes' : 'no', $consentVersion, $_SERVER['REMOTE_ADDR'] ?? ''];
    $logFile = $dataDirectory . '/submissions.csv';
    $newFile = !is_file($logFile);
    $handle = fopen($logFile, 'ab');
    if ($handle === false) {
        throw new RuntimeException('Cannot store submission.');
    }
    if ($newFile) {
        fputcsv($handle, ['submitted_at', 'source', 'name', 'email', 'phone', 'message', 'newsletter_consent', 'consent_version', 'ip']);
    }
    fputcsv($handle, $record);
    fclose($handle);
    chmod($logFile, 0600);

    $body = "Nauja svetainės užklausa\n\nŠaltinis: {$source}\nEl. paštas: {$email}\n";
    if ($name !== '') { $body .= "Vardas: {$name}\n"; }
    if ($phone !== '') { $body .= "Telefonas: {$phone}\n"; }
    if ($message !== '') { $body .= "\nŽinutė:\n{$message}\n"; }
    if ($consent) { $body .= "\nNaujienlaiškio sutikimas: taip ({$consentVersion})\n"; }
    send_mail(env_required('FORM_RECIPIENT_EMAIL'), $email, '[Atradimai.lt] ' . $source, $body, $attachment);

    if ($consent && ($webhook = getenv('NEWSLETTER_WEBHOOK_URL'))) {
        $request = curl_init($webhook);
        curl_setopt_array($request, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => json_encode(['email' => $email, 'name' => $name, 'consent_version' => $consentVersion]), CURLOPT_HTTPHEADER => ['Content-Type: application/json'], CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10]);
        curl_exec($request);
        curl_close($request);
    }
    json_response(200, ['success' => true, 'redirect' => $redirect]);
} catch (\Throwable $exception) {
    error_log('Atradimai form error: ' . $exception->getMessage());
    json_response(503, ['success' => false, 'message' => 'Formos šiuo metu nepavyko išsiųsti. Bandykite vėliau arba parašykite mums el. paštu.']);
}
