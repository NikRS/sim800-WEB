<?php
// Точка входа контроллер
// Он вызовет Модель, а Модель вызовет Представление

include_once '../../env.php';

date_default_timezone_set('Europe/Moscow');

include("./core/Controller.php");
