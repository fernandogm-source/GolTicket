function loadCars() {
    var verificate_filters = localStorage.getItem('filters') || false;
    if (verificate_filters != false) {
        shop_filters();
        highlightFilters();
    } else {
        ajaxForSearch('module/shop/ctrl/ctrl_shop.php?op=all_cars');
    }
}

function loadDetails() {
    $(document).on("click", ".list_content_shop", function() {
        var id_car = this.getAttribute('id');

        ajaxPromise('module/shop/ctrl/ctrl_shop.php?op=details_car&id=' + id_car,
            'GET', 'JSON')
        .then(function(data) {
            $('#content_shop_cars').empty();
            $('.date_car' && '.date_img').empty();
            // $('#div_filters').attr({ class: 'none-filter' });
            $('#div_filters').hide();
            $('#div_map_shop').hide();
            $('#div_map_details').show();

            for (row in data[1][0]) {
                $('<div></div>').attr({ 'id': data[1][0].id_img, class: '' }).appendTo('.date_img')
                    .html(
                        "<div class='content-img-details'>" +
                        "<img src= '" + data[1][0][row].img_cars + "'" + "</img>" +
                        "</div>"
                    )
            }

            $('<div></div>').attr({ 'id': data[0].id_car, class: '' }).appendTo('.date_car')
                .html(
                    "<div class='list_product_details'>" +
                    "<div class='product-info_details'>" +
                    "<div class='product-content_details'>" +
                    "<h1><b>" + data[0].id_brand + " " + data[0].name_model + "</b></h1>" +
                    "<hr class=hr-shop>" +
                    "<table id='table-shop'> <tr>" +
                    "<td> <i id='col-ico' class='fa-solid fa-road fa-2xl'></i> &nbsp;" + data[0].Km + "KM" + "</td>" +
                    "<td> <i id='col-ico' class='fa-solid fa-person fa-2xl'></i> &nbsp;" + data[0].gear_shift + "</td>  </tr>" +
                    "<td> <i id='col-ico' class='fa-solid fa-car fa-2xl'></i> &nbsp;" + data[0].name_cat + "</td>" +
                    "<td> <i id='col-ico' class='fa-solid fa-door-open fa-2xl'></i> &nbsp;" + data[0].num_doors + "</td>  </tr>" +
                    "<td> <i id='col-ico' class='fa-solid fa-gas-pump fa-2xl'></i> &nbsp;" + data[0].name_tmotor + "</td>" +
                    "<td> <i id='col-ico' class='fa-solid fa-calendar-days fa-2xl'></i> &nbsp;" + data[0].matricualtion_date + "</td>  </tr>" +
                    "<td> <i id='col-ico' class='fa-solid fa-palette fa-2xl'></i> &nbsp;" + data[0].color + "</td>" +
                    "<td> <i class='fa-solid fa-location-dot fa-2xl'></i> &nbsp;" + data[0].city + "</td> </tr>" +
                    // <a href=""></a>
                    // "<td class='color-car' style='background-color: #06ad51;'> <i id='col-ico'class='fa-solid fa-palette fa-2xl'></i> &nbsp;" + data[0].color + "</td> </tr>" +
                    "</table>" +
                    "<hr class=hr-shop>" +
                    "<h3><b>" + "More Information:" + "</b></h3>" +
                    "<p>This vehicle has a 2-year warranty and reviews during the first 6 months from its acquisition.</p>" +
                    "<div class='buttons_details'>" +
                    "<a class='button add' href='#'>Add to Cart</a>" +
                    "<a class='button buy' href='#'>Buy</a>" +
                    "<span class='button' id='price_details'>" + data[0].price + "<i class='fa-solid fa-euro-sign'></i> </span>" +
                    // "<a class='button return' href='#'>Return Shop</a>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                )
            $('.date_img').slick({
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true,
                autoplay: true,
                autoplaySpeed: 1500
            });
        }).catch(function() {
            window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Load_Details SHOP";
        });
        ajaxPromise('module/shop/ctrl/ctrl_shop.php?op=details_count_car','POST', 'JSON', { 'id_car': id_car } )
    });
}

function load_filter() {
    $('<div></div>').attr({ 'id': 'filters', class: 'filters' }).appendTo('.filters_content')
        .html(
            '<p><u>SEARCH CAR:</u></p>' +
            '<hr class=hr-filter>' +
            '<div class="color">' +
            '<h4>COLOR:</h4>' +
            '<input type="checkbox" value="White" id="White" class="color">White</br>' +
            '<input type="checkbox" value="Blue" id="Blue" class="color">Blue</br>' +
            '<input type="checkbox" value="Black" id="Black"class="color">Black</br>' +
            '<input type="checkbox" value="Red" id="Red" class="color">Red</br>' +
            '<input type="checkbox" value="Grey" id="Grey" class="color">Grey' +
            '</div>' +
            '<hr class=hr-filter>' +
            '<div class="doors">' +
            '<h4>NUMBER DOORS:</h4>' +
            '<input type="radio" name="doors" value="3" id="3" class="doors">3</br>' +
            '<input type="radio" name="doors" value="5" id="5" class="doors">5</br>' +
            '</div>' +
            '<hr class=hr-filter>' +
            '<div class="doors">' +
            '<h4>CATEGORY:</h4>' +
            '<select name="select_cat" id="select_cat">' +
            '<option value="*" id="*">All</ option>' +
            '<option value="1" id="1">Km 0</option>' +
            '<option value="2" id="2">Second Hand</option>' +
            '<option value="3" id="3">Renting</option>' +
            '<option value="4" id="4">Pre-Owned</option>' +
            '<option value="5" id="5">Offer</option>' +
            '<option value="6" id="6">New</option>' +
            '</select>' +
            '</div>' +
            '<hr class=hr-filter>' +
            '<input type="button" class="submit_filter" id="buttons_filters" value="SEARCH">' +
            '<input type="button" class="remove_filters" id="buttons_filters" value="REMOVE">'
        )

    $(document).on('click', '.submit_filter', function() {
        save_filters();
    });

    $(document).on('click', '.remove_filters', function() {
        remove_filters();
    });
}

function save_filters() {
    var color = [];
    var doors = [];
    var category = [];
    var filters = [];

    localStorage.removeItem('filters');
    //color
    $.each($("input[class='color']:checked"), function() {
        color.push($(this).val());
    });
    if (color.length != 0) {
        filters.push({ "Color": color });
    } else {
        filters.push({ "Color": '*' });
    }
    //doors
    $.each($("input[class='doors']:checked"), function() {
        doors.push($(this).val());
    });

    if (doors.length != 0) {
        filters.push({ "Num_doors": doors });
    } else {
        filters.push({ "Num_doors": '*' });
    }

    //category
    var cat = document.getElementById("select_cat").value;
    if (cat != 0) {
        category.push(cat);
        if (category == "*") {
            filters.push({ "category": "*" });
        } else {
            filters.push({ "category": category });
        }
    } else {
        filters.push({ "category": '*' });
    }
    //all_filters (localstorage)
    if (filters.length != 0) {
        localStorage.setItem('filters', JSON.stringify(filters));
    }
    shop_filters();
}

function shop_filters() {
    var all_filters = JSON.parse(localStorage.getItem('filters'));
    var color = all_filters[0].Color;
    var doors = all_filters[1].Num_doors[0];
    var category = all_filters[2].category[0];
    ajaxForSearch('module/shop/ctrl/ctrl_shop.php?op=filters&color=' + color + '&doors=' + doors + '&category=' + category);
}

function ajaxForSearch(url) {
    ajaxPromise(url, 'GET', 'JSON')
        .then(function(data) {
            $('#content_shop_cars').empty();
            $('.date_car' && '.date_img').empty();
            $('#div_map_details').hide();

            if (data == "error") {
                $('<div></div>').appendTo('#content_shop_cars')
                    .html(
                        '<h3>¡No se encuentarn resultados con los filtros aplicados!</h3>'
                    )
            } else {
                for (row in data) {
                    $('<div></div>').attr({ 'id': data[row].id_car, class: 'list_content_shop' }).appendTo('#content_shop_cars')
                        .html(
                            "<div class='list_product'>" +
                            "<div class='img-container'>" +
                            "<img src= '" + data[row].img_car + "'" + "</img>" +
                            "</div>" +
                            "<div class='product-info'>" +
                            "<div class='product-content'>" +
                            "<h1><b>" + data[row].id_brand + " " + data[row].name_model + "</b></h1>" +
                            "<p>Up-to-date maintenance and revisions</p>" +
                            "<ul>" +
                            "<li> <i id='col-ico' class='fa-solid fa-road fa-xl'></i>&nbsp;&nbsp;" + data[row].Km + " KM" + "</li>" +
                            "<li> <i id='col-ico' class='fa-solid fa-person fa-xl'></i>&nbsp;&nbsp;&nbsp;" + data[row].gear_shift + "</li>" +
                            "<li> <i id='col-ico' class='fa-solid fa-palette fa-xl'></i>&nbsp;" + data[row].color + "</li>" +
                            "</ul>" +
                            "<div class='buttons'>" +
                            "<a class='button add' href='#'>Add to Cart</a>" +
                            "<a class='button buy' href='#'>Buy</a>" +
                            "<span class='button' id='price'>" + data[row].price + '€' + "</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                        )
                }
            }
        }).catch(function() {
            window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Function ajxForSearch SHOP";
        });
}

function highlightFilters() {
    var all_filters = JSON.parse(localStorage.getItem('filters'));

    if (all_filters[1].Num_doors[0] != '*') {
        document.getElementById(all_filters[1].Num_doors[0]).setAttribute('checked', true);
    }
    if (all_filters[2].category[0] != '*') {
        document.getElementById('select_cat').value = all_filters[2].category[0];
    }
    if (all_filters[0].Color[0] != '*') {
        for (row in all_filters[0].Color) {
            document.getElementById(all_filters[0].Color[row]).setAttribute('checked', true);
        }
    }
}

function remove_filters() {
    localStorage.removeItem('filters');
    localStorage.removeItem('brand_filter');
    localStorage.removeItem('category_filter');
    localStorage.removeItem('type_motor_filter');
    localStorage.removeItem('search');
    localStorage.removeItem('order');
    location.reload();
}

$(document).ready(function() {
    load_filter();
    loadCars();
    loadDetails();
});