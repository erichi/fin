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