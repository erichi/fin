<?php //use_stylesheet('default.css')?>
<div id="sf_admin_container" class="project_report">
	<h1>Показатели по всем бизнес юнитам</h1>
	<hr />
	<div id="sf_admin_content">
	
			<?php foreach($bus as $bu):?>
				<?php include_component('business_unit', 'reportTable', array('bu_id' => $bu->getId(), 'title' => false)); ?>
			<?php endforeach; ?>
		
	</div>
</div>