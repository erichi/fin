<nobr>
<?php if($mp->getIsConfirmed()) : ?>
    <?php echo image_tag('/sf/sf_admin/images/tick.png', array('alt' => 'Подтвержден', 'title' => 'Подтвержден')); ?>
<?php else : ?>
    <a href="#" id="exp<?php echo $mp->getId(); ?>" onclick="editCurrentExpence('<?php echo $mp->getId(); ?>')">
<?php endif; ?>
<span class="formatInt">
<?php echo $mp->getAmount() ?>
</span>
<?php if(!$mp->getIsConfirmed()) echo '</a>'; ?>
</nobr>