$(document).ready(function() {

	//Попап менеджер FancyBox
	//Документация: http://fancybox.net/howto
	//<a class="fancybox"><img src="image.jpg" /></a>
	//<a class="fancybox" data-fancybox-group="group"><img src="image.jpg" /></a>
	$(".fancybox").fancybox();

	//Плавный скролл до блока .div по клику на .scroll
	//Документация: https://github.com/flesler/jquery.scrollTo
	/*$("a.scroll").click(function() {
		$.scrollTo($(".div"), 800, {
			offset: -90
		});
	});*/
    $('a[href^="#"]').click(function(){
        var el = $(this).attr('href');
        $('body').animate({
            scrollTop: $(el).offset().top}, 2000);
        //return false;
    });

	//Каруселька
	//Документация: http://owlgraphic.com/owlcarousel/
	var owl = $(".carousel");
	owl.owlCarousel({
		items : 4
	});
	owl.on("mousewheel", ".owl-wrapper", function (e) {
		if (e.deltaY > 0) {
			owl.trigger("owl.prev");
		} else {
			owl.trigger("owl.next");
		}
		e.preventDefault();
	});
	$(".next_button").click(function(){
		owl.trigger("owl.next");
	});
	$(".prev_button").click(function(){
		owl.trigger("owl.prev");
	});

	//Кнопка "Наверх"
	//Документация:
	//http://api.jquery.com/scrolltop/
	//http://api.jquery.com/animate/
	$("#top").click(function () {
		$("body, html").animate({
			scrollTop: 0
		}, 800);
		return false;
	});


    // При нажатии кнопки ответить в комментарии
    $('.comm-reply-link').on('click', function(){
        $( ".reply-block" ).remove();
        var linkData = $(this).data();
        var replyId = linkData['replyId'];
        var replyUserId = linkData['replyUserId'];
        var replyUserName = linkData['replyUserName'];
        var replyComment = $('#comment-'+replyId+' .comment-text').text();
        //alert(replyId);
        var block = '<div class="reply-block">' +
            '<div class="reply-info">Ответ на комментарий <strong>#'+replyId+'</strong> пользователя <strong>'+replyUserName+'</strong></div>' +
            '<div class="reply-comm">'+replyComment+'</div>' +
			'<div class="reply-cancel">Отменить</div>'+
            '</div>';
        $(block).insertBefore('.comm-text');
        $('#commentform-reply_to').val(replyId);
        // Навешиваем обработчик на кнопку Отменить при ответе на комментарий
        $('.reply-cancel').bind('click', function(){
            $('#commentform-reply_to').val('');
            $('.reply-block').animate({opacity: 0, height: 0}, 500, function(){
                $(this).remove();
            });

        });
    });

});