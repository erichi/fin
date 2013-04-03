<script>
$(document).ready(function(){
	$('#tender_business_unit_id').val('<?php echo $sf_request->getParameter('return_to_pr'); ?>');
});
</script>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@tender') ?>
    <?php echo $form->renderHiddenFields(false) ?>
	<input type="hidden" name="return_to_pr" value="<?php echo $sf_request->getParameter('return_to_pr'); ?>" />
    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('tender/form_fieldset', array('Tender' => $Tender, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('tender/form_actions', array('Tender' => $Tender, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
