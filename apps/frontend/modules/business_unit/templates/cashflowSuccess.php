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
			<input type="hidden" name="id" value="<?php echo $business_unit_id ?>">
			<input type="text" name="date" id="cashflow_start_date" value="<?php echo $date ?>">
			<button class="btn" type="submit">Обновить по дате</button>
		</form>
		<div>
			<table class="table table-bordered">
				<tr>
					<th>Компания</th>
					<?php foreach ($columns[0] as $day_of_week) {
						echo '<th>'.$day_of_week['day_name'].'<br/><i class="date">'.$day_of_week['date'].'</i></th>';
					} ?>
					<?php if (count($columns[1])) {
						foreach ($columns[1] as $week) {
							echo '<th>'.$week['week_name'].'</th>';
						} 
					}?>
					<?php if (count($columns[2])) {
						echo '<th>'.__($columns[2]['month_name']).'</th>';
					} ?>
					<?php if (isset($columns[3])) {
						foreach ($columns[3] as $month) {
							echo '<th>'.__($month['month_name']).'</th>';
						}
					} ?>
					<th>Всего</th>
				</tr>
				<?php foreach ($data as $data_row): ?>
				
					<tr>
						
						<?php if($data_row['type'] == 'cur_exp' ){														//if Days for CurrentExpenses
//							foreach ($data_row['columns'][0] as $day_column) {
//								echo '<td><ul class="outcome_payments"><li>'.$day_column['amount'].'</li></ul></td>';
//							}
						} else { ?>
						<td><?php echo $data_row['name'] ?></td>
						<?php foreach ($data_row['columns'][0] as $day_column): ?>										<!-- Days -->
							<td>
								<ul class="income_payments">	
									<?php if(count($day_column['income'])){
										 foreach ($day_column['income'] as $income): ?>
											<li>
												<?php echo $income['amount']?>
												<?php if (!$income['approved']): ?>
													<button type="button" class="btn btn-success btn-mini" onclick="approveJoIp(<?php echo $income['id'] ?>)"><i class="icon-ok icon-white"></i></button>
												<?php endif; ?>
											</li>
									<?php endforeach;} else { echo '<li>0</li>';} ?>
								</ul>
								<ul class="outcome_payments">
									<?php  if(count($day_column['outcome'])){
										foreach ($day_column['outcome'] as $outcome): ?>
										<li>
										  <?php echo $outcome['amount'] ?>
                        <?php echo $outcome['filename'] ? '('.link_to('скачать', '/uploads/'.$outcome['filename'], array('target'=>'_blank')).')' : '' ?>
                        <?php if (!$outcome['approved']): ?>
                          <button type="button" class="btn btn-success btn-mini" onclick="approveJoOp(<?php echo $outcome['id'] ?>)"><i class="icon-ok icon-white"></i></button>
                        <?php endif; ?>
										</li>
									<?php endforeach; } else { echo '<li>0</li>';} ?>
								</ul>
							</td>
						<?php endforeach;
						} ?>
						
						<?php if (isset($data_row['columns'][1])): ?>														<!-- If Weeks exists -->
							<?php if($data_row['type'] == 'cur_exp' ) {													
//								foreach ($data_row['columns'][1] as $week_column) {
//									echo '<td><ul class="outcome_payments"><li>'.$week_column['outcome'].'</li></ul></td>';
//								}
							} else { ?>
							<?php foreach ($data_row['columns'][1] as $week_column): ?>						<!-- Weeks -->
								<td>
									<ul class="income_payments">
										<li><?php echo $week_column['income'] ?></li>
									</ul>
									<ul class="outcome_payments">
										<li><?php echo $week_column['outcome'] ?></li>
									</ul>
								</td>
							<?php endforeach;
							} ?>
						<?php endif; ?>
						
						<?php if (isset($data_row['columns'][2])): ?>														<!-- If Broken month exists -->
							<?php if($data_row['type'] == 'cur_exp' ) {
//								if (isset($data_row['columns'][2])) {
//									echo '<td><ul class="outcome_payments"><li>'.$data_row['columns'][2]['outcome'].'</li></ul></td>';
//								}
							} else { ?>
							<?php if ($data_row['columns'][2]): ?>																<!-- IF broken month exist -->
								<td>
									<ul class="income_payments">
										<li><?php echo $data_row['columns'][2]['income'] ?></li>
									</ul>
									<ul class="outcome_payments">
										<li><?php echo $data_row['columns'][2]['outcome'] ?></li>
									</ul>							
								</td>
							<?php endif;
							}?>
						<?php endif; ?>
						
						<?php if (isset($data_row['columns'][3])): ?>														<!-- If Months exists -->
							<?php if($data_row['type'] == 'cur_exp' ) {
//								foreach ($data_row['columns'][3] as $month_column) {
//									echo '<td><ul class="outcome_payments"><li>'.$month_column['outcome'].'</li></ul></td>';
//								}
							} else { ?>
							<?php foreach ($data_row['columns'][3] as $month_column): ?>					<!-- Months -->
								<td>
									<ul class="income_payments">
										<li><?php echo $month_column['income'] ?></li>
									</ul>
									<ul class="outcome_payments">
										<li><?php echo $month_column['outcome'] ?></li>
									</ul>
								</td>
							<?php endforeach;
							} ?>
						<?php endif; ?>
						
						<?php if($data_row['type'] == 'cur_exp' ) {
								//echo '<td><ul class="outcome_payments"><li>'.$data_row['total_outcome'].'</li></ul></td>';
						} else { ?>
							<td>
								<ul class="income_payments">
									<li><?php echo $data_row['total_income'] ?></li>
								</ul>
								<ul class="outcome_payments">
									<li><?php echo $data_row['total_outcome'] ?></li>
								</ul>
							</td>
						<?php } ?>
					</tr>
				<?php endforeach; ?>
				<tr> 

				<?php foreach ($data_expences as $key => $expences) {
					 echo '<tr><td>'.$expences_type[$key-1].'</td>';
					
						  $sum = 0;
					       foreach ($expences as $val) {
					       		echo '<td><ul class="outcome_payments"><li>'.$val.'</li></ul></td>';
					       		$sum += $val;
					       }
					echo '<td><ul class="outcome_payments"><li>'.$sum.'</li></ul></td>';
			  		echo '</tr>';				
				}?>
																										<!-- Bottom sum row -->
					<td>Всего</td>
					<?php $total_income = 0; $total_outcome = 0; 
					foreach ($col_sum as $col_sum_section) {
							foreach ($col_sum_section as $col_sum) {
								echo '<td><ul class="income_payments"><li>'.$col_sum['income'].'</li></ul><ul class="outcome_payments"><li>'.$col_sum['outcome'].'</li></ul></td>';
								$total_income += $col_sum['income'];
								$total_outcome += $col_sum['outcome'];
							}
					}?>
					<td><ul class="income_payments"><li><?php echo $total_income ?></li></ul><ul class="outcome_payments"><li><?php echo $total_outcome ?></li></ul></td>
				</tr>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	var cashflow_index_url = "<?php echo url_for('business_unit/cashflow?id='.$business_unit_id.'&date='.$date) ?>";
	var approve_income_payment_url = "<?php echo url_for('business_unit/approveIncomePayment') ?>";
	var approve_outcome_payment_url = "<?php echo url_for('business_unit/approveOutcomePayment') ?>";
</script>