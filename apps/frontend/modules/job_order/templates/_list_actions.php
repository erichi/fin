<?php if ($sf_user->hasCredential(array(  0 =>   array(    0 => 'admin',    1 => 'director',    2 => 'fm', 3 => 'pm'  ),))): ?>
<?php //echo $helper->linkToNew(array(  'credentials' =>   array(    0 =>     array(      0 => 'admin',      1 => 'director',      2 => 'fm',    ),  ),  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'New',)) ?>
<a class="btn btn-large btn-primary" href="/job_order/new">Создать</a>
<?php endif; ?>

