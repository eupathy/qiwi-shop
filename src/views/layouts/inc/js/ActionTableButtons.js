$(document).ready(function () {
	$('button.tableBtn').click(function () {
		$('button').attr('disabled', true);
		var $btn = $(this);
		var action = $btn.data('action');
		var id = $btn.data('id');

		$.post('orders/action/' + action, {order_id: id},
			function (data) {
				$('button').attr('disabled', false);
				$('#message').dialog({
					title: data['title'], show: 'fade', hide: 'fade', modal: true, close: function () {
						location.reload();
					}
				}).html(data['message']);
			}
		);
	});

	$('button.actionBtn').click(function () {
		var $btn = $(this);
		var $modal = $('#payReturn');
		$modal.data('id', $btn.data('id'));
		$modal.data('action', $btn.data('action'));
	});

	$('button.payReturnModal').click(function () {
		$('button').attr('disabled', true);
		var $modal = $(this).parents('#payReturn');
		var action = $modal.data('action');
		var id = $modal.data('id');

		var sum = $modal.find('#inputReturnSum').val();
		var comment = $modal.find('#inputReturnComment').val();

		$.post('orders/action/' + action, {order_id: id, sum: sum, comment: comment},
			function (data) {
				$('button').attr('disabled', false);
				if (data['error']) {
					$('#errorReturnSum').html(data['error']['sum']);
					$('#errorReturnComment').html(data['error']['comment']);
					return;
				}
				$('#payReturn').modal('hide');
				$('#message').dialog({
					title: data['title'], show: 'fade', hide: 'fade', modal: true, close: function () {
						location.reload();
					}
				}).html(data['message']);
			}
		);
	});

	$('#createOrder').click(function () {
		$('button').attr('disabled', true);
		var item = $('#inputItem').val();
		var sum = $('#inputSum').val();
		var tel = $('#inputTel').val();
		var comment = $('#inputComment').val();
		$.post('/qiwi/shop/orders/create', { item: item, sum: sum, tel: tel, comment: comment},
			function (data) {
				if (data['errors']) {
					$('#errorItem').html(data['errors']['item']);
					$('#errorSum').html(data['errors']['sum']);
					$('#errorTel').html(data['errors']['tel']);
					$('#errorComment').html(data['errors']['comment']);
					$('#errorCommon').html(data['errors']['common']);
					$('button').attr('disabled', false);
				}
				if (data['result'] == 'ok') {
					alert(data['message']);
					location.reload();
				}
			}
		);

	});
});
