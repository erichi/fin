<div class="form-actions">
<?php if ($form->isNew()): ?>
  <button type="submit" class="btn btn-primary">Сохранить</button>
  <input class="btn btn-primary" type="submit" value="Сохранить и добавить" name="_save_and_add">
<a class="btn" href="/job_type">Вернуться к списку</a>
<?php else: ?>
  <button type="submit" class="btn btn-primary">Сохранить</button>

<a class="btn" onclick="if (confirm('Are you sure?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', 'sf_method'); m.setAttribute('value', 'delete'); f.appendChild(m);var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_csrf_token'); m.setAttribute('value', '0986a700cc7e43b89b4d74d326876aa6'); f.appendChild(m);f.submit(); };return false;" href="/job_type/1">Удалить</a>

<a class="btn" href="/job_type">Вернуться к списку</a>

  <?php echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save_and_add',  'label' => 'Save and add',)) ?>
<?php endif; ?>
</div>