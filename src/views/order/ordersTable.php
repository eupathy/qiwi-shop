<?php
/**
 * @var Order   $orders
 * @var Setting $settings
 */
use FintechFab\QiwiShop\Models\Order;
use FintechFab\QiwiShop\Models\Setting;
use FintechFab\QiwiShop\Widgets\ButtonsForOrdersTable;

echo View::make('ff-qiwi-shop::order.inc.createOrder');
?>
<?= View::make('ff-qiwi-shop::order.inc.payReturnModal') ?>
<script type="application/javascript">
	<?php require(__DIR__ . '/../layouts/inc/js/ActionTableButtons.js') ?>
</script>

<?=
Form::button('Новый заказ', array(
	'class'       => 'btn btn-primary',
	'id'          => 'newOrder',
	'data-toggle' => 'modal',
	'data-target' => '#newOrderModal',
))?>
<br><br>
<table class="table table-striped table-hover" id="ordersTable">
	<tr>
		<td><b>ID</b></td>
		<td><b>Название</b></td>
		<td><b>Сумма</b></td>
		<td><b>Комментарий</b></td>
		<td><b>Статус</b></td>
		<td><b>Сумма возвратов</b></td>
		<td><b>Действия с заказом</b></td>
	</tr>
	<?php foreach ($orders as $order): ?>
		<?php $arr = ButtonsForOrdersTable::getButtons($order, $settings) ?>
		<tr>
			<td><?= $order->id ?></td>
			<td><?= $order->item ?></td>
			<td><?= $order->sum ?></td>
			<td><?= $order->comment ?></td>
			<td><?= $arr['status'] ?></td>
			<td><?= $arr['sumReturn'] ?></td>
			<td><?= $arr['activity'] ?></td>
		</tr>

	<?php endforeach ?>
</table>
<?= $orders->links() ?>
<div id="message" class="text-center"></div>
