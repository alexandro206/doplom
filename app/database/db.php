<?php
session_start();
require('connect.php');

function tt($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}

function tte($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}
// Проверка выполнения запроса к БД
function dbCheckError($query) {
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO:: ERR_NONE) {
        echo $errInfo[2];
        exit();
    }
    return true;
}
// Запрос на получения данных с одной таблицы
function selectAll($table, $params = []){
   global $pdo;
    $sql = "SELECT * FROM $table";

   if (!empty($params)) {
       $i = 0;
       foreach ($params as $key => $value) {
           if (!is_numeric($value)) {
               $value = "'" . $value . "'";
           }
           if ($i === 0) {
               $sql = $sql . " WHERE $key = $value";
           }else {
               $sql = $sql . " AND $key = $value";
           }
           $i++;
       }

   }


    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
   return $query->fetchAll();
}

//Запрос на получение одной строки выбранной с таблицы
function seleceOne($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if (!is_numeric($value)) {
                $value = "'" . $value . "'";
            }
            if ($i === 0) {
                $sql = $sql . " WHERE $key = $value";
            }else {
                $sql = $sql . " AND $key = $value";
            }
            $i++;
        }

    }
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

//Запись в таблицу бд
function insert($table, $params)
{
    global $pdo;

    // Формируем список столбцов и плейсхолдеров
    $columns = implode(", ", array_keys($params)); // Список столбцов
    $placeholders = ":" . implode(", :", array_keys($params)); // Список плейсхолдеров

    // Формируем SQL-запрос
    $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
    $query = $pdo->prepare($sql);

    $query->execute($params);
    dbCheckError($query);
    return $pdo->lastInsertId();
}

//Обновление строки в таблице topics
function updateTopics($table, $id, $params)
{
    global $pdo;
    $str = '';

    // Формируем список полей для обновления с плейсхолдерами
    foreach ($params as $key => $value) {
        $str .= "$key = :$key, ";
    }
    // Убираем последнюю запятую и пробел
    $str = rtrim($str, ', ');

    // Формируем SQL-запрос
    $sql = "UPDATE `$table` SET $str WHERE id_topics = :id";

    $query = $pdo->prepare($sql);

    // Добавляем id к массиву параметров
    $params['id'] = $id;

    $query->execute($params);

    dbCheckError($query);
}

//Обновление строки в таблице posts
function updatePosts($table, $id, $params)
{
    global $pdo;
    $str = '';

    // Формируем список полей для обновления с плейсхолдерами
    foreach ($params as $key => $value) {
        $str .= "$key = :$key, ";
    }
    // Убираем последнюю запятую и пробел
    $str = rtrim($str, ', ');

    // Формируем SQL-запрос
    $sql = "UPDATE `$table` SET $str WHERE id_posts = :id";

    $query = $pdo->prepare($sql);

    // Добавляем id к массиву параметров
    $params['id'] = $id;

    $query->execute($params);

    dbCheckError($query);
}

//Обновление строки в таблице users
function updateUsers($table, $id, $params)
{
    global $pdo;
    $str = '';

    // Формируем список полей для обновления с плейсхолдерами
    foreach ($params as $key => $value) {
        $str .= "$key = :$key, ";
    }
    // Убираем последнюю запятую и пробел
    $str = rtrim($str, ', ');

    // Формируем SQL-запрос
    $sql = "UPDATE `$table` SET $str WHERE id_user = :id";

    $query = $pdo->prepare($sql);

    // Добавляем id к массиву параметров
    $params['id'] = $id;

    $query->execute($params);

    dbCheckError($query);
}

//Обновление строки в таблице comments
function updateComments($table, $id, $params)
{
    global $pdo;
    $str = '';

    // Формируем список полей для обновления с плейсхолдерами
    foreach ($params as $key => $value) {
        $str .= "$key = :$key, ";
    }
    // Убираем последнюю запятую и пробел
    $str = rtrim($str, ', ');

    // Формируем SQL-запрос
    $sql = "UPDATE `$table` SET $str WHERE id = :id";

    $query = $pdo->prepare($sql);

    // Добавляем id к массиву параметров
    $params['id'] = $id;

    $query->execute($params);

    dbCheckError($query);
}

//Удаление данных с таблицы topics
function deleteTopics($table, $id){
    global $pdo;
    $sql = "DELETE FROM $table WHERE id_topics = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

//Удаление данных с таблицы posts
function deletePosts($table, $id){
    global $pdo;
    $sql = "DELETE FROM $table WHERE id_posts = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

//Удаление данных с таблицы users через админку
function deleteUsers($table, $id){
    global $pdo;
    $sql = "DELETE FROM $table WHERE id_user = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

//Удаление данных с таблицы comments через админку
function deleteComments($table, $id){
    global $pdo;
    $sql = "DELETE FROM $table WHERE id = $id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}

// Выборка записей (posts) с автором в админку
function selectAllFromPostsWithUsers($table1, $table2){
    global $pdo;
    $sql = "SELECT 
        t1.id_posts,
        t1.title,
        t1.img,
        t1.content,
        t1.status,
        t1.id_topic,
        t1.created_data,
        t2.user_name
        FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id_user";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();

}

// Выборка записей (posts) с автором на главную
function selectAllFromPostsWithUsersonIndex($table1, $table2, $limit, $offset){
    global $pdo;
    $sql = "SELECT p.*, u.user_name FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id_user WHERE p.status=1 LIMIT $limit OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();

}

// Выборка записей (posts) на карусель на главной
function selectTopTopicFromPostsOnIndex($table1){
    global $pdo;
    $sql = "SELECT * FROM $table1 WHERE id_topic = 12";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();

}

// Поиск по заголовкам и содержимому (простой)
function seacrhInTitileAndContent($text, $table1, $table2){
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = "SELECT 
        p.*, u.user_name 
        FROM $table1 AS p 
        JOIN $table2 AS u 
        ON p.id_user = u.id_user
        WHERE p.status=1
        AND p.title LIKE '%$text%' OR p.content LIKE '%$text%'";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

// Выборка записи (posts) с автором для сингл
function selectPostFromPostsWithUsersOnSingle($table1, $table2, $id){
    global $pdo;
    $sql = "SELECT p.*, u.user_name FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id_user WHERE p.id_posts=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

// Считаем количество строк в таблице
function countRow($table){
    global $pdo;
    $sql = "SELECT COUNT(*) FROM $table WHERE status = 1";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}
