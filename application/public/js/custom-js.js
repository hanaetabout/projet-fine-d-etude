$(document).ready(function () {
	$("#selectAll").click(function() {
		$("input[type=checkbox]").prop("checked", $(this).prop("checked"));
	});
	
	$("input[type=checkbox]").click(function() {
		if (!$(this).prop("checked")) {
			$("#selectAll").prop("checked", false);
		}
	});
	
  	$(document).on("click", function () {
		if($('.sidebar').hasClass('width')){
			if(!$(event.target).closest('.toggle-menu').length && !$(event.target).closest('.sidebar').length) {
				//alert();
				$(".sidebar").removeClass("width");
				$('.toggle-menu').removeClass("toggle-cross");
			} 
		}
    });  	
	
	$(".toggle-menu").on("click", function () {
        $(".sidebar").addClass("width");
        $(this).addClass("toggle-cross");
    });
	

});