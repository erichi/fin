<?php use_helper('I18N', 'Date') ?>
<?php include_partial('job_order/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Show Job order', array(), 'messages') ?></h1>

  <?php include_partial('job_order/flashes') ?>

  <div id="sf_admin_content" class="job_order">
  	<fieldset>
      <legend>Просмотр JO</legend>
      <div style="width: 400px; float:left;margin-right:20px;">
      	<p><b>Business Unit</b>: <?= $JobOrder->getBusinessUnit() ?></p>
      	<p><b>Название JO</b>: <?= $JobOrder ?></p>
      	<p>
      		<b>Менеджеры</b>: 
      		<ul style="margin-left: 30px;">
	      		<? foreach ($managers as $manager){
	      			echo '<li>'.$manager->getProfile()->getLastName().' '.$manager->getProfile()->getFirstName().'</li>';
	      		} ?>
	      	</ul>
	      </p>
  		</div>
  		<div style="float:left">
  			<p><b>Клиент</b>: <?= $JobOrder->getClient() ?></p>
      	<p>
      		<b>Контакты</b>: 
      		<ul style="margin-left: 30px;">
	      		<? foreach ($JobOrder->getClient()->getContactPersons() as $cp){
	      			echo '<li>'.$cp->getName().'</li>';
	      		} ?>
	      	</ul>
	       </p>
  		</div>
  		<div class="clear"></div>
  	</fieldset>
  	
		<fieldset id="income_payment">
    	<legend>Incoming Payment</legend>
    	<div id="income_payment_list">
	    	<table>
    			<tr><th>Платеж</th><th>Сумма</th><th>Дата</th></tr>
    			<?php if($income_payments){
	    			foreach ($income_payments as $income_payment): ?>
	    				<tr>
	    					<td><?= $income_payment->getName() ?></td>
	    					<td><?= $income_payment->getAmount() ?></td>
	    					<td><?= $income_payment->getDate() ?></td>
	    				</tr>
	    			<? endforeach;
    			} ?>
    		</table>
    	</div>
    	<div style="float:left;">
    		<p>Total budget: <span id="ip_total_budget"><?= $total_budget ?></span></p>
    		<p>Indulgence: <?= JobOrderPeer::$indulgences[$JobOrder->getIndulgence()] ?></p>
    		<p>Net profit: <span id="ip_net_profit"><?= $net_profit ?></span></p>
    		<p>Margin: <span id="ip_margin"><?= $margin ?></span>%</p>
    	</div>
    	<div class="clear"></div>
    </fieldset>
  	
  	
  	<fieldset id="outcome_payment">
      <legend>Job description &#38; estimation</legend>
	    <div id="outcome_payment_list">
		    <table id="job_list">
		    	<tr>
		    		<th>JOB DESCRIPTION<br/>&#38; ESTIMATION</th>
		    		<th>Job name</th>
		    		<th>Supplier</th>
		    		<th>Total sum</th>
		    		<th>Payments</th>
		    	</tr>
    		<?php if($jobs){
    			foreach ($jobs as $job):?>
    				<tr>
    					<td><?= $job->getJobType()->getName() ?></td>
    					<td><?= $job->getName() ?></td>
    					<td><?= $job->getSupplier() ?></td>
    					<td><?= $job->getAmount() ?></td>
    					<td class="job_payments">
    						<table><?php if($job->getJobPayments()){
	    						foreach ($job->getJobPayments() as $job_payment): ?>
	    						<?php $file_link = $job_payment->getFilename() ? 'http://'.$sf_request->getHost().'/uploads/'.$job_payment->getFilename() : '#' ?>
	    							<tr>
	    								<td><?= $job_payment->getName() ?></td>
	    								<td><?= $job_payment->getDate() ?></td>
	    								<td><?= $job_payment->getAmount() ?></td>
	    								<td class="job_payment_download"><a href="<?= $file_link ?>" target="_blank">скачать</a></td>
	    						  </tr>
					    		<?php
					    		endforeach;
					    		} ?>	</table>
				    	</td>
    				</tr>
    		<?php
    		 endforeach;
    		} ?>
		    </table>
      </div>
    </fieldset>  	
  </div>

  <div id="sf_admin_footer" style="padding: 20px;">
    <?php echo link_to('Вернуться к списку', '@job_order', 'style=background: url('.image_path("list.png").') no-repeat left;padding-left:20px;') ?>
  </div>
</div>
  