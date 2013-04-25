<?php //use_stylesheet('default.css')?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('jquery.jeditable.mini.js') ?>
<?php use_javascript('project_report.js') ?>

<div id="sf_admin_container" class="project_report">
	<h1>Отчет по проектам</h1>
	<div id="sf_admin_content">
		<div>

			<?php include_component('business_unit', 'reportTable', array('bu_id' => $sf_request->getParameter('id'))) ?>

			<h2 style="margin-top:20px;">Реальные проекты</h2>											<!-- Tenders -->
			<hr/>
			<table class="table">
			<thead>
				<tr>
					<th>Проект</th><th>бюджет</th>
					<th>себестоимость</th>
					<th>маржа</th>
					<th>% маржи</th>
					<th>доля в обороте</th>
					<th>доля в плане</th>
					<th>приход</th>
					<th>расход</th>

					<th>дебет</th>
					<th>кредит</th>
					<th>сальдо</th>

				</tr>
			</thead>
			<tbody>
				<?php foreach ($job_orders as $jo): ?>
					<tr>
						<td>
                        <?php if($jo->getId() != -1) : ?>
                            <a href="/job_order/<?php echo $jo->getId(); ?>/edit"><?php echo $jo->getName(); ?></a>
                        <?php else : echo $jo->getName(); endif;  ?>
                        </td>
						<td><?php echo $jo->getBudget(); ?></td>
						<td><?php echo $jo->getProductionCost();?></td>
						<td><?php echo $jo->getMargin(); ?></td>
						<td><?php echo $jo->getMarginPercent(); ?>%</td>
						<td><?php echo $jo->getTurnoverShare(); ?>%</td>
						<td><?php echo $jo->getPlanShare(); ?>%</td>
						<td><?php echo $jo->getIncome(); ?></td>
						<td><?php echo $jo->getOutcome(); ?></td>
						<td><?php echo $jo->getDebet(); ?></td>
						<td><?php echo $jo->getCredit(); ?></td>
						<td><?php echo $jo->getSaldo(); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			</table>
			<div><?php echo link_to('Новый проект', 'job_order/new?return_to_pr='.$business_unit->getId(), 'class=btn btn-primary') ?></div>

		</div>
			<br />																											<!--    Tenders		 -->
		<div>
			<h2>Тендеры</h2>
			<hr/>
			<table class="table">
				<tr>
					<th>Проект</th><th>бюджет</th>
					<th>себестоимость</th>
					<th>маржа</th>
					<th>% маржи</th>
					<th>доля в обороте</th>
					<th>доля в плане</th>
					<?php /*
					<th>приход</th>
					<th>расход</th>
					<th>дебет</th>
					<th>кредит</th>
					<th>сальдо</th>*/
					?>
					<th></th>
				</tr>
				<?php foreach ($tenders as $tender){
						if ($tender->getStatus() == 'new'): ?>
					<tr>
						<td class="noFormat">
                        <?php if($tender->getId() != -1) : ?>
                            <a href="<?php echo url_for('tender_edit', array('id' => $tender->getId(), 'business_unit' => $business_unit->getId(), 'return_to_pr' => $business_unit->getId()));?>"><?php echo $tender->getName() ?></a>
                        <?php else : echo $tender->getName(); endif; ?>
                        </td>
						<td class="formatInt"><?php echo $tender->getBudget() ?></td>
						<td class="formatInt"><?php echo $tender->getAmount() ?></td>
						<td class="formatInt"><?php echo $tender->getMargin(); ?></td>
						<td><?php echo $tender->getMarginPercent(); ?>%</td>
						<td><?php echo $tender->getTurnoverShare(); ?>%</td>
						<td><?php echo $tender->getPlanShare(); ?>%</td>
						<?php /*
						<td>33000</td>
						<td>54777</td>
						<td>233333</td>
						<td>20000</td>
						<td>320000</td>*/
						?>
						<td>
						<div class="btn-group">
          <a class="btn btn-mini" href="#">Результат</a>
          <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo '/job_order/new?tender_id='.$tender->getId().'&return_to_pr='.$business_unit->getId(); ?>"><i class="icon-thumbs-up"></i> Выигран</a></li>
            <li><a href="<?php echo '/business_unit/loseTender?tender_id='.$tender->getId().'&bu_id='.$business_unit->getId(); ?>"><i class="icon-thumbs-down"></i> Проигран</a></li>
          </ul>
        </div>
						</td>
					</tr>
				<?php endif;
				} ?>
			</table>
			<div><?php echo link_to('Новый тендер', 'tender/new?return_to_pr='.$business_unit->getId(), 'class=btn btn-primary') ?></div>

		</div>
		<br />
		<div>																											<!--    Lost Tenders		 -->
			<h2>Проигранные тендеры</h2>
			<hr/>
			<table class="table">
				<tr>
					<th>Проект</th><th>бюджет</th>
					<th>себестоимость</th>
					<th>маржа</th>
					<th>% маржи</th>
					<th>доля в обороте</th>
					<th>доля в плане</th>
					<?php /*
					<th>приход</th>
					<th>расход</th>
					<th>дебет</th>
					<th>кредит</th>
					<th>сальдо</th>*/
					?>
                    <th></th>
				</tr>
				<?php foreach ($tenders as $tender){
						if ($tender->getStatus() == 'lost'): ?>
					<tr>
						<td class="noFormat"><?php echo $tender->getName() ?></td>
						<td class="formatInt"><?php echo $tender->getBudget() ?></td>
						<td class="formatInt"><?php echo $tender->getAmount() ?></td>
						<td class="formatInt"><?php echo $tender->getMargin(); ?></td>
						<td><?php echo $tender->getMarginPercent(); ?>%</td>
						<td><?php echo $tender->getTurnoverShare(); ?>%</td>
						<td><?php echo $tender->getPlanShare(); ?>%</td>
                        <td>
                        <?php if($tender->getId() != -1) : ?>
                            <a href="<?php echo '/business_unit/renewTender?tender_id='.$tender->getId().'&bu_id='.$business_unit->getId(); ?>"><i class="icon-thumbs-up"></i>Вернуть</a>
                        <?php endif; ?>
                        </td>
						<?php /*
						<td>33000</td>
						<td>54777</td>
						<td>233333</td>
						<td>20000</td>
						<td>320000</td>*/
						?>
					</tr>
				<?php endif;
				} ?>
			</table>
		</div>
		<br />
		<div style="margin-top:20px;">																<!-- Plans -->
			<h2>Планы</h2>
			<hr/>
			<table class="table">
				<tr>
					<th>Проект</th><th>бюджет</th>
					<th>себестоимость</th>
					<th>маржа</th>
					<th>% маржи</th>
					<th>доля в обороте</th>
					<th>доля в плане</th>
					<?php /*
					<th>приход</th>
					<th>расход</th>
					<th>дебет</th>
					<th>кредит</th>
					<th>сальдо</th>
					<th></th>*/
					?>
                    <th></th>
				</tr>
				<?php foreach ($plans as $plan){
						if (!$plan->getJobOrderId()): ?>
					<tr>
						<td class="noFormat">
                        <?php if($plan->getId() != -1) : ?>
                            <a href="<?php echo url_for('plan_edit', array('id' => $plan->getId(), 'busines_unit' => $business_unit->getId(),'return_to_pr' => $business_unit->getId()));?>"><?php echo $plan->getName() ?></a>
                        <?php else : echo $plan->getName(); endif; ?>
                        </td>
						<td class="formatInt"><?php echo $plan->getBudget() ?></td>
						<td class="formatInt"><?php echo $plan->getAmount() ?></td>
						<td class="formatInt"><?php echo $plan->getMargin(); ?></td>
						<td><?php echo $plan->getMarginPercent(); ?>%</td>
						<td><?php echo $plan->getTurnoverShare(); ?>%</td>
						<td><?php echo $plan->getPlanShare(); ?>%</td>
						<?php /*
						<td>33000</td>
						<td>54777</td>
						<td>233333</td>
						<td>20000</td>
						<td>320000</td>*/
						?>
						<td>
                        <?php if($plan->getId() != -1) : ?>
                            <div class="btn-group">
                                <a class="btn btn-mini" href="#">Перенести</a>
                                <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo '/job_order/new?plan_id='.$plan->getId().'&return_to_pr='.$business_unit->getId(); ?>">В "реальные"</a></li>
                                    <li><a href="<?php echo '/business_unit/PlanToTender?plan_id='.$plan->getId().'&bu_id='.$business_unit->getId(); ?>">В тендеры</a></li>
                                </ul>
                            </div>
							<?php // echo link_to('перенести в "реальные"', 'job_order/new?plan_id='.$plan->getId().'&return_to_pr='.$business_unit->getId()) ?>
                        <?php endif; ?>
						</td>
					</tr>
				<?php endif;
				} ?>
			</table>
			<div><?php echo link_to('Запланировать', 'plan/new?return_to_pr='.$business_unit->getId(), 'class=btn btn-primary') ?></div>
		</div>

	</div>
</div>
<script type="text/javascript">
	var save_field_data_url = "<?php echo url_for('business_unit/saveTypedData') ?>";
	var save_bu_id = "<?php echo $sf_request->getParameter('id') ?>";

	function IsNumeric(input)
	{
    	return (input - 0) == input && input.length > 0;
	}

	$(document).ready(function(){
		$('td,span').not('.formatInt,.noFormat').each(function(){
			if(IsNumeric($(this).text()) && $(this).text() != 0)
				$(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000", locale:"ru"})+'</nobr>');
		});
        $('.formatInt').each(function(){
            if(IsNumeric($(this).text()) && $(this).text() != 0)
                $(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000", locale:"ru"})+'</nobr>');
        });


	});

</script>

