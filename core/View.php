<?php
// Представление (View) отвечает за отображение данных модели пользователю, реагируя на изменения модели
	include 'template/User.php';
		include 'template/User_view.php';
		include 'template/User_send.php';
		include 'template/User_contacts.php';


function show_content($content){

	if ($content["view_template"] == 'User_view') {
			frame(get($content));
	}
	elseif ($content["view_template"] == 'User_send_form') {
			frame(send_form($content));
	}
	elseif ($content["view_template"] == 'User_contacts') {
			frame(contacts_view($content));
	}
}
