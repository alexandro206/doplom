<?php
include "path.php";
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

<main class="container mt-4">
    <section class="about-us">
        <h2 class="text-center">Обо мне</h2>
        <p>
            Добро пожаловать на сайт LightReason! Данный сайт стремится предоставлять качественную информацию с использованием удобного и приятного интерфейса.
            Его цель - помочь каждому достичь своих вершин, улучшая знания и навыки.
        </p>

    </section>

    <section class="team mt-5">

        <div class="row">
            <div class="col-md-4">
                <img src="assets/images/team_image_5.jpg" alt="Команда" class="img-fluid rounded mb-3">
            </div>
            <div class="col-md-8">
                <h4>Каменецкий Алексей
                </h4>
                <p><strong>Руководитель проекта</strong></p>
                <p>
                    Алексей отвечает за стратегическое развитие проекта и координацию работы команды.
                    С его лидерством мы достигли значительных успехов в создании динамического сайта.
                </p>
                <p><strong>Главный разработчик</strong></p>
                <p>
                    Алексей — наш технический эксперт, который обеспечивает стабильную работу системы и внедряет новые функции.
                    Его вклад в разработку позволяет нам предлагать пользователям лучший продукт.
                </p>
                <p><strong>UI/UX дизайнер</strong></p>
                <p>
                    Алексей создает удобные и эстетичные интерфейсы, которые делают использование сайта приятным и интуитивно понятным.
                    Его дизайнерские решения помогают нам выделяться на рынке.
                </p>
            </div>
        </div>
    </section>
</main>
<!-- footer -->
<?php include("app/include/footer.php"); ?>
<!-- footer END -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
