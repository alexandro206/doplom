<?php

include SITE_ROOT . "/app/database/db.php";
if (!$_SESSION) {
    header('location:' . BASE_URL . '/log.php');
}

$errMsg = [];
$id = '';
$title = '';
$content = '';
$topic = '';
$img = '';
$name = '';

$topics = selectAll('topics');
$posts = selectAll('posts');
$postsAdm = selectAllFromPostsWithUsers('posts', 'users');

// Код для формы создания записи
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_post"])) {

    if (!empty($_FILES['img']['name'])){
        $imgName = time() . "_" . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $destination = ROOT_PATH . "\assets\images\posts\\" . $imgName;


        if (strpos($fileType, 'image') === false) {
            array_push($errMsg, "Подгружаемый файл не является изображением!");
        }else{
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result){
                $_POST['img'] = $imgName;
            }else{
                array_push($errMsg, "Ошибка загрузки изображения на сервер");
            }
        }
    }else{
        array_push($errMsg,"Ошибка получения картинки");
    }


    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $topic = trim($_POST['topic']);

    $publish = isset($_POST['publish']) ? 1 : 0;

    if ($title === "" || $content === "" || $topic === "") {
        array_push($errMsg,'Не все поля заполнены!');
    }elseif (mb_strlen($title, "UTF-8") < 5) {
        array_push($errMsg,'Название статьи должно быть более 5-ти символов');
    }else{
            $post = [
                'id_user' => $_SESSION['id'],
                'title' => $title,
                'img' => $_POST['img'],
                'content' => $content,
                'status' => $publish,
                'id_topic' => $topic
            ];
            $id = insert("posts", $post);
            $post = seleceOne('posts', ['id_posts' => $id]);
            header('Location: ' . BASE_URL . 'admin/posts/index.php');
        }
}else{
    $id = '';
    $title = '';
    $content = '';
    $publish = '';
    $topic = '';
}

// Апдейт статьи
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $post = seleceOne('posts', ['id_posts' => $_GET['id']]);

    $id = $post["id_posts"];
    $title = $post['title'];
    $content = $post['content'];
    $topic = $post['id_topic'];
    $publish = $post['status'];

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_post"])) {

    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $topic = trim($_POST['topic']);
    $publish = isset($_POST['publish']) ? 1 : 0;

    if (!empty($_FILES['img']['name'])){
        $imgName = time() . "_" . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $destination = ROOT_PATH . "\assets\images\posts\\" . $imgName;


        if (strpos($fileType, 'image') === false) {
            array_push($errMsg, "Подгружаемый файл не является изображением!");
        }else{
            $result = move_uploaded_file($fileTmpName, $destination);

            if ($result){
                $_POST['img'] = $imgName;
            }else{
                array_push($errMsg, "Ошибка загрузки изображения на сервер");
            }
        }
    }else{
        array_push($errMsg, "Ошибка получения картинки");
    }

    if ($title === "" || $content === "" || $topic === "") {
        array_push($errMsg, 'Не все поля заполнены!');
    } elseif (mb_strlen($title, "UTF-8") < 5) {
        array_push($errMsg, 'Название статьи должно быть более 5-ти символов');
    } else {
        $post = [
            'id_user' => $_SESSION['id'],
            'title' => $title,
            'content' => $content,
            'img' => $_POST['img'],
            'status' => $publish,
            'id_topic' => $topic
        ];

        $post = updatePosts("posts", $id, $post);
        header('location: ' . BASE_URL . 'admin/posts/index.php');
    }
} else {
    $title = '';
    $content = '';
    $publish = isset($_POST['publish']) ? 1 : 0;
    $topic = '';
}


//// Удаление статьи
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete_id"])) {
    $id = $_GET["delete_id"];
    $post = seleceOne('posts', ['id_posts' => $id]);
    $name = $post['title'];

    deletePosts("posts", $id);
    $errMsg = "Категория $name была удалена!";
    header('Location: ../../admin/posts/index.php');
}

// Статус опубликовать или снять с публикации
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])){
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    $postId = updatePosts('posts', $id, ['status' => $publish]);

    header('location: ' . BASE_URL . 'admin/posts/index.php');
    exit();
}

