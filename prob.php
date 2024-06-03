<?PHP

$user = 'u67323';
$pass = '3649631';
$db = new PDO(
    'mysql:host=localhost;dbname=u67323',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
try {
    $login = uniqid('user_');
    $password = bin2hex(random_bytes(6)); // Генерируем 6 случайных байт и преобразуем в HEX

    // Хэширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Запись данных в базу данных
    $stmt = $db->prepare("INSERT INTO main (login, password_hash) VALUES (:login,:password_hash)");

    if ($conn->query($db) === TRUE) {
        echo "Запись успешно добавлена в базу данных<br>";
        echo "Сгенерированный логин: $login <br>";
        echo "Сгенерированный пароль: $password <br>";
    } else {
        echo "Ошибка при записи в базу данных: " . $conn->error;

    }
} catch (PDOException $e) {
    print ('Error : ' . $e->getMessage());
    exit();
}
// Закрытие соединения с базой данных


?>