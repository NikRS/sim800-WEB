<?php
// Основная тема


function frame($content){
    $simURL = URL_SIM;
    $siteURL = URL_MAIN;
echo<<<HTMLheredoc
<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="core/template/img/sim-card-icon.png" type="image/png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
 
    <link rel="stylesheet" href="./core/template/css/sim.css">
	<script src="./core/template/js/simUIevents.js"></script>
    <title>SIM</title>
  </head>
  <body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	    <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0">
	        <ul class="navbar-nav ml-auto text-center px-3">
	            <li class="nav-item px-1">
	                <a class="nav-link" href="{$simURL}?read">События</a>
	            </li>
	            <li class="nav-item px-1">
	                <a class="nav-link" href="{$simURL}?send">Отправить</a>
	            </li>
	            <li class="nav-item px-1">
	                <a class="nav-link" href="{$simURL}?contacts">Контакты</a>
	            </li>
	        </ul>
	    </div>
	    <div class="mx-auto my-0 order-0 order-md-1 position-relative">
	        <a class="mx-auto" href="https://esistlist.000webhostapp.com/">
	            <img src="https://esistlist.000webhostapp.com/libs/images/favicon.png" style="width: 55px;">
	        </a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2" style="border-color: transparent;">
	            <span class="navbar-toggler-icon" style="height: 1.2em"></span>
	        </button>
	    </div>
	    <div class="navbar-collapse collapse w-100 dual-collapse2 order-2 order-md-2">
	        <ul class="navbar-nav mr-auto text-center px-3">
	            <li class="nav-item px-1">
	                <a class="nav-link" href="{$siteURL}/core/notes">Заметки</a>
	            </li>
	            <li class="nav-item px-1">
	                <a class="nav-link" href="{$siteURL}/core/file_display">Файлы</a>
	            </li>
	            <li class="nav-item px-1">
	                <a class="nav-link logOUT" href="{$siteURL}/core/auth_close">Выйти</a>
	            </li>
	        </ul>
	    </div>
	</nav>
	{$content}
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>
HTMLheredoc;
}
