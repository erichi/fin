<?php use_helper('I18N') ?>
<form action="<?php echo url_for('@sf_guard_password') ?>" method="post">
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Request') ?>" />
  <?php echo link_to('На страницу входа', '@sf_guard_signin', array('style' => 'margin-left: 70px;'))?>
</form>