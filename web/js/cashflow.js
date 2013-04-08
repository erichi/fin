date_reg = /^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/; 			// regular expression to match date format
float_reg = /^[1-9_][0-9_]{0,2}(?: ?[0-9_]{3}){0,3}\,[0-9_]{2}$/;                  // regular expression to match float format

$(function () {
    // Collect column cells and build edge rows
    function buildEdgeCells(cells) {
        var colCells = [],
            newColRows = [];

        cells.each(function (i, el) {
            colCells.push({
                text: $(el).html(),
                height: $.browser.opera ? $(el).outerHeight() : $(el).height()
            });

            $(el).remove();
        });

        $.each(colCells, function (i, cell) {
            var row = '<tr><td style="height: ' + cell.height + 'px;">' + (cell.text || '&nbsp;') + '</td></tr>'
            newColRows.push(row)
        });

        return newColRows.join('');
    }

    var viewport = $('.scrollable-table-viewport'),
        wrap = viewport.find('.scrollable-table'),
        table = wrap.find('table'),
        cells = table.find('thead').find('th'),
        firstCol = $('#first-col'),
        lastCol = $('#last-col'),
        totalWidth = 0;

    // Set proper table width
    cells.each(function (i, el) {
        totalWidth += $(el).outerWidth();
    });

    wrap.width(totalWidth);

    // Build edge columns
    firstCol.find('tbody').append(
        buildEdgeCells(table.find('tr').find('td:first'))
    ).end().find('thead').append(
        buildEdgeCells(table.find('tr').find('th:first'))
    );

    lastCol.find('tbody').append(
        buildEdgeCells(table.find('tr').find('td:last'))
    ).end().find('thead').append(
        buildEdgeCells(table.find('tr').find('th:last'))
    );

    // Normalize table cells height
    table.find('tr').each(function(i, row) {
        var index = $(row).index(),
            $cells = $.merge(firstCol, lastCol,  table).find('tbody tr').eq(index).find('td:first'),
            heights = $cells.map(function () {
                return $(this).outerHeight();
            }).get(),
            maxHeight = Math.max.apply(null, heights);

        firstCol.find('tbody tr').eq(index).find('td:first').height(maxHeight);
        table.find('tbody tr').eq(index).find('td:first').height(maxHeight);
        lastCol.find('tbody tr').eq(index).find('td:first').height(maxHeight);
    });

    $('.table tbody').find('tr').hover(
        function() {
            var index = $(this).index();
            $('.table tbody').find('tr:eq(' + index + ')').addClass('hover');
        }, function() {
            var index = $(this).index();
            $('.table tbody').find('tr:eq(' + index + ')').removeClass('hover');
        }
    );

    $('#cashflow_start_date').datepicker({
        beforeShowDay: function (date) {
            return [date.getDay() > 0 && date.getDay() < 6, '']; // Disable weekends
        },
        firstDay: 1,
        dateFormat: 'yy-mm-dd',
        onSelect: function (date) {
            var col = $('#' + date);

            if (col.length) {
                viewport.scrollTo(col.position().left + 2, 0, { duration: 700 });
            }
        }
    });
	
	var col = $('#' + $('#cashflow_start_date').val());
    if (col.length) {
        viewport.scrollTo(col.position().left + 2, 0, { duration: 700 });
    }
			
	$('#job_payment_date').datepicker({
		beforeShowDay: function (date) {
            return [date.getDay() > 0 && date.getDay() < 6, '']; // Disable weekends
        },
	});
});

function approveJoIp(id) {
    $.ajax({
        url: approve_income_payment_url,
        async: false,
        data: 'income_payment_id=' + id,
        success: function () {
            window.location = cashflow_index_url;
        }
    });
}

function approveJoOp(id) {
    $.ajax({
        url: approve_outcome_payment_url,
        async: false,
        data: 'outcome_payment_id=' + id,
        success: function () {
            window.location = cashflow_index_url;
        }
    });
}

function editPaymentDialog(joid, isIncome)
{
	dialog = $('#dialog_job_payment').dialog({
		autoOpen: false, minWidth: 500,	modal: true, resizable: false, draggable: false,
		title:	isIncome ? "Подтверждение входящего платежа" : "Подтверждение платежа подрядчику",
		buttons: {
			"Подтвердить": function() {
				if (validateJobPayment()) {
					$.ajax({
						url: '/job_order/approvePayment/action',
//						method: 'GET',
						data: {
							'bu': business_unit_id,
							'id': $('#job_payment_id').val(),
							'name': $('#job_payment_name').val(),
							'date': $('#job_payment_date').val(),
							'amount': $('#job_payment_amount').val().replace(/[_ ]/g,'').replace(',', '.'),
							'isIncome' : isIncome
						},
						success: function(result){
							if(result != "error" && result.length > 0){
								document.location = result;
							}
						}
					});
				}
			},
			"Отмена": function() {
				$(this).dialog("close");
			}
		}			
	});	
	
	
	var data = $('#'+joid).data('jo');
	console.log(data);
	if(typeof data.filelink == 'undefined'){
		$('#job_payment_file_container').css('display' , 'none');
	}else{
		$('#job_payment_file_container').css('display' , 'table-row');
		$('#job_payment_file').html(data.filelink); 
	}
	$('#job_payment_id').val(data.id);
	$('#job_payment_name').val(data.name);
	$('#job_payment_date').val(data.date);
	$('#job_payment_amount').inputmask('999 999 999 999,99', { numericInput: true, placeholder:"_" });
	$('#job_payment_amount').val(data.amount.replace('.',''));
	dialog.dialog('open');
}

function validateJobPayment()
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
    //$('#job_payment_amount').val($('#job_payment_amount').val().replace(/_/g,''));
	return true;
}