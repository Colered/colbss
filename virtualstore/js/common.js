$(document).ready(function() {
	$('#btnProceed').click(function(){
		$('.form-error').show();  
		$('.form-error').html("");
		var err = 0;
		/*if ($('#school_url').val() == '') {
			$('#school_url').parent().parent().find('.form-error').html(lang_select_school);
			err++;
		}else{
		   var action_url = $('#school_url').val()+'/precart.php';	
		}*/
		/*if ($('#parent_name').val() == '') {
			$('#parent_name').parent().parent().find('.form-error').html(lang_for_blank);
			err++;
		}
		if($('#s1g1').val() == '' && $('#s2g2').val() == '' && $('#s3g3').val() == '' && $('#s4g4').val() == ''){
			$('#s1g1').parent().parent().find('.form-error').html(lang_choose_one_grade);
			err++;
		}*/
		if (err == 0) {
			$(".rhino-active-bullet").removeClass("step-error").addClass("step-success");
			//$('#frmParentInfo').attr('action', action_url);
			$('#frmParentInfo').submit();
		} else {
			$(".rhino-active-bullet").removeClass("step-success").addClass("step-error");
		}
	});
});
/*function goDirectlyStore() {
	
	var sch_url=$("#school_url :selected").text();
	if($("#school_url :selected").val()!=""){
      window.location=sch_url;
	}else{
	  $('.form-error').show();
	  $('#school_url').parent().parent().find('.form-error').html(lang_select_school);
	}
}*/
function removeErr()
{
	$('.form-error').hide();
}



