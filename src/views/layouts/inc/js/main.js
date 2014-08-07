$(document).ajaxError(function () {
	alert('Ошибка запроса к серверу');
	$('button').attr('disabled', false);
});