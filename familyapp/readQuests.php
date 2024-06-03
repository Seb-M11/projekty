<?php
    include 'config.php';
    date_default_timezone_set("Europe/Warsaw"); 

    if ($conn) {
        $token = $_COOKIE['user'];
        $q1 = "SELECT id FROM users WHERE token = '$token'";
        $r1 = mysqli_query($conn, $q1);
        if (@mysqli_num_rows($r1) > 0) {
            $row1 = mysqli_fetch_assoc($r1);
            $Userid = $row1['id'];
        }
        $query = "SELECT id, title, description, dt FROM quests WHERE user_id = $Userid";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['title'];
                $description = $row['description'];
                $dt = $row['dt'];
                $date = strtotime($dt);
                $currdate = time(); 
                $questid = $row['id'];

                if ($date > $currdate) {
                    echo "<div class = 'element'>
                        <h2 class = 'element-title'>$title</h2>
                        <p class = 'element-description'>$description</p>
                        <p class = 'element-time'>Termin: $dt</p>
                        <form action = '' method = 'post'>
                        <input type = 'hidden' value = '$questid' name = 'finished'>
                        <input class='signup' type = 'submit' value = 'Ukończ zadanie'>
                        </form>
                        </div>";
                    $i++;
                    if ($i != mysqli_num_rows($result)) {
                        echo "";
                    }
                } else {
                    $queryRemoveQuest = "DELETE FROM quests WHERE id = $questid;";
                    $queryPoints = "UPDATE users SET points = points - 1 WHERE token = '$token'";
                    if (mysqli_query($conn, $queryRemoveQuest) && mysqli_query($conn, $queryPoints)) {
                        echo "<script>
                        location.reload();
                        </script>";
                    }
                }
            }     
        }
        mysqli_close($conn);
    }
?>
