<?php

?>
<div class="row">
	<div class="col-md-5">
		<h2>О пакете QIWI shop</h2>

		<p>Это иммитация интернет магизина для работы с платёжной системой QIWI:</p>

		<ul>
			<li>Оформление заказа</li>
			<li>Выставление на него счёта в системе QIWI</li>
			<li>Отмена счёта</li>
			<li>Оплата счёта</li>
			<li>Возвврат средств после оплаты</li>
		</ul>
	</div>

	<div class="col-md-6">

		<h2>Ссылки</h2>

		<p>Пакет на <a href="https://github.com/fintech-fab/qiwi-shop">GitHub</a></p>

		<p>Для работы необходим пакет взаимодействия с сервером QIWI - PHP SDK:</p>
		<ul>
			<li>
				<a href="https://github.com/fintech-fab/qiwi-sdk"> GitHub </a>.
			</li>
			<li>
				<a href="<?= URL::route('aboutSdk') ?>">Описание</a>.
			</li>
		</ul>
		<p>
			Отдельно полноценный эмулятор работы системы QIWI можно взять
			<a href="https://github.com/fintech-fab/qiwi-shop">здесь</a>. </p>

		<p>
			Для установки пакета необходим фреймоврк <a href="http://laravel.com">Laravel</a>. </p>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<h2>Описание работы</h2>

		<p>
			Для работы с магазином требуется авторизированный пользователь в сессии. Подробнее от этом
			<a href="https://github.com/fintech-fab/qiwi-shop#%D0%9F%D0%BE%D0%BB%D1%83%D1%87%D0%B5%D0%BD%D0%B8%D0%B5-id-%D0%BF%D0%BE%D0%BB%D1%8C%D0%B7%D0%BE%D0%B2%D0%B0%D1%82%D0%B5%D0%BB%D1%8F-%D0%B4%D0%BB%D1%8F-%D0%B0%D0%B2%D1%82%D0%BE%D1%80%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D0%B8">
				здесь. </a>
		</p>

		<p>
			Callback запросы от сервера QIWI обрабатывается по адресу:<br>
			<?= URL::route('processCallback') ?> </p>
	</div>
</div>