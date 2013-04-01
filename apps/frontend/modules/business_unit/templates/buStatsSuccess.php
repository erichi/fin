<?php //use_stylesheet('default.css')?>
<div id="sf_admin_container" class="project_report">
	<h1>Показатели по всем бизнес юнитам</h1>
	<hr />
	<div id="sf_admin_content">
			<?php $bus[0]->setName('Общий');?>
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
		$('td,span').each(function(){

			if(IsNumeric($(this).text()) && $(this).text() != 0)
				$(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000.00", locale:"ru"})+'</nobr>');
		});


	});

</script>