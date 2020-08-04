<?php
// Модель (Model) предоставляет данные и реагирует на команды контроллера, изменяя своё состояние


include_once '_db.php';
// $stmt = DB::run("SELECT id FROM users WHERE name=? AND password=? LIMIT ?;", [$userName, $userPassword, 1])->fetchAll(PDO::FETCH_ASSOC);
include_once 'View.php';


// Подготовим данные
$content = [];


function view($user_ID){																// Пользователь запросил информацию

	$content["view_template"] = 'User_view';

	// Узнаем номер телефона пользователя и баланс с последнего запроса, ID сим карт пользователя
	$stmt = DB::run("SELECT * FROM `sim_users` WHERE user_ID = ?;", [$user_ID])->fetchAll(PDO::FETCH_ASSOC);
		$content["sim_number"] = $stmt[0]["number"];
		$content["sim_balance"] = $stmt[0]["balance"];
		$content["sim_ID"] = $stmt[0]["sim_ID"];


	// Узнаем последние события по сим карте пользователя
	$content["e"] = DB::run("SELECT * FROM `sim_events` WHERE sim_ID = ? ORDER BY `id` DESC;", [$content["sim_ID"]])->fetchAll(PDO::FETCH_ASSOC);


	// Если есть контакты найти их подписи
	$contacts =[];
	foreach ($content["e"] as $key) {
		if ($key["phone"] != NULL AND !in_array($key["phone"], $contacts)) {
			$contacts[] = $key["phone"];
		}
	}

	if ($contacts) {
		$request = 'SELECT * FROM contacts WHERE';
		foreach ($contacts as $value) {
			$request_part .= " OR phone = '{$value}'";
		}
		$request_part = substr($request_part, 3);
		$request .= $request_part;
		$contacts = DB::run($request, [])->fetchAll(PDO::FETCH_ASSOC);

		foreach ($content["e"] as $key => $value) {
			if ($value["phone"] != NULL) {
				$_key = array_search($value["phone"], array_column($contacts, "phone"));
				if (is_int($_key)) {
					$content["e"][$key]["phone"] = array();
					$content["e"][$key]["phone"]["number"] = $contacts[$_key]["phone"];
					$content["e"][$key]["phone"]["name"] = $contacts[$_key]["name"];
				 }
			}
		}
	}

	show_content($content);
}


function send($sim_ID){																// Пользователь передаёт данные серверу
	$content["view_template"] = 'User_send_form';										// Выведем форму для отправки команд микроконтроллеру
	// Отправить сообщение
	// Отправить АТ команду (распространённые команды приведены ниже в виде справки)
	if (isset($_POST["phoneNumber"]) and isset($_POST["message"])) {
		$send_SMS_AT_comand = "oSMS\n" . $_POST["phoneNumber"] . "\n" . $_POST["message"] . "\n";
		$request_timestamp = date("Y-m-d H:i:s");

		DB::run("INSERT INTO `sim_events` (`sim_ID`, `phone`, `request`, `request_time`, `type`) VALUES (?, ?, ?, ?, 'oSMS_r');", [$sim_ID, $_POST["phoneNumber"], $send_SMS_AT_comand, $request_timestamp])->fetchAll(PDO::FETCH_ASSOC);
		header('Location: /?read');
	}
	elseif (isset($_POST["AT-comand"])) {
		if (substr($_POST["AT-comand"], 0, 2) == 'AT' and strlen($_POST["AT-comand"]) > 2) {
			$_POST["AT-comand"] = substr($_POST["AT-comand"], 2);
			$send_SMS_AT_comand = 'AT'. "\n" . $_POST["AT-comand"] . "\n";
		}else{
			$send_SMS_AT_comand = $_POST["AT-comand"] . "\n";
		}
		$request_timestamp = date("Y-m-d H:i:s");
		DB::run("INSERT INTO `sim_events` (`sim_ID`, `request`, `request_time`, `type`) VALUES (?, ?, ?, 'AT_r');", [$sim_ID, $send_SMS_AT_comand, $request_timestamp])->fetchAll(PDO::FETCH_ASSOC);
		header('Location: '. URL_SIM .'?read');
	}

	show_content($content);
}


function contacts($user_ID){															// Пользователь 
	$content["view_template"] = 'User_contacts';										// Выведем формочку для создания \ редактирования подписей к контактам

	if (isset($_POST["name"]) and isset($_POST["phone"])) {
		DB::run("INSERT INTO `contacts` (`phone`, `name`) VALUES (?, ?);", [$_POST["phone"], $_POST["name"]])->fetchAll(PDO::FETCH_ASSOC);
		header('Location: '. URL_SIM .'?contacts');
		exit;
	}

	$content["contacts"] = DB::run("SELECT `phone`, `name` FROM `contacts` ORDER BY `name`;", [])->fetchAll(PDO::FETCH_ASSOC);

	show_content($content);
}


if (isset($_POST["delete"])) {
	include_once '../../../env.php';
    $items = '';

	unset($_POST["delete"]);
	foreach ($_POST as $value) {
		$items .= intval($value).',';
	}
	$items = substr($items, 0, -1);


	DB::run("DELETE FROM `sim_events` WHERE `id` IN (?);", [$items])->fetchAll(PDO::FETCH_ASSOC);
	echo URL_SIM.'?read';
	die();
}

// Отобразим результат пользователю

// type
// 	AT
// 	simSUCCESS	?
// 	simERROR	?
// 	STATUS
// 	iSMS
// 	oSMS
// 	iCall
// 	USSD

// echo 'AT'. "\n" .'+CBC'. "\n";
