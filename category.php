<?php
    include "path.php";
    include 'app/controllers/topics.php';
    $posts = selectAll('posts', ['id_topic' => $_GET['id']]);
    $topTopic = selectTopTopicFromPostsOnIndex('posts');
    $category = seleceOne('topics', ['id_topics' => $_GET['id']]);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Decision support system</title>
  <!-- Boostrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a3acc0358c.js" crossorigin="anonymous"></script>

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">

</head>
<body>

<?php include("app/include/header.php"); ?>

<!-- Блок Main START -->
<div class="container">
  <div class="content row">
    <!-- Main Content -->
    <div class="main-content col-md-9 col-12">
        <h2>Статьи с раздела <strong><?= $category['name_topics']; ?></strong></h2>
        <?php foreach ($posts as $post): ?>
            <div class="post row align-items-center">
                <div class="img col-12 col-md-4">
                    <img src="<?= BASE_URL . 'assets/images/posts/' . $post['img'] ?>" class="img-thumbnail" alt="<?=$post['title']?>">
                </div>
                <div class="post_text col-12 col-md-8">
                    <h3>
                        <a href="<?= BASE_URL . 'single.php?post=' . $post['id_posts']; ?>"><?=substr($post['title'], 0,120) . '' ?></a>
                    </h3>
                    <div class="post_meta">
                        <i class="far fa-user"> <?= $post['id_user']; ?></i>
                        <i class="far fa-calendar"> <?= $post['created_data']; ?></i>
                    </div>
                    <p class="preview-text">
                        <?=  mb_substr($post['content'], 0, 55, 'UTF-8') . '...' ;?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- sidebar Content -->
    <div class="sidebar col-md-3 col-12">

      <div class="section search">
        <h3>Поиск</h3>
        <form action="search.php" method="post">
          <input type="text" name="search-term" class="text-input" placeholder="Введите...">
        </form>
      </div>

      <div class="section topics">
        <h3>Категории</h3>
        <ul>
            <?php foreach ($topics as $key => $topic):  ?>
            <li>
                <a href="<?=BASE_URL . 'category.php?id=' . $topic['id_topics']; ?>"><?=$topic['name_topics']; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Блок Main END -->

<!-- footer -->
<?php include("app/include/footer.php"); ?>
<!-- footer END -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>