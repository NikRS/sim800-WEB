<?php
// Отображение событий с сим модуля сохранённые в БД

function get($events){
	$content = '';
		// Общая информация о выбранной сим карте
	$content .= '<div class="mainInfo text-center mt-2">';
	$content .= '<div class="phone country-flag-ua">'. $events["sim_number"] .'</div>'; // +380 72 133 83 11
	$content .= '<div class="balance">'. $events["sim_balance"] .'</div>'; // 0.04 р
	$content .= '</div>';

		// События на сим карте
	$content .= '	<div class="container" style="position: relative;" id="simEvents">';
	foreach ($events["e"] as $event) {
		if ($event["type"] == 'iSMS') {
			$content .= '<div class="iMessage" id="'. $event["id"] .'-event">';
			if (is_array($event["phone"])) {
				$content .= '<p class="phone">'. $event["phone"]["name"] . '<span>' . $event["phone"]["number"] .'</span></p>';
				}else{
				$content .= '<p class="phone">'. $event["phone"] .'</p>';
				}
			$content .= '<p class="response">'. $event["response"] .'</p>';
			$content .= '<p class="request mb-0">from <span class="response-time">'. $event["response_time"] .'</span></p>';
			$content .= '</div>';
		}
		elseif ($event["type"] == 'oSMS' or $event["type"] == 'oSMS_r') {
			$content .= '<div class="oMessage" id="'. $event["id"] .'-event">';
			if (is_array($event["phone"])) {
				$content .= '<p class="phone">'. $event["phone"]["name"] . '<span>' . $event["phone"]["number"] .'</span></p>';
				}else{
				$content .= '<p class="phone">'. $event["phone"] .'</p>';
				}
			$content .= '<p class="response">'. $event["response"] .'</p>';
			// $content .= '<p class="request mb-0">from <span class="request-time">'. $event["request_time"] .'</span>&nbsp; to <span class="response-time">'. $event["response_time"] .'</span></p>';
			$content .= '<p class="request mb-0">from <span class="request-time">'. $event["request_time"] .'</span>&nbsp; to <span class="response-time">'. $event["response_time"] .'</span> request <span class="request-content"><b>'. $event["request"] .'</b></span></p>';
			
			$content .= '</div>';
		}
		elseif ($event["type"] == 'iCall') {
			$content .= '<div class="iCall" id="'. $event["id"] .'-event">';
			if (is_array($event["phone"])) {
				$content .= '<p class="phone">'. $event["phone"]["name"] . '<span>' . $event["phone"]["number"] .'</span></p>';
				}else{
				$content .= '<p class="phone">'. $event["phone"] .'</p>';
				}
			$content .= '<p class="request mb-0">from <span class="response-time">'. $event["response_time"] .'</span></p>';
			$content .= '</div>';
		}
		elseif ($event["type"] == 'USSD') {
			$content .= '<div class="USSD" id="'. $event["id"] .'-event">';
			$content .= '<p class="response">'. $event["response"] .'</p>';
			$content .= '<p class="request mb-0">from <span class="request-time">'. $event["request_time"] .'</span>&nbsp; to <span class="response-time">'. $event["response_time"] .'</span></p>';
			$content .= '</div>';
		}
		elseif ($event["type"] == 'AT' or $event["type"] == 'AT_r' or $event["type"] == 'STATUS' or $event["type"] == 'simSUCCESS' or $event["type"] == 'simERROR' or $event["type"] == 'STATUS') {
			$content .= '<div class="AT-comand" id="'. $event["id"] .'-event">';
			$content .= '<p class="response">'. $event["response"] .'</p>';
			$content .= '<p class="request mb-0">from <span class="request-time">'. $event["request_time"] .'</span>&nbsp; to <span class="response-time">'. $event["response_time"] .'</span> request <span class="request-content"><b>'. $event["request"] .'</b></span></p>';
			$content .= '</div>';
		}
	}

	$content .= '
		<div class="alertWrapper tscale-0">
			<div class="alert alert-danger scale-0" role="alert">
				<p class="m-0">Ошибка при удалении<br>Обновите страницу</p>
			</div>
			<div class="alert alert-success scale-0" role="alert">
				<p class="m-0">Успешно удалено<br>Обновите страницу</p>
			</div>

			<div class="alert alert-dismissible fade show shadow p-3 mb-5 bg-white rounded position-relative scale-0" role="alert">
				
				<div class="selectedEvents"></div>

				<button type="button" class="btn btn-close" onclick="cancelDeleteEvent()">
					<span aria-hidden="true">Отмена</span>
				</button>			
				<button type="button" class="btn btn-danger btn-delete" onclick="deleteEvent()">
					<span>Удалить</span>
				</button>
			</div>
		</div>

	</div>';

	return $content;
}
