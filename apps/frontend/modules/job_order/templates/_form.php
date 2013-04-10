<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_stylesheet('smoothness/jquery-ui-1.8.16.custom.css') ?>
<?php use_javascript('jquery.watermark.min.js') ?>
<?php use_javascript('jquery-ui-1.8.16.custom.min.js') ?>
<?php use_javascript('job_order.js') ?>
<?php use_javascript('inputmask.js') ?>
<?php use_javascript('jquery.ui.datepicker-ru.js')?>
<?php use_javascript('ajaxfileupload.js') ?>


  <?php echo form_tag_for($form, '@job_order', array('onsubmit' => 'return validateForm();', 'class' => 'form-horizontal')) ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <div class="row">
    <div class="span4">
    <fieldset>
    	<div class="control-group<?php echo ($form['name']->hasError())?' error':'';?>">
            <label class="control-label" for="input01">Название:</label>
            <div class="controls">
              <?php echo $form['name']->render(array('class' => 'input-small')); ?>
              <?php if($form['name']->hasError()): ?>
              	<p class="help-block"><?php echo $form['name']->renderError(); ?></p>
              <?php endif; ?>
            </div>
        </div>
    	<div class="control-group<?php echo ($form['business_unit_id']->hasError())?' error':'';?>">
            <label class="control-label" for="input01">Бизнес юнит:</label>
            <div class="controls">
              <?php echo $form['business_unit_id']->render(array('class' => 'input-medium')); ?>
              <?php if($form['business_unit_id']->hasError()): ?>
              	<p class="help-block"><?php echo $form['business_unit_id']->renderError(); ?></p>
              <?php endif; ?>
            </div>
        </div>
    </fieldset>
    </div>
    <div class="span4">
    <table class="table">
    		<tr><td>Total budget:</td> <td><span id="ip_total_budget"></span></td></tr>
    		<tr><td>Indulgence:</td> <td> <?php echo  $form['indulgence']->render(array('class' => 'input-small')); ?></td></tr>
    		<tr><td>Net profit:</td> <td> <span id="ip_net_profit"></span></td></tr>
    		<tr><td>Margin:</td> <td> <span id="ip_margin"></span>%</td></tr>
    	</table>
    </div>
    </div>

    <div class="row">
    <div class="span4">
    	<h4>Менеджер</h4><br />
    	<div class="well">

		    <select id="manager">
	        <option value=""></option>
	        <?php foreach ($all_managers as $manager): ?>
	        	<option value="<?php echo $manager->getId()?>"><?php echo $manager->getProfile()->getLastName().' '.$manager->getProfile()->getFirstName() ?></option>
	        <?php endforeach; ?>
		    </select>

