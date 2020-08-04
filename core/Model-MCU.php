<?php
// Модель (Model) предоставляет данные и реагирует на команды контроллера, изменяя своё состояние

include_once '_db.php';


function get_cmd(){													// Модуль запросил команды
    // $_SERVER["HTTP_USER_AGENT"] = 'Inception 1.4 (iPod touch; iPhone OS 4.3.3; en_US)';
    $sim_ID = DB::run("SELECT `sim_ID` FROM `sim_users` WHERE User_Agent=? LIMIT 1;", [$_SERVER["HTTP_USER_AGENT"]])->fetchAll(PDO::FETCH_ASSOC)[0]["sim_ID"]; // Узнаем с какой сим-картой будем работать
	$sim_RAW_request = DB::run("SELECT `request` FROM `sim_events` WHERE `sim_ID`=? AND `response` IS NULL ORDER BY `id` ASC LIMIT 1", [$sim_ID])->fetchAll(PDO::FETCH_ASSOC)[0]["request"];

	if ($sim_RAW_request) {
		echo $sim_RAW_request; die();
	}else{
		err_(404);
	}
}


function set_cmd(){													// Модуль передаёт данные серверу
	$_SERVER["HTTP_USER_AGENT"] = 'Inception 1.4 (iPod touch; iPhone OS 4.3.3; en_US)';
    $sim_ID = DB::run("SELECT `sim_ID` FROM `sim_users` WHERE User_Agent=? LIMIT 1;", [$_SERVER["HTTP_USER_AGENT"]])->fetchAll(PDO::FETCH_ASSOC)[0]["sim_ID"]; // Узнаем с какой сим-картой будем работать
    
    
	$_response_time = date("Y-m-d H:i:s");


	if (isset($_GET["STATUS"])){
		$_response =
			'Уровень заряда батареи: '.$_GET["bat"]."</br>\n".
			'Тип авторизации в сети: '.$_GET["al"]."</br>\n".
			'Уровень сигнала: '.$_GET["ss"]."</br>\n".
			'Текущее время: '.$_GET["time"]."</br>\n".
			'Температура: '.$_GET["t"]."</br>\n".
			'Влажность: '.$_GET["h"]."</br>\n";
		DB::run("UPDATE `sim_events` SET `response`=?, `response_time`=? WHERE `request`=\"STATUS\n\" AND `sim_ID`=? AND `response` IS NULL LIMIT 1;", 
			[$_response, $_response_time, $sim_ID]);

	}

	elseif (isset($_GET["simSUCCESS"])){
	    $_query = "UPDATE `sim_events` SET `response`=\"". htmlspecialchars(stripcslashes($_GET["a"])) ."\", `response_time`=\"". htmlspecialchars(stripcslashes($_response_time)) ."\", `type`='AT' WHERE `request` LIKE \"". str_replace('"', '\"', $_GET["q"]) ."\" AND `sim_ID`=\"". htmlspecialchars(stripcslashes($sim_ID)) ."\" AND `response` IS NULL LIMIT 1;";
		DB::run($_query);
	}

	elseif (isset($_GET["simERROR"])){
	    DB::run("UPDATE `sim_events` SET `response`=?, `response_time`=?, `type`='ERROR' WHERE `request` LIKE ? AND `sim_ID`=? AND `response` IS NULL LIMIT 1;", 
			[$_GET["a"], $_response_time]);
	}
    
	if (isset($_GET["t"])) {

	    if($_GET["t"] == "iSMS"){										// Входящее сообщение
		DB::run("INSERT INTO `sim_events` (`sim_ID`, `response_time`, `response`, `phone`, `type`) VALUES (?, ?, ?, ?);", [$sim_ID, $_GET["localTime"], $_GET["b"], $_GET["n"], $_GET["t"]])->fetchAll(PDO::FETCH_ASSOC)[0]["sim_ID"];
		}

		elseif ($_GET["t"] == "iCall"){									// Входящий вызов

			DB::run("INSERT INTO `sim_events` (`sim_ID`, `response_time`, `phone`, `type`) VALUES (?, ?, ?);", [$sim_ID, $_GET["localTime"], $_GET["n"], $_GET["t"]])->fetchAll(PDO::FETCH_ASSOC)[0]["sim_ID"];
		}

		elseif ($_GET["t"] == "USSD"){									// Ответ на USSD запрос

			DB::run("UPDATE `sim_events` SET `response_time`=?, `response`=?, `type`=? WHERE `sim_ID`=?;", 
				[$_GET["localTime"], $_GET["b"], $_GET["t"], $sim_ID]);
			// Заменить значение баланса на новое
			DB::run("UPDATE `sim_users` SET `balance`=CONCAT(?,' р.') WHERE  `sim_ID`=?;", 
				[$_GET["m"], $sim_ID]);
		}

	}


    echo "ok\r\n";                                                  // Данные успешно приняты и обработаны, выведем подтверждение для модуля

}
