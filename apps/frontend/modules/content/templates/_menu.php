
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
			<li class="divider"></li>
			<?php foreach ($bus as $bu): ?>
			<li class="dropdown-submenu">
    			<a tabindex="-1" href="#"><?php echo $bu->getName(); ?></a>
    			<ul class="dropdown-menu">
            <li><a tabindex="-1" href="/business_unit/projectReport?id=<?php echo $bu->getId(); ?>">Отчет по проектам</a></li>
            <li><a tabindex="-1" href="/business_unit/currentExpenses?id=<?php echo $bu->getId(); ?>">Текущие расходы</a></li>
            <li><a tabindex="-1" href="/business_unit/cashflow?id=<?php echo $bu->getId(); ?>">Cashflow</a></li>

    			</ul>
  			</li>
  			<?php endforeach; ?>
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
		<?php /*<li><?php echo link_to('Тендеры', '@tender') ?></li>
		<li><?php echo link_to('Планы', '@plan') ?></li>
		<li><?php echo link_to('Текущие расходы', '@current_expenses') ?></li>*/?>
		<li class="dropdown">

		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Бизнес юниты <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<?php if($sf_user->hasCredential(array('fm'))):?>
			<li><?php echo link_to('Показатели по всем BU', '@business_unit_stats') ?></li>
			<li class="divider"></li>
			<?php endif; ?>
			<?php foreach ($bus as $bu): ?>
			<li class="dropdown-submenu">
    			<a tabindex="-1" href="#"><?php echo $bu->getName(); ?></a>
    			<ul class="dropdown-menu">
            <li><a tabindex="-1" href="/business_unit/projectReport?id=<?php echo $bu->getId(); ?>">Отчет по проектам</a></li>
            <li><a tabindex="-1" href="/business_unit/currentExpenses?id=<?php echo $bu->getId(); ?>">Текущие расходы</a></li>
            <li><a tabindex="-1" href="/business_unit/cashflow?id=<?php echo $bu->getId(); ?>">Cashflow</a></li>

    			</ul>
  			</li>
  			<?php endforeach; ?>
    	</ul>
    	</li>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
		
	<?php elseif ($sf_user->hasCredential('sharer')): ?>

		<li><?php echo link_to('Job order', '@job_order') ?></li>
		<li class="dropdown">

		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Бизнес юниты <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><?php echo link_to('Показатели по всем BU', '@business_unit_stats') ?></li>
    	</ul>
    	</li>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
		
	<?php elseif ($sf_user->hasCredential('pm')): ?>
	
		<li><?php echo link_to('Job order', '@job_order') ?></li>
		<li><?php echo link_to('Выход', '@sf_guard_signout') ?></li>
		
	<?php endif; ?>
