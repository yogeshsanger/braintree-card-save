<html>
    <head>
        <title>Add New Card</title>
    </head>
    <body>
        <form method="POST">
            <label>Card Holder Name<input type="text" name="name"></label><br>
            <label>Card No.<input type="text" name="number"></label><br>
            <label>CVV.<input type="text" name="cvv"></label><br>
            <label>Exp. Month
                <select name="month">
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </label><br>
            <label>Exp. Year
                <select name="year"
                        <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                </select>
            </label><br>
            <input type="submit">
        </form>
    </body>
</html>
<?php
if ($_POST) {
    if (empty($_POST['name']) || empty($_POST['number']) || empty($_POST['cvv']) || empty($_POST['month']) || empty($_POST['year'])) {
        return false;
    }
    require_once './braintree/lib/Braintree.php';
    include './database.php';
    $db = new Database();
    Braintree_Configuration::environment('sandbox');
    Braintree_Configuration::merchantId('merchantId');
    Braintree_Configuration::publicKey('publicKey');
    Braintree_Configuration::privateKey('privateKey');
    $name = array_filter(explode(' ', $_POST['name']));
    try {
        $result = Braintree_Customer::create([
                    'firstName' => reset($name),
                    'lastName' => end($name),
                    'email' => '',
                    'phone' => '',
                    'creditCard' => [
                        'cardholderName' => $_POST['name'],
                        'number' => $_POST['number'],
                        'expirationMonth' => $_POST['month'],
                        'expirationYear' => $_POST['year'],
                        'cvv' => $_POST['cvv'],
                        'billingAddress' => array(
                            'firstName' => reset($name),
                            'lastName' => end($name),
                        ),
                        'options' => array(
                            'verifyCard' => true
                        )
                    ]
        ]);
        if ($result->success) {
            $db->insertData('INSERT INTO credit_cards SET mask ="'.$result->customer->creditCards[0]->maskedNumber.'", token="'.$result->customer->creditCards[0]->token.'"');
            header('Location: http://localhost/braintreeDemo/');
            die;
        } else {
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
}
?>
