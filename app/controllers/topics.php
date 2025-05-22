<?php

include SITE_ROOT . "/app/database/db.php";

$errMsg = [];
$id = '';
$name = '';
$description = '';

$topics = selectAll('topics');


// Код для формы создания категории
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["topic-create"])) {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name === "" || $description === "") {
        array_push($errMsg,'Не все поля заполнены!');
    }elseif (mb_strlen($name, "UTF-8") < 2) {
        array_push($errMsg,'Категория должна быть длинее 2-х символов');
    }else{
        $existence = seleceOne('topics', ['name_topics' => $name]);
        if ($existence['name_topics'] === $name) {
            array_push($errMsg,'Такая категория в базе уже есть в базе');
        }else {
            $topic = [
                'name_topics' => $name,
                'description_topics' => $description
            ];
            $id = insert("topics", $topic);
            $topic = seleceOne('topics', ['id_topics' => $id]);
            header('Location: ../../admin/topics/index.php');
        }
    }
}else{
    $name = '';
    $description = '';
}

// Апдейт категории
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $topic = seleceOne('topics', ['id_topics' => $id]);
    $id = $topic['id_topics'];
    $name = $topic['name_topics'];
    $description = $topic['description_topics'];

}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["topic-edit"])) {

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name === "" || $description === "") {
        array_push($errMsg,'Не все поля заполнены!');
    }elseif (mb_strlen($name, "UTF-8") < 2) {
        array_push($errMsg,'Категория должна быть длинее 2-х символов');
    }else{
        {
            $topic = [
                'name_topics' => $name,
                'description_topics' => $description
            ];
            $id = $_POST['id'];
            $topic_id = updateTopics("topics", $id, $topic);
            header('Location: ../../admin/topics/index.php');
        }
    }
}

// Удаление категории
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["del_id"])) {
    $id = $_GET["del_id"];
    $topic = seleceOne('topics', ['id_topics' => $id]);
    $name = $topic['name_topics'];

    deleteTopics("topics", $id);
    array_push($errMsg,"Категория $name была удалена!");
    header('Location: ../../admin/topics/index.php');
}


