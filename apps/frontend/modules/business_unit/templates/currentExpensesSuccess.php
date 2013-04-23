<script>
var types = [ '<?php echo implode("', '", $types->getRawValue()); ?>' ];
</script>
<?php //use_stylesheet('default.css') ?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('jquery.jeditable.mini.js') ?>
<?php use_javascript('current_expenses.js') ?>
<?php use_javascript('inputmask.js') ?>
<div id="sf_admin_container" class="current_expenses">
	<div class="page-header">
	<h1>Текущие расходы</h1>
	</div>
	<div id="sf_admin_content">

		<div id="current_expenses_taxes">
							<!-- Taxes -->

			<table class="table table-bordered">
				<tr>
					<th>Наименование</th><th>Тип</th>
					<?php for($i = 0; $i < 12; $i++):?>
					<th><?php echo date('m/Y', strtotime('first day of +'.$i.' month')); ?></th>
					<?php endfor; ?>
					<th>Итого</th>
                    <th>%</th>
				</tr>

				<?php foreach($expence_types as $key => $et): ?>
					<tr class="tax_main_<?php echo $key?>">
						<td style="background-color: #e7f4ff;"><a class="expand" href="javascript:;">развернуть</a></td>
						<td style="background-color: #e7f4ff;"><?php echo $et->getName(); ?></td>
						<?php for($i = 0; $i < 12; $i++):?>
							<td style="background-color: #e7f4ff;" desc="<?php echo $et->getCode();?>_0_<?php echo date('m', strtotime('first day of +'.$i.' month')).'_'.date('Y', strtotime('first day of +'.$i.' month')); ?>"></td>
						<?php endfor; ?>
						<td desc="<?php echo $et->getCode();?>_all" style="background-color: #e7f4ff;" class="year_sum"></td>
                        <td desc="<?php echo $et->getCode();?>_percent" style="background-color: #e7f4ff;" class="year_percent"></td>
					</tr>
					<?php foreach($expenses as $ce): ?>
						<?php if($et->getCode() == $ce->getExpencesType()->getCode()): ?>
							<tr class="tax tax_<?php echo $key?>" id="tax_<?php echo $ce->getId() ?>">
								<td>
                                    <a href="<?php echo url_for('current_expenses/delRow?id='.$ce->getId().'&business_unit_id='.$business_unit_id);?>" onclick="return confirm('Вы уверены?');">-</a>
                                    <?php echo $ce->getName() ?>
                                </td>
								<td><?php echo $ce->getExpencesType()->getName(); ?></td>
								<?php for($i = 0; $i<12; $i++):?>
								<td <?php echo ($ce->getMonthPayment($i)->getIsConfirmed())?'':'class="edit"';?> info="<?php echo $ce->getMonthPayment($i)->getId(); ?>" desc="<?php echo $ce->getExpencesType()->getCode();?>_<?php echo $ce->getId(); ?>_<?php echo date('m', strtotime('first day of +'.$i.' month')).'_'.date('Y', strtotime('first day of +'.$i.' month')); ?>" data='{"id":"<?php echo $ce->getMonthPayment($i)->getId() ?>"}'>
								<?php include_partial('business_unit/regular_expence', array('mp' => $ce->getMonthPayment($i))); ?>
								</td>
								<?php endfor; ?>
								<td desc="<?php echo $ce->getExpencesType()->getCode();?>_<?php echo $ce->getId(); ?>_0"></td>
                                <td></td>
							</tr>

						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				<tr>
					<td>Итого</td>
					<td></td>
					<?php for($i = 0; $i < 12; $i++):?>
					<td desc="col_sum_<?php echo date('m', strtotime('first day of +'.$i.' month')).'_'.date('Y', strtotime('first day of +'.$i.' month')); ?>" class="summ_by_month"></td>
					<?php endfor; ?>

					<td id="tax_sum_month_all"></td>
                    <td></td>
				</tr>
                <tr>
                    <td>Оплачено</td>
                    <td></td>
                    <?php for($i = 0; $i < 12; $i++):?>
                        <td desc="col_sum_confirmed_<?php echo date('m', strtotime('first day of +'.$i.' month')).'_'.date('Y', strtotime('first day of +'.$i.' month')); ?>" class="summ_by_month"></td>
                    <?php endfor; ?>

                    <td id="tax_sum_month_confirmed_all"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Не оплачено</td>
                    <td></td>
                    <?php for($i = 0; $i < 12; $i++):?>
                        <td desc="col_sum_notconfirmed_<?php echo date('m', strtotime('first day of +'.$i.' month')).'_'.date('Y', strtotime('first day of +'.$i.' month')); ?>" class="summ_by_month"></td>
                    <?php endfor; ?>

                    <td id="tax_sum_month_notconfirmed_all"></td>
                    <td></td>
                </tr>


			</table>
			<div><a href="#" onclick="$('#tax_dialog').dialog('open');return false;" class="btn btn-primary">Новая строка</a></div>
		</div>
	</div>
</div>
<div class="dialog" id="tax_dialog">																					<!--Dialog box Tax-->
	<table>
		<tr>
			<td><label for="ce_tax_name">Категория трат:</label></td>
      <td><select name="ce[tax_type]" id="ce_tax_type">
      	<?php foreach($expence_types as $et): ?>
      		<option value="<?php echo $et->getId(); ?>"><?php echo $et->getName(); ?></option>
      	<?php endforeach; ?>
      </select></td>
		</tr>
		<tr>
			<td><label for="ce_tax_name">Наименование:</label></td>
      <td><input type="text" name="ce[tax_name]" id="ce_tax_name"></td>
		</tr>
	</table>
