<?php //use_stylesheet('default.css')?>
<div id="sf_admin_container" class="project_report">
	<h1>Показатели по всем бизнес юнитам</h1>
	<hr />
</div>
<div>
    <h2>Итого на </h2>
    <table class="table">
        <tr>
            <th>Бизнес юнит</th>
            <th>Текущий месяц</th>
            <?php for($i = 1; $i < 12; $i++): ?>
            <th><?php echo date('m/Y', strtotime('first day of +'.$i.' month'))?></th>
            <?php endfor;?>
        </tr>
        <?php foreach($bus as $bu):?>
            <tr>
                <td><?php echo $bu->getName(); ?></td>
                <td><?php echo $bu->getCurrentSumm(); ?></td>
                <?php for($i = 1; $i < 12; $i++): ?>
                    <td><?php echo $bu->getCurrentSumm($i); ?></td>
                <?php endfor;?>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td>Общее</td>
            <td><?php echo $overall->getCurrentSumm(); ?></td>
            <?php for($i = 1; $i < 12; $i++): ?>
                <td><?php echo $overall->getCurrentSumm($i); ?></td>
            <?php endfor;?>
        </tr>
    </table>
</div>
<br />
	<div id="sf_admin_content">
			<?php foreach($bus as $bu):?>
				<?php include_partial('business_unit/reportTable', array('bu' => $bu, 'title' => false)); ?>
			<?php endforeach; ?>

	</div>
</div>
<script type="text/javascript">

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