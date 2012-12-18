<td>
<div class="btn-group">
          <a class="btn" href="#"><i class="icon-briefcase icon-black"></i> BU</a>
          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="business_unit/projectReport?id=<?php echo $BusinessUnit->getId(); ?>"><i class="icon-list-alt"></i> Отчет по проектам</a></li>
            <li><a href="business_unit/currentExpenses?id=<?php echo $BusinessUnit->getId(); ?>"><i class="icon-list-alt"></i> Текущие расходы</a></li>
            <li><a href="business_unit/cashflow?id=<?php echo $BusinessUnit->getId(); ?>"><i class="icon-list-alt"></i> Cashflow</a></li>
            <li class="divider"></li>
            <li><a href="/frontend_dev.php/business_unit/<?php echo $BusinessUnit->getId(); ?>/edit"><i class="icon-pencil"></i> Редактировать</a></li>
            <li><a onclick="if (confirm('Are you sure?')) { var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'post'; f.action = this.href;var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', 'sf_method'); m.setAttribute('value', 'delete'); f.appendChild(m);var m = document.createElement('input'); m.setAttribute('type', 'hidden'); m.setAttribute('name', '_csrf_token'); m.setAttribute('value', '8dcecfa422736755928a88d4e793f922'); f.appendChild(m);f.submit(); };return false;" href="/frontend_dev.php/business_unit/<?php echo $BusinessUnit->getId(); ?>"><i class="icon-trash"></i> Удалить</a></li>
          </ul>
        </div>

    