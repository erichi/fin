var ccp_cnt = 1;		//client contact_person counter
var ip_cnt = 1;
var job_cnt = 1;
//var jp_cnt = 1;		//job payment counter
var op_cnt = 1;
var man_cnt = 1;
date_reg = /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/; 			// regular expression to match date format
float_reg = /^[1-9][0-9]{0,2}(?: ?[0-9]{3}){0,3}\,[0-9]{2}$/;                  // regular expression to match float format

$(document).ready(function(){
	
	$('#client_org_block').hide();
	//$('#client_fio_block').hide();	

	$('#new_client_link').click(function(){
		$('#client_org_block').show();
		//$('#client_fio_block').show();	
	});

	$('#client_new').watermark('Новый клиент');
	//$('#client_contact_person').watermark('ФИО клиента');
	recountBudget();

	var all_clients = $.parseJSON(clients);						//get all clients and contact persons from DB
	var client_id = $('#jo_client_id option:selected').val();
	if (client_id) {
		generateContactPersonList(all_clients);
	}
	$('#client select').change(function(){
		$.ajax({
		  url: get_clients_url,
		  async: false,
		  data: {client_id: client_id},
		  success: function(data) {
		  	obj = $.parseJSON(data);
		  	generateContactPersonList(obj);
		  },
		  error: function(error) {
		  	alert('Произошла неизвестная ошибка.');
		  }
		});
	});	

	//income_payment = incomePaymentDialog();
	new_job = newJobDialog();
	//job_payment = newJobPaymentDialog();
	//job_payment_file = newJobPaymentFileDialog();
	
	$('#payment_date').datepicker();
	$('#job_payment_date').datepicker();
})

function addManager()
{
	var manager_id = $('#manager option:selected').val();
	var manager_val = $('#manager option:selected').text();
	var field_id = 'manager_'+ manager_id; 
	if (!manager_id) {
		alert('Выберите менеджера.');
		return false;
	}
	if (!hasUniqueManager(field_id)) {
		alert('Такой менеджер уже есть.');
		return false;
	}
	var manager_row = '<tr id="'+field_id+'"><td> <input type="hidden" name="jo[manager]['+ manager_id +']" value="'+ manager_id +'" />' +
						manager_val +'</td><td><a href="#" onclick="deleteOptionalField(\''+ field_id +'\'); return false;">удалить</a></td></tr>';
	$('#manager_table').append(manager_row);
	$('#manager :first').attr('selected', 'selected');
}
function hasUniqueManager(manager_id)
{
	var is_uniq = true;
	$('#manager .optional tr').each(function (key, val){
		if (manager_id == val.id){
			is_uniq = false;
		}
	});
	return is_uniq;
}
function deleteOptionalField(id)
{
	$('#'+id).remove();
}

function addClientContactPerson()
{
	var client_id = $('#jo_client_id option:selected').val();
	var cp_name = $('#client_contact_person').val();
	if (!client_id) {
		alert('Выберите из списка или введите нового клиента.');
		return false;
	}
	if (!$.trim(cp_name)) {
		alert('Введите ФИО клиента.');
		$('#client_contact_person').focus();
		return false;
	}
	$.ajax({
	  url: create_contact_person_url,
	  async: false,
	  data: {client_id: client_id, cp_name: cp_name},
	  success: function(data) {
	  	obj = $.parseJSON(data);
	  	generateContactPersonList(obj);
	  	$('#client_contact_person').val('');
	  },
	  error: function(error) {
	  	alert('Произошла неизвестная ошибка.');
	  }
	});
}

function deleteContactPerson(id, client_id)
{
	$.ajax({
		  url: delete_contact_person_url,
		  async: false,
		  data: {cp_id: id, client_id: client_id},
		  success: function(data) {
		  	obj = $.parseJSON(data);
		  	generateContactPersonList(obj);
		  },
		  error: function(error) {
		  	alert('Произошла неизвестная ошибка.');
		  }
		});
}

