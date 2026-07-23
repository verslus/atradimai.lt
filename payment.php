<?php
declare(strict_types=1);

$paymentUrl = getenv('PAYSERA_PAYMENT_URL') ?: '';
$parts = parse_url($paymentUrl);
if (($parts['scheme'] ?? '') !== 'https' || empty($parts['host'])) {
    http_response_code(503);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><meta charset="utf-8"><title>Mokėjimas laikinai nepasiekiamas</title><p>Mokėjimo paslauga dar nesukonfigūruota. Susisiekite el. paštu info@atradimai.lt.</p>';
    exit;
}
header('Location: ' . $paymentUrl, true, 303);
exit;
