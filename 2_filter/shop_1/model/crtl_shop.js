function ajaxForSearch(url, filter) {
    ajaxPromise(url, 'POST', 'JSON', { 'filter': filter })
        .then(function (shop) {
            console.log(shop);
            $("#containerShop").empty();
            for (row in shop) {
                $('<div></div>').appendTo('#containerShop')
                    .html(
                        '<div id="overlay">' +
                        '<div class= "cv-spinner" >' +
                        '<span class="spinner"></span>' +
                        '</div >' +
                        '</div > ' +
                        '</div>' +
                        '</div>' +
                        '<div class="page">' +
                        '<section class="section section-md bg-white">' +
                        '<div class="shell">' +
                        '<div class="range range-50 range-sm-center range-md-left range-md-middle range-md-reverse">' +
                        '<div class="cell-sm-6 wow fadeInRightSmall">' +
                        ' <div class="thumb-line"><img src="' + shop[row].img + '" alt="" width="531" height="640"/>' +
                        '</div>' +
                        '</div>' +
                        '<div class="cell-sm-6">' +
                        '<div class="box-width-3">' +
                        '<p class="heading-1 wow fadeInLeftSmall">' + shop[row].brand_name + '</p>' +
                        '<article class="quote-big wow fadeInLeftSmall" data-wow-delay=".1s">' +
                        '<p class="q">' + shop[row].modelo + '</p>' +
                        '<p class="q">' + shop[row].precio + '€</p>' +
                        '<p class="q">' + shop[row].cat_name + '</p>' +
                        '</article>' +
                        '<div class="divider wow fadeInLeftSmall" data-wow-delay=".2s"></div>' +
                        '<p class="q">' + shop[row].type_name + '<i class="fa-thin fa-gas-pump fa-2xl"></i></p>' +
                        '<p class="wow fadeInLeftSmall" data-wow-delay=".3s">' + shop[row].puertas + '<i class="fa-solid fa-door-open fa-2xl"></i></p><a class="button button-primary-outline button-ujarak button-size-1 wow fadeInLeftSmall link button_spinner" data-wow-delay=".4s" id="' + shop[row].id + '">Read More</a>' +
                        '</div>' +
                        '</div>' +
                        '</section>' +
                        '</div>');
            }
        }).catch(function (e) {
            $("#containerShop").empty();
            $('<div></div>').appendTo('#containerShop').html('<h1>No hay coches con estos filtros</h1>');
        });
}

function shopAll() {
    //var filtro = localStorage.getItem('filter');
    var filtro = JSON.parse(localStorage.getItem('filter'))|| false;

    //var filtro = localStorage.getItem('filter') || false;
    //if (filtro != false) {
    //if (filtro.length != 0) {
    if (filtro) {
        ajaxForSearch("modules/shop/crtl/crtl_shop.php?op=filter", filtro);
    } else {
        ajaxForSearch("modules/shop/crtl/crtl_shop.php?op=shopAll");
    }
}

function details(id) {
    $("#containerShop").empty();
    
    ajaxPromise('modules/shop/crtl/crtl_shop.php?op=details&id=' + id, 'POST', 'JSON')
        .then(function (id) {
            $('<div></div>').appendTo('#containerShop')
                .html('<div class="page">' +
                    '<section class="section section-md bg-white">' +
                    '<div class="shell">' +
                    '<div class="range range-50 range-sm-center range-md-left range-md-middle range-md-reverse">' +
                    '<div class="cell-sm-6 wow fadeInRightSmall">' +
                    '<div class="slider">' +
                    '<div class="slider-wrapper theme-default">' +
                    '<div id="slider" class="nivoSlider">' +
                    '</div>' +
                    '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/jquery.nivo.slider.pack.min.js"></script>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="cell-sm-6">' +
                    '<div class="box-width-3">' +
                    '<p class="heading-1 wow fadeInLeftSmall">' + id[0].brand_name + '</p>' +
                    '<article class="quote-big wow fadeInLeftSmall" data-wow-delay=".1s">' +
                    '<p class="q">' + id[0].modelo + '</p>' +
                    '<p class="q">' + id[0].precio + '€</p>' +
                    '<p class="q">' + id[0].type_name + '</p>' +
                    '</article>' +
                    '<div class="divider wow fadeInLeftSmall" data-wow-delay=".2s"></div>' +
                    '<p class="wow fadeInLeftSmall" data-wow-delay=".3s">' + id[0].puertas + '<i class="fa-solid fa-door-open fa-2xl"></i></p>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</section>' +
                    '</div>');

            for (row in id) {
                $('<img src = "' + id[row].img + '"></img>').attr({ 'id': id[row].id })
                    .appendTo('#slider')
            }
            $('#slider').nivoSlider({
                slices: 35,
                animSpeed: 100,
            });
        }).catch(function (error) {
            window.location.href = "index.php?modules=exception&op=503&error=details&type=503";
        });
}

