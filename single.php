<?php
    include "path.php";
    include "app/controllers/topics.php";
    $post = selectPostFromPostsWithUsersOnSingle('posts', 'users', $_GET['post']);
function make_links_clickable($text) {
    // Регулярное выражение для поиска URL
    $pattern = '~((?:https?://)?(?:www\.)?[a-zA-Z0-9-.]+\.[a-zA-Z]{2,}(?:/[^\s]*)?)~';
    return preg_replace_callback($pattern, function($matches) {
        $url = $matches[1];
        // Добавляем http:// если его нет
        if (!preg_match('~^https?://~i', $url)) {
            $url = 'http://' . $url;
        }
        return '<a href="' . htmlspecialchars($url, ENT_QUOTES) . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($matches[1]) . '</a>';
    }, $text);
}
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

<!-- header -->
<?php include("app/include/header.php"); ?>
<!-- header END -->

<!-- Блок Main START -->
<div class="container">
    <div class="content row">
        <!-- Main Content -->
        <div class="main-content col-md-9 col-12">
            <h2><?php echo $post['title']; ?></h2>

            <div class="single_post row align-items-center">
                <div class="img col-12">
                    <img src="<?= BASE_URL . 'assets/images/posts/' . $post['img'] ?>" alt="<?=$post['title']?>"
                    class="img-shadow img-border">
                    <?php if(!empty($post['img_caption'])): ?>
                        <span class="img-caption"><?= htmlspecialchars($post['img_caption']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="info">
                    <i class="far fa-user"> <?= $post['user_name']; ?></i>
                    <i class="far fa-calendar"> <?= $post['created_data']; ?></i>
                </div>

                <div class="single_post_text">
                    <?= make_links_clickable(nl2br(htmlspecialchars_decode($post['content']))) ?>
                </div>

                <div class="mb-3 col-12 col-md-4 err">
                    <?php include "app/helps/errorInfo.php"; ?>
                </div>
                <!-- Инклюдим HTML блок с комментариями -->
                <?php include("app/include/comments.php"); ?>
            </div>

        </div>
        <!-- sidebar Content -->
        <div class="sidebar col-md-3 col-12">

            <div class="section search">
                <h3>Поиск</h3>
                <form action="/" method="post">
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