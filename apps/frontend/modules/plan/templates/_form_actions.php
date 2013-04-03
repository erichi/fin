
<div class="form-actions">
<?php if ($form->isNew()): ?>
  <button type="submit" class="btn btn-primary">Сохранить</button>
  <input class="btn btn-primary" type="submit" value="Сохранить и добавить" name="_save_and_add">
<a class="btn" href="<?php echo url_for('project_report', array('id' => $sf_request->getParameter('return_to_pr')));?>">Вернуться к списку</a>
<?php else: ?>
  <button type="submit" class="btn btn-primary">Сохранить</button>
<a class="btn" onclick="if (confirm('Are you sure?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', 'sf_method'); m.setAttribute('value', 'delete'); f.appendChild(m);var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_csrf_token'); m.setAttribute('value', ''); f.appendChild(m);f.submit(); };return false;" href="<?php echo url_for('plan_delete', array('id' => $form->getObject()->getId()));?>">Удалить</a>
<a class="btn" href="<?php echo url_for('project_report', array('id' => $form->getObject()->getBusinessUnitId()));?>">Вернуться к списку</a>

  <?php echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save_and_add',  'label' => 'Save and add',)) ?>
<?php endif; ?>
</div>