function highlight(filter) {
    if (filter != 0) {
        $('.highlight').empty();
        $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
            .html('<p style="display: inline; margin:10px;">Sus filtros: </p>');
        for (row in filter) {
            $('<div style="display: inline; float: right;"></div>').appendTo('.highlight')
                .html('<p style="display: inline; margin:3px;">' + filter[row] + '</p>');
        }
    }
    else {
        $('.highlight').empty();
        location.reload();
    }
}

function print_filters() {
    $('<div class="div-filters"></div>').appendTo('.filters')
        .html('<select class="filter_type">' +
            '<option value="1">Electrico</option>' +
            '<option value="2">Hibrido</option>' +
            '<option value="3">Adaptado</option>' +
            '<option value="4">Gasolina</option>' +
            '</select>' +
            '<select class="filter_category">' +
            '<option value="1">KM0</option>' +
            '<option value="2">Seminuevo</option>' +
            '<option value="3">PocosKM</option>' +
            '</select>' +
            '<select class="filter_order">' +
            '<option value="precio">Precio de mas a menos </option>' +
            '<option value="km">KM de menos a mas </option>' +
            '</select>' +
            '<div id="overlay">' +
            '<div class= "cv-spinner" >' +
            '<span class="spinner"></span>' +
            '</div >' +
            '</div > ' +
            '</div>' +
            '</div>' +
            '<p> </p>' +
            '<button class="filter_button button_spinner" id="Button_filter">Filter</button>' +
            '<button class="filter_remove" id="Remove_filter">Remove</button>');
}

function filter_button() {
    //Filtro type
        $('.filter_type').change(function () {
            localStorage.setItem('filter_type', this.value);
        });
        if (localStorage.getItem('filter_type')) {
            $('.filter_type').val(localStorage.getItem('filter_type'));
        }

    //Filtro category
        $('.filter_category').change(function () {
            localStorage.setItem('filter_category', this.value);
        });
        if (localStorage.getItem('filter_category')) {
            $('.filter_category').val(localStorage.getItem('filter_category'));
        }

    //Filtro type
        $('.filter_brand').change(function () {
            localStorage.setItem('filter_brand', this.value);
        });
        if (localStorage.getItem('filter_brand')) {
            $('.filter_brand').val(localStorage.getItem('filter_brand'));
        }

    //Filtro de km
        $('.filter_order').change(function () {
            localStorage.setItem('filter_order', this.value);
        });
        if (localStorage.getItem('filter_order')) {
            $('.filter_order').val(localStorage.getItem('filter_order'));
        }

    $(document).on('click', '.filter_button', function () {
        var filter = [];

        if (localStorage.getItem('filter_type')) {
            filter.push(['combustible', localStorage.getItem('filter_type')])
        }
        if (localStorage.getItem('filter_category')) {
            filter.push(['categoria', localStorage.getItem('filter_category')])
        }
        if (localStorage.getItem('filter_brand')) {
            filter.push(['marca', localStorage.getItem('filter_brand')])
        }
        if (localStorage.getItem('filter_order')) {
            filter.push(['orden', localStorage.getItem('filter_order')])
        }

        //localStorage.setItem('filter', filter);
        localStorage.setItem('filter', JSON.stringify(filter));
        window.Location.reload;

        //var filter = localStorage.getItem('filter') || false;
        //if (filter != false) {
        //if (filter.length != 0) {
        /* if (filter) {
            ajaxForSearch("modules/shop/crtl/crtl_shop.php?op=filter", filter);
        }
        else {
            ajaxForSearch("modules/shop/crtl/crtl_shop.php?op=shopAll");
        }

        highlight(filter); */

        $(document).on('click', '.filter_remove', function () {
            localStorage.removeItem('filter_type');
            localStorage.removeItem('filter_category');
            filter.length = 0;
            localStorage.removeItem('filter');
            window.Location.reload;

/* 
            if (filter == 0) {
                ajaxForSearch("modules/shop/crtl/crtl_shop.php?op=shopAll");
                highlight(filter);
            } */
        });
    });
}

function load_details() {
    $(document).on('click', '.link', function () {
        var id = this.getAttribute('id');
        details(id);
    })
}

$(document).ready(function () {
    shopAll();
    load_details();
    print_filters();
    filter_button();
});