function generateContactPersonList(data)
{
	$('#client_table').children().remove();										//clear contact persons list 
	var selected_client_id = $('#client option:selected').val();
	
	$.each(data.db, function(key, client){
		if(client.id == selected_client_id){
			$.each(client.contact_persons, function(key, contact_person){
			  var id = contact_person.id;
				var name = contact_person.name;
				
				var contact_person_row = '<tr id="ccp_'+ ccp_cnt +'"><td>'+ name +'</td>'+
					'<td><a href="#" onclick="deleteContactPerson(\''+id+'\', \''+ selected_client_id +'\'); return false;">удалить</a></td></tr>';
				$('#client_table').append(contact_person_row);
				ccp_cnt++;
			});
		}
	});
}

function generateClientList(clients)
{
	$('#client select').children().remove();											//clear clients selectbox OR *.length = 0*
	$('#client .optional').children().remove();										//clear contact persons list 
	var client_zero = '<option value=""></option>';
	$('#client select').append(client_zero);
	$.each(clients.db, function(key, client) {
	  var client_option = '<option value="'+ client.id +'">'+ client.name +'</option>';
		$('#client select').append(client_option);
	});
	if (clients.added){
		$("#client select [value='"+ clients.added.id +"']").attr("selected", "selected");
		$('#client_new').val('');
	}
}

function addNewClient()
{
	var name = $('#client_new').val();
	if (!$.trim(name)) {
		alert('Введите клиента.');
		$('#client_new').focus();
		return false;
	}
	$.ajax({
	  url: add_new_client_url,
	  async: false,
	  data: {client_name: name},
	  success: function(data) {
	  	obj = $.parseJSON(data);
	  	generateClientList(obj);
	  },
	  error: function(error) {
	  	alert('Произошла неизвестная ошибка.');
	  }
	});
}

function addIncomePayment()
{
	var name = $('#payment_name').val();
	var date = $('#payment_date').val();
	var amount = $('#payment_amount').val();
	
  var payment_tr = '<tr id="ip_'+ ip_cnt +'"><td>'+
	  '<input type="hidden" name="jo[income_payment]['+ ip_cnt +'][name]" value="'+ name +'" />'+
		'<input type="hidden" name="jo[income_payment]['+ ip_cnt +'][amount]" value="'+ amount +'" />'+
		'<input type="hidden" name="jo[income_payment]['+ ip_cnt +'][date]" value="'+ date +'" />'+
		'<input type="hidden" name="jo[income_payment]['+ ip_cnt +'][is_confirmed]" value="0" />'+
		'</td><td>'+ name +'</td><td>'+ amount +'</td><td>'+ date +'</td><td></td>'+
		'<td><button type="button" class="btn btn-mini delete_btn" onclick="deleteIncomePayment('+ip_cnt+')" style="margin-top:5px;">удалить</button> </td></tr>';
 
  $('#income_payment_table').append(payment_tr);
  //clear input fields
	$('#payment_name').val('');
	$('#payment_date').val('');
	$('#payment_amount').val('');
	
  ip_cnt++;
}
function editaddIncomePayment(obj)
{ 
	var name = $('#payment_name').val();
	var date = $('#payment_date').val();
	var amount = $('#payment_amount').val();
    /*set change from format xxx xxx,xx to xxxxxx.xx*/
    amount = amount.replace(',', '.');
    amount = amount.replace(' ', '');
	$('input[name="jo[income_payment]['+ obj +'][name]"]').val(name);
	$('input[name="jo[income_payment]['+ obj +'][amount]"]').val(amount);
	$('input[name="jo[income_payment]['+ obj +'][date]"]').val(date);
	$('input[name="jo[income_payment]['+ obj +'][is_confirmed]"]').val(0);
	$('#ip_'+obj +' .income_paymen_name').text(name);
	$('#ip_'+obj +' .income_paymen_amount').text(amount);
	$('#ip_'+obj +' .income_paymen_date').text(date);
	
	
}
function recountBudget()
{
	var total_budget = 0, amount = 0, sum_op = 0, margin = 0, net_profit = 0;
	for (i= 1; i < ip_cnt; i++) {
		amount = Number($('#jo_income_payment_amount_'+i).val());
		total_budget += amount;
	}
	for (i= 1; i < job_cnt; i++) {
		amount = Number($('#jo_outcome_payment_amount_'+i).val());
		sum_op += amount;
	}
	net_profit = total_budget - sum_op;
	if (total_budget){
		margin = net_profit / total_budget * 100;
	}
	$('#ip_total_budget').html(total_budget.toFixed(2));
	$('#ip_net_profit').html(net_profit.toFixed(2));
	$('#ip_margin').html(margin.toFixed(2));
}

