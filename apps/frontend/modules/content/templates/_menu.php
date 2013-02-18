
	<?php if ($sf_user->hasCredential('admin')): ?>
		<li><?php echo link_to('Job order', '@job_order') ?></li>
		<?php /*<li><?php echo link_to('Тендеры', '@tender') ?></li>
		<li><?php echo link_to('Планы', '@plan') ?></li>
		<li><?php echo link_to('Текущие расходы', '@current_expenses') ?></li>*/?>
		<li class="dropdown">

		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Бизнес юниты <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><?php echo link_to('Список', '@business_unit') ?></li>
			<li><?php echo link_to('Показатели по всем BU', '@business_unit_stats') ?></li>
    	</ul>
    	</li>
		<li class="dropdown">

		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Настройки <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><?php echo link_to('Типы работ', '@job_type') ?></li>
			<li><?php echo link_to('Клиенты', '@client') ?></li>
			<li><?php echo link_to('Пользователи', '@sf_guard_user') ?></li>
    	</ul>
      	</li>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
	<?php elseif ($sf_user->hasCredential(array('director', 'fm'), false)): ?>
		<li><?php echo link_to('Job order', '@job_order') ?></li>
		<li><?php echo link_to('Отчет по проектам', '@project_report') ?></li>
		<li><?php echo link_to('Текущие расходы', '@bu_current_expenses') ?></li>
		<li><?php echo link_to('Cashflow', '@cashflow') ?></li>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
	<?php elseif ($sf_user->hasCredential('sharer')): ?>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
	<?php elseif ($sf_user->hasCredential('pm')): ?>
		<li><?php echo link_to('Job order', '@job_order') ?></li>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
	<?php endif; ?>
