const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
 
function loadEvent() {
    //var filtro = localStorage.getItem('filter');
    var filtro = JSON.parse(localStorage.getItem('filter'))|| false;

    //var filtro = localStorage.getItem('filter') || false;
    //if (filtro != false) {
    //if (filtro.length != 0) {
    if (filtro) {
        ajaxForSearch("module/shop/controller/controller_shop.php?op=all_event", filtro);
    } else {
        ajaxForSearch("module/shop/controller/controller_shop.php?op=all_event");
    }
}
 
function ajaxForSearch(url, filtro) {
    filtro = filtro || [];
    ajaxPromise(url, 'POST', 'JSON', { filter: JSON.stringify(filtro) })
        .then(function(data) {
            $('#containerPartidos').empty();

            if (data == "error") {
                $('#containerPartidos').append(`
                    <div class="partido-card">
                        <p class="partido-nombre">No se encuentran resultados con los filtros aplicados</p>
                    </div>
                `);
            } else {
                for (let row in data) {
                    const p = data[row];
                    const f = p.fecha_partido.split('-');
                    const mes = MESES[parseInt(f[1]) - 1];

                    let slidesHTML = '';
                    if (p.imgs_partido && p.imgs_partido.length > 0) {
                        for (let i in p.imgs_partido) {
                            slidesHTML += `<div class="swiper-slide"><img src="${p.imgs_partido[i]}" alt="${p.nombre_partido}"/></div>`;
                        }
                    } else {
                        slidesHTML = `<div class="swiper-slide"><img src="${p.img_campo}" alt="${p.nombre_partido}"/></div>`;
                    }

                    $('<div></div>').attr({ 'id': p.id_partido, 'class': 'partido-card' }).appendTo('#containerPartidos')
                        .html(`
                            <div class="swiper partido-card-swiper" id="swiper-${p.id_partido}">
                                <div class="swiper-wrapper">${slidesHTML}</div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                            <div class="partido-card-body">
                                <p class="partido-nombre">${p.nombre_partido}</p>
                                <div class="partido-fecha">
                                    <span class="partido-fecha-dia">${f[0]}</span>
                                    <span class="partido-fecha-mes">${mes}</span>
                                    <span class="partido-fecha-anyo">${f[2]}</span>
                                </div>
                                <div class="partido-meta">
                                    <span class="partido-meta-item">
                                        <span class="material-symbols-outlined">stadium</span>
                                        ${p.nombre_campo}
                                    </span>
                                    <span class="partido-meta-item">
                                        <span class="material-symbols-outlined">location_on</span>
                                        ${p.nombre_ciudad}
                                    </span>
                                </div>
                                <span class="partido-badge">${p.nombre_competicion}</span>
                                <button class="btn-tickets" id="${p.id_partido}">Ver entradas</button>
                            </div>
                        `);

                    new Swiper(`#swiper-${p.id_partido}`, {
                        speed: 500,
                        loop: p.imgs_partido.length > 1,  // loop solo si hay más de 1 imagen
                        slidesPerView: 1,
                        autoHeight: false,
                        navigation: {
                            prevEl: `#swiper-${p.id_partido} .swiper-button-prev`,
                            nextEl: `#swiper-${p.id_partido} .swiper-button-next`,
                        }
                    });
                }
            }
        }).catch(function() {
            // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Function ajxForSearch SHOP";
        });
}


