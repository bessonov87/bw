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

    // Добавляем ведущий ноль к месяцу
    function leadZero(n) { return (n < 10 ? '0' : '') + n; }

    // ЗАГРУЗКА ДРУГОГО МЕСЯЦА КАЛЕНДАРЯ
    $('.calendar_control').on('click', function(){
        var currentDate = $('#calendar-current-date').text();
        var splitDate = currentDate.split('-');
        var year = splitDate[0];
        var month = splitDate[1];
        if($(this).attr('id') == 'calendar-prev'){
            if(month == '01') loadDate = (--year)+'-12';
            else loadDate = year+'-'+leadZero(--month);
        }
        if($(this).attr('id') == 'calendar-next'){
            if(month == '12') loadDate = (++year)+'-01';
            else loadDate = year+'-'+leadZero(++month);
        }
        // Отправка запроса
        $.ajax({
            url: '/ajax/calendar',
            type: 'GET',
            data: {
                'date' : loadDate,
            },
            success: function(data){
                $('.calendar_body').html(data);
            }
        });
    });

    // ГОРОСКОП
    function change_znak(znak)
    {
        $('.goro-item').css('display', 'none');
        $('#' + znak).css('display', 'block');
        $('#znak').val(znak);
    }

    $('.goroskop_zodiac').on('click', function() {
        change_znak($(this).data('zodiac'));
    });

    $('.goro-select select').on('change', function() {
        console.log($(this).val());
        change_znak($(this).val());
    });

    // РЕЙТИНГ
    $('.post_rating button').on('click', function() {
        //$('.post_rating').detach();
        var postId = $('#post-id').text();
        var score = 0;
        var bClass = $(this).attr('class');
        if(bClass == 'post_rating_button_plus'){
            score = 1;
        } else if(bClass == 'post_rating_button_minus') {
            score = -1;
        }
        // Отправка запроса
        $.ajax({
            url: '/ajax/rating',
            type: 'GET',
            data: {
                'post_id' : postId,
                'score' : score,
            },
            success: function(data){
                $('.content-item-rating-1').html(data);
            }
        });
    });

    // ИЗБРАННОЕ
    $('.post_favorite_button').on('click', function() {
        var postId = $('#post-id').text();
        // Отправка запроса
        $.ajax({
            url: '/ajax/favorite',
            type: 'GET',
            data: {
                'post_id' : postId,
            },
            success: function(data){
                $('.content-item-favorite').html(data);
            }
        });
    });

    // БЛОК СЕГОДНЯ В ЛУННОМ КАЛЕНДАРЕ СТРИЖЕК
    $(function() {
        $('.today_day').on('click', function() {
            $('#today_block').toggle();
            $('#tomorrow_block').toggle();
            $('#moon_tomorrow').toggleClass('today_active');
            $('#moon_today').toggleClass('today_active');
        });
    });

    var floatingBlock = $('.floating');
    if(floatingBlock.length) {
        var topPos = floatingBlock.offset().top; //topPos - это значение от верха блока до окна браузера
        $(window).scroll(function () {
            var top = $(document).scrollTop();
            if (top > topPos) $('.floating').addClass('fixed');
            else $('.floating').removeClass('fixed');
        });
    }

    $(document).on('click', "button[name='login-button-2']", function(){
        console.log('Login clicked!');
        var username = $('#loginform-username').val();
        dataLayer.push({
            'username': username,
            'event': 'event_username_login'
        });
    });

    $(document).on('click', "#calendar-prev", function(){
        console.log('Calendar clicked!');
        var month = $('.calendar_nowmonth').find('a').text();
        console.log(month);
        dataLayer.push({
            'month': month,
            'event': 'event_change_month'
        });
    });

});