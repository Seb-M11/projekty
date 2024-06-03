<!DOCTYPE html>
<?php
    if (isset($_COOKIE['user'])) {
        echo "<script>
        location.href = 'index.php';
        </script>";
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>FamilyApp</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="icon192.png" type="image/x-icon">
    </head>
    <body>
        <div class="logo">
            FamilyApp
        </div>
        <div class="login">
            <label>Sign in to your account</label><br>
            <form action = '' method = 'post'>
                <input class="input" type="text" name="login" placeholder="Login">
                <input class="input" type="password" name="pass" placeholder="Password">
                <input class="signin" type="submit" value = 'Sign in'>
            </form>
            <hr>
            <label>Create a new account</label><br>
            <a href='register.php'><button class="signup">Sign up</button></a>
        <?php
            include 'config.php';
            if (!empty($_POST['login']) && !empty($_POST['pass'])) {
                if ($conn) {
                    $query = "SELECT login, pass, token FROM users";
                    $result = mysqli_query($conn, $query);
                    $i = 0;
                    $j = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row["login"] == $_POST['login']) {
                                if (password_verify($_POST['pass'], $row['pass'])) {
                                    $i++;
                                    $token = $row['token'];
                                } else {
                                    echo "Źle wprowadzone hasło";
                                    $j++;
                                }
                            }
                        }
                        if ($i == 1) {
                            echo "Zalogowano";
                            echo "<script>           
                            let f = new FormData();
                            f.append('log', '$token');
                            fetch ('cookies.php', {
                                method: 'POST',
                                body: f
                            });
                            location.href = 'index.php';
                            </script>";
                        } elseif ($j == 0) {
                            echo "Nie istnieje taki użytkownik";
                        }
                    } else {
                        echo "Nie istnieje taki użytkownik";
                    }
                } else {
                    echo "Nie udalo się połączyć z bazą danych";
                }
            } else {
                if (isset($_POST['login']) || isset($_POST['pass'])) {
                    echo '<p>Wprowadź prawidłowo login i hasło</p>';
                }
            }
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