function addJob()
{
	var job_type 	= $('#job_job_type option:selected').text();
	var job_type_id = $('#job_job_type option:selected').val();
	var name 			= $('#job_name').val();
	var supplier 	= $('#job_supplier').val();
	var amount 		= $('#job_amount').val();

	var payment_tr = '<tr id="job_'+ job_cnt +'"><td>'+
	  '<input type="hidden" name="jo[outcome_payment]['+ job_cnt +'][name]" value="'+ name +'" />'+
		'<input type="hidden" name="jo[outcome_payment]['+ job_cnt +'][job_type]" value="'+ job_type_id +'" />'+
		'<input type="hidden" name="jo[outcome_payment]['+ job_cnt +'][supplier]" value="'+ supplier +'" />'+
		'<input type="hidden" name="jo[outcome_payment]['+ job_cnt +'][amount]" value="'+ amount +'" />'+
		'</td><td>'+ job_type +'</td><td>'+ name +'</td><td>'+ supplier +'</td><td>'+ amount +'</td>'+
			'<td class="job_payments"><a class="btn btn-mini btn-info" onclick="newJobPayment(\''+ job_cnt +'\');return false;"><i class="icon-plus icon-white"></i> добавить счет</a><table></table></td></tr>';
	
  $('#job_list').append(payment_tr);
  //clear input fields
	$('#job_job_type').val('');
	$('#job_name').val('');
	$('#job_supplier').val('');
	$('#job_amount').val('');
	
  job_cnt++;
}

//function addJobPayment()
//{
//	var job_id		= $('#job_id_new_payment input').val();
//	var name 			= $('#job_payment_name').val();
//	var date 			= $('#job_payment_date').val();
//	var amount 		= $('#job_payment_amount').val();
//	var file 			= $('#job_payment_file').val();
//	if (file) {
//		var file_link = 'http://finsys/uploads/'+ file;
//		var links = '<a href="'+ file_link +'" target="_blank">скачать</a>';
//	} else {
//		var links = '<a href="#" onclick="uploadJobPayment();return false;">загрузить</a>';
//	}
//
//  var payment_tr = '<tr id="jp_'+ jp_cnt +'"><td>'+
//	  '<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][name]" value="'+ name +'" />'+
//		'<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][date]" value="'+ date +'" />'+
//	  '<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][amount]" value="'+ amount +'" />'+
//		'<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][file]" value="'+ file +'" />'+
//		'<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][is_confirmed]" value="0" />'+
//		'</td><td>'+ name +'</td><td>'+ date +'</td><td>'+ amount +'</td><td class="job_payment_download">'+links+'</td></tr>';
//	
//  $('tr#job_'+ job_id +' td.job_payments table').append(payment_tr);
//  //clear input fields
//	$('#job_payment_name').val('');
//	$('#job_payment_date').val('');
//	$('#job_payment_amount').val('');
//	$('#job_payment_file').val('');
//	
//  jp_cnt++;
//}
function addJobPayment()
{
	var job_id		= $('#job_id_new_payment input').val();
	var jp_cnt      = $('#job_'+job_id+' table tr').length + 1;
	
	var name 			= $('#job_payment_name').val();
	var date 			= $('#job_payment_date').val();
	var amount 		= $('#job_payment_amount').val();
	var file 			= $('#job_payment_file').val();
	if (file) {
		var file_link = '/uploads/files/'+ file;
		var links = '<a href="'+ file_link +'" target="_blank">скачать</a>';
	} else {
		var links = '<a href="#" onclick="uploadJobPayment('+jp_cnt+','+job_id+');return false;">загрузить</a>';
	}

   ajaxFileUpload('job_payment_file');

  var payment_tr = '<tr id="jp_'+ jp_cnt +'"><td>'+
	  '<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][name]" value="'+ name +'" />'+
		'<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][date]" value="'+ date +'" />'+
	  '<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][amount]" value="'+ amount +'" />'+
		'<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][file]" value="'+ file +'" />'+
		'<input type="hidden" name="jo[outcome_payment]['+ job_id +'][job_payment]['+ jp_cnt +'][is_confirmed]" value="0" />'+
		'</td><td>'+ name +'</td><td>'+ date +'</td><td>'+ amount +'</td><td class="job_payment_download">'+links+'</td>'+
		'<td><button type="button" class="btn btn-mini delete_btn" onclick="deleteJobPayment('+jp_cnt+','+job_id+')" ><i class="icon-trash icon-black"></i> удалить</button> </td></tr>';
	
  $('tr#job_'+ job_id +' td.job_payments table').append(payment_tr);
  //clear input fields
	$('#job_payment_name').val('');
	$('#job_payment_date').val('');
	$('#job_payment_amount').val('');
	$('#job_payment_file').val('');
	
  jp_cnt++;
}
function editaddJobPayment(obj,job)
{
	var job_id		= $('#job_id_new_payment input').val();
	var name 			= $('#job_payment_name').val();
	var date 			= $('#job_payment_date').val();
	var amount 		= $('#job_payment_amount').val();
	var file 			= $('#job_payment_file').val();
	if (file) {
		var file_link = '/uploads/files/'+ file;
		var links = '<a href="'+ file_link +'" target="_blank">скачать</a>';
	} else {
		var links = '<a href="#" onclick="uploadJobPayment();return false;">загрузить</a>';
	}


   ajaxFileUpload('job_payment_file');


   $('input[name="jo[outcome_payment]['+job+'][job_payment]['+obj+'][name]"]').val(name);
   $('input[name="jo[outcome_payment]['+job+'][job_payment]['+obj+'][date]"]').val(date);
   $('input[name="jo[outcome_payment]['+job+'][job_payment]['+obj+'][amount]"]').val(amount);
   $('input[name="jo[outcome_payment]['+job+'][job_payment]['+obj+'][file]"]').val(file);
   $('input[name="jo[outcome_payment]['+job+'][job_payment]['+obj+'][is_confirmed]"]').val(0);
   
	$('#job_'+job+' #jp_'+obj +' .job_payment_name').text(name);
	$('#job_'+job+' #jp_'+obj +' .job_payment_amount').text(amount);
	$('#job_'+job+' #jp_'+obj +' .job_payment_date').text(date);

}

