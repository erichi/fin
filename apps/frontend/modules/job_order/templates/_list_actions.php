<?php if ($sf_user->hasCredential(array(  0 =>   array(    0 => 'admin',    1 => 'director',    2 => 'fm',  ),))): ?>
<?php //echo $helper->linkToNew(array(  'credentials' =>   array(    0 =>     array(      0 => 'admin',      1 => 'director',      2 => 'fm',    ),  ),  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'New',)) ?>
<a class="btn btn-large btn-primary" href="/frontend_dev.php/job_order/new">Создать</a>
<?php endif; ?>

