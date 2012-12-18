<?php if($mp->getIsConfirmed()):?>
<?php echo $mp->getAmount(); ?>
<?php else: ?>
<?php echo $mp->getAmount(); ?>
<?php echo ($mp->getAmount() != 0)?'<input class="confirm_exp" info="'.$mp->getId().'" type="checkbox">':'';?>
<?php endif; ?>