function uploadJobPayment(i,id)
{
	newJobPaymentFile(i,id);
}

//function incomePaymentDialog()
//{
//	dialog = $('#dialog_income_payment').dialog({
//		autoOpen: false, minWidth: 440,	modal: true, resizable: false, draggable: false,
//		title:	"Add New Incoming Payment",
//		buttons: {
//			"Сохранить": function() {
//				if (validateIncomePayment()) {
//					addIncomePayment();					
//					$(this).dialog("close");
//				}
//			}
//		}			
//	});	
//	return dialog;
//}
function incomePaymentDialog()
{
	dialog = $('#dialog_income_payment').dialog({
		autoOpen: false, minWidth: 440,	modal: true, resizable: false, draggable: false,
		title:	"Add New Incoming Payment",
		buttons: {
			"Сохранить": function() {
				if (validateIncomePayment()) {
					addIncomePayment();					
					$(this).dialog("close");
				}
			}
		}			
	});	
	return dialog;
}
function editIncomePaymentDialog(i)
{
	dialog = $('#dialog_income_payment').dialog({
		autoOpen: false, minWidth: 440,	modal: true, resizable: false, draggable: false,
		title:	"Edit Incoming Payment",
		buttons: {
			"Сохранить": function() {
				if (validateIncomePayment()) {
					
					editaddIncomePayment(i);					
					$(this).dialog("close");
				}
			}
		}			
	});	
	return dialog;
}

