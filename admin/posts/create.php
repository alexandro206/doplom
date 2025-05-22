<?php
    include "../../path.php";
    include "../../app/controllers/posts.php";

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Decision support system</title>
    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css" />
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a3acc0358c.js" crossorigin="anonymous"></script>

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">

</head>
<body>

<?php include("../../app/include/header-admin.php"); ?>

<div class="container">
    <?php include("../../app/include/sidebar-admin.php"); ?>

        <div class="posts col-9">
            <div class="button row">
                <a href="<?php echo BASE_URL . "admin/posts/create.php";?>" class="col-3 btn btn-success">Создать</a>
                <span class="col-1"></span>
                <a href="<?php echo BASE_URL . "admin/posts/index.php";?>" class="col-3 btn btn-warning">Редактировать</a>
            </div>
            <div class="row title-table">
                <h2>Добавление записи</h2>
            </div>
            <div class="row add-post">
                <div class="mb-12 col-12 col-md-12 err">
                    <!-- Вывод массива с ошибками -->
                    <?php include "../../app/helps/errorInfo.php"; ?>
                </div>
               <form action="create.php" method="post" enctype="multipart/form-data">
                   <div class="col mb-2">
                       <input value="<?=$title; ?>" name="title" type="text" class="form-control" placeholder="Title" aria-label="Название статьи">
                   </div>
                   <div class="col">
                       <label for="editor" class="form-label">Содержимое записи</label>
                       <textarea name="content" id="editor" class="form-control" rows="6"><?=$content; ?></textarea>

                   </div>
                   <div class="input-group col mb-4 mt-4">
                       <input name="img" type="file" class="form-control" id="inputGroupFile02">
                       <label class="input-group-text" for="inputGroupFile02">Upload</label>
                   </div>
                   <div class="col mb-3">
                       <input value="<?= $img_caption ?? '' ?>" name="img_caption" type="text" class="form-control" placeholder="Подпись к изображению">
                   </div>
                   <select name="topic" class="form-select mb-2" aria-label="Default select example">
                       <option selected>Категория поста:</option>
                       <?php foreach ($topics as $key => $post):  ?>
                           <option value="<?=$post['id_topics']; ?>"><?=$post['name_topics'];?></option>
                       <?php endforeach; ?>
                   </select>
                   <div class="form-check">
                       <input name="publish" class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked>
                       <label class="form-check-label" for="flexCheckChecked">
                           Publish
                       </label>
                   </div>
                   <div class="col col-6">
                       <button name="add_post" class="btn btn-primary" type="submit">Добавить запись</button>
                   </div>
               </form>
            </div>
        </div>
    </div>
</div>


<!-- footer -->
<?php include("../../app/include/footer.php"); ?>
<!-- footer END -->

<!-- Option 1: Boostrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Добавление визуального редактора к текстовому полю админки -->
<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>

<script src="../../assets/js/scripts.js"></script>
</body>
</html>