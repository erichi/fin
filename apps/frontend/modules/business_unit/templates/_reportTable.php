<?php /*
<div style="margin: 50px 0; padding: 15px; width: 400px; background: #fff;">
	<h3 style="margin: 10px">Report</h3>
	<ul style="margin-left: 20px">

		<li>Дебет: <?php echo $bu->getDebet(); ?></li>
		<li>Кредит: <?php echo $bu->getCredit(); ?></li>
		<li>Текущие расходы на этот месяц: <?php echo $bu->getMonthExpences();?></li>
		<li>Займы в прибыль: <?php echo $bu->getLoans();?></li>
		<li>Итого на текущий месяц: <?php echo $bu->getCurrentSumm(); ?></li>
		<?php for($i = 1; $i < 12; $i++): ?>
			<li>Итого на <?php echo date('m/Y', strtotime('+'.$i.' month'))?>: <?php echo $bu->getCurrentSumm($i); ?></li>
		<?php endfor;?>
	</ul>
</div>
*/
?>

			<?php if(isset($title) && $title == false): ?>
			<h2 style="margin-top:20px;"><?php echo $bu->getName(); ?></h2>
			<?php else: ?>
			<h2 style="margin-top:20px;">Показатели</h2>											<!-- Tenders -->
			<hr/>
			<?php endif; ?>

    <div class="row">
    <div class="span4">
			<table class="table table-bordered">
					<tr>
						<td>Дебет: </td><td><?php echo $bu->getDebet(); ?></td></tr>
						<tr><td>Кредит:</td><td><?php echo $bu->getCredit(); ?></td></tr>
						<tr><td>Текущие расходы на этот месяц:</td><td><?php echo $bu->getMonthExpences();?></td></tr>
						<tr><td>Займы в прибыль:</td><td><?php echo $bu->getLoans();?></td></tr>
						<tr><td>Итого на текущий месяц:</td><td><?php echo $bu->getCurrentSumm(); ?></td></tr>
		<?php for($i = 1; $i < 12; $i++): ?>
			<tr><td>Итого на <?php echo date('m/Y', strtotime('+'.$i.' month'))?>:</td> <td><?php echo $bu->getCurrentSumm($i); ?></td></tr>
		<?php endfor;?>
			</table>
	</div>
    <div class="span4">
			<form action="" method="post">
				<table class="table table-bordered">
				<tbody>
					<tr>
						<td>План</td>
						<td><span><?php echo $bu->getPlan(); ?></span> <?php echo $bu->getCurrentProfitPercent()?>%</td>
					</tr>
					<tr>
						<td>Фактическая прибыль</td>
						<td><?php echo $bu->getCurrentProfit()?></td>
					</tr>
				</tbody>
				</table>
			</form>
	</div>
	</div>

<br />