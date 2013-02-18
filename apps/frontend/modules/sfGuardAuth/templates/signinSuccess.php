

<div class="row">
	<div class="span4 offset4">
<form class="well" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
	<?php echo $form->renderHiddenFields(); ?>
    <?php echo $form['username']->render(array('placeholder' => 'Логин')); ?>
    <?php if($form['username']->hasError()):?>
    <span class="help-inline"><?php echo $form['username']->renderError(); ?></span>
    <?php endif; ?>
    <?php echo $form['password']->render(array('placeholder' => 'Пароль')); ?>
    <?php if($form['password']->hasError()):?>
    <span class="help-inline"><?php echo $form['password']->renderError(); ?></span>
    <?php endif; ?>
	<label class="checkbox">
    	<?php echo $form['remember']->render(); ?> Запомнить меня
  	</label>

  <button type="submit" class="btn">Войти</button>
  <?php echo link_to('Забыл пароль', '@sf_guard_password', array('style' => 'margin-left: px;'))?>

</form>
	
	</div>
</div>
