<?php

use FintechFab\QiwiShop\Models\Setting;

/**
 * @var Setting $setting
 */

?>
<script type="application/javascript">
	<?php require(__DIR__ . '/../layouts/inc/js/ActionSettings.js') ?>
</script>
<div class="text-center inner">
	<h3>Изменить настройки</h3>

	<div class="form-group row">
		<?= Form::label('inputName', 'Название организации:', array('class' => 'col-sm-4 control-label')) ?>

		<div class="col-sm-4">
			<?=
			Form::input('text', 'name', $setting->name, array(
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
			Form::input('text', 'gate_id', $setting->gate_id, array(
				'placeholder' => 'Id в системе QIWI',
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
			Form::input('password', 'password', $setting->gate_password, array(
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
			Form::input('text', 'key', $setting->gate_key, array(
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
			Form::input('text', 'lifetime', $setting->lifetime, array(
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
			<?=
			Form::input('text', 'gateUrl', $setting->gate_url, array(
				'placeholder' => 'Ссылка на QIWI Gate:',
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
			Form::input('text', 'payUrl', $setting->pay_url, array(
				'placeholder' => 'Ссылка для оплаты:',
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