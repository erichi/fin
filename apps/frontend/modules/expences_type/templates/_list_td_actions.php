<td>
     <?php /* <a class="btn btn-mini" href="/frontend_dev.php/job_order/<?php echo $JobOrder->getId(); ?>">просмотр</a>*/ ?>
      <a class="btn btn-mini" href="/expences_type/<?php echo $ExpencesType->getId(); ?>/edit"><i class="icon-pencil icon-black"></i> редактирование</a>
      <a class="btn btn-mini" onclick="if (confirm('Are you sure?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', 'sf_method'); m.setAttribute('value', 'delete'); f.appendChild(m);var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_csrf_token'); m.setAttribute('value', '0c7a05329cd8e42c3e28471c0c125bbc'); f.appendChild(m);f.submit(); };return false;" href="/expences_type/<?php echo $ExpencesType->getId(); ?>"><i class="icon-trash icon-black"></i> удалить</a>
</td>