function newJobDialog()
{
	dialog = $('#dialog_new_job').dialog({
		autoOpen: false, minWidth: 440,	modal: true, resizable: false, draggable: false,
		title:	"Add New Job",
		buttons: {
			"Сохранить": function() {
				if (validateNewJob()) {
					addJob();
					$(this).dialog("close");
				}
			}
		}			
	});	
	return dialog;
}
//function newJobPaymentDialog()
//{
//	dialog = $('#dialog_job_payment').dialog({
//		autoOpen: false, minWidth: 500,	modal: true, resizable: false, draggable: false,
//		title:	"Новый платеж порядчику",
//		buttons: {
//			"Сохранить": function() {
//				if (validateNewJobPayment()) {
//					if ($('#job_payment_file').val()) {
//						ajaxFileUpload('job_payment_file');
//					}
//					addJobPayment();
//					$(this).dialog("close");
//					$('tr#job_id_new_payment').remove();
//				}
//			}
//		}			
//	});	
//	return dialog;
//}
function newJobPaymentDialog()
{
	dialog = $('#dialog_job_payment').dialog({
		autoOpen: false, minWidth: 500,	modal: true, resizable: false, draggable: false,
		title:	"Новый платеж подрядчику",
		buttons: {
			"Сохранить": function() {
				if (validateNewJobPayment()) {
					if ($('#job_payment_file').val()) {
						ajaxFileUpload('job_payment_file');
					}
					addJobPayment();
					$(this).dialog("close");
					$('tr#job_id_new_payment').remove();
				}
			}
		}			
	});	
	return dialog;
}
function editJobPaymentDialog(i,job_id)
{
	dialog = $('#dialog_job_payment').dialog({
		autoOpen: false, minWidth: 500,	modal: true, resizable: false, draggable: false,
		title:	"Редактирование платежа подрядчику",
		buttons: {
			"Сохранить": function() {
			
				if (validateNewJobPayment()) {
					if ($('#job_payment_file').val()) {
				
						
						var file = $('#job_payment_file').val();
						var file_link = '/uploads/files/'+ file;
			            var file_downloads = '<a href='+file_link+' target="_blank">скачать</a>';
			            $('#job_'+job_id+' #jp_'+i+' .job_payment_download a').remove();
			            $('#job_'+job_id+' #jp_'+i+' .job_payment_download').append(file_downloads);
						ajaxFileUpload('job_payment_file');
					}
					editaddJobPayment(i,job_id);
					$(this).dialog("close");
					$('tr#job_id_new_payment').remove();
				}
			}
		}			
	});	
	return dialog;
}

function newJobPaymentFileDialog(i,id)
{
	dialog = $('#dialog_job_payment_file').dialog({
		autoOpen: false, minWidth: 500,	modal: true, resizable: false, draggable: false,
		title:	"Загрузка файла",
		buttons: {
			"Сохранить": function() {
		            var file = $('#job_payment_file_after').val();
		            var file_link = '/uploads/files/'+ file;
		            var file_downloads = '<a href='+file_link+' target="_blank">скачать</a>';
		            $('#job_'+id+' #jp_'+i+' .job_payment_download a').remove();
		            $('#job_'+id+' #jp_'+i+' .job_payment_download').append(file_downloads);
		            $('input[name="jo[outcome_payment]['+id+'][job_payment]['+i+'][file]"]').val(file);
					ajaxFileUpload('job_payment_file_after');
					$(this).dialog("close");
//					$('tr#job_id_new_payment').remove();
				}
			}
	});	
	return dialog;
}

//function newIncomePayment()
//{
//	income_payment.dialog('open');
//}
function newIncomePayment()
{
	incomePaymentDialog().dialog('open');
	$('#payment_name').val('');
	$('#payment_date').val('');
	$('#payment_amount').val('');
	
}
function deleteIncomePayment(i){
	$('#ip_'+i).remove();
}
function editIncomePayment(i)
{  
	editIncomePaymentDialog(i).dialog('open');
	name = $('#ip_'+i +' .income_paymen_name').text();
	amount = $('#ip_'+i +' .income_paymen_amount').text();
	date = $('#ip_'+i +' .income_paymen_date').text();
	$('#payment_name').val(name);
	$('#payment_date').val(date);
	$('#payment_amount').val(amount);
}

function newJob()
{
	new_job.dialog('open');
}

