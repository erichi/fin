$.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test($(elem)[attr.method](attr.property));
}

$(document).ready(function(){
	
    $('#current_expenses_taxes .tax').hide();
	$('#current_expenses_taxes .expand').click(function(){
		key = $(this).parent().parent().attr('class').replace('tax_main_','');
		if ($('#current_expenses_taxes .tax_'+key).is(':visible')){
			$('#current_expenses_taxes .tax_'+key).hide();
			$(this).text('развернуть')
		} else {
			$('#current_expenses_taxes .tax_'+key).show();
			$(this).text('свернуть')
		}
		
	});
	
	recount(types);
	$('#recount_link').click(function(){
		recount(types);
	});
	
/*	$('.confirm_exp').change(function(){
		var id = $(this).attr('info');
		$.ajax({
			type: "POST",
			url: "/confirmexp",
			data: "id="+id
		}).done(function( msg ) {
			var result = $.parseJSON(msg);
			if(result == 'error')
				alert('Платеж не подтвержден из-за ошибки системы. No entry in database');
		});
	});*/
});

$(function() {
	
/*	$('.edit').editable(save_field_data_url,{
		event			: "dblclick.editable",
		id:  'editinput',
		loadurl         : "/frontend_dev.php/loadexp",
		loaddata: function(){
			obj = $.parseJSON($(this).attr('data'));
    		return { id: obj.id }
		},
    	submit 		: "OK",
    	onsubmit	: function(){
    	    if (isNaN($('[name="value"]').val())) {
      		alert("Значение должно быть числом! Введенно значение: "+$('[name="value"]').val()+"");
      		return false;
    		}
    	},
    	submitdata: function(){
    		obj = $.parseJSON($(this).attr('data'));
    		return { id: obj.id }
    	},
    	callback : function(value, settings) {
    		recount(types);
    	}
	}); */

	$('#tax_dialog').dialog({
		autoOpen: false, minWidth: 440,	modal: true, resizable: false, draggable: false,
		title:	"Добавить расходы",
		buttons: {
			"Сохранить": function() {
				if ($.trim($('#ce_tax_name').val())) {
					addTaxRow($('#ce_tax_name').val(), $('#ce_tax_type :selected').val());					
					$(this).dialog("close");
				} else {
					alert('Пожалуйста, введите наименование налога.');
					$('#ce_name').focus();
				}
			}
		}
	});

});

function recount(types)
{
    $.each(types, function(){
		var type = this.concat();
    	$('td:regex(desc,^'+type+'_0_\\d{2}_\\d{4}$)').each(function(){
    		var desc_regexp = $(this).attr('desc').split(type+'_0').join(type+'_[^0]{1}[0-9]*');
    		var amount = 0;
			var confirmed = 0;
			var not_confirmed = 0;
    		$('td:regex(desc,^'+desc_regexp+'$)').each(function(){
				var value = parseInt($.trim($(this).text()));
				if (isNaN(value)) {
					value = 0;
				}
    			amount += value;
				if($(this).has('a').length == 0){ // confirmed
					confirmed += value;
				}else{
					not_confirmed += value;
				}
    		});
			var type_sum_attr = desc_regexp.split(type+'_[^0]{1}[0-9]*').join(type+'_0');
			if(not_confirmed == 0 && confirmed != 0){
				amount = '<nobr><img src="/sf/sf_admin/images/tick.png" alt="Подтвержден" title="Подтвержден" />'+amount+'</nobr>';
			}
    		$('[desc="'+type_sum_attr+'"]').html(amount).data("confirmed", confirmed).data("notconfirmed", not_confirmed);
    	});		

    	var amount_all = 0;
    	$('td:regex(desc,^'+type+'_0_\\d{2}_\\d{4}$)').each(function(){
    		var value = parseInt($.trim($(this).text()));
			if (isNaN(value)) {
				value = 0;
			}
			amount_all += value;
    	});	
    	$('[desc="'+type+'_all"]').html(amount_all);

    });	
    
    $('td:regex(desc,^col_sum_\\d{2}_\\d{4}$)').each(function(){
    	var desc_attr = $(this).attr('desc').split('col_sum').join('');
//		console.log(desc_attr);
    	var col_summ = 0;
		var confirmed_summ = 0;
		var notconfirmed_summ = 0;
    	$.each(types, function(){
    		var type = this.concat();
    		var value = parseInt($.trim($('[desc="'+type+'_0'+desc_attr+'"]').text()));
			if (isNaN(value)) {
				value = 0;
			}
    		col_summ += value;
			confirmed_summ += $('[desc="'+type+'_0'+desc_attr+'"]').data("confirmed");
			notconfirmed_summ += $('[desc="'+type+'_0'+desc_attr+'"]').data("notconfirmed");
    	});
    	$('[desc="col_sum'+desc_attr+'"]').html(col_summ);
		$('[desc="col_sum_confirmed'+desc_attr+'"]').html(confirmed_summ);
		$('[desc="col_sum_notconfirmed'+desc_attr+'"]').html(notconfirmed_summ);
    });
	
	var confirmed_summ_all = 0;
	$('[desc^=col_sum_confirmed]').each(function(){
		var value = parseInt($(this).text());
		confirmed_summ_all += value;
	});
	$('#tax_sum_month_confirmed_all').html(confirmed_summ_all);
	var notconfirmed_summ_all = 0;
	$('[desc^=col_sum_notconfirmed]').each(function(){
		var value = parseInt($(this).text());
		notconfirmed_summ_all += value;
	});
	$('#tax_sum_month_notconfirmed_all').html(notconfirmed_summ_all);
    
    var sum_of_types = 0;
    $.each(types, function(){
    	var type = this.concat();
    	var value = parseInt($.trim($('[desc="'+type+'_all"]').html()));
		if (isNaN(value)) {
			value = 0;
		}
    	sum_of_types += value;
    	
    	var cnt = 0;
    	var ex_sum = 0;
    	$('td:regex(desc,^'+type+'_[^0]{1}[0-9]*_\\d{2}_\\d{4}$)').each(function(){
    		cnt++;
    		var sp = $(this).attr('desc').split('_');
    		var ex_id = sp[1];
    		if(cnt == 12)
    		{
   				$('[desc="'+type+'_'+ex_id+'_0"]').html(ex_sum);
				ex_sum = 0;
				cnt = 0;
    		}
    		else
    		{
    			var value = parseInt($.trim($(this).html()));
				if (isNaN(value)) {
					value = 0;
				}
				ex_sum += value;
    		}
    	});	
    });
	$('#tax_sum_month_all').html(sum_of_types);
	
	$.each(types, function(){
		var type = this.concat();
		var year_value = parseInt($.trim($('[desc='+type+'_all]').text()));
		if (isNaN(year_value)) {
			year_value = 0;
		}
		var percent = year_value / sum_of_types * 100;
		$('[desc='+type+'_percent]').html(percent.toFixed(2));
	});

}

