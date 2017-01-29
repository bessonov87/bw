$(function () {
    var sharerTopPos = $('.sharer').offset().top; //topPos - это значение от верха блока до окна браузера
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top > sharerTopPos) $('.sharer').addClass('fixed');
        else $('.sharer').removeClass('fixed');
    });

    console.log('Start sharer!');
    console.log(window.location.href);
    var url = encodeURIComponent(window.location.href);
    console.log($('title').text());
    var title = encodeURIComponent($('title').text());

    $('.sharer-item').on('click', function () {
        var link;
        var service = $(this).data('service');
        switch(service){
            case 'vk':
                link = 'https://vk.com/share.php?url='+url+'&title='+title;
                break;
            case 'ok':
                link = 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl='+url;
                break;
            case 'fa':
                link = 'https://www.facebook.com/sharer.php?src=bw&u='+url+'&t='+title;
                break;
            case 'gp':
                link = 'https://plus.google.com/share?url='+title;
                break;
            case 'tw':
                link = 'https://twitter.com/intent/tweet?url='+url+'&text='+title;
                break;
            case 'mr':
                link = '';
                break;
            case 'fv':
                link = 'favorite';
                break;
        }
        share(service, link);
    });

    function share(service, link) {
        if(service === 'fv'){
            addFav();
        } else {
            if (!window.open(link, 'Поделиться', 'toolbar=0,status=0,scrollbars=1,width=626,height=436')) {
                console.log('Error!');
            }
        }
    }

    // Функция для добавления в закладки избранного
    function addFav() {
        var title = document.title,
            url = document.location,
            UA = navigator.userAgent.toLowerCase(),
            isFF = UA.indexOf('firefox') != -1,
            isMac = UA.indexOf('mac') != -1,
            isWebkit = UA.indexOf('webkit') != -1,
            isIE = UA.indexOf('.net') != -1;

        if (isIE) { // IE
            window.external.AddFavorite(url, title);
            return false;
        }

        if (isFF && window.external) { // Firefox
            window.external.AddFavorite(url, title);
            return false;
        }

        if (isMac || isWebkit) { // Webkit (Chrome, Opera), Mac
            alert('Нажмите "' + (isMac ? 'Command/Cmd' : 'Ctrl') + ' + D" для добавления страницы в закладки');
            return false;
        }
    }
});
