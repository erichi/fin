<?php /*<td> 
      <?php if ($sf_user->hasCredential(array(  0 =>   array(    0 => 'admin',    1 => 'director',    2 => 'pm',    3 => 'fm',  ),))): ?>
<?php echo link_to(__('Просмотр', array(), 'messages'), 'job_order/show?id='.$JobOrder->getId(), array('class' => 'btn-mini')) ?>
<?php endif; ?>

    <?php if ($sf_user->hasCredential(array(  0 =>   array(    0 => 'admin',    1 => 'director',    2 => 'pm',    3 => 'fm',  ),))): ?>
<?php echo $helper->linkToEdit($JobOrder, array(  'credentials' =>   array(    0 =>     array(      0 => 'admin',      1 => 'director',      2 => 'pm',      3 => 'fm',    ),  ),  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
<?php endif; ?>

    <?php if ($sf_user->hasCredential(array(  0 =>   array(    0 => 'admin',  ),))): ?>
<?php echo $helper->linkToDelete($JobOrder, array(  'credentials' =>   array(    0 =>     array(      0 => 'admin',    ),  ),  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
<?php endif; ?>

</td>
*/ 
?>
<td>
     <?php /* <a class="btn btn-mini" href="/frontend_dev.php/job_order/<?php echo $JobOrder->getId(); ?>">просмотр</a>*/ ?>
      <a class="btn btn-mini" href="/frontend_dev.php/job_order/<?php echo $JobOrder->getId(); ?>/edit"><i class="icon-pencil icon-black"></i> просмотр</a>
      <a class="btn btn-mini" onclick="if (confirm('Are you sure?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', 'sf_method'); m.setAttribute('value', 'delete'); f.appendChild(m);var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_csrf_token'); m.setAttribute('value', '8dcecfa422736755928a88d4e793f922'); f.appendChild(m);f.submit(); };return false;" href="/frontend_dev.php/job_order/<?php echo $JobOrder->getId(); ?>"><i class="icon-trash icon-black"></i> удалить</a>
</td>