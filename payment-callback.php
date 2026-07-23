<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/server-config.php';

try {
    atradimai_load_server_config();
    require_once __DIR__ . '/vendor/autoload.php';
    $response = WebToPay::validateAndParseData(
        $_REQUEST,
        (int) atradimai_env_required('PAYSERA_PROJECT_ID'),
        atradimai_env_required('PAYSERA_SIGN_PASSWORD')
    );
    $orderId = (string) ($response['orderid'] ?? '');
    if (!preg_match('/^ATR-[0-9]{14}-[a-f0-9]{12}$/', $orderId)) {
        throw new RuntimeException('Invalid order id.');
    }
    $orderFile = rtrim(atradimai_env_required('PAYSERA_ORDER_DIR'), '/') . '/' . $orderId . '.json';
    $order = is_file($orderFile) ? json_decode((string) file_get_contents($orderFile), true, 512, JSON_THROW_ON_ERROR) : null;
    if (!is_array($order)) {
        throw new RuntimeException('Unknown order.');
    }
    $receivedAmount = (int) ($response['payamount'] ?? $response['amount'] ?? 0);
    $receivedCurrency = (string) ($response['paycurrency'] ?? $response['currency'] ?? '');
    if ($receivedAmount !== (int) $order['amount'] || $receivedCurrency !== $order['currency']) {
        throw new RuntimeException('Payment amount mismatch.');
    }
    if (in_array((string) ($response['status'] ?? ''), ['1', '3'], true)) {
        $order['status'] = 'paid';
        $order['paid_at'] = gmdate(DATE_ATOM);
        file_put_contents($orderFile, json_encode($order, JSON_THROW_ON_ERROR), LOCK_EX);
        chmod($orderFile, 0600);
    }
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'OK';
} catch (Throwable $exception) {
    error_log('Atradimai Paysera callback error: ' . $exception->getMessage());
    http_response_code(400);
    echo 'ERROR';
}