//function newJobPayment(id)
//{
//	var job_tr = '<tr id="job_id_new_payment"><td><input type="hidden" name="job_id" value="'+ id +'" /></td></tr>';
//  $('#dialog_job_payment table').append(job_tr);
//	job_payment.dialog('open');
//}
function newJobPayment(id)
{
	var job_tr = '<tr id="job_id_new_payment"><td><input type="hidden" name="job_id" value="'+ id +'" /></td></tr>';
  $('#dialog_job_payment').append(job_tr);
   newJobPaymentDialog().dialog('open');
   $('#job_payment_name').val('');
   $('#job_payment_date').val('');
   $('#job_payment_amount').val('');
   
}
function editJobPayment(id,job_id)
{
	var job_tr = '<tr id="job_id_new_payment"><td><input type="hidden" name="job_id" value="'+ id +'" /></td></tr>';
  $('#dialog_job_payment').append(job_tr);
   editJobPaymentDialog(id,job_id).dialog('open');
  
   name =$('#job_'+job_id +' #jp_'+id +' .job_payment_name').text();
   amount =$('#job_'+job_id +' #jp_'+id +' .job_payment_amount').text();
   amount = amount.replace(' ', '');
   amount = amount.replace(',', '.');

   date = $('#job_'+job_id +' #jp_'+id +' .job_payment_date').text();
  
   $('#job_payment_name').val(name);
   $('#job_payment_date').val(date);
   $('#job_payment_amount').val(amount);
   

}
function deleteJobPayment(i,job_cnt)
{
	$('#job_'+job_cnt+' #jp_'+i).remove();	
}
function newJobPaymentFile(i,id)
{
	newJobPaymentFileDialog(i,id).dialog('open');
}

function validateForm()
{
	if(!$.trim($('#jo_business_unit_id').val())){
		alert("Пожалуйста, выберите Бизнес Юнит.");
		return false;
	}
	if(!$.trim($('#jo_name').val())){
		alert("Пожалуйста, введите имя проекта.");
		$('#jo_name').focus();
		return false;
	}
	if(!$.trim($('#jo_client_id').val())){
		alert("Пожалуйста, выберите Клиента.");
		return false;
	}
	return true;
}

function validateIncomePayment()
{
	if(!$.trim($('#payment_name').val())){
		alert("Пожалуйста, введите название платежа.");
		$('#payment_name').focus();
		return false;
	}		
	if(!$.trim($('#payment_date').val())){
		alert("Пожалуйста, введите дату платежа.");
		$('#payment_date').focus();
		return false;
	}
	if(!$.trim($('#payment_amount').val())){
		alert("Пожалуйста, введите суму.");
		$('#payment_amount').focus();
		return false;
	} else if (!$('#payment_amount').val().match(float_reg)) {
		alert("Сумма должна быть числом, например (999.99).");
		$('#payment_amount').focus();
		return false;
	}
	return true;
} 

function validateNewJob()
{	
	if(!$.trim($('#job_job_type').val())){
		alert("Пожалуйста, выберите тип работы.");
		return false;
	}		
	if(!$.trim($('#job_name').val())){
		alert("Пожалуйста, введите название работы.");
		$('#job_name').focus();
		return false;
	}
	if(!$.trim($('#job_supplier').val())){
		alert("Пожалуйста, введите подрядчика.");
		$('#job_supplier').focus();
		return false;
	}		
	if(!$.trim($('#job_amount').val())){
		alert("Пожалуйста, введите общую стоимость.");
		$('#job_amount').focus();
		return false;
	} else if (!$('#job_amount').val().match(float_reg)) {
		alert("Общая стоимость должна быть числом, например (999.99).");
		$('#job_amount').focus();
		return false;
	}
	return true;
}

function validateNewJobPayment()
{
	if(!$.trim($('#job_payment_name').val())){
		alert("Пожалуйста, введите название платежа.");
		$('#job_payment_name').focus();
		return false;
	}		
	if(!$.trim($('#job_payment_date').val())){
		alert("Пожалуйста, введите дату платежа.");
		$('#job_payment_date').focus();
		return false;
	}
	if(!$.trim($('#job_payment_amount').val())){
		alert("Пожалуйста, введите сумму.");
		$('#job_payment_amount').focus();
		return false;
	} else if (!$('#job_payment_amount').val().match(float_reg)) {
		alert("Сумма должна быть числом, например (999.99).");
		$('#job_payment_amount').focus();
		return false;
	}
	return true;
}


function ajaxFileUpload(field_id)
{

  $.ajaxFileUpload
  (
    {
      url: upload_url,
      secureuri:false,
      fileElementId:field_id,
      dataType: 'json',
      success: function (data, status)				// what I must do on Success????
      {
        if(typeof(data.error) != 'undefined')
        {
          if(data.error != '')
          {
              alert(data.error);
          }else
          {
              alert(data.msg);
          }
        }
      },
      error: function (data, status, e)
      {
          alert(e);
      }
    }
  )
 
  return false;

}  