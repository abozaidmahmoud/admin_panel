

//statr dashbord

$(".plus-toggle").click(function(){
	$(this).toggleClass('active').parent().next('.panel-body').fadeToggle(500);
	if($(this).hasClass('active')){
		$(this).html('<i class="fa fa-minus fa-lg"></i>')
	}
	else{
		$(this).html('<i class="fa fa-plus fa-lg"></i>');
	}
})



//end dashbord
$('select').selectBoxIt();

$('[placeholder]').focus(function(){

   $placeholder= $(this).attr('placeholder');
   $(this).attr('placeholder','');

}).blur(function(){
	 $(this).attr('placeholder',$placeholder);
});

//add astreisk after each required input

$("input").each(function(){
	if($(this).attr('required')==='required'){
		$(this).after('<span class="astrisk">*</span>')
	}
})
 // when click in eye icon in form show and hide password
$('.eye').click(function(){
	$attr=$('.password').attr('type');
	if($attr=='password'){
        $('.password').attr('type','text');
	}
  	else{
        $('.password').attr('type','password');   
	}
  
})

//confirm in delete user

$('.delebut').click(function(){
	return confirm("are you sure to delete");
})

//make full and classic view for cateogery 

$('.cateogery h2').on('click',function(){
	$(this).next('.full-view').slideToggle(200);
})

$(".cateogery-head span").click(function(){
	
		$(this).addClass('active').siblings("span").removeClass('active');
		if($(this).data('view')=='view'){
			$(".full-view").slideDown(200);
		}
		else{
			$(".full-view").slideUp(200);
		}
	
	
})