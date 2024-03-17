$('.cd-accordion-menu li label').click(function(){
    if($(this).parent().hasClass('active')){
        $(this).next().slideUp(300, function(){
            $(this).parent().removeClass('active');
        });
    }else{
        $(this).next().slideDown(300, function(){
            $(this).parent().addClass('active');
        });
    }
});