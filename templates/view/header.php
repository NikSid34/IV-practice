<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отзывы</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/templates/css/bootstrap.min.css" rel="stylesheet">
    <link href="/templates/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid topLine">
    <div class="row justify-content-between">
        <div class="col-md-auto whiteText"><h5>Производственная практика</h5></div>
        <div class="col"></div>
        <div class="col-md-auto"><a class="whiteText" href="/api/feedbacks"><span>Все отзывы</span></a></div>
        <div class="col-md-auto dropdown">
			<?php session_start(); if (isset($_SESSION['login'])) : ?>
                <div class="whiteText" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                     aria-controls="collapseOne" id="dropdownMenuButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                    <span><?php echo htmlspecialchars($_SESSION['login']); ?></span></div>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="whiteButton blackText" href="/api/logout"><span class="black_text">Выйти из аккаунта</span></a>
                </div>
			<?php else : ?>
                <a href="/api/login" class="whiteText">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                    <span>Войти</span></a>
			<?php endif; ?>
        </div>
    </div>
</div>