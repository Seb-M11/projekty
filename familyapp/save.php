<?php
    if (isset($_POST['nick']) && isset($_POST['tekst']) && isset($_POST['family_id'])) {
        $wiadomosc = htmlspecialchars($_POST['tekst']);
        $nick = htmlspecialchars($_POST['nick']);
        $family_id = $_POST['family_id'];
        include 'config.php';
        if ($conn) {
            $query = "INSERT INTO chat (login, message, family_id) VALUES ('$nick', '$wiadomosc', $family_id)";
            if (mysqli_query($conn, $query)) {
                echo "<div class='msg-container'>
                <p class='username'>$nick</p>
                <p class='message'>$wiadomosc</p>
              </div>";
            } else {
                echo 'error';
            }
        } 
    }
?>
          <?php
            if (!isset($_COOKIE['user'])) {
                header("Refresh: 0; url=login.php");
            } 

        ?>