<?php use_helper('I18N', 'Date') ?>
<?php //include_partial('job_order/assets') ?>

<?php /*<div id="sf_admin_container" style="width: 900px;">*/ ?>
<div class="page-header">
   <h1><?php echo __('Редактирование ', array(), 'messages') ?><?php echo $JobOrder->getName(); ?></h1>
  </div>
  

  <div class="row">
  <?php include_partial('job_order/flashes') ?>
  </div>

  <div class="row">
    <?php include_partial('job_order/form_header', array('JobOrder' => $JobOrder, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div class="row">
  	<div class="span12">
    <?php include_partial('job_order/form', array('JobOrder' => $JobOrder, 
    																							'form' => $form, 	
    																							'configuration' => $configuration, 
    																							'helper' => $helper,
    																							'clients' => $clients,
    																							'all_managers' => $all_managers,
    																							'jo_managers' => $jo_managers,
    																							'job_types'	=> $job_types,
    																							'income_payments' => $income_payments,
    																							'jobs' => $jobs )) ?>
    																							
    </div>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('job_order/form_footer', array('JobOrder' => $JobOrder, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
