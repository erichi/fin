<?php use_helper('I18N', 'Date') ?>
<?php include_partial('job_type/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Список типов работ для подрядчиков', array(), 'messages') ?></h1>
  <hr />

  <?php include_partial('job_type/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('job_type/list_header', array('pager' => $pager)) ?>
  </div>


  <div id="sf_admin_content">
    <form action="<?php echo url_for('job_type_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('job_type/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
      <?php //include_partial('job_type/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('job_type/list_actions', array('helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('job_type/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
