$(function(){
	
	$('#cashflow_start_date').datepicker({
		firstDay: 1,
	});
	
});

function approveJoIp(id)
{
	$.ajax({
		url: approve_income_payment_url,
		async: false,
		data: 'income_payment_id='+id,
		success: function(){
			window.location = cashflow_index_url;
		}
	});
}

function approveJoOp(id)
{
	$.ajax({
		url: approve_outcome_payment_url,
		async: false,
		data: 'outcome_payment_id='+id,
		success: function(){
			window.location = cashflow_index_url;
		}
	});
}