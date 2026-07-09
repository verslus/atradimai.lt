<meta name="verify-paysera" content="8005fcf48eb0a46044b5a34ef250e816">
<?php
 
require_once('WebToPay.php');
 
function get_self_url() {
    $s = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0,
                strpos($_SERVER['SERVER_PROTOCOL'], '/'));
 
    if (!empty($_SERVER["HTTPS"])) {
        $s .= ($_SERVER["HTTPS"] == "on") ? "s" : "";
    }
 
    $s .= '://'.$_SERVER['HTTP_HOST'];
 
    if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
        $s .= ':'.$_SERVER['SERVER_PORT'];
    }
 
    $s .= dirname($_SERVER['SCRIPT_NAME']);
 
    return $s;
}
 
try {
    $self_url = get_self_url();
 
    $request = WebToPay::redirectToPayment(array(
        'projectid'     => 69154,
        'sign_password' => 'fc23b5db09f447a88f995540924726bc',
        'orderid'       => 0,
        'amount'        => 13100,
        'currency'      => 'EUR',
        'country'       => 'LT',
        'accepturl'     => 'http://atradimai.lt/registracija-sekminga/',
        'cancelurl'     => 'http://atradimai.lt/registracija-nutraukta/',
        'callbackurl'   => $self_url.'/callback.php',
        'test'          => 0,
    ));
} catch (WebToPayException $e) {
    // handle exception
} 
				