function print_filters() {
    $('.filters').html(`
        <div class="div-filters">
            <select class="filter_select" id="filter_competicion">
                <option value="">Todas las competiciones</option>
                <option value="1">LaLiga</option>
                <option value="2">Champions League</option>
                <option value="3">LaLiga 2</option>
                <option value="4">Copa del Rey</option>
            </select>
            <select class="filter_select" id="filter_ciudad">
                <option value="">Todas las ciudades</option>
                <option value="1">Madrid</option>
                <option value="2">Barcelona</option>
                <option value="3">Almería</option>
                <option value="4">Manchester</option>
                <option value="5">Castellón</option>
            </select>
            <select class="filter_select" id="filter_equipo">
                <option value="">Todos los equipos</option>
                <option value="1">Real Madrid C.F.</option>
                <option value="2">F.C. Barcelona</option>
                <option value="3">C.D. Castellón</option>
                <option value="4">Manchester City F.C.</option>
                <option value="5">U.D. Almería</option>
            </select>
            <button class="btn-primary" id="btn-filter">
                <span class="material-symbols-outlined">filter_list</span>
                Filtrar
            </button>
            <button class="btn-volver" id="btn-remove-filter">
                <span class="material-symbols-outlined">close</span>
                Limpiar
            </button>
        </div>
    `);

    // Guardar valor al cambiar
    $('#filter_competicion').change(function() {
        localStorage.setItem('filter_competicion', this.value);
    });
    $('#filter_ciudad').change(function() {
        localStorage.setItem('filter_ciudad', this.value);
    });
    $('#filter_equipo').change(function() {
        localStorage.setItem('filter_equipo', this.value);
    });

    // Restaurar valor guardado
    if (localStorage.getItem('filter_competicion')) {
        $('#filter_competicion').val(localStorage.getItem('filter_competicion'));
    }
    if (localStorage.getItem('filter_ciudad')) {
        $('#filter_ciudad').val(localStorage.getItem('filter_ciudad'));
    }
    if (localStorage.getItem('filter_equipo')) {
        $('#filter_equipo').val(localStorage.getItem('filter_equipo'));
    }
}

 
function clicks() {
    $(document).on("click", ".btn-tickets", function() {
        var id = this.getAttribute('id');
        if (id) loadDetails(id);
    });

    $(document).on('click', '#btn-volver', function() {
        if ($('.date_img').hasClass('slick-initialized')) {
            $('.date_img').slick('unslick');
        }
        $('#details-shop').empty();
        $('#seccion-detalle').hide();
        $('#seccion-lista').show();
    });

    $(document).on('click', '#btn-filter', function() {
    var filtro = [];

    var competicion = $('#filter_competicion').val();
    var ciudad      = $('#filter_ciudad').val();
    var equipo      = $('#filter_equipo').val();

    if (competicion) filtro.push(['p.id_competicion', competicion]);
    if (ciudad)      filtro.push(['ci.id_ciudad', ciudad]);
    if (equipo)      filtro.push(['equipo', equipo]);

    localStorage.setItem('filter', JSON.stringify(filtro));
    ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event', filtro);
});
    $(document).on('click', '#btn-remove-filter', function() {
        localStorage.removeItem('filter');
        localStorage.removeItem('filter_competicion');
        localStorage.removeItem('filter_ciudad');
        localStorage.removeItem('filter_equipo');

        $('#filter_competicion').prop('selectedIndex', 0);
        $('#filter_ciudad').prop('selectedIndex', 0);
        $('#filter_equipo').prop('selectedIndex', 0);

        ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event', []);
    });
}
 
function loadDetails(id) {
    ajaxPromise('module/shop/controller/controller_shop.php?op=details_event&id=' + id, 'GET', 'JSON')
    .then(function(data) {

        $('#details-shop').empty();

        const p = data[0];
        const f = p.fecha_partido.split('-');
        const mes = MESES[parseInt(f[1]) - 1];

        // Construir extras HTML
        let extrasHTML = '';
        if (data[2].length > 0) {
            let itemsHTML = '';
            for (let row in data[2]) {
                itemsHTML += `
                    <div class="extra-item">
                        <img src="${data[2][row].img_extra}" alt="${data[2][row].nombre_extra}"/>
                        <span>${data[2][row].nombre_extra}</span>
                    </div>
                `;
            }
            extrasHTML = `
                <div class="extras-section">
                    <h4 class="extras-titulo">
                        <span class="material-symbols-outlined">star</span>
                        Extras disponibles
                    </h4>
                    <div class="extras-lista">${itemsHTML}</div>
                </div>
            `;
        }

        // Inyectar toda la estructura
        $('#details-shop').html(`
            <div class="details-row">
                <div class="date_img"></div>
                <div class="date_event">
                    <div class="partido-detail">
                        <h2 class="partido-detail-titulo">${p.nombre_partido}</h2>
                        <div class="partido-detail-meta">
                            <div class="partido-detail-item">
                                <span class="material-symbols-outlined">stadium</span>
                                <span>${p.nombre_campo}</span>
                            </div>
                            <div class="partido-detail-item">
                                <span class="material-symbols-outlined">location_on</span>
                                <span>${p.nombre_ciudad}</span>
                            </div>
                            <div class="partido-detail-item">
                                <span class="material-symbols-outlined">calendar_month</span>
                                <span>${f[0]} ${mes} ${f[2]}</span>
                            </div>
                            <div class="partido-detail-item">
                                <span class="material-symbols-outlined">emoji_events</span>
                                <span>${p.nombre_competicion}</span>
                            </div>
                        </div>
                        <div class="partido-detail-actions">
                            <button class="btn-tickets">Comprar entradas</button>
                        </div>
                    </div>
                </div>
            </div>
            ${extrasHTML}
        `);

        // Imágenes al carrusel
        for (let row in data[1]) {
            $('<div></div>').attr({ 'class': 'date_img_dentro' }).appendTo('.date_img')
                .html(`<img src="${data[1][row].img}" alt="${p.nombre_partido}"/>`);
        }

        $('#seccion-lista').hide();
        $('#seccion-detalle').show();

        $('.date_img').slick({
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 1500
        });

    }).catch(function() {
        // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Load_Details SHOP";
    });
}
 
$(document).ready(function () {
    loadEvent();
    print_filters();
    clicks();
});