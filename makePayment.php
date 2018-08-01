<?php
require_once './braintree/lib/Braintree.php';
Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('merchantId');
Braintree_Configuration::publicKey('publicKey');
Braintree_Configuration::privateKey('privateKey');
if (isset($_POST['amount']) && !empty($_POST['amount'])) {
    $result = Braintree_PaymentMethodNonce::create($_POST['token']);
    $nonce = $result->paymentMethodNonce->nonce;
    $result_new = Braintree_Transaction::sale(array(
                'amount' => number_format($_POST['amount'], 2, '.', ''), //total amomount
                'merchantAccountId' => 'signitysolutions',
                'paymentMethodNonce' => $nonce,
                'options' => array('submitForSettlement' => true)
    ));
    echo '<pre>';
    print_r($result_new);
    echo '</pre>';
}
