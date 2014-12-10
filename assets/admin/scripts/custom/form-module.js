var FormModule = function () {
	
	var handleModuleForm = function () {	
		// --------------------- Used in Module Listing

		// --------------------- start --- Used in Module Listing
		//$('.mod_func').each(function() {
			//if ($(this).find('input[type="checkbox"]:checked').length == 0) {
				//$(this).parent('.select_holder').find('.module_menu').prop('checked','');
			//} 
		//});	

		$('.module_menu').change( function () {		
			var selected = $(this).parent().find('table tr td input[class="check_hidden_mplr"]');
			var closests = $(this).parents('.select_holder').find('div[class^="checker"] span');
			if ($(this).attr('checked') === 'checked') { selected.prop('checked','checked'); closests.removeClass('checked'); } 
			if ($(this).attr('checked') !== 'checked') { selected.prop('checked',''); closests.addClass('checked'); }	
		});

		$('input[class^="check_hidden_mplr"]').change( function () {
			if ($(this).prop('checked') == true) {
				$(this).closest("table").parent("td").find('input[name^="module_menu[group_id]"]').prop('checked','checked');
			} else {
				$(this).closest("table").parent("td").find('input[name^="module_menu[group_id]"]').prop('checked','');				
			}
		});	
		$('.fadeOut').fadeOut(3000);
		// --------------------- end --- Used in Module Listing
		
		 $('input[type="checkbox"]#ipt_checkall').click(function(){
			var value = $(this).attr('checked');
			if (value==true){
				$('input[type="checkbox"].ipt_tocheck').each(function(){
				   $(this).attr('checked','true').addClass('activecheck'); 
				});
			}else{
				$('input[type="checkbox"].ipt_tocheck').each(function(){
				   $(this).removeAttr('checked').removeClass('activecheck');
				});
			}
		});

		$('input[type="checkbox"].ipt_tocheck').click(function(){
			var value = $(this).attr('checked');
			if (value==true){
				$(this).attr('checked','true').addClass('activecheck');     
			}else{
				$(this).removeAttr('checked').removeClass('activecheck');
			}
		});
	
	}
	
    return {
        //main function to initiate the module
        init: function () {
        	
			handleModuleForm();
		}
	}
	
}();