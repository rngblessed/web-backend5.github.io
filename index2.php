<?php
$user = 'admin';
$pass = 'smpP4ssw0rd!';
$db = new PDO(
    'mysql:host=localhost;dbname=admin',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
header('Content-Type: text/html; charset=UTF-8');
$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
    $session_started = true;
    if (!empty($_SESSION['login'])) {
        $_SESSION = array();
        session_destroy();
        // Удаляем куки сессии
        setcookie(session_name(), '', time() - 3600, '/');
        header('Location: index.php');
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['login'])) {
        header('Location: index.php');
        exit();
    } else {
        ?>

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>ZADANIE5</title>
            <link rel="stylesheet" href="main.css" />

        </head>
        <div>
            <div>
                <form action="" method="post">
                    <label for="validationCustom01">Логин</label>
                    <input name="login" />
                    <label for="validationCustom01">Пароль</label>
                    <input name="pass" />
                    </br>
                    <input type="submit" value="Войти" />
                    </br>
                    <input type="submit" value="Выйти">
            </div>
        </div>
        <?php
    }
} else {
    try {
        $login = $_POST['login'];
        $query = "SELECT * FROM main WHERE login = :login ";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['login'] = $login;
            $_SESSION['uid'] = '123';
            header('Location: db.php');
            exit();
        }
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}


if (isset($_SESSION['login'])) {
    ?>

    <?php
}
?>