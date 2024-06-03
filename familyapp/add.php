<html>
  <head>
    <meta charset="utf-8" />
    <title>FamilyApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="icon192.png" type="image/x-icon">
  </head>
  <body>
  <?php
            if (!isset($_COOKIE['user'])) {
                header("Refresh: 0; url=login.php");
            } 

        ?>
    <div class="logo">
      <h1 class="title"><a href="index.php">FamilyApp</a></h1>
    </div>
    <div class="main-add">
      <form action = '' method = 'post'>
        <label>Title</label>
        <input name = 'title' class="input" required/>
        <label>Description</label>
        <textarea name = 'desc' maxlength="240"></textarea>
        <label>Time</label>
        <div>
            <input class="input" name = 'time' type="time"/>
            <input class="input" name = 'date' type="date" min="<?php echo date("Y-m-d"); ?>"/>
        </div>
            <label>User</label>
            <input class="input" type='text' name = 'a' id = 'a' value = '' onclick='show()' readonly>
            <?php
                include 'config.php';
                date_default_timezone_set("Poland");
                $token = $_COOKIE['user'];
                $query1 = "SELECT family_id, id FROM users WHERE token = '$token'";
                $result1 = mysqli_query($conn, $query1);
                if (mysqli_num_rows($result1) > 0) {
                  while($row = mysqli_fetch_assoc($result1)) {
                      $family_id = $row['family_id'];
                  }
                }
                if (!$family_id) {
                    echo "<script>
                    location.href = 'family.php';
                    </script>";
                } else {
                $query2 = "SELECT login FROM users WHERE family_id = $family_id";
                $result2 = mysqli_query($conn, $query2);
                if (mysqli_num_rows($result2) > 0) {
                  $i = 0;
                  echo "<div id='list' class='list' style = 'opacity: 1;'>";
                  while($row = mysqli_fetch_assoc($result2)) {
                      $i++;
                      $login = $row['login'];
                      echo "<input class = 'add-user' onclick='user(event)' type = 'text' value = '$login' id = 'i$i' readonly>";
                  }
                  echo "</div>";
                }
            ?>
            <input class = 'submit' type = 'submit' value = 'Send'>
            <?php
                if (!empty($_POST['title']) && !empty($_POST['desc']) && !empty($_POST['time']) && !empty($_POST['date']) && !empty($_POST['a'])) {
                    $title = $_POST['title'];
                    $desc = $_POST['desc'];
                    $datetime = $_POST['date'] . " " . $_POST['time'];
                    $a = $_POST['a'];
                    $query4 = "SELECT id FROM users WHERE login = '$a'";
                    $result4 = mysqli_query($conn, $query4);
                    if (mysqli_num_rows($result4) > 0) {
                        while($row = mysqli_fetch_assoc($result4)) {
                            $id2 = $row['id'];
                        }
                    }   
                    $query3 = "INSERT INTO quests (title, description, dt, user_id, family_id) VALUES ('$title', '$desc', '$datetime', $id2, $family_id)";
                    if (mysqli_query($conn, $query3)) {
                        echo "<script>
                        location.href = 'index.php';
                        </script>";
                    } else {
                        echo "bruh";
                    }
                } else {
                    if (isset($_POST['title']) || isset($_POST['desc']) || isset($_POST['time']) || isset($_POST['date']) || isset($_POST['a'])) {
                        echo "Wprowadź wszystkie dane";
                    }
                }
            }
      ?>
      </form>
    </div>
    <script>
        function user(event) {
            document.getElementById('a').value = document.getElementById(event.target.id).value;
        }
    </script>
    <script>
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
  </body>
</html>
