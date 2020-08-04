<?php
// Контроллер (Controller) интерпретирует действия пользователя, оповещая модель о необходимости изменений


//include_once '../../env.php';

//date_default_timezone_set('Europe/Moscow');

// Провеирм, кто обращается (пользователь или микроконтроллер)
if ($_SERVER["HTTP_USER_AGENT"] == "Inception 1.4 (iPod touch; iPhone OS 4.3.3; en_US)" or $develop_mode) {
	// Работаем с микроконтроллером
	include 'Model-MCU.php';

	if (isset($_GET["get"])) {                                          // Модуль запросил команды
		get_cmd();
    }elseif (isset($_GET["set"])) {                                     // Модуль передаёт данные серверу
    	set_cmd();
    }else{                                                              // Прочие запросы не валидны
        err_(404);
    }
}
else{
	// Работаем с пользователем
	//session_name("id"); session_start(); $_SESSION["id"] = 1;

	// Проверка авторизации
	if(isset($_COOKIE["id"])){
	    // Вытянуть из сессии АйДи и передать управление в Модель
	//	session_name("id"); session_start();
		
		include 'Model-user.php';

		if (isset($_GET["read"])) {                                     // Пользователь запросил информацию
			view($_SESSION["id"]);   
	    }elseif (isset($_GET["send"])) {                                // Пользователь передаёт данные серверу
	    	send($_SESSION["id"]);						// SIM ID
	    }elseif (isset($_GET["contacts"])) {                            // Пользователь просматривает \ редактирует контакты
	    	contacts($_SESSION["id"]);
	    }else{                                                          // Пользовательский запрос не валиден
	        err_(404);
	    }
	}
	else{
		// Выведем ошибку авторизации
        err_(401);
	}
}


function err_($error_code){
	if ($error_code == 404) {
		header("HTTP/1.0 404 Not Found");
	}
	if ($error_code == 401) {
		header("HTTP/1.0 401 Unauthorized");
	}
}