function addTaxRow(tax_name, tax_type)
{
	$.ajax({
	  url: new_row_url,
	  data: "type="+tax_type+"&name=" + tax_name +"&business_unit_id="+business_unit_id,
	  success: function(html){
	  	location.reload();
	  }
	});
}


function hideStaff()
{
	$('.worker').each(function(){
		$(this).css('visibility', 'collapse');
	});
}

function showStaff()
{
	$('.worker').each(function(){
		$(this).css('visibility', 'visible');
	});
}

function hideTaxes()
{
	$('.tax').each(function(){
		$(this).css('visibility', 'collapse');
	});
}

function showTaxes()
{
	$('.tax').each(function(){
		$(this).css('visibility', 'visible');
	});
}

function approveExpence(id, isApproved) {
	if (validateExpence()) {
        var amount = $('#expence_amount').val().replace(/[_ ]/g,'');
		$.ajax({
			url: '/confirmexp',
			data: {
				'id': id,
				'amount': amount,
				'isApproved' : isApproved
			},
			success: function(msg){
                var result = $.parseJSON(msg);
                if(result == 'error'){
                    alert('Платеж не подтвержден из-за ошибки системы. No entry in database');
                }else{
                    if(isApproved){
                        $('#exp' + id).before('<nobr><img src="/sf/sf_admin/images/tick.png" alt="Подтвержден" title="Подтвержден" />'+amount+'</nobr>');
                        $('#exp' + id).remove();
                    }else{
                        $('#exp' + id).text(amount);
                    }
                    recount(types);
                }
			}
		});
	}
}

function editCurrentExpence(id)
{
	dialog = $('#dialog_edit_expence').dialog({
		autoOpen: false, minWidth: 500,	modal: true, resizable: false, draggable: false,
		title:	"Подтверждение",
		buttons: {
			"Подтвердить": function(){ approveExpence(id, true); $(this).dialog("close"); },
			"Сохранить": function(){ approveExpence(id, false); $(this).dialog("close"); },
			"Отмена": function() {
				$(this).dialog("close");
			}
		}			
	});	

	$('#expence_amount').inputmask('999 999 999 999', { numericInput: true, placeholder:"_" });
    console.log($('#exp'+id).text().trim());
	$('#expence_amount').val($('#exp'+id).text().trim());
	dialog.dialog('open');
}

function validateExpence()
{
	if(!$.trim($('#expence_amount').val())){
		alert("Пожалуйста, введите сумму.");
		$('#expence_amount').focus();
		return false;
	} else if (isNaN($('#expence_amount').val().replace(/[_ ]/g,''))) {
		alert("Сумма должна быть числом, например (999).");
		$('#expence_amount').focus();
		return false;
	}
    //$('#job_payment_amount').val($('#job_payment_amount').val().replace(/_/g,''));
	return true;
}

