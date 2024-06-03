<?php
    include 'config.php';
    if ($conn) {
        $family_id = $_POST['family_id'];
        $query = "SELECT login, message FROM chat WHERE family_id = $family_id";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $nick = $row['login'];
                $message = $row['message'];
                echo "<div class='msg-container'>
                <p class='username'>$nick</p>
                <p class='message'>$message</p>
              </div>";
            }
        }
    }
?>
          <?php
            if (!isset($_COOKIE['user'])) {
                header("Refresh: 0; url=login.php");
            } 

        ?>