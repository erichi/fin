<nobr>
<?php if($mp->getIsConfirmed()) : ?>
    <?php echo image_tag('/sf/sf_admin/images/tick.png', array('alt' => 'Подтвержден', 'title' => 'Подтвержден')); ?>
<?php else : ?>
    <a href="#" id="exp<?php echo $mp->getId(); ?>" onclick="editCurrentExpence('<?php echo $mp->getId(); ?>')">
<?php endif; ?>
<?php echo $mp->getAmount() ?>
<?php if(!$mp->getIsConfirmed()) echo '</a>'; ?>
</nobr>