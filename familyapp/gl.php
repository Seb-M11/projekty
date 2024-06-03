<?php 
include "config.php";
$date = $_POST['date'];
$gl = $_POST['gl'];
$lat = $_POST['lat'];
$long = $_POST['long'];

$token = $_COOKIE['user'];
$q1 = "SELECT login FROM users WHERE token = '$token'";
$r1 = mysqli_query($conn, $q1);
if (@mysqli_num_rows($r1) > 0) {
     while ($row1 = mysqli_fetch_assoc($r1)) {
        $login = $row1['login'];
    }
}
            
echo $date . " " . $gl . " " . "$login" . " " . $lat . " " . "$long";


$sql = "UPDATE gl SET date='$date', gl='$gl',latitude='$lat', longitude='$long' WHERE login='$login'";
$conn->query($sql);


$conn->close();


?>