</div>												<!--End Dialog box-->
<div class="dialog" id="dialog_edit_expence">																					<!--Dialog box Job Payment-->
    <table>
        <tr>
            <td><label for="expence_amount">Сумма:</label></td>
            <td><input type="text" name="mp[amount]" id="expence_amount"></td>
        </tr>
    </table>
</div>
<a href="#" onclick='recount(types); return false;'>recount</a>
<script type="text/javascript">
	var business_unit_id = <?php echo $business_unit_id ?>;
	var save_field_data_url = "<?php echo url_for('current_expenses/saveTypedData') ?>";
	var new_row_url = "<?php echo url_for('current_expenses/addNewRow') ?>";
	var current_expenses_url = "<?php echo url_for('business_unit/currentExpenses?id='.$business_unit_id) ?>";
<?php /*
<?php //use_stylesheet('default.css') ?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('jquery.jeditable.mini.js') ?>
<?php use_javascript('current_expenses.js') ?>

<div id="sf_admin_container" class="current_expenses">
    <div class="page-header">
        <h1>Текущие расходы</h1>
    </div>
    <div id="sf_admin_content">

        <div id="current_expenses_taxes">
            <!-- Taxes -->

            <table class="table table-bordered">
                <tr>
                    <th>Наименование</th><th>Тип</th>
                    <?php for($i = 0; $i < 12; $i++):?>
                        <th><?php echo date('m/Y', strtotime('+'.$i.' month')); ?></th>
                    <?php endfor; ?>
                    <th>Итого</th>
                </tr>

                <?php foreach($expence_types as $key => $et): ?>
                    <tr class="tax_main_<?php echo $key?>">
                        <td style="background-color: #e7f4ff;"><a class="expand" href="javascript:;">развернуть</a></td>
                        <td style="background-color: #e7f4ff;"><?php echo $et->getName(); ?></td>
                        <?php for($i = 0; $i < 12; $i++):?>
                            <td style="background-color: #e7f4ff;" desc="<?php echo $et->getCode();?>_0_<?php echo date('m', strtotime('+'.$i.' month')).'_'.date('Y', strtotime('+'.$i.' month')); ?>"></td>
                        <?php endfor; ?>
                        <td desc="<?php echo $et->getCode();?>_all" style="background-color: #e7f4ff;" class="year_sum"></td>
                    </tr>
                    <?php foreach($expenses as $ce): ?>
                        <?php if($et->getCode() == $ce->getExpencesType()->getCode()): ?>
                            <tr class="tax tax_<?php echo $key?>" id="tax_<?php echo $ce->getId() ?>">
                                <td><?php echo $ce->getName() ?></td>
                                <td><?php echo $ce->getExpencesType()->getName(); ?></td>
                                <?php for($i = 0; $i<12; $i++):?>
                                    <td <?php echo ($ce->getMonthPayment($i)->getIsConfirmed())?'':'class="edit"';?> info="<?php echo $ce->getMonthPayment($i)->getId(); ?>" desc="<?php echo $ce->getExpencesType()->getCode();?>_<?php echo $ce->getId(); ?>_<?php echo date('m', strtotime('+'.$i.' month')).'_'.date('Y', strtotime('+'.$i.' month')); ?>" data='{"id":"<?php echo $ce->getMonthPayment($i)->getId() ?>"}'>
                                        <?php include_partial('business_unit/regular_expence', array('mp' => $ce->getMonthPayment($i))); ?>
                                    </td>
                                <?php endfor; ?>
                                <td desc="<?php echo $ce->getExpencesType()->getCode();?>_<?php echo $ce->getId(); ?>_0"></td>
                            </tr>

                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <tr>
                    <td>Итого</td>
                    <td></td>
                    <?php for($i = 0; $i < 12; $i++):?>
                        <td desc="col_sum_<?php echo date('m', strtotime('+'.$i.' month')).'_'.date('Y', strtotime('+'.$i.' month')); ?>" class="summ_by_month"></td>
                    <?php endfor; ?>

                    <td id="tax_sum_month_all"></td>
                </tr>

            </table>
            <div><a href="#" onclick="$('#tax_dialog').dialog('open');return false;" class="btn btn-primary">Новая строка</a></div>
        </div>
    </div>
</div>
<div class="dialog" id="tax_dialog">																					<!--Dialog box Tax-->
    <table>
        <tr>
            <td><label for="ce_tax_name">Категория трат:</label></td>
            <td><select name="ce[tax_type]" id="ce_tax_type">
                    <?php foreach($expence_types as $et): ?>
                        <option value="<?php echo $et->getId(); ?>"><?php echo $et->getName(); ?></option>
                    <?php endforeach; ?>
                </select></td>
        </tr>
        <tr>
            <td><label for="ce_tax_name">Наименование:</label></td>
            <td><input type="text" name="ce[tax_name]" id="ce_tax_name"></td>
        </tr>
    </table>
</div>												<!--End Dialog box-->

<script type="text/javascript">
    var business_unit_id = <?php echo $business_unit_id ?>;
    var save_field_data_url = "<?php echo url_for('current_expenses/saveTypedData') ?>";
    var new_row_url = "<?php echo url_for('current_expenses/addNewRow') ?>";
    var current_expenses_url = "<?php echo url_for('business_unit/currentExpenses?id='.$business_unit_id) ?>";

    function IsNumeric(input)
    {
        return (input - 0) == input && input.length > 0;
    }

    $(document).ready(function(){
        $('td').each(function(){

            if(IsNumeric($(this).text()) && $(this).text() != 0)
            //$(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000.00", locale:"ru"})+'</nobr>');
                $(this).find("input[type=checkbox]").hide();
        });
    });

*/?>
</script>