<button type="button" class="btn" onclick="addManager()">Выбрать</button>
<br /><br />
		  <table class="table table-condensed" id="manager_table" style="margin-bottom: 0px;">
		  	<?php if ($jo_managers) {
		  		foreach ($jo_managers as $jo_manager): ?>
			  	<tr id="manager_<?php echo $jo_manager->getId() ?>">
			  		<td><input type="hidden" name="jo[manager][<?php echo $jo_manager->getId() ?>]" value="<?php echo $jo_manager->getId() ?>" /><?php echo $jo_manager->getProfile()->getLastName().' '.$jo_manager->getProfile()->getFirstName() ?></td>
			  		<td><?php if(!$sf_user->hasCredential('pm')): ?><a href="#" onclick="deleteOptionalField('manager_<?php echo  $jo_manager->getId() ?>'); return false;">удалить</a><?php endif; ?></td>
			    </tr>
		  	<?php endforeach;
		  	} ?>
		  </table>

	    </div>
    </div>
    <div class="span4">
    	<h4>Компания клиент</h4><br />
    	<div class="well" id="client">
      		<?php echo $form['client_id']->render(); ?>
      		<br /><a href="javascript:;" id="new_client_link">Новая компания клиент</a>
      		<div id="client_org_block">
		  		<input type="text" name="client[new]" id="client_new" />
		    	<button type="button" onclick="addNewClient()">добавить</button>
		    </div>
		    <?php /*
		  <br /><br /><table id="client_table" class="table table-condensed"></table>
		  <div id="client_fio_block">
		  	<input type="text" name="client[contact_person]" id="client_contact_person" />
		    <button type="button" onclick="addClientContactPerson()">добавить</button>
		  </div> */
		  ?>
	    </div>
    </div>
    </div>
    <div class="row">
    	<div class="span8">
    	<h4>Входящие платежи</h4><br />

	    	<table id="income_payment_table" class="table" style="margin-bottom: 0px;">
	    		<tr><th class="hidden_fields"></th><th>Платеж</th><th>Сумма</th><th>Дата</th><th></th><th></th></tr>
	    		<?php if($income_payments){
	    			$ip_cnt = 1;
	    			foreach ($income_payments as $income_payment): ?>
	    				<tr id="ip_<?php echo  $ip_cnt ?>">
	    					<td>
                                <?php if($income_payment->getIsConfirmed() == true){
                                    echo image_tag('/sf/sf_admin/images/tick.png', array('alt' => 'Подтвержден', 'title' => 'Подтвержден'));
                                }?>
	    					  <input type="hidden" name="jo[income_payment][<?php echo  $ip_cnt ?>][name]" value="<?php echo  $income_payment->getName() ?>" />
									<input type="hidden" name="jo[income_payment][<?php echo  $ip_cnt ?>][amount]" value="<?php echo  $income_payment->getAmount() ?>" id="jo_income_payment_amount_<?php echo  $ip_cnt ?>" />
									<input type="hidden" name="jo[income_payment][<?php echo  $ip_cnt ?>][date]" value="<?php echo  $income_payment->getDate('d.m.Y') ?>" />
									<input type="hidden" name="jo[income_payment][<?php echo  $ip_cnt ?>][is_confirmed]" value="<?php echo  $income_payment->getIsConfirmed() ?>" />
								</td>

	    					<td class ="income_paymen_name"><?= $income_payment->getName() ?></td>
	    					<td class ="income_paymen_amount"><?= $income_payment->getAmount() ?></td>
	    					<td class ="income_paymen_date"><?= $income_payment->getDate('d.m.Y') ?></td>
	    					<td>
                                <?php if($income_payment->getIsConfirmed() == false) : ?>
                                <button type="button" class="btn btn-mini" onclick="editIncomePayment(<?php echo $ip_cnt?>)" style="margin-top:5px;"><i class="icon-pencil icon-black"></i> редактировать</button>
                                <?php endif ?>
                            </td>
	    					<td><button type="button" class="btn btn-mini" onclick="deleteIncomePayment(<?php echo $ip_cnt?>)" style="margin-top:5px;"><i class="icon-trash icon-black"></i> удалить</button> </td>
	    				</tr>
	    		<?php $ip_cnt++;
	    			endforeach;
	    		} ?>
	    	</table>
		    <button type="button" class="btn" onclick="newIncomePayment()" style="margin-top:5px;"><i class="icon-plus"></i> новый платеж</button>




    	</div>
    </div>
    <br />
    <div class="row">
    	<div class="span8">
    		<h4>Планирование и стоимость работ</h4><br />

		    <table id="job_list" class="table">
		    	<tr>
		    		<th class="hidden_fields"></th>
		    		<th>Категория</th>
		    		<th>Название</th>
		    		<th>Подрядчик</th>
		    		<th>Сумма</th>
		    		<th>Счета</th>
		    	</tr>
    		<?php if($jobs){
    			$job_cnt = 1;
    			foreach ($jobs as $job): ?>
    				<tr id="job_<?php echo  $job_cnt ?>">
    					<td>
    						<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][name]" value="<?php echo  $job->getName() ?>" />
								<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][job_type]" value="<?php echo  $job->getJobType()->getId() ?>" />
								<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][supplier]" value="<?php echo  $job->getSupplier() ?>" />
								<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][amount]" value="<?php echo  $job->getAmount() ?>" id="jo_outcome_payment_amount_<?php echo  $job_cnt ?>"  />
    					</td>
    					<td class="job_type_name"><?php echo  $job->getJobType()->getName() ?></td>
    					<td class="job_name"><?php echo  $job->getName() ?></td>
    					<td class="job_supplier"><?php echo  $job->getSupplier() ?></td>
    					<td class="job_amount"><?php echo  $job->getAmount() ?></td>
    					<td class="job_payments">
							<button type="button" class="btn btn-mini" onclick="editJob('<?php echo $job_cnt ?>')" >редактировать</button><br /> <br />
    						<a class="btn btn-mini btn-info" onclick="newJobPayment('<?php echo  $job_cnt ?>');return false;"><i class="icon-plus icon-white"></i> добавить счет</a><br /><br />
    						<table><?php if($job->getJobPayments()){
    							$jp_cnt = 1;
    							$count_jp = count($job->getJobPayments());
	    						foreach ($job->getJobPayments() as $job_payment): ?>
	    						<?php $file_link = $job_payment->getFilename() ? 'http://'.$sf_request->getHost().'/uploads/files/'.$job_payment->getFilename() : '#' ?>
	    							<tr id="jp_<?php echo  $jp_cnt ?>">
	    								<td>
                                            <?php if($job_payment->getIsConfirmed() == true){
                                                echo image_tag('/sf/sf_admin/images/tick.png', array('alt' => 'Подтвержден', 'title' => 'Подтвержден'));
                                            }?>
	    									<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][job_payment][<?php echo  $jp_cnt ?>][name]" value="<?php echo  $job_payment->getName() ?>" />
												<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][job_payment][<?php echo  $jp_cnt ?>][date]" value="<?php echo  $job_payment->getDate('d.m.Y') ?>" />
												<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][job_payment][<?php echo  $jp_cnt ?>][amount]" value="<?php echo  $job_payment->getAmount() ?>" />
												<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][job_payment][<?php echo  $jp_cnt ?>][file]" value="<?php echo  $job_payment->getFilename() ?>" />
												<input type="hidden" name="jo[outcome_payment][<?php echo  $job_cnt ?>][job_payment][<?php echo  $jp_cnt ?>][is_confirmed]" value="<?php echo  $job_payment->getIsConfirmed() ?>" />
											</td>
	    								<td class="job_payment_name"><?= $job_payment->getName() ?></td>
	    								<td class="job_payment_date"><?= $job_payment->getDate('d.m.Y') ?></td>
	    								<td class="job_payment_amount"><?= $job_payment->getAmount() ?></td>
	    								<?php if ($job_payment->getFilename()):?>
	    								<td class="job_payment_download"><a href="<?php echo  $file_link ?>" target="_blank">скачать</a></td>
	    						     	<?php else:?>
	    						     	<td class="job_payment_download"><a href="#" onclick="uploadJobPayment(<?php echo $jp_cnt.','.$job_cnt?>);return false;">загрузить</a></td>
	    						     	<?php endif;?>

	    						 		<td style="padding-left: 0; padding-right: 0;">
                                             <?php if($job_payment->getIsConfirmed() == false) : ?>
                                             <button type="button" class="btn btn-mini" onclick="editJobPayment(<?php echo $jp_cnt.','.$job_cnt?>)" >редактировать</button>
                                             <?php endif; ?>
                                         </td>
	    					            <td style="padding-right: 0;"><button type="button" class="btn btn-mini" onclick="deleteJobPayment(<?php echo $jp_cnt.','.$job_cnt?>)" >удалить</button> </td>
	    						  </tr>

					    		<?php $jp_cnt++;
					    		endforeach;
					    		} ?>	</table>
				    	</td>
    				</tr>
    		<?php $job_cnt++;
    		 endforeach;
    		} ?>
		    </table>
	    	<button class="btn" type="button" onclick="newJob()"><i class="icon-plus"></i> новая работа</button>



    	</div>
    </div>
    			<div class="dialog" id="dialog_new_job">																						<!--Dialog box Job-->
    					<table>
    						<tr>
    							<td><label for="job_job_type">Тип работы:</label></td>
    							<td><select name="job[job_type]" id="job_job_type">
    								<option value=""></option>
    								<?php foreach ($job_types as $job_type): ?>
    									<option value="<?php echo  $job_type->getId() ?>"><?php echo  $job_type->getName() ?></option>
    								<?php endforeach; ?>
    							</select></td>
    						</tr>
    						<tr>
    							<td><label for="job_name">Название работы:</label></td>
    							<td><input type="text" name="job[name]" id="job_name"></td>
    						</tr>
    						<tr>
    							<td><label for="job_supplier">Подрядчик:</label></td>
    							<td><input type="text" name="job[supplier]" id="job_supplier"></td>
    						</tr>
    						<tr>
    							<td><label for="job_amount">Общая стоимость:</label></td>
    							<td><input type="text" name="job[amount]" id="job_amount"></td>
    						</tr>
    					</table>
    			</div>
    <div class="dialog" id="dialog_job_payment_file">																					<!--Dialog box Job Payment-->
		    <table>
        	<tr>
    				<td><label for="job_payment_file_after">Файл:</label></td>
        		<td><input type="file" name="fileToUpload" id="job_payment_file_after"></td>
        	</tr>
        </table>
    </div>
			<div class="dialog" id="dialog_income_payment">				<!--Dialog box Income Payment-->
					<table>
						<tr>
							<td><label for="payment_name">Название платежа:</label></td>
							<td><input type="text" name="payment[name]" id="payment_name"></td>
						</tr>
						<tr>
							<td><label for="payment_date">Дата:</label></td>
							<td><input type="text" name="payment[date]" id="payment_date"></td>
						</tr>
						<tr>
							<td><label for="payment_amount">Сумма:</label></td>
							<td><input type="text" name="payment[amount]" id="payment_amount"></td>
						</tr>
					</table>
			</div>												<!--End Dialog box-->


    <div class="dialog" id="dialog_job_payment">																					<!--Dialog box Job Payment-->
		    <table>
			    <tr>
				    <td><label for="job_payment_name">Название платежа:</label></td>
        		<td><input type="text" name="job_payment[name]" id="job_payment_name"></td>
          </tr>
        	<tr>
    				<td><label for="job_payment_date">Дата:</label></td>
        		<td><input type="text" name="job_payment[date]" id="job_payment_date"></td>
        	</tr>
        	<tr>
    				<td><label for="job_payment_amount">Сумма:</label></td>
        		<td><input type="text" name="job_payment[amount]" id="job_payment_amount"></td>
        	</tr>
        	<tr>
    				<td><label for="job_payment_file">Файл:</label></td>
        		<td><input type="file" name="fileToUpload" id="job_payment_file"></td>
        	</tr>
        </table>
    </div>												<!--End Dialog box-->

