$(document).ready(function() {
	$(".form-group select").select2({
	    width:'100%',
	    dir:'rtl',
	    "language": {
	         "noResults": function(){
	             if($('body').hasClass('en'))
	              return "no results";
	             else
	              return "یافت نشد";
	         }
	     },
	      escapeMarkup: function (markup) {
	          return markup;
	      }
	});
	$('.form-group select').on('select2:opening', function (e) {
	  $(this).parents('.form-group').addClass('open');
	  if($('body').hasClass('en'))
	  $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'search');
	  else
	  $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'جستجو');
	  if($(this).parents('.form-group').hasClass('gray'))
	    $(this).data('select2').$dropdown.addClass('gray');

	});
	$('.form-group select').on('select2:closing', function (e) {
	  $(this).parents('.form-group').removeClass('open');
	  if($(this).parents('.form-group').hasClass('gray'))
	    $(this).data('select2').$dropdown.removeClass('gray');
	});
	$('.form-group select').on('select2:open', function (e) {
	  var width = $(this).parents('.form-group').outerWidth();
	  var dropdownwidth = $(this).data('select2').$results.width();
	  if(Math.ceil(dropdownwidth)==170 && !$('body').hasClass('en')){
	    $(this).data('select2').$dropdown.css('marginLeft','-'+Math.abs(width-170)+'px');
	  }else{
	    $(this).data('select2').$dropdown.css('marginLeft',0);
	  }
	});
	$('.form-group select').on('select2:select', function (e) {
		var data = e.params.data;
		$.get("/locale/"+e.params.data.id);
		if(e.params.data.id=="en"){
			$('body').addClass('en');
			$('.login .box .form-group').each(function( index, element){
				$(element).find('label').text($(element).data('en'));
				$(element).find('input').attr("placeholder", $(element).data('en'));
			});
			$('.login .box .btn.btn-blue.arrow').text($('.login .box .btn.btn-blue.arrow').data('en'));
		}else if(e.params.data.id=="fa"){
			$('body').removeClass('en');
			$('.login .box .form-group').each(function( index, element){
				$(element).find('label').text($(element).data('fa'));
				$(element).find('input').attr("placeholder", $(element).data('fa'));
			});
			$('.login .box .btn.btn-blue.arrow').text($('.login .box .btn.btn-blue.arrow').data('fa'));
		}
	});
});
