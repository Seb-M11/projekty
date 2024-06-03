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
    <div class="header-container">
    <div class="header">
      <a href = 'index.php'><h1 class="title">FamilyApp</h1></a>
    </div>
    </div>
    <div class = 'main-chat' id = 'main'>
    </div>
    <div class="send-container">
      <div class="send">
        <div class="form">
          <input
            type="text"
            id="inputCzat"
            name="tekst"
            autocomplete="off"
            placeholder="Type a message..."
            class="msg-input"
          />
          <button type="button" id="send" class="chat-button">Send</button>
        </div>
      </div>
    </div>
    <?php 
        include 'config.php';
        if ($conn) {
            $token = $_COOKIE['user'];
            $query = "SELECT login, family_id FROM users WHERE token = '$token'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0 ) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nick = $row['login'];
                    $family_id = $row['family_id'];
                    if ($family_id == 0) {
                        echo "<script>
                        location.href = 'family.php'
                        </script>";
                    }
                }
            }
        }
    ?>
    <script>
        let family_id = <?php echo $family_id; ?>;
        function send() {
            let nick = <?php echo "'$nick'"; ?>;
            let wiadomosc = document.getElementById('inputCzat').value;
            console.log('bruh');
                if (wiadomosc != '') {
                    
                    let formData = new FormData();
                    formData.append('tekst', wiadomosc);
                    formData.append('nick', nick);
                    formData.append('family_id', family_id);
                    fetch ('save.php', {
                        method: 'POST',
                        body: formData
                    }).then(function (response) {
                        return response.text(); 
                    }).then(function (response) {
                        document.getElementById('main').innerHTML += response;
                        document.getElementById('inputCzat').value = '';
                        document.getElementById('main').scrollTop = document.getElementById('main').scrollHeight;
                    });
                }
            }
            document.getElementById('send').addEventListener('click', send);
            function read() {
                let fd = new FormData();
                fd.append('family_id', family_id);
                fetch('read.php', {
                    method: 'POST',
                    body: fd
                }).then(function (response) {
                    return response.text();
                }).then(function (response) {
                        let i = document.getElementById('main').childElementCount;
                        document.getElementById('main').innerHTML = response;
                        let j = document.getElementById('main').childElementCount;
                        if(i < j) {
                            document.getElementById('main').scrollTop = document.getElementById('main').scrollHeight;
                        }
                });
            }
            setInterval(read, 1000);
            document.getElementById('inputCzat').addEventListener('keydown', function (x) {
                if (x.key === 'Enter') {
                   send();
                }
            });
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
