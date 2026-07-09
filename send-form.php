<?php
/**
 * Atradimai.lt - Static Site PHP Form Handler
 * Handles form submissions from static HTML pages, sends emails, and handles redirects or JSON responses.
 */

// Configuration
define('TO_EMAIL', 'info@atradimai.lt');
define('FROM_EMAIL', 'noreply@atradimai.lt');
define('SUBJECT_PREFIX', '[Atradimai.lt Formos] ');

// Set headers for CORS and response format
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

// Capture request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    exit(0);
}

// Function to clean input data
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check for POST data
if ($method === 'POST') {
    // Get form data
    $name = isset($_POST['name']) ? clean_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? clean_input($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? clean_input($_POST['phone']) : '';
    $message = isset($_POST['message']) ? clean_input($_POST['message']) : '';
    $newsletter = isset($_POST['newsletter']) ? clean_input($_POST['newsletter']) : 'no';
    
    // File upload support (e.g. for dalyvio-sutartis.html)
    $file_attachment = null;
    if (isset($_FILES['contract']) && $_FILES['contract']['error'] === UPLOAD_ERR_OK) {
        $file_attachment = $_FILES['contract'];
    }

    // Determine form source and redirect URL based on referral or post parameter
    $form_subject = 'Bendra užklausa';
    $redirect_url = 'thank-you.html';

    if (isset($_POST['source'])) {
        $source = clean_input($_POST['source']);
        $form_subject = $source;
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
        if ($referer === 'duk.html') {
            $form_subject = 'D.U.K. puslapio registracija';
            $redirect_url = 'registracijos-patvirtinimas.html';
        } elseif ($referer === 'isbandyk-1-treniruote-uz-1-eu.html') {
            $form_subject = '1 € bandomoji registracija';
            $redirect_url = 'registracijos-patvirtinimas-isbandyk.html';
        } elseif ($referer === 'dalyvio-sutartis.html') {
            $form_subject = 'Dalyvio sutarties įkėlimas';
            $redirect_url = 'thank-you.html';
        } elseif ($referer === 'gauk-dovanu-intervizija.html') {
            $form_subject = 'ZipFM Intervizijos dovana';
            $redirect_url = 'thank-you.html';
        } elseif ($referer === 'kontaktai.html' || $referer === 'az-interviu.html') {
            $form_subject = 'Kontaktai / Klausimas';
            $redirect_url = 'thank-you.html';
        }
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Neteisingas el. pašto adresas.']);
            exit;
        } else {
            echo "Klaida: Neteisingas el. pašto adresas.";
            exit;
        }
    }

    // Email Body construction
    $email_body = "Gauta nauja užklausa iš Atradimai.lt svetainės.\n\n";
    $email_body .= "Šaltinis: " . $form_subject . "\n";
    if (!empty($name)) $email_body .= "Vardas, pavardė: " . $name . "\n";
    $email_body .= "El. paštas: " . $email . "\n";
    if (!empty($phone)) $email_body .= "Telefonas: " . $phone . "\n";
    if ($newsletter === 'yes' || $newsletter === 'on') {
        $email_body .= "Naujienlaiškis: Taip, sutinka gauti naujienas.\n";
    }
    if (!empty($message)) {
        $email_body .= "\nŽinutė / Klausimas:\n" . $message . "\n";
    }

    // Email Headers
    $subject = SUBJECT_PREFIX . $form_subject;
    
    // Check if there is a file attachment
    if ($file_attachment) {
        // Multipart email headers for attachment
        $boundary = md5(time());
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From: " . FROM_EMAIL . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

        // Plain text section
        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $email_body . "\r\n";

        // Attachment section
        $file_content = chunk_split(base64_encode(file_get_contents($file_attachment['tmp_name'])));
        $file_name = basename($file_attachment['name']);
        $body .= "--" . $boundary . "\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n\r\n";
        $body .= $file_content . "\r\n";
        $body .= "--" . $boundary . "--";
        
        $mail_sent = mail(TO_EMAIL, $subject, $body, $headers);
    } else {
        // Standard email headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "From: " . FROM_EMAIL . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        
        $mail_sent = mail(TO_EMAIL, $subject, $email_body, $headers);
    }

    // --- Duomenų išsaugojimas (Data Logging) ---
    $data_dir = __DIR__ . '/data';
    if (!is_dir($data_dir)) {
        mkdir($data_dir, 0755, true);
    }
    
    $csv_file = $data_dir . '/submissions.csv';
    $file_exists = file_exists($csv_file);
    
    $log_data = [
        date('Y-m-d H:i:s'),
        time(),
        $form_subject,
        $name,
        $email,
        $phone,
        $message,
        $newsletter,
        $_SERVER['REMOTE_ADDR'] ?? ''
    ];
    
    if ($fp = fopen($csv_file, 'a')) {
        if (!$file_exists) {
            // Write headers if file is new
            fputcsv($fp, ['date', 'submit_time', 'form_name', 'your-name', 'your-email', 'your-phone', 'your-message', 'newsletter', 'Submitted From']);
        }
        fputcsv($fp, $log_data);
        fclose($fp);
    }

    // --- Automatinis atsakiklis (Auto-Responder) ---
    // Siunčiame patvirtinimo laišką vartotojui
    $auto_subject = "Gavome Jūsų užklausą – Atradimai.lt";
    $auto_body = "Sveiki,\n\n";
    
    if (strpos($form_subject, 'registracija') !== false || strpos($form_subject, 'sutarties') !== false) {
        $auto_subject = "Atradimai.lt: Jūsų registracija sėkminga";
        $auto_body .= "Dėkojame už jūsų registraciją / pateiktus dokumentus svetainėje Atradimai.lt.\n";
        $auto_body .= "Netrukus su jumis susisieksime ir pateiksime visą reikalingą informaciją.\n\n";
    } elseif (strpos($form_subject, 'dovana') !== false) {
        $auto_subject = "Atradimai.lt: Jūsų dovana";
        $auto_body .= "Dėkojame už susidomėjimą!\n";
        $auto_body .= "Netrukus su jumis susisieksime ir atsiųsime daugiau informacijos.\n\n";
    } else {
        $auto_body .= "Dėkojame, kad susisiekėte su mumis.\n";
        $auto_body .= "Gavome Jūsų žinutę ir pasistengsime atsakyti kuo greičiau.\n\n";
    }
    
    $auto_body .= "Pagarbiai,\nAtradimai.lt komanda\nhttps://atradimai.lt";
    
    $auto_headers = "MIME-Version: 1.0\r\n";
    $auto_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $auto_headers .= "From: Atradimai.lt <" . FROM_EMAIL . ">\r\n";
    $auto_headers .= "Reply-To: " . TO_EMAIL . "\r\n";
    
    // Siunčiame laišką tik tuo atveju, jeigu pavyko išsiųsti administratoriui ir vartotojas nurodė el. paštą
    if ($mail_sent && !empty($email)) {
        mail($email, $auto_subject, $auto_body, $auto_headers);
    }

    // Respond based on request type
    if (isset($_POST['ajax']) || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
        header('Content-Type: application/json');
        if ($mail_sent) {
            echo json_encode(['success' => true, 'redirect' => $redirect_url]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nepavyko išsiųsti laiško. Bandykite dar kartą.']);
        }
    } else {
        if ($mail_sent) {
            header("Location: " . $redirect_url);
        } else {
            echo "Įvyko klaida siunčiant užklausą. Prašome susisiekti el. paštu: " . TO_EMAIL;
        }
    }
} else {
    header("Location: index.html");
}
