<html>
  <head>
    <meta charset="utf-8" />
    <title>FamilyApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="icon192.png" type="image/x-icon">
  </head>
  <body>
    <div class="logo">
      <a href = 'index.php'><h1 class="title">FamilyApp</h1></a>
    </div>
    <div class='login'>
        <form action = '' method = 'post'>
            <label>Nazwa rodziny</label>
            <input type = 'text' class = 'input' name = 'name'>
            <input type = 'submit' class = 'submit' value = 'send'>
        </form>
        <?php
            include 'config.php';
            if ($conn) {
                    $token = $_COOKIE['user'];
                    $query1 = "SELECT id, login, family_id FROM users WHERE token = '$token'";
                    $result = mysqli_query($conn, $query1);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $idZalozyciela = $row['id'];
                        $family_id = $row['family_id'];
                        $login = $row['login'];
                    }
                    if ($family_id) {
                        echo "<script>
                        location.href = 'family.php';
                        </script>";   
                    } else {
                        if ($idZalozyciela && isset($_POST['name'])) {
                            $nazwa = $_POST['name'];
                            $queryAdd = "INSERT INTO families (family_name, id_zalozyciela) VALUES ('$nazwa', $idZalozyciela);";
                            mysqli_query($conn,  $queryAdd);
                            $queryGet = "SELECT id FROM families WHERE id_zalozyciela = $idZalozyciela";
                            $resultGet = mysqli_query($conn, $queryGet);
                            $rowGet = mysqli_fetch_assoc($resultGet);
                            $familyid = $rowGet['id'];
                            $querySet = "UPDATE users SET family_id = $familyid WHERE id = $idZalozyciela";
                            $upt = "UPDATE gl SET family_id = $familyid WHERE login = '$login'";
                            $conn->query($upt);
                            if (mysqli_query($conn, $querySet)) {
                                echo "<script>
                                location.href = 'family.php';
                                </script>"; 
                            }
                        }
                    }
                mysqli_close($conn);
            }
            echo "Jezeli nie chcesz tworzyć rodziny poproś kogoś aby dodał cię do własnej"
        ?>
    </div>
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