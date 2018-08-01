<html>
    <head>
        <title>Braintree Payment</title>
    </head>
    <body>
        <?php
        include './database.php';
        $db = new Database();
        $cards = $db->getData("SELECT * FROM credit_cards");
        ?>
        <form action="makePayment.php" method="POST">
            <label>Amount:<input type="text" name="amount"></label>
            <ul>
                <?php
                foreach ($cards as $key => $card) {
                    ?>
                    <li><input <?php echo!$key ? 'checked="checked"' : ''; ?> name="token" type="radio" value="<?php echo $card['token']; ?>"><?php echo $card['mask']; ?></li>
                    <?php
                }
                ?>
            </ul>
            <input type="submit">
        </form>
        <a href="addNewCard.php">Add New Card</a>
    </body>
</html>