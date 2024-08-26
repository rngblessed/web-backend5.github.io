<?PHP

$user = 'admin';
$pass = 'smpP4ssw0rd!';
$db = new PDO(
    'mysql:host=localhost;dbname=admin',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);



try {
    function isValidRussianFullName($fio)
    {
        return preg_match('/^[\p{Cyrillic}\s]+$/u', $fio);
    }

    function isValidPhone($tel)
    {
        return preg_match('/^\+7\d{10}$/', $tel);
    }

    function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }



    header('Content-Type: text/html; charset=UTF-8');
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $messages = array();

        if (!empty($_COOKIE['save'])) {
            setcookie('save', '', 100000);
            setcookie('login', '', 100000);
            setcookie('pass', '', 100000);
            $messages[] = 'Спасибо, результаты сохранены.';
            if (!empty($_COOKIE['pass'])) {
                $messages[] = sprintf(
                    '</br>Вы можете <a href="index2.php">     войти</a></br>  с логином и паролем</br><strong>%s</strong> <strong>%s</strong> для изменения данных.',
                    strip_tags($_COOKIE['login']),
                    strip_tags($_COOKIE['pass'])
                );
            }
        }
        $errors = array();
        $errors['fio'] = !empty($_COOKIE['fio_error']);
        $errors['tel'] = !empty($_COOKIE['tel_error']);
        $errors['email'] = !empty($_COOKIE['email_error']);
        $errors['date'] = !empty($_COOKIE['date_error']);
        $errors['someGroupName'] = !empty($_COOKIE['someGroupName_error']);
        $errors['language'] = !empty($_COOKIE['language_error']);
        $errors['Biographi'] = !empty($_COOKIE['Biographi_error']);
        $errors['checkt'] = !empty($_COOKIE['checkt_error']);
        if ($errors['fio']) {
            setcookie('fio_error', '', 100000);
            setcookie('fio_value', '', 100000);
            $messages[] = '<div class="error">Заполните имя(Использовать только русские буквы).</div>';
        }
        if ($errors['tel']) {
            setcookie('tel_error', '', 100000);
            setcookie('tel_value', '', 100000);
            $messages[] = '<div class="error">Введите номер телефона(Начиная с +7).</div>';
        }
        if ($errors['email']) {
            setcookie('email_error', '', 100000);
            setcookie('email_value', '', 100000);
            $messages[] = '<div class="error">Введите почту.</div>';
        }
        if ($errors['date']) {
            setcookie('date_error', '', 100000);
            setcookie('date_value', '', 100000);
            $messages[] = '<div class="error">Выберите дату(Вам нет 18 лет).</div>';
        }
        if ($errors['someGroupName']) {
            setcookie('someGroupName_error', '', 100000);
            setcookie('someGroupName_value', '', 100000);
            $messages[] = '<div class="error">Выберите пол.</div>';
        }
        if ($errors['language']) {
            setcookie('language_error', '', 100000);
            setcookie('language_value', '', 100000);
            $messages[] = '<div class="error">Вы не выбрали языки программирования.</div>';
        }
        if ($errors['Biographi']) {
            setcookie('Biographi_error', '', 100000);
            setcookie('Biographi_value', '', 100000);
            $messages[] = '<div class="error">Напишите о себе.</div>';
        }
        if ($errors['checkt']) {
            setcookie('checkt_error', '', 100000);
            setcookie('checkt_value', '', 100000);
            $messages[] = '<div class="error">Вы не ознакомились с правилами.</div>';
        }






        $values = array();
        $values['fio'] = empty($_COOKIE['fio_value']) ? '' : strip_tags($_COOKIE['fio_value']);
        $values['tel'] = empty($_COOKIE['tel_value']) ? '' : strip_tags($_COOKIE['tel_value']);
        $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
        $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
        $values['someGroupName'] = empty($_COOKIE['someGroupName_value']) ? '' : strip_tags($_COOKIE['someGroupName_value']);
        $values['Biographi'] = empty($_COOKIE['Biographi_value']) ? '' : strip_tags($_COOKIE['Biographi_value']);
        $values['checkt'] = empty($_COOKIE['checkt_value']) ? '' : strip_tags($_COOKIE['checkt_value']);
        $values['language'] = empty($_COOKIE['language_value']) ? '' : strip_tags($_COOKIE['language_value']);

        if (
            empty($errors) && !empty($_COOKIE[session_name()]) &&
            session_start() && !empty($_SESSION['login'])
        ) {
            $stmt = $db->prepare("SELECT Name, phone, email, birth_date, gender, Biographi, contract_agreed FROM main WHERE login = :login");
            $stmt->bindParam(':login', $_SESSION['login']);
            $stmt->execute();
            $values = $stmt->fetch(PDO::FETCH_ASSOC);
            printf('Имя пользователя: %s<br>', $values['Name']);
            printf('Телефон: %s<br>', $values['phone']);
            printf('Email: %s<br>', $values['email']);
            printf('Дата рождения: %s<br>', $values['birth_date']);
            printf('Пол: %s<br>', $values['gender']);
            printf('Выберите языки программирования: %s<br>', $values['language']);
            printf('О себе: %s<br>', $values['Biographi']);
            printf('Согласие на условия: %s<br>', $values['contract_agreed']);
            printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
        }
        include ('index.php');
    } else {
        $errors = FALSE;

        if (empty($_POST['fio']) || !isValidRussianFullName($_POST['fio'])) {
            setcookie('fio_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('fio_value', $_POST['fio'], time() + 12 * 30 * 24 * 60 * 60);

        if (empty($_POST['tel']) || !isValidPhone($_POST['tel'])) {
            setcookie('tel_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('tel_value', $_POST['tel'], time() + 12 * 30 * 24 * 60 * 60);

        if (empty($_POST['email']) || !isValidEmail($_POST['email'])) {
            setcookie('email_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);

        if (empty($_POST['date'])) {
            setcookie('date_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('date_value', $_POST['date'], time() + 12 * 30 * 24 * 60 * 60);

        if (empty($_POST['someGroupName'])) {
            setcookie('someGroupName_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('someGroupName_value', $_POST['someGroupName'], time() + 12 * 30 * 24 * 60 * 60);


        if (empty($_POST['Biographi'])) {
            setcookie('Biographi_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('Biographi_value', $_POST['Biographi'], time() + 12 * 30 * 24 * 60 * 60);

        if (empty($_POST['checkt'])) {
            setcookie('checkt_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('checkt_value', $_POST['checkt'], time() + 12 * 30 * 24 * 60 * 60);

        if (empty($_POST['language'])) {
            setcookie('language_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;

        } else {
            $selected_languages = $_POST['language'];
            setcookie('language_value', serialize($selected_languages), time() + 12 * 30 * 24 * 60 * 60);
        }

        if ($errors) {
            header('Location: db.php');
            exit();
        } else {
            setcookie('fio_error', '', 100000);
            setcookie('tel_error', '', 100000);
            setcookie('email_error', '', 100000);
            setcookie('date_error', '', 100000);
            setcookie('someGroupName_error', '', 100000);
            setcookie('Biographi_error', '', 100000);
            setcookie('checkt_error', '', 100000);
            setcookie('language_error', '', 100000);
        }

        if (
            !empty($_COOKIE[session_name()]) &&
            session_start() && !empty($_SESSION['login'])
        ) {
            $fio = $_POST['fio'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            $date = $_POST['date'];
            $someGroupName = $_POST['someGroupName'];
            $Biographi = $_POST['Biographi'];
            $checkt = $_POST['checkt'];
            $stmt = $db->prepare("UPDATE main SET Name = :Name, phone = :phone, email = :email, birth_date = :birth_date, gender = :gender, Biographi = :Biographi, contract_agreed = :contract_agreed WHERE login = :login");
            $stmt->bindParam(':Name', $fio);
            $stmt->bindParam(':phone', $tel);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':birth_date', $date);
            $stmt->bindParam(':gender', $someGroupName);
            $stmt->bindParam(':Biographi', $Biographi);
            $stmt->bindParam(':contract_agreed', $checkt);
            $stmt->bindParam(':login', $_SESSION['login']);
            $stmt->execute();
        } else {
            $login = uniqid('', true);
            $password = bin2hex(random_bytes(6));
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            setcookie('login', $login);
            setcookie('pass', $password, time() + 12 * 30 * 24 * 60 * 60);
            setcookie('save', '1');
            $stmt = $db->prepare("INSERT INTO main (Name, phone,email,birth_date,gender,Biographi,contract_agreed,login,password_hash) VALUES (:Name, :phone,:email,:birth_date,:gender,:Biographi,:contract_agreed,:login,:password_hash)");
            $fio = $_POST['fio'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $date = $_POST['date'];
            $someGroupName = $_POST['someGroupName'];
            $Biographi = $_POST['Biographi'];
            $checkt = $_POST['checkt'];
            $stmt->bindParam(':Name', $fio);
            $stmt->bindParam(':phone', $tel);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':birth_date', $date);
            $stmt->bindParam(':gender', $someGroupName);
            $stmt->bindParam(':Biographi', $Biographi);
            $stmt->bindParam(':contract_agreed', $checkt);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':password_hash', $hashed_password);
            $stmt->execute();
            $user_id = $db->lastInsertId();
            $Languages = $_POST['language'];
            foreach ($Languages as $language_name) {
                $stmt = $db->prepare("INSERT INTO user_languages (user_id, language_name) VALUES (:user_id,:language_name)");
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':language_name', $language_name);
                $stmt->execute();
            }
        }
        setcookie('save', '1');
        header('Location: db.php');

    }
} catch (PDOException $e) {
    print ('Error : ' . $e->getMessage());
    exit();
}


?>