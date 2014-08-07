<?php
/**
 * @var int $user_id
 */
?>
<script type="application/javascript">
	<?php require(__DIR__ . '/../layouts/inc/js/ActionSettings.js') ?>
</script>
<div class="text-center inner">
	<h3>Установить настройки</h3>

	<div class="form-group row">
		<?= Form::label('inputId', 'ID пользователя:', array('class' => 'col-sm-4 control-label')) ?>

		<div class="col-sm-4">
			<?=
			Form::input('text', 'user_id', $user_id, array(
				'class'    => 'form-control',
				'id'       => 'inputId',
				'required' => '',
				'disabled' => '',
			));
			?>
		</div>
		<div id="errorId" class="error col-sm-4 text-left"></div>
	</div>
	<div class="form-group row">
		<?= Form::label('inputName', 'Название организации:', array('class' => 'col-sm-4 control-label')) ?>

		<div class="col-sm-4">
			<?=
			Form::input('text', 'name', '', array(
				'placeholder' => 'Название',
				'class'       => 'form-control',
				'id'          => 'inputName',
				'required'    => 'required',
			));
			?>
		</div>
		<div id="errorName" class="error col-sm-4 text-left"></div>
	</div>
	<div class="form-group row">
		<?= Form::label('inputGateId', 'Id в системе QIWI:', array('class' => 'col-sm-4 control-label')) ?>

		<div class="col-sm-4">
			<?=
			Form::input('text', 'gateId', $user_id, array(
				'placeholder' => 'Скорее всего равен ID пользователя',
				'class'       => 'form-control',
				'id'          => 'inputGateId',
				'required'    => '',
			));
			?>
		</div>
		<div id="errorGateId" class="error col-sm-4 text-left"></div>
	</div>
	<div class="form-group row">
		<?= Form::label('inputPassword', 'Пароль в системе QIWI:', array('class' => 'col-sm-4 control-label')) ?>
		<div class="col-sm-4">
			<?=
			Form::input('password', 'password', '', array(
				'placeholder' => 'Пароль в системе QIWI',
				'class'       => 'form-control',
				'id'          => 'inputPassword',
				'required'    => '',
			));
			?>
		</div>
		<div id="errorPassword" class="error col-sm-4 text-left"></div>

	</div>
	<div class="form-group row">
		<?= Form::label('inputKey', 'Ключ из системы QIWI:', array('class' => 'col-sm-4 control-label')) ?>
		<div class="col-sm-4">
			<?=
			Form::input('text', 'key', '', array(
				'placeholder' => 'Ключ из системы QIWI',
				'class'       => 'form-control',
				'id'          => 'inputKey',
			));
			?>
		</div>
		<div id="errorKey" class="error col-sm-4 text-left"></div>
	</div>
	<div class="form-group row">
		<?= Form::label('inputLifetime', 'Срок действия заказа (дней):', array('class' => 'col-sm-4 control-label')) ?>
		<div class="col-sm-4">
			<?=
			Form::input('text', 'lifetime', 3, array(
				'placeholder' => 'Срок действия заказа',
				'class'       => 'form-control',
				'id'          => 'inputLifetime',
			));
			?>
		</div>
		<div id="errorLifetime" class="error col-sm-4 text-left"></div>
	</div>
	<div class="form-group row">
		<?= Form::label('inputGateUrl', 'Ссылка на QIWI Gate:', array('class' => 'col-sm-4 control-label')) ?>
		<div class="col-sm-4">
			<?php $url = str_replace(':8000', '', URL::to('/qiwi/gate/api/v2/prv/')) . '/'; ?>
			<?=
			Form::input('text', 'gateUrl', $url, array(
				'placeholder' => $url,
				'class'       => 'form-control',
				'id'          => 'inputGateUrl',
			));
			?>
		</div>
		<div id="errorGateUrl" class="error col-sm-4 text-left"></div>
	</div>
	<div class="form-group row">
		<?= Form::label('inputPayUrl', 'Ссылка для оплаты:', array('class' => 'col-sm-4 control-label')) ?>
		<div class="col-sm-4">
			<?=
			Form::input('text', 'payUrl', URL::to('/qiwi/gate/order/external/main.action'), array(
				'placeholder' => URL::to('/qiwi/gate/order/external/main.action'),
				'class'       => 'form-control',
				'id'          => 'inputPayUrl',
			));
			?>
		</div>
		<div id="errorPayUrl" class="error col-sm-4 text-left"></div>
	</div>

	<br>
	<?=
	Form::button('Сохранить', array(
		'id'    => 'saveSettings',
		'class' => 'btn btn-success',
	));
	?>

</div>
<div id="message" class="row"></div>