$(function () {
    var sharerTopPos = $('.sharer').offset().top; //topPos - это значение от верха блока до окна браузера
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top > sharerTopPos) $('.sharer').addClass('fixed');
        else $('.sharer').removeClass('fixed');
    });

    console.log('Start sharer!');
    console.log(window.location.href);
    var url = encodeURI(window.location.href);
    console.log($('title').text());
    var title = encodeURIComponent($('title').text());

    $('.sharer-vk').on('click', function () {
        window.open('https://vk.com/share.php?url='+url+'&title='+title, 'Поделиться', 'width=600,height=400');
    });


});
