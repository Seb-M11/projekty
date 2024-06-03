<html>

<head>
  <meta charset="utf-8">
  <title>FamilyApp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="icon192.png" type="image/x-icon">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

  <div class="header-container">
    <div class="header">
      <a onclick="hideDropdown()" class="icon-link"><img id="menu_icon" src="img/menu_icon.svg" width="50px"
          alt="menu" /></a>
      <h1 class="title">FamilyApp</h1>
    </div>
    <div class="dropdown">
      <div class="dropdown-content">
        <div class="dropdown-div"><img src="img/user_icon.svg" alt="user">

          <?php
          include 'config.php';
          include 'keys.php';
          $opencagekey = OPEN_CAGE_KEY;
          $mapboxkey = MAPBOX_KEY;
          if ($conn) {
            $token = $_COOKIE['user'];
            $q1 = "SELECT id, login FROM users WHERE token = '$token'";
            $r1 = mysqli_query($conn, $q1);
            if (@mysqli_num_rows($r1) > 0) {
              while ($row1 = mysqli_fetch_assoc($r1)) {
                $login = $row1['login'];
                $id = $row1['id'];
              }
              echo '<p>' . $login . '#' . $id . '</p>';
            }
          }
          ?>
        </div>
        <div class="dropdown-div">
          <?php
          if (!isset($_COOKIE['user'])) {
            header("Refresh: 0; url=login.php");
          } else {
            echo "
                <img src='img/switch_icon.svg' alt='log out'>
                <form action = 'logout.php' method='post'>
                      <input class = 'log-in-out' type = 'submit' value = 'Log out' name = 'logout'> 
                      </form>";
          }

          ?>
        </div>
        <div class="dropdown-div" onclick='changeTheme()'>
          <img src="img/dark_mode_icon.svg" alt="user">
          <p>Change color theme</p>
        </div>
      </div>
    </div>
  </div>
  <div id='main' class="main">
    <?php
    if ($conn) {
      if (isset($_POST['finished'])) {
        $finishedId = $_POST['finished'];
        $queryFinish = "DELETE FROM quests WHERE id = $finishedId";
        $queryPoints = "UPDATE users SET points = points + 1 WHERE token = '$token'";
        if (mysqli_query($conn, $queryFinish) && mysqli_query($conn, $queryPoints)) {
          unset($_POST['finished']);
          echo "<script>
                        location.href = 'index.php';
                        </script>";
        }
      }
    }
    ?>
  </div>
  <script>
    const openCageKey = '<?= $opencagekey ?>';
    let dropdown_mode = 0;
    const dropdown_height = document.getElementsByClassName("dropdown-div").length * 48;

    function hideDropdown() {
      let dropdown = document.getElementsByClassName("dropdown")[0];

      if (dropdown_mode == 1) {
        dropdown.style.height = "0px";
        dropdown_mode = 0;
      } else {
        dropdown.style.height = dropdown_height + "px";
        dropdown_mode = 1;
      }

    }

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(geoSucc);
    }
    function geoSucc(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;
      var date = new Date();
      date.setHours(date.getHours() + 2);
      var isodate = date.toISOString().slice(0, 19).replace("T", " ")
      fetch(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=${openCageKey}`)
        .then(response => response.json())
        .then(data =>
          $.post("gl.php",
            {
              date: isodate,
              gl: data["results"][0]["formatted"],
              lat: latitude,
              long: longitude
            },
            function (data, status) {
              console.log(data);
            }))
    }
    function read() {
      fetch('readQuests.php').then(function (response) {
        return response.text();
      }).then(function (response) {
        document.getElementById('main').innerHTML = response;
      });
    }
    setInterval(read, 1000);

  </script>
  <?php
  mysqli_close($conn);
  ?>
  <footer>
    <a href='czat.php'>
      <p><img src="img/czat_icon.svg" alt="chat"><span>Chat</span></p>
    </a>
    <a href='add.php'>
      <p><img src="img/tasks_icon.svg" alt="tasks"><span>Tasks</span></p>
    </a>
    <a href='family.php'>
      <p><img src="img/home_icon.svg" alt="family"><span>Family</span></p>
    </a>
    <a href='lokalizacja.php'>
      <p><img src="img/location_icon.svg" alt="location"><span>Location</span></p>
    </a>
  </footer>
  <script>
    let c_length = document.cookie.length;
    let color_theme = document.cookie[c_length - 1];

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
</body>

</html>