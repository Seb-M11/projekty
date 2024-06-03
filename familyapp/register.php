<!DOCTYPE html>
<?php
if (isset($_COOKIE['user'])) {
    header("Refresh: 0; url='index.php'");
}
?>
<html>

<head>
    <meta name='viewport' content="width=device-width, initial-scale=1.0">
    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="icon192.png" type="image/x-icon">
</head>

<body>
    <div class="logo">
        <a href="login.php">FamilyApp</a>
    </div>
    <div class="login">
        <label>Create a new account</label><br>
        <form action='' method='POST'>
            <input type='text' name='login' class="input" placeholder="Login">
            <input type='password' name='pass' class="input"
            placeholder="Password">
            <input type='submit' name='submit' value='Sign Up' class="signup">
            <?php
            include 'config.php';
            if (!empty($_POST['login']) && !empty($_POST['pass'])) {
                if ($conn) {
                    $log = $_POST['login'];
                    $i = 0;
                    $queryCheck = "SELECT login FROM users;";
                    $result = mysqli_query($conn, $queryCheck);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($log == $row['login']) {
                                $i++;
                            }
                        }
                    }
                    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    if ($i > 0) {
                        echo "Istnieje juz użytkownik z taką nazwą";
                    } else {
                        $token = password_hash($log, PASSWORD_DEFAULT);
                        $query = "INSERT INTO users (login, pass, token, points) VALUES ('$log', '$pass', '$token', 0)";
                        if (mysqli_query($conn, $query)) {
                            $sql = "INSERT INTO gl (login) VALUES ('$log')";
                            $conn->query($sql);
                            echo "<script>
                            location.href = 'login.php';
                            </script>";
                        }
                    }
                }
            } else {
                if (isset($_POST['login']) || isset($_POST['pass'])) {
                    echo "Wprowadź wszystkie dane";
                }
            }
            ?>
        </form>
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