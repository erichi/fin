<div class="row">
	<div class="span4 offset4">
		<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  		<table>
    		<?php echo $form ?>
  		</table>
	</div>
	
  <input type="submit" value="sign in" />
</form>
</div>
