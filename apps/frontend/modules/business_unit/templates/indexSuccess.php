<?php use_helper('I18N', 'Date') ?>
<?php include_partial('business_unit/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Список BU', array(), 'messages') ?></h1>
  <hr />

  <?php include_partial('business_unit/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('business_unit/list_header', array('pager' => $pager)) ?>
  </div>


  <div id="sf_admin_content">
    <form action="<?php echo url_for('business_unit_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('business_unit/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
      <?php //include_partial('business_unit/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('business_unit/list_actions', array('helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('business_unit/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
<script type="text/javascript">
    function IsNumeric(input)
    {
        return (input - 0) == input && input.length > 0;
    }

    $(document).ready(function(){
        $('.sf_admin_list_td_plan').each(function(){
            if(IsNumeric($(this).text()) && $(this).text() != 0) {
                $(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000.00", locale:"ru"})+'</nobr>');
            }
        });

    });

</script>