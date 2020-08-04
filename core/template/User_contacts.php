<?php


function contacts_view($content){
	$page = '<div class="container my-3">
	<form action="?contacts" method="POST">
		<div class="row">
			<div class="col">
		  		<input type="text" name="name" class="form-control" placeholder="Подпишите контакт" required>
			</div>
			<div class="col">
		  		<input type="text" name="phone" class="form-control" placeholder="и добавьте номер" pattern="^\+?\d{3,}" required>
			</div>
		</div>
 		<button type="submit" class="btn btn-outline-dark my-3 btn-block">Отправить</button>
	</form>';

	$page .= '<h5>Контакты</h5><table class="table table-hover"><tbody>';
		foreach ($content["contacts"] as $item) {
			$page .= '<tr><td>'.$item["name"].'</td><td>'.$item["phone"].'</td></tr>';
		}
	$page .= '</tbody></table></div>';
	return $page;
}
