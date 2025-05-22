<?php
// контролер
include_once SITE_ROOT . "/app/database/db.php";
$commentsForAdm = selectAll('comments');

$page = $_GET['post'];
$email = '';
$comment = '';
$errMsg = [];
$status = 0;
$comments = [];

// Код для формы создания комментария
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['goComment'])){

    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);


    if($email === '' || $comment === ''){
        array_push($errMsg, "Не все поля заполнены!");
    }elseif (mb_strlen($comment, 'UTF8') < 15){
        array_push($errMsg, "Комментарий должен быть длинее 15 символов");
    }else{
        $user = seleceOne('users', ['email_user' => $email]);
        if ($user['email_user'] == $email){
            $status = 1;
        }

        $comment = [
            'status' => $status,
            'page' => $page,
            'email' => $email,
            'comment' => $comment
        ];

        $comment1 = insert('comments', $comment);
        $comments = selectAll('comments', ['page' => $page, 'status' => 1] );

    }

}else{
    $email = '';
    $comment = '';
    $comments = selectAll('comments', ['page' => $page, 'status' => 1] );

}

// Удаление комментария
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    deleteComments('comments', $id);
    header('location: ' . BASE_URL . 'admin/comments/index.php');
}

// Статус опубликовать или снять с публикации
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])){
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    $postId = updateComments('comments', $id, ['status' => $publish]);

    header('location: ' . BASE_URL . 'admin/comments/index.php');
    exit();
}



// АПДЕЙТ СТАТЬИ
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $oneComment = seleceOne('comments', ['id' => $_GET['id']]);

    $id =  $oneComment['id'];
    $email =  $oneComment['email'];
    $text1 = $oneComment['comment'];
    $publish = $oneComment['status'];
    $pub = $oneComment['status'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment'])){

    $id =  $_POST['id'];
    $text = trim($_POST['content']);
    $publish = isset($_POST['publish']) ? 1 : 0;

    if($text === ''){
        array_push($errMsg, "Комментарий не имеет содержимого текста");
    }elseif (mb_strlen($text, 'UTF8') < 15){
        array_push($errMsg, "Количество символов внутри комментария меньше 15");
    }else{
        $com = [
            'comment' => $text,
            'status' => $publish
        ];

        $comment = updateComments('comments', $id, $com);
        header('location: ' . BASE_URL . 'admin/comments/index.php');
    }
}else{
    $text = '';
    $publish = isset($_POST['publish']) ? 1 : 0;
}