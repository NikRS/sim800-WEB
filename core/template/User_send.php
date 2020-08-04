<?php


function send_form($content){
	$content = '
	<div class="container">
		<form action="?send" method="POST" class="mt-3">
			<div class="form-group">
				<label for="phoneNumber" class="font-weight-bold">Номер телефона</label>
				<input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="+123123456789" required>
			</div>
			<div class="form-group">
				<label for="message" class="font-weight-bold">Текст сообщения</label>
				<textarea class="form-control" id="message" name="message" rows="3" required></textarea>
			</div>
	 		<button type="submit" class="btn btn-outline-dark mb-2 btn-block">Отправить</button>
		</form>
	<hr><hr><hr><hr><hr>
		<form action="?send" method="POST" class="mt-3">
			<div class="form-group">
				<label for="AT-comand" class="font-weight-bold">AT-команды</label>
				<input type="text" class="form-control" id="AT-comand" name="AT-comand" required>
			</div>
	 		<button type="submit" class="btn btn-outline-dark mb-2 btn-block">Отправить</button>
		</form>
		<table class="table table-hover text-center" style="font-size:0.55rem">
  <thead>
    <tr>
      <th scope="col" style="vertical-align: middle;">Назначение команды</th>
      <th scope="col" style="vertical-align: middle;">Пример команды</th>
      <th scope="col" style="vertical-align: middle;">Комментарий</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Готовность модуля к работе</td>
      <td>AT</td>
      <td><b>OK</b></td>
    </tr>
    <tr>
      <td>Запрос качества связи</td>
      <td>AT+CSQ</td>
      <td><p><b>+CSQ: &lt;rssi&gt;,&lt;ber&gt;</b></p><p>&lt;rssi&gt; - качество сигнала (от 10 и выше — нормальное)</p><p>&lt;ber&gt; - коэффициент битовых ошибок (меньше — лучше)</p></td>
    </tr>
    <tr>
      <td>Напряжение питания</td>
      <td>AT+CBC</td>
      <td><b>+CBC: <i>&lt;bcs&gt;</i>,<i>&lt;bcl&gt;</i>,<i>&lt;voltage&gt;</i></b><br>
		<b><i>&lt;bcs&gt;</i></b> — статус зарядки<br>
		<b>0</b> — зарядки нет<br>
		<b>1</b> — зарядка идет<br>
		<b>2</b> — зарядка завершена<br>
		<b><i>&lt;bcl&gt;</i></b> — объем оставшегося заряда в процентах<br>
		<b><i>&lt;voltage&gt;</i></b> — напряжение питания модуля, в милливольтах
	  </td>
    </tr>
    <tr>
      <td>Тип регистрации в сети</td>
      <td>AT+CREG?</td>
      <td><b>+CREG: <i>&lt;n&gt;</i>,<i>&lt;stat&gt;</i><br>OK</b><br>
	  <b><i>&lt;n&gt;</i></b> — параметр ответа<br>
	  <b>0</b> — незапрашиваемый код регистрации в сети отключен<br>
	  <b>1</b> — незапрашиваемый код регистрации в сети включен<br>
	  <b>2</b> — незапрашиваемый код регистрации в сети включен с информацией о местоположении<br>
	  <b><i>&lt;stat&gt;</i></b> — статус<br>
	  <b>0</b> — незарегистрирован, не ищет нового оператора для регистрации<br>
	  <b>1</b> — зарегистрирован в домашней сети<br>
	  <b>2</b> — незарегистрирован, но в поиске нового оператора для регистрации<br>
	  <b>3</b> — регистрация запрещена<br>
	  <b>4</b> — неизвестно<br>
	  <b>5</b> — зарегистрирован, в роуминге
	</td>
    </tr>
    <tr>
      <td>Получить список SMS</td>
      <td>AT+CMGL="REC UNREAD",1</td>
      <td><b><i>&lt;stat&gt;</i></b> — фильтр, значения<br>
	  <b><raw>"REC UNREAD"</raw></b> — полученные непрочитанные SMS<br>
	  <b><raw>"REC READ"</raw></b> — полученные прочитанные SMS<br>
	  <b><raw>"STO UNSENT"</raw></b> — сохраненные непрочитанные  SMS<br>
	  <b><raw>"STO SENT"</raw></b> — сохраненные непрочитанные  SMS<br>
	  <b><raw>"ALL"</raw></b> — все SMS<br>
	  <b><i>&lt;mode&gt;</i></b> — фильтр удаляемых сообщений (необязат., используется при <i>&lt;index&gt;</i>=0), значения:<br>
	  <b>0</b> — изменить статус сообщений на «прочитано»<br>
	  <b>1</b> — оставить статус без изменения
	  </td>
    </tr>
    <tr>
      <td>Отправить USSD-запрос</td>
      <td>AT+CUSD=1,"*101#"</td>
      <td><b>AT+CUSD=<i>&lt;n&gt;</i>[,<i>&lt;str&gt;</i>[,<i>&lt;dcs&gt;</i>]]</b><br>
	  <b><i>&lt;n&gt;</i></b> задает статус ответа:<br>
	  <b>0</b> — не получать ответ<br>
	  <b>1</b> — получать ответ<br>
	  <b>2</b> — отменить сеанс<br>
	  <b><i>&lt;str&gt;</i></b> — строка запроса в кавычках<br>
	  <b><i>&lt;dcs&gt;</i></b> — схема кодирования данных (целое число, по умолчанию&nbsp;— 0)<br>
	  <b><i>&lt;str_urc&gt;</i></b> — текст ответ на USSD-запрос
      </td>
    </tr>
    <tr>
      <td>Запрос основной информации о модуле</td>
      <td>STATUS</td>
      <td><b>Запрашивает:</b><br>Уровень заряда батареи<br>Тип авторизации в сети<br>Уровень сигнала<br>Текущее время<br>Температуру<br>Влажность</td>
    </tr>
  </tbody>
</table>
	</div>';
	return $content;
}
