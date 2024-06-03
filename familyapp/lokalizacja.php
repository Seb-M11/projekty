<!DOCTYPE html>
<html>

<head>
    <title>FamilyApp</title>
    <meta name='viewport' content='initial-scale = 1.0, width = device-width'>
    <link rel="icon" href="icon192.png" type="image/x-icon">
</head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
<link rel="stylesheet" href="style.css">
<div class="header">
    <a href='index.php'>
        <h1 class="title">FamilyApp</h1>
    </a>
</div>

<?php
include "config.php";
include 'keys.php';
$opencagekey = OPEN_CAGE_KEY;
$mapboxkey = MAPBOX_KEY;

$token = $_COOKIE['user'];
$q1 = "SELECT login FROM users WHERE token = '$token'";
$r1 = mysqli_query($conn, $q1);
if (@mysqli_num_rows($r1) > 0) {
    while ($row1 = mysqli_fetch_assoc($r1)) {
        $login = $row1['login'];
    }
}

$fi = "SELECT family_id FROM gl WHERE login='$login'";
$result = $conn->query($fi);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $family_id = $row['family_id'];
    }
} else {
    echo "błąd";
}

$sql = "SELECT date, gl, login, latitude, longitude FROM gl WHERE family_id='$family_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lat = $row["latitude"];
        $long = $row["longitude"];
        $gl = $row["gl"];
        $login = $row["login"];
        $data = $row["date"];
        //echo "login: " . $row["login"] . "<br>" . "ostatnia lokalizacja: " . $row["gl"] . "<br>" . "data: " . $row["date"] . "<br><br>";
        echo 
        "<div class='family-container'>
            <h3>$login</h3>
            <p>$gl</p><br>
            <p>$data</p>
        </div>";
    }
} else {
    echo "      
    <div class= 'family-name'>
    <div class ='family-container'>
    <b><a href = 'createFamily.php'>Utwórz swoją rodzinę</a></b>
    <p>lub poczekaj aż ktoś cie zaprosi</p></div>
    </div>";
}


$count = "SELECT COUNT(*) AS ile FROM gl WHERE family_id = '$family_id'";
$result = $conn->query($count);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ile = $row['ile'];
    }
}

$latlong = mysqli_query($conn, "SELECT login, latitude, longitude FROM gl WHERE family_id = '$family_id'");
while ($row = mysqli_fetch_array($latlong)) {
    $lati[] = $row['latitude'];
    $longi[] = $row['longitude'];
}




$conn->close();
?>

<br>
<div id="map" style="height:500px; width:100%;"></div>
<script>
    const openCageKey = '<?= $opencagekey ?>';
    const mapBoxKey = '<?= $mapboxkey ?>';
    var ile = '<?= $ile ?>';
    var lati = <?php echo json_encode($lati); ?>;
    for (var i = 0; i < lati.length; i++) {
        this["lati" + i] = lati[i];
    }
    var longi = <?php echo json_encode($longi); ?>;
    for (var i = 0; i < longi.length; i++) {
        this["longi" + i] = longi[i];
    }

    var map = L.map('map').setView([49.6333308, 20.7166638], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2ViaW5obyIsImEiOiJjbDB4dGQzdGEwOWNtM2lvMWNqNjR1NzloIn0.q9JyLxHUFAS6Mbe_8nxbzQ', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 20,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: mapBoxKey
    }).addTo(map);

    var markers = [];


    for (var i = 0; i < ile; i++) {
        this["marker" + i] = L.marker([lati[i], longi[i]]).addTo(map);
        markers.push(this["marker" + i]);
    }


    console.log(markers[0])

    markers.forEach(myFunction);

    function myFunction(marker) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(geoSucc);
        }


        function geoSucc(position) {
            var latitude = marker['_latlng']['lat'];
            var longitude = marker['_latlng']['lng'];
            fetch(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=${openCageKey}`)
                .then(response => response.json())
                .then(data => marker.bindPopup(data["results"][0]["formatted"]).openPopup())
        };
    }


     let c_length = document.cookie.length;
     let color_theme = document.cookie[c_length-1];

      function changeTheme() {
        if (color_theme == 1) color_theme = 0
        else color_theme = 1;
        colorTheme();
        document.cookie = "theme =" + color_theme + "; expires=Fri,  Sun, 31 Jan 2100 12:00:00 UTC;" + "path=/";
      }

      let root = document.documentElement;

      function colorTheme() {
        if (color_theme == 0) {
          root.style.setProperty('--main-bg-color', "#232323");
          root.style.setProperty('--secondary-bg-color', "#2b2b2b");
          root.style.setProperty('--third-bg-color', "#313131");
          root.style.setProperty('--font-color', "#eee");
          root.style.setProperty('--bg-rgba', "rgba(33, 33, 33, 0.8)");
          root.style.setProperty('--invert', "1");
        } else {
          root.style.setProperty('--main-bg-color', "#fff");
          root.style.setProperty('--secondary-bg-color', "#eee");
          root.style.setProperty('--third-bg-color', "#ddd");
          root.style.setProperty('--font-color', "#333");
          root.style.setProperty('--bg-rgba', "rgba(255, 255, 255, 0.8)");
          root.style.setProperty('--invert', "0");
        }
      }
      
        window.onload(colorTheme());
    
</script>

</html>