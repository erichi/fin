<?php use_helper('I18N', 'Date') ?>
<?php include_partial('job_order/assets') ?>

<div id="sf_admin_container">
<div class="page-header">
  <h1><?php echo __('Список job order', array(), 'messages') ?></h1>
</div>
  <?php include_partial('job_order/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('job_order/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php //include_partial('job_order/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('job_order_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('job_order/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
   
      <?php //include_partial('job_order/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('job_order/list_actions', array('helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('job_order/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
