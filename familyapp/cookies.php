<?php
    if (isset($_POST['log'])) {
        $uzytkownik = $_POST['log'];
        setcookie('user', $uzytkownik, time() + (86400 * 30), '/');
        unset($_POST['log']);
        $sec = "0";
        $page = $_SERVER['PHP_SELF'];
        header("Refresh: $sec; url=$page");
    }
?>