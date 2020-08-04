var deleteEventsIDs = [];

window.onclick = function(e) {
	var elem = e ? e.target : window.event.srcElement;
	while(!(elem.id || (elem == document.body))) elem = elem.parentNode;
	if (!elem.id) return; else id = elem.id;
	// если вдруг у элемента по которому кликнули нет id,
	// скрипт будет подниматься вверх по цепочке DOM узлов до близжайшего элемента с id или до тега body
	// Тут работаем с id элемента
	// alert(id);

	if (elem.parentNode.id == 'simEvents') {
		// console.log(parseInt(id));
		displayEventDeleteMessage(id);
	}
}


function displayEventDeleteMessage(id){
	// console.log(deleteEventsIDs.indexOf(id));
	if (deleteEventsIDs.indexOf(parseInt(id)) == -1) {
		deleteEventsIDs.push(parseInt(id));
		document.getElementsByClassName('alertWrapper')[0].className = document.getElementsByClassName('alertWrapper')[0].className.replace(" tscale-0", " tscale-1");
		document.getElementsByClassName('alert-dismissible')[0].className = document.getElementsByClassName('alert-dismissible')[0].className.replace(" scale-0", " scale-1");
		document.getElementsByClassName('selectedEvents')[0].appendChild(document.getElementById(id).cloneNode(true));
	}
}


function deleteEvent(){
		// console.log(deleteEventsIDs.length);
	if(deleteEventsIDs.length > 0){

		let formData = new FormData(document.forms.simDeleteEvents);

		// Добавим немного информации
		formData.append("delete", "sim");

		deleteEventsIDs.forEach(function(item, i, deleteEventsIDs) {
			formData.append(i, item);
		});

		// Формируем запрос
		let xhr = new XMLHttpRequest();
	  
		xhr.open("POST", window.location.origin+"/core/sim/core/Model-user.php");
		// Отправим данные
		xhr.send(formData);

		// Пока ждём ответ крутим анимацию ожидания
		displayWaitingAlert();

		// Действия по окончани загрузки
		xhr.onload = function () {
		    if (xhr.readyState === xhr.DONE) {
		        if (xhr.status === 200) {
		            console.log(xhr.response);
		            displaySuccessAlert();
	            	document.location.href = xhr.response;
		        }else{
		    		console.log(xhr.status);
		            displayErrorAlert();
		        }
		    }
		}
	}
}

function displaySuccessAlert(){
	deleteEventsIDs = [];
	document.getElementsByClassName('alert-success')[0].className = document.getElementsByClassName('alert-dismissible')[0].className.replace(" scale-0", '');
	
}

function displayErrorAlert(){
	document.getElementsByClassName('alert-danger')[0].className = document.getElementsByClassName('alert-dismissible')[0].className.replace(" scale-0", '');
}

function displayWaitingAlert(){
	document.getElementsByClassName('alert-dismissible')[0].className = document.getElementsByClassName('alert-dismissible')[0].className.replace(" scale-1", " scale-0");
}

function cancelDeleteEvent(){
	deleteEventsIDs = [];
	document.getElementsByClassName('selectedEvents')[0].innerHTML = '';
	document.getElementsByClassName('alert-dismissible')[0].className = document.getElementsByClassName('alert-dismissible')[0].className.replace(" scale-1", " scale-0");
	document.getElementsByClassName('alertWrapper')[0].className = document.getElementsByClassName('alertWrapper')[0].className.replace(" scale-1", " scale-0");
}
