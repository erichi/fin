<?php use_helper('I18N')?>
<?php //use_stylesheet('default.css') ?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('cashflow.js') ?>
<?php use_javascript('jquery.ui.datepicker-ru.js')?>

<style>
#cashflow_container ul li
{
  padding: 0px;
  list-style: none;
}

.income_payments li{
	color: green;
}
.outcome_payments li{
	color: red;
}

</style>


<div id="cashflow_container" class="cashflow">
	<h1>Cashflow</h1>
		<hr/>
	<div id="sf_admin_content">
		<form action="<?php echo url_for('@cashflow')?>" method="POST">
			<input type="hidden" name="id" value="<?php echo $sf_request->getParameter('id'); ?>">
			<input type="text" name="date" id="cashflow_start_date" value="<?php echo date('Y-m-d'); ?>">
			<button class="btn" type="submit">Обновить по дате</button>
		</form>
		<div>
			<table class="table table-bordered">

				<tr>
					<th></th>
					<?php foreach ($range as $r): ?>
					<th><?php echo $r; ?></th>
					<?php endforeach; ?>
				</tr>
				<?php foreach ($result as $res): ?>
				<tr>
					<td><?php echo $res['name']; ?></td>
					<?php foreach ($res['dates'] as $date): ?>
						<?php if(!empty($date)):?>
						<td>
							<?php if(isset($date['in'])): ?>
							<ul class="income_payments">	
								<?php foreach ($date['in'] as $amount): ?>
								<li><?php echo $amount; ?></li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
							<?php if(isset($date['out'])): ?>
							<ul class="outcome_payments">	
								<?php foreach ($date['out'] as $amount): ?>
								<li><?php echo $amount; ?></li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</td>

						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>

			</table>
		</div>
	</div>
</div>
<?php /*

<script type="text/javascript">
	var cashflow_index_url = "<?php echo url_for('business_unit/cashflow?id='.$business_unit_id.'&date='.$date) ?>";
	var approve_income_payment_url = "<?php echo url_for('business_unit/approveIncomePayment') ?>";
	var approve_outcome_payment_url = "<?php echo url_for('business_unit/approveOutcomePayment') ?>";
</script>
*/
?>