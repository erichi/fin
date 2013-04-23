<?php use_helper('I18N', 'Date') ?>
<?php include_partial('job_order/assets') ?>

<div id="sf_admin_container">
<div class="page-header">
  <h1><?php echo __('Новый job order', array(), 'messages') ?></h1>
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
    																							'jobs'	=> $jobs)) ?>
  </div> </div>

  <div id="sf_admin_footer">
    <?php include_partial('job_order/form_footer', array('JobOrder' => $JobOrder, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
<script type="text/javascript">
    <?php
        $managers = array();
        foreach($all_managers_new as $manager){
            /** @var $manager sfGuardUser */
            foreach($manager->getUserBusinessUnits() as $userBusinesUnit){
                $managers[$userBusinesUnit->getBusinessUnitId()][] = array(
                    'id' => $manager->getId(),
                    'name' => $manager->getProfile()->getLastName().' '.$manager->getProfile()->getFirstName()
                );
            }
        }
    ?>
    var managers = <?php echo json_encode($managers) ?>;
    $(document).ready(function(){
        $('#jo_business_unit_id').change(function(){
            var bu = $('#jo_business_unit_id :selected').val();
            $('#manager').empty();
            $('#manager').append('<option value=""></option>');
            for(var k in managers[bu]){
                var val = managers[bu][k];
                $('#manager').append('<option value="'+val.id+'">'+val.name+'</option>')
            }

        });
    })
</script>