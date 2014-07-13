$(function(){
		$('.main_menu li').hover(function(){
			$(this).addClass('hover');
		},function(){
			$(this).removeClass('hover');
		});
		
		$('.menu_title,.select_box_link').live('click',function(){ 
			$(this).toggleClass('active');
			$(this).next().toggleClass('active');
			return false;
		});
		
		
		$('.main_menu ul li').live('click',function(){
			$('.main_menu ul li').removeClass('active');
			$(this).toggleClass('active');
			return false;
		});
//	});

//$(document).ready(function(){
    $('table tr:nth-child(even)').addClass('even');

    /* Задаем начальные значения */
    var col = $('#BottomMenu ul').size();
    $('#BottomMenu ul').slice(1, col).hide();

    /* Клики по нижним ссылкам */
    $('#BottomMenu a').click(function(){
        $('#BottomMenu a').each(function() {
            $(this).removeClass('active');
        });

        $(this).addClass('active');
    });

    var val_id = $('.active').attr('id');
    $("#BottomMenu ul").hide();
    $("#BottomMenu ."+val_id).show();

    var ind = 0;
    var el = null;
    var id = null;

    /* Клик по табу */
    $('#TopMenu li').click(function(){

        if( el != undefined )
            el.css('z-index', ind);

        $('#TopMenu li').each(function() {
            $(this).removeClass('active');
        });

        ind = $(this).css('zIndex');
        el = $(this);

        id = $(this).attr('id');

        $(this).addClass('active');
        $(this).css({zIndex:'1000'});

        $("#BottomMenu ul").hide();
        $("#BottomMenu ."+id).show();
    });
});