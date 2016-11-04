<?php
    require_once '../../include.php';
    $cardNumber=isset($_REQUEST['cardNumber'])?(int)$_REQUEST['cardNumber']:null;
    if($cardNumber==null)
        echo '';
    else{
        $cardType = getCardTypeForCardNumber($cardNumber);
        echo $cardType;
    }

?>