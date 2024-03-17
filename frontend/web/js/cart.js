function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options = {}) {
    options = {
        path: '/',
    };

    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }

    document.cookie = updatedCookie;
}

$(document).ready(function () {
    //закидівание товара в корзину
    $('.buy-button').click(function () {
        var id = $(this).attr('data-id');
        var cart = getCookie('cart');
        if (cart === undefined) cart = '[]';
        cart = JSON.parse(cart);

        var f = false;
        for (var i = 0; i < cart.length; i++) {
            if (cart[0].id === id) {
                cart[0].count++;
                f = true;
            }
        }
        if (!f) cart.push({id: id, count: 1});

        setCookie('cart', JSON.stringify(cart), {secure: true});

        return false;
    });
});
