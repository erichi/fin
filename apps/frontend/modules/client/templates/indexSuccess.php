<?php use_helper('I18N', 'Date') ?>
<?php include_partial('client/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Список компаний клиентов', array(), 'messages') ?></h1>
  <hr />

  <?php include_partial('client/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('client/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('client_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('client/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
      <?php //include_partial('client/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('client/list_actions', array('helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('client/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
