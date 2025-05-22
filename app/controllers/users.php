<?php
include SITE_ROOT . "/app/database/db.php";

$errMsg = [];

function userAuth($user){
    $_SESSION['id'] = $user['id_user'];
    $_SESSION['login'] = $user['user_name'];
    $_SESSION['admin'] = $user['admin_user'];
    if ($_SESSION['admin']) {
        header("location: " . BASE_URL . "admin/posts/index.php");
    }else{
        header("location: " . BASE_URL);
    }
}

$users = selectAll('users');

// Код для формы регистрации
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["button-reg"])) {
    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if ($login === "" || $email === "" || $passF === "") {
        array_push($errMsg,'Не все поля заполнены!');
    }elseif (mb_strlen($login, "UTF-8") < 2) {
        array_push($errMsg,'Логин должен быть длинее 2-х символов');
    }elseif ($passF !== $passS) {
        array_push($errMsg,'Пароли в обеих полях должны соответсвовать');
    }else{
        $existence = seleceOne('users', ['email_user' => $email]);
        if ($existence['email_user'] === $email) {
            array_push($errMsg,'Пользователь с такой почтой уже зарегистирован');
        }else {
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            $post = [
                'admin_user' => $admin,
                'user_name' => $login,
                'email_user' => $email,
                'password_user' => $pass
            ];
            $id = insert("users", $post);
            $user = seleceOne('users', ['id_user' => $id]);
            userAuth($user);
        }
    }
}else{
    $login = '';
    $email = '';
}

// Код для формы авторизации
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['button-log'])) {
    $email = trim($_POST['mail']);
    $pass = trim($_POST['password']);

    if ($email === "" || $pass === "") {
        array_push($errMsg,'Не все поля заполнены!');

    }else {
        $existence = seleceOne('users', ['email_user' => $email]);
        if ($existence && password_verify($pass, $existence['password_user'])) {
            userAuth($existence);
        }else{
            array_push($errMsg,'Почта либо пароль введены неверно!');
        }
    }
}else{
    $email = '';
}

//Код добавления пользователя в админке
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["create-user"])) {

    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if ($login === "" || $email === "" || $passF === "") {
        array_push($errMsg,'Не все поля заполнены!');
    }elseif (mb_strlen($login, "UTF-8") < 2) {
        array_push($errMsg,'Логин должен быть длинее 2-х символов');
    }elseif ($passF !== $passS) {
        array_push($errMsg,'Пароли в обеих полях должны соответсвовать');
    }else{
        $existence = seleceOne('users', ['email_user' => $email]);
        if ($existence['email_user'] === $email) {
            array_push($errMsg,'Пользователь с такой почтой уже зарегистирован');
        }else {
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            if (isset($_POST['admin_user'])) $admin = 1;
            $user = [
                'admin_user' => $admin,
                'user_name' => $login,
                'email_user' => $email,
                'password_user' => $pass
            ];
            $id = insert("users", $user);
            $user = seleceOne('users', ['id_user' => $id]);
            userAuth($user);
        }
    }
}else{
    $login = '';
    $email = '';
}

// Код удаления пользователя в админке
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete_id"])) {
    $id = $_GET["delete_id"];
    deleteUsers("users", $id);
    header('Location: ../../admin/users/index.php');
}

// Апдейт пользователя через админку
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["edit_id"])) {
    $user = seleceOne('users', ['id_user' => $_GET['edit_id']]);

    $id = $user['id_user'];
    $admin = $user['admin_user'];
    $username = $user['user_name'];
    $email = $user['email_user'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update-user"])) {
    $id = $_POST['id'];
    $email = trim($_POST['mail']);
    $login = trim($_POST['login']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    $admin = isset($_POST['admin']) ? 1 : 0;

    if ( $login === "") {
        array_push($errMsg, 'Не все поля заполнены!');
    } elseif (mb_strlen($login, "UTF-8") < 2) {
        array_push($errMsg, 'Логин должен быть более 2-ух символов');
    } elseif ($passF !== $passS) {
        array_push($errMsg,'Пароли в обеих полях должны соответсвовать');
    }else {
        $pass = password_hash($passF, PASSWORD_DEFAULT);
        if (isset($_POST['admin'])) $admin = 1;
        $user = [
            'admin_user' => $admin,
            'user_name' => $login,
//            'email_user' => $email,
            'password_user' => $pass
        ];

        $user = updateUsers("users", $id, $user);
        header('location: ' . BASE_URL . 'admin/users/index.php');
    }
} else {
    $login = '';

}