<br />
<div class="row">
	<div class="span8">
    <?php include_partial('job_order/form_actions', array('JobOrder' => $JobOrder, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>

  </div>
  </div>

<script type="text/javascript">
  add_new_client_url = "<?php echo url_for('job_order/addNewClient')?>";
  get_clients_url = "<?php echo url_for('job_order/getClients')?>";
  create_contact_person_url = "<?php echo url_for('job_order/createContactPerson')?>";
  delete_contact_person_url = "<?php echo url_for('job_order/deleteContactPerson')?>";
  upload_url = "<?php echo url_for('job_order/uploadFile')?>";
	var clients = '<?php echo $sf_data->getRaw("clients") ?>';

	ip_cnt = <?php echo count($income_payments) ?>+1;
	job_cnt = <?php echo count($jobs) ?>+1;
	jp_cnt = <?php echo isset($count_jp) ? $count_jp : '0' ?>+1;

	function IsNumeric(input)
	{
    	return (input - 0) == input && input.length > 0;
	}

	$(document).ready(function(){
		$('.income_paymen_amount').each(function(){

			if(IsNumeric($(this).text()) && $(this).text() != 0)
				$(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000.00", locale:"ru"})+'</nobr>');

		});
		$('td').each(function(){

			if(IsNumeric($(this).text()) && $(this).text() != 0)
				$(this).html('<nobr>'+$.formatNumber($(this).text(), {format:"0,000.00", locale:"ru"})+'</nobr>');
		});

	});

</script>

