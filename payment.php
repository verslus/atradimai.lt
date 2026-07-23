<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/server-config.php';

function payment_error(): never {
    http_response_code(503);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html lang="lt"><meta charset="utf-8"><title>Mokėjimas nepasiekiamas</title><p>Mokėjimo šiuo metu pradėti nepavyko. Parašykite mums el. paštu.</p></html>';
    exit;
}

function payment_origin(): string {
    $origin = rtrim(atradimai_env_required('SITE_ORIGIN'), '/');
    if (filter_var($origin, FILTER_VALIDATE_URL) === false || !str_starts_with($origin, 'https://')) {
        throw new RuntimeException('SITE_ORIGIN must be an HTTPS URL.');
    }
    return $origin;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        exit;
    }
    atradimai_load_server_config();
    require_once __DIR__ . '/vendor/autoload.php';

    $orderDirectory = atradimai_env_required('PAYSERA_ORDER_DIR');
    if (!is_dir($orderDirectory) && !mkdir($orderDirectory, 0700, true) && !is_dir($orderDirectory)) {
        throw new RuntimeException('Cannot create payment order directory.');
    }
    $amount = (int) atradimai_env_required('PAYSERA_AMOUNT_CENTS');
    $currency = atradimai_env_required('PAYSERA_CURRENCY');
    if ($amount <= 0 || !preg_match('/^[A-Z]{3}$/', $currency)) {
        throw new RuntimeException('Invalid payment amount or currency.');
    }
    $orderId = 'ATR-' . gmdate('YmdHis') . '-' . bin2hex(random_bytes(6));
    $order = ['order_id' => $orderId, 'amount' => $amount, 'currency' => $currency, 'status' => 'pending', 'created_at' => gmdate(DATE_ATOM)];
    $orderFile = $orderDirectory . '/' . $orderId . '.json';
    if (file_put_contents($orderFile, json_encode($order, JSON_THROW_ON_ERROR), LOCK_EX) === false) {
        throw new RuntimeException('Cannot save payment order.');
    }
    chmod($orderFile, 0600);

    $origin = payment_origin();
    WebToPay::redirectToPayment([
        'projectid' => (int) atradimai_env_required('PAYSERA_PROJECT_ID'),
        'sign_password' => atradimai_env_required('PAYSERA_SIGN_PASSWORD'),
        'orderid' => $orderId,
        'amount' => $amount,
        'currency' => $currency,
        'country' => 'LT',
        'paytext' => 'Atradimai.lt programa',
        'accepturl' => $origin . '/payment-success.html',
        'cancelurl' => $origin . '/payment-cancelled.html',
        'callbackurl' => $origin . '/payment-callback.php',
        'test' => (int) (getenv('PAYSERA_TEST') ?: '0'),
    ], true);
} catch (Throwable $exception) {
    error_log('Atradimai payment setup error: ' . $exception->getMessage());
    payment_error();
}
