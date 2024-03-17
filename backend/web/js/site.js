//обрезка цыфр в числах с плавающей точкой
function floorFigure(number, decimals) {
    number = 1 * number;
    if (isNaN(number)) number = 0;
    number = number.toFixed(8);

    var s = number + '', a = s.split('.');
    if (decimals > 0) {
        a[1] = a[1] || '';
        a[1] = a[1].substring(0, decimals);
        while (a[1].length < decimals) {
            a[1] = a[1] + '0';
        }
        return a[0] + '.' + a[1];
    } else {
        return a[0];
    }
}

//действия при смене экрана
function change_screen() {
    if (screen.width < 650) {
        var mvp = document.getElementById('vp');
        mvp.setAttribute('content', 'user-scalable=no,width=650');
    }

    var $sidebar = $('aside.main-sidebar'),
        $sidebarSection = $sidebar.find('section.sidebar'),
        sidebarPaddingTop = parseInt($sidebar.css('padding-top')),
        bodyHeight = $(window).innerHeight(),
        sidebarSectionMaxHeight = bodyHeight - sidebarPaddingTop;

    $sidebarSection.css({
        'max-height': sidebarSectionMaxHeight + 'px',
        'overflow-y': 'auto'
    });
}

//показ загрузчика
function showPreloader() {
    if (!$('.preloader_bg').length) {
        var $preloader = $('<div class="preloader_bg"><div class="load""><hr><hr><hr><hr></div></div>'),
            preloaderStyles = '<style>.preloader_bg{background-color:rgba(236,240,245,1);position:fixed;left:0;right:0;top:0;bottom:0;z-index:999}.load,.load hr{position:absolute}.load{top:50%;left:50%;-webkit-transform:translateX(-50%) translateY(-50%);-moz-transform:translateX(-50%) translateY(-50%);-ms-transform:translateX(-50%) translateY(-50%);-o-transform:translateX(-50%) translateY(-50%);transform:translateX(-50%) translateY(-50%);width:100px;height:100px}.load hr{border:0;margin:0;width:40%;height:40%;border-radius:50%;animation:spin 2s ease infinite}.load :first-child{background:#3c3760;animation-delay:-1.5s}.load :nth-child(2){background:#ec407a;animation-delay:-1s}.load :nth-child(3){background:#ff7043;animation-delay:-.5s}.load :last-child{background:#00c0ef}@keyframes spin{0%,100%{transform:translate(0)}25%{transform:translate(160%)}50%{transform:translate(160%,160%)}75%{transform:translate(0,160%)}}@media (max-width:1025px){.load{width:50px;height:50px}}</style>';

        $('body').append($preloader);
        $('body').append(preloaderStyles);
    } else {
        $('.preloader_bg').show();
        $('.preloader_bg .load').show();
    }
}

//создание селекта вмулти полях
function renderSelectOptions(item, $obj) {
    var f = 0;

    $obj.find('select').each(function () {
        if ($(this).val() === item.value) f = 1;
    });

    if (f === 0) {
        return '<div><span>' + item.text + '</span></div>';
    } else {
        return '<div style=\'display: none;\'><span>' + item.text + '</span></div>';
    }
}

//когда в мульти полях есть селект и нужно чтобы не попадались дубликаты
function refreshSelectOptions($obj) {
    $obj.find('.selectize-dropdown-content div').show().each(function () {
        var f = 0;
        var value = $(this).attr('data-value');
        $obj.find('select').each(function () {
            if ($(this).val() === value) f = 1;
        });

        if (f === 1) $(this).hide();
    });
}

$(window).on('load', function () {
    change_screen();
    $(window).resize(function () {
        change_screen();
    });
});

//установка для блокировки дуьлирование нажатие сабмита
var submit = true;
$('button[type="submit"], input[type="submit"]').click(function () {
    if (!submit) return false;
});

//после отправки форм показывать загрузщик
$('form').on('beforeSubmit', function () {
    if (submit) {
        showPreloader();
        submit = false;
    } else {
        return false;
    }
});


//обрезка чисел с плавающей точкей
$('body').on('change', 'input.float', function () {
    var floor = $(this).attr('data-floor');
    var value = floorFigure($(this).val().replace(',', '.').replace(/\s/g, ''), floor);
    $(this).val(value);
});



