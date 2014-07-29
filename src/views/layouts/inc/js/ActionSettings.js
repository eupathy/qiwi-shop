$(document).ready(function () {

	$('#saveSettings').click(function () {
		$('button').attr('disabled', true);
		var name = $('#inputName').val();
		var gateId = $('#inputGateId').val();
		var password = $('#inputPassword').val();
		var key = $('#inputKey').val();
		var lifetime = $('#inputLifetime').val();
		var gateUrl = $('#inputGateUrl').val();
		var payUrl = $('#inputPayUrl').val();
		$.post('', {
				name: name,
				gateId: gateId,
				password: password,
				key: key,
				lifetime: lifetime,
				gateUrl: gateUrl,
				payUrl: payUrl
			},
			function (data) {

				if (data['errors']) {
					$('#errorName').html(data['errors']['name']);
					$('#errorGateId').html(data['errors']['gateId']);
					$('#errorPassword').html(data['errors']['password']);
					$('#errorKey').html(data['errors']['key']);
					$('#errorLifetime').html(data['errors']['lifetime']);
					$('#errorGateUrl').html(data['errors']['gateUrl']);
					$('#errorPayUrl').html(data['errors']['payUrl']);
					$('button').attr('disabled', false);
					return;
				}
				$('#message').dialog({
					title: 'Сообщение', show: 'fade', hide: 'fade', modal: true, close: function () {
						location.replace("/qiwi/shop/orders/create");
					}
				}).html(data['message']);
			}
		);

	});
});