/*
$.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ?
                matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test($(elem)[attr.method](attr.property));
}

$(document).ready(function(){

    $('#current_expenses_taxes .tax').hide();
    $('#current_expenses_taxes .expand').click(function(){
        key = $(this).parent().parent().attr('class').replace('tax_main_','');
        if ($('#current_expenses_taxes .tax_'+key).is(':visible')){
            $('#current_expenses_taxes .tax_'+key).hide();
            $(this).text('развернуть')
        } else {
            $('#current_expenses_taxes .tax_'+key).show();
            $(this).text('свернуть')
        }

    });

    recount();
    $('#recount_link').click(function(){
        recount();
    });

    $('.confirm_exp').change(function(){
        var id = $(this).attr('info');
        $.ajax({
            type: "POST",
            url: "/confirmexp",
            data: "id="+id
        }).done(function( msg ) {
                var result = $.parseJSON(msg);
                if(result == 'error')
                    alert('Платеж не подтвержден из-за ошибки системы. No entry in database');
            });
    });
});

$(function() {

    $('.edit').editable(save_field_data_url,{
        event			: "dblclick.editable",
        id:  'editinput',
        loadurl         : "/frontend_dev.php/loadexp",
        loaddata: function(){
            obj = $.parseJSON($(this).attr('data'));
            return { id: obj.id }
        },
        submit 		: "OK",
        onsubmit	: function(){

            if (isNaN($('[name="value"]').val())) {
                alert("Значение должно быть числом! Введенно значение: "+$('[name="value"]').val()+"");
                return false;
            }
        },
        submitdata: function(){
            obj = $.parseJSON($(this).attr('data'));
            return { id: obj.id }
        },
        callback : function(value, settings) {
            recount();
        }
    });

    $('#tax_dialog').dialog({
        autoOpen: false, minWidth: 440,	modal: true, resizable: false, draggable: false,
        title:	"Добавить расходы",
        buttons: {
            "Сохранить": function() {
                if ($.trim($('#ce_tax_name').val())) {
                    addTaxRow($('#ce_tax_name').val(), $('#ce_tax_type :selected').val());
                    $(this).dialog("close");
                } else {
                    alert('Пожалуйста, введите наименование налога.');
                    $('#ce_name').focus();
                }
            }
        }
    });

});

function recount()
{
    var types = [ 'salary', 'rent', 'tax', 'co', 'ooe', 'loan', 'fin' ];
    $.each(types, function(){
        var type = this.concat();
        $('td:regex(desc,^'+type+'_0_\\d{2}_\\d{4}$)').each(function(){
            var desc_regexp = $(this).attr('desc').split(type+'_0').join(type+'_[^0]{1}[0-9]*');
            var amount = 0;
            $('td:regex(desc,^'+desc_regexp+'$)').each(function(){
                var value = parseInt($.trim($(this).html()));
                amount += value;
            });
            var type_sum_attr = desc_regexp.split(type+'_[^0]{1}[0-9]*').join(type+'_0');
            $('[desc="'+type_sum_attr+'"]').html(amount);

        });

        var amount_all = 0;
        $('td:regex(desc,^'+type+'_0_\\d{2}_\\d{4}$)').each(function(){
            amount_all += parseInt($.trim($(this).html()));
        });
        $('[desc="'+type+'_all"]').html(amount_all);

    });

    $('td:regex(desc,^col_sum_\\d{2}_\\d{4}$)').each(function(){
        var desc_attr = $(this).attr('desc').split('col_sum').join('');
        var col_summ = 0;
        $.each(types, function(){
            var type = this.concat();
            var value = parseInt($.trim($('[desc="'+type+'_0'+desc_attr+'"]').html()));
            col_summ += value;
        });
        $('[desc="col_sum'+desc_attr+'"]').html(col_summ);
    });

    var sum_of_types = 0;
    $.each(types, function(){
        var type = this.concat();
        var value = parseInt($.trim($('[desc="'+type+'_all"]').html()));
        sum_of_types += value;

        var cnt = 0;
        var ex_sum = 0;
        $('td:regex(desc,^'+type+'_[^0]{1}[0-9]*_\\d{2}_\\d{4}$)').each(function(){
            cnt++;
            var sp = $(this).attr('desc').split('_');
            var ex_id = sp[1];
            if(cnt == 12)
            {
                $('[desc="'+type+'_'+ex_id+'_0"]').html(ex_sum);
                ex_sum = 0;
                cnt = 0;
            }
            else
            {
                ex_sum += parseInt($.trim($(this).html()));
            }
        });
    });
    $('#tax_sum_month_all').html(sum_of_types);

}

function addTaxRow(tax_name, tax_type)
{
    $.ajax({
        url: new_row_url,
        data: "type="+tax_type+"&name=" + tax_name +"&business_unit_id="+business_unit_id,
        success: function(html){
            window.location.reload();
        }
    });
}


function hideStaff()
{
    $('.worker').each(function(){
        $(this).css('visibility', 'collapse');
    });
}

function showStaff()
{
    $('.worker').each(function(){
        $(this).css('visibility', 'visible');
    });
}

function hideTaxes()
{
    $('.tax').each(function(){
        $(this).css('visibility', 'collapse');
    });
}

function showTaxes()
{
    $('.tax').each(function(){
        $(this).css('visibility', 'visible');
    });
}
*/