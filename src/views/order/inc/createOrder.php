<div class="modal fade" id="newOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title text-center">Новый заказ</h4>
			</div>
			<div class="modal-body">
				<div class="text-center inner">

					<div class="form-group row">
						<?= Form::label('inputItem', 'Наименование товара:', array('class' => 'col-sm-4 control-label')) ?>

						<div class="col-sm-7">
							<?=
							Form::input('text', 'item', '', array(
								'placeholder' => 'Наименование',
								'class'       => 'form-control',
								'id'          => 'inputItem',
								'required'    => 'required',
							));
							?>
						</div>
						<div id="errorItem" class="error col-sm-offset-1 col-sm-12 text-center"></div>
					</div>
					<div class="form-group row">
						<?= Form::label('inputSum', 'Сумма(руб):', array('class' => 'col-sm-4 control-label')) ?>

						<div class="col-sm-7">
							<?=
							Form::input('text', 'sum', '', array(
								'placeholder' => 'Сумма заказа',
								'class'       => 'form-control',
								'id'          => 'inputSum',
								'required'    => 'required',
							));
							?>
						</div>
						<div id="errorSum" class="error col-sm-offset-1 col-sm-12 text-center"></div>
					</div>
					<div class="form-group row">
						<?= Form::label('inputTel', 'Телефон:', array('class' => 'col-sm-4 control-label')) ?>
						<div class="col-sm-7">
							<?=
							Form::input('tel', 'tel', '', array(
								'placeholder' => '+12345678900',
								'class'       => 'form-control',
								'id'          => 'inputTel',
								'required'    => 'required',
							));
							?>
						</div>
						<div id="errorTel" class="error col-sm-offset-1 col-sm-12 text-center"></div>

					</div>
					<div class="form-group row">
						<?= Form::label('inputComment', 'Комментарий:', array('class' => 'col-sm-4 control-label')) ?>
						<div class="col-sm-7">
							<?=
							Form::textarea('comment', '', array(
								'placeholder' => 'Комментарий к заказу (если нужен)',
								'class'       => 'form-control',
								'id'          => 'inputComment',
								'rows'        => '5',
							));
							?>
						</div>
						<div id="errorComment" class="col-sm-offset-1 col-sm-12 text-center"></div>
					</div>
					<div id="errorCommon" class="error text-center"></div>
					<br>
					<?=
					Form::button('Оформить заказ', array(
						'id'    => 'createOrder',
						'class' => 'btn btn-success',
					));
					?>
					<?=
					Form::button('Отмена', array(
						'class'        => 'btn btn-danger',
						'data-dismiss' => 'modal',
					));
					?>

				</div>
			</div>
			<div id="message" class="row"></div>
		</div>
	</div>
</div>