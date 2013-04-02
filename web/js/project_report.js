$(function() {	
	$('.edit').editable(save_field_data_url,{
		event			: "dblclick.editable",
		id:  'editinput',
		data: function(value, settings) {
			return $.parseNumber(value, {format:"0,000.00", locale:"ru"});
		}, 
    	submit 		: "OK",
    	onsubmit	: function(){
    	    if (isNaN($('[name="value"]').val())) {
				alert("Значение должно быть числом! Введенно значение: "+$('[name="value"]').val()+"");
				return false;
    		}
    	},
    	submitdata: function(){
    		return { id: save_bu_id }
    	},
     	callback : function(value, settings) {
			value = $.parseJSON(value)
			$.each(value, function(key, val){
				$("." + key).html($.formatNumber(val, {format:"0,000.00", locale:"ru"}));
			});
    	} 
	});
});