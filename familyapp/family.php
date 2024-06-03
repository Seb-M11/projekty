<html>

<head>
    <meta charset="utf-8" />
    <title>FamilyApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="icon192.png" type="image/x-icon">
    
</head>

<body>
    <div class="header">
        <a href='index.php'>
            <h1 class="title">FamilyApp</h1>
        </a>
    </div>
    <div class="family-main">
        <?php
        if (!isset($_COOKIE['user'])) {
            echo "<script>
            location.href = 'login.php';
            </script>";
        }
        include 'config.php';
        if ($conn) {
            $token = $_COOKIE['user'];
            $query = "SELECT id, family_id FROM users WHERE token = '$token'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (!empty($row['family_id'])) {
                        $family_id = $row['family_id'];
                        $id = $row['id'];
                        echo "
                            <div class ='family-container'>
                            <h2>Family members</h2>
                            </div>
                            <div class = 'family-container'>
                            <h4>Family Id: $family_id</h4>
                            </div>";
                    }
                }
            }
            if (isset($family_id)) {
                $query3 = "SELECT id_zalozyciela FROM families WHERE id = $family_id";
                $result3 = mysqli_query($conn, $query3);
                $row3 = mysqli_fetch_assoc($result3);
                $query2 = "SELECT login, id, points FROM users WHERE family_id = $family_id ORDER BY points DESC";
                $result2 = mysqli_query($conn, $query2);
                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $id2 = $row['id'];
                        $login = $row['login'];
                        $points = $row['points'];
                        if ($id2 == $row3['id_zalozyciela']) {
                            echo "<div class='family-container'>
                                <div class='use'><p><b>$login</b></p>
                                <p>User Id: $id2</p>
                                <p>Points: <b>$points</b></p>
                                </div>
                                </div>";
                        } else if ($row3['id_zalozyciela'] == $id && $id2 != $id) {
                            echo "
                                <div class='family-container'>
                                <div class='use'><p><b>$login</b></p>
                                <p>User Id: $id2</p>
                                <p>Points: <b>$points</b></p>
                                </div>
                                <form class='delete-user-form' action = '' method = 'post'>
                                <input type = 'hidden' name = 'deleteUser' value = $id2>
                                <input class='delete-user' type = 'submit' value = '&#8722 Delete user'>
                                </form>
                                </div>
                                
                                ";
                        } else {
                            echo "
                                <div class='family-container'>
                                <div class='use'><p><b>$login</b></p>
                                <p>User Id: $id2</p>
                                <p>Points: <b>$points</b></p>
                                </div>
                                </div>
                                ";
                        }

                    }
                }
                if (isset($_POST['deleteUser'])) {
                    $deletedUser = $_POST['deleteUser'];
                    $queryDeleteThisUser = "UPDATE users SET family_id = NULL, points = 0 WHERE id = $deletedUser";
                    $queryDeleteThisUser2 = "DELETE FROM quests WHERE user_id = $deletedUser";
                    if (mysqli_query($conn, $queryDeleteThisUser) && mysqli_query($conn, $queryDeleteThisUser2)) {
                        unset($_POST['deleteUser']);
                        echo "<script>
                            location.href = 'family.php';
                            </script>";
                    }
                }
                if ($row3['id_zalozyciela'] == $id) {
                    echo "
                        <form class='family-form' action = '' method = 'post'>
                        <input class='input' type='text' name='newMember' placeholder = 'Enter user login'/>
                        <input class='signin' type = 'submit' value = 'Add family member'/>
                        </form>
                        <form class='family-form' action = '' method = 'post'>
                        <hr>
                        <input class='warning' type = 'submit' value = 'Delete family' name = 'delete'>
                        </form>
                        ";
                } else {
                    echo "
                        
                        <form class='family-form' action = '' method = 'post'>
                        <input class='submit' type = 'submit' value = 'Leave family' name = 'leave'>
                        </form>
                        ";
                }
                if (isset($_POST['leave'])) {
                    $queryLeave = "UPDATE users SET family_id = NULL, points = 0 WHERE token = '$token'";
                    $queryLeave2 = "DELETE FROM quests WHERE user_id = $id";
                    $sql = "UPDATE gl SET family_id = NULL WHERE login = '$login'";
                    $conn->query($sql);
                    if (mysqli_query($conn, $queryLeave) && mysqli_query($conn, $queryLeave2)) {
                        unset($_POST['leave']);
                        echo "<script>
                            location.reload();
                            </script>";
                    }
                }
                if (isset($_POST['delete'])) {
                    $queryDelete = "UPDATE users SET family_id = NULL, points = 0 WHERE family_id = $family_id";
                    $queryDelete1 = "DELETE FROM chat WHERE family_id = $family_id;";
                    $queryDelete2 = "DELETE FROM families WHERE id = $family_id";
                    $queryDelete3 = "DELETE FROM quests WHERE family_id = $family_id";
                    $sql = "UPDATE gl SET family_id = NULL WHERE login = '$login'";
                    $conn->query($sql);
                    if (mysqli_query($conn, $queryDelete) && mysqli_query($conn, $queryDelete1) && mysqli_query($conn, $queryDelete2) && mysqli_query($conn, $queryDelete3)) {
                        unset($_POST['delete']);
                        echo "<script>
                            location.reload();
                            </script>";
                    } else {
                        echo "Błąd";
                    }
                }
                if (isset($_POST['newMember'])) {
                    $newMember = $_POST['newMember'];
                    $queryCheckMember = "SELECT family_id, family_request FROM users WHERE login = '$newMember'";
                    $resultCheckMember = mysqli_query($conn, $queryCheckMember);
                    if (mysqli_num_rows($resultCheckMember) > 0) {
                        $rowCheckMember = mysqli_fetch_assoc($resultCheckMember);
                        $memberFamily = $rowCheckMember['family_id'];
                        $memberRequests = $rowCheckMember['family_request'];
                        if ($memberRequests == null && $memberFamily == null) {
                            $queryUpdate = "UPDATE users SET family_request = $family_id WHERE login = '$newMember'";
                            if (mysqli_query($conn, $queryUpdate)) {
                                echo "Wysłano zaproszenie";
                            }
                        } else {
                            echo "Ten użytkownik jest już przypisany do rodziny lub otrzymał od kogoś zaproszenie";
                        }
                    }
                    unset($_POST['newMember']);
                }
            } else {
                echo "
                    <div class ='family-container'>
                    <b><a href = 'createFamily.php'>Utwórz swoją rodzinę</a></b>
                    <p>
                    lub poczekaj aż ktoś cie zaprosi</p></div>
                    ";
                $queryInvite = "SELECT family_request FROM users WHERE token = '$token'";
                $resultInvite = mysqli_query($conn, $queryInvite);
                if (mysqli_num_rows($resultInvite) > 0) {
                    $rowInvite = mysqli_fetch_assoc($resultInvite);
                    $inviteId = $rowInvite['family_request'];
                    if ($inviteId != NULL) {
                        $queryGetFamilyName = "SELECT family_name FROM families WHERE id = $inviteId";
                        $resultGetFamilyName = mysqli_query($conn, $queryGetFamilyName);
                        if (mysqli_num_rows($resultGetFamilyName) > 0) {
                            $rowGetFamilyName = mysqli_fetch_assoc($resultGetFamilyName);
                            $inviteName = $rowGetFamilyName['family_name'];
                            echo "
                            <div class = 'family-container'>
                            <h2>Zaproszono cię do rodziny</h2>
                            <span>Family Id: <b>$inviteId</b></span>
                            <span>Family Name: <b>$inviteName</b></span>
                            <form action = '' method = 'post'>
                            <input class ='accept' type = 'submit' name='accept' value = 'Accept'><input class='reject' type = 'submit' name='reject' value = 'Reject'>
                            </form>
                            </div>
                            ";
                            if (isset($_POST['reject'])) {
                                $queryReject = "UPDATE users SET family_request = NULL WHERE token = '$token'";
                                if (mysqli_query($conn, $queryReject)) {
                                    echo "Odrzucono zaproszenie";
                                    unset($_POST['reject']);
                                    echo "
                                    <script>
                                    location.reload();
                                    </script>
                                    ";
                                }
                            }
                            if (isset($_POST['accept'])) {
                                $queryAccept = "UPDATE users SET family_id = $inviteId, family_request = NULL WHERE token = '$token';";
                                $q1 = "SELECT login FROM users WHERE token = '$token'";
                                $r1 = mysqli_query($conn, $q1);
                                if (@mysqli_num_rows($r1) > 0) {
                                    while ($row1 = mysqli_fetch_assoc($r1)) {
                                        $login = $row1['login'];
                                    }
                                }
                                $upt = "UPDATE gl SET family_id = '$inviteId' WHERE login = '$login'";
                                $conn->query($upt);
                                if (mysqli_query($conn, $queryAccept)) {
                                    unset($_POST['accept']);
                                    echo "
                                    <script>
                                    location.reload();
                                    </script>
                                    ";
                                }
                            }
                        }
                    }
                }
            }
            mysqli_close($conn);
        }
        ?>

    </div>
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