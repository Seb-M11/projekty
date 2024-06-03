<?php
    if (isset($_POST['logout'])) {
        setcookie('user', 'breeeh', time() - 3600, '/');
        unset($_POST['logout']);
        header("Refresh: 0; url='login.php'");
    }
?>