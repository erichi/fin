<br />
<div class="control-group">
<?php if ($field->isPartial()): ?>
  <?php include_partial('client/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('client', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
    <?php echo $form[$name]->renderError() ?>
      <?php echo $form[$name]->renderLabel($label, array('class'=>'control-label')) ?>

      <div class="controls"><?php echo $form[$name]->render(array('class'=>'input-xlarge')) ?></div>
<?php endif; ?>
</div>