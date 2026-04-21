const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

// ── MAPA LEAFLET ──────────────────────────────────────────────────────────────

let leafletMap = null;
let leafletMapDetail = null;

function destroyMap() {
    if (leafletMap) {
        leafletMap.remove();
        leafletMap = null;
    }
}

/**
 * Mapa con todos los partidos (vista lista/shop).
 * Cada partido necesita lat y lng en los datos del servidor.
 */
function leafletMap_all(shop) {
    destroyMap();

    leafletMap = L.map('map').setView([40.4168, -3.7038], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(leafletMap);

    const bounds = [];

    for (let row in shop) {
        const p = shop[row];
        if (!p.lat || !p.lng) continue;

        const lat = parseFloat(p.lat);
        const lng = parseFloat(p.lng);
        bounds.push([lat, lng]);

        // Construir slides del carrusel
        let slides = '';
        if (p.imgs_partido && p.imgs_partido.length > 0) {
            p.imgs_partido.forEach(function(img) {
                slides += `<div class="swiper-slide">
                               <img src="${img}" alt="${p.nombre_partido}" style="width:100%; height:160px; object-fit:cover;"/>
                           </div>`;
            });
        }

        const swiperID = `swiper-popup-${p.id_partido}`;

        const popupContent = `
            <div class="popup-card">
                <div class="swiper ${swiperID}" style="width:100%; height:160px; border-radius:10px 10px 0 0; overflow:hidden;">
                    <div class="swiper-wrapper">${slides}</div>
                    ${p.imgs_partido && p.imgs_partido.length > 1
                        ? `<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>`
                        : ''}
                </div>
                <div class="popup-body">
                    <p class="popup-nombre">${p.nombre_partido}</p>
                    <div class="popup-meta">
                        <span><span class="material-symbols-outlined">stadium</span>${p.nombre_campo}</span>
                        <span><span class="material-symbols-outlined">location_on</span>${p.nombre_ciudad}</span>
                    </div>
                    <div class="popup-footer">
                        <span class="popup-precio">${p.precio}€</span>
                        <button class="btn-tickets popup-btn" id="${p.id_partido}">Ver entradas</button>
                    </div>
                </div>
            </div>
        `;

        const marker = L.marker([lat, lng]).addTo(leafletMap);
        marker.bindPopup(popupContent, { maxWidth: 280, minWidth: 280 });

        // Inicializar Swiper cuando el popup esté en el DOM
        marker.on('popupopen', function() {
            new Swiper(`.${swiperID}`, {
                loop: p.imgs_partido && p.imgs_partido.length > 1,
                slidesPerView: 1,
                speed: 400,
                navigation: {
                    prevEl: `.${swiperID} .swiper-button-prev`,
                    nextEl: `.${swiperID} .swiper-button-next`,
                }
            });
        });
    }

    if (bounds.length > 0) {
        leafletMap.fitBounds(bounds, { padding: [30, 30] });
    }
}

/**
 * Mapa de detalle de un partido individual.
 */
function leafletMap_single(partido) {
    destroyMapDetail();

    if (!partido.lat || !partido.lng) return;

    const lat = parseFloat(partido.lat);
    const lng = parseFloat(partido.lng);

    leafletMapDetail = L.map('map-detail').setView([lat, lng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(leafletMapDetail);

    const popupContent = `
        <div class="popup-card">
            <div class="popup-body">
                <p class="popup-nombre">${partido.nombre_partido}</p>
                <div class="popup-meta">
                    <span><span class="material-symbols-outlined">stadium</span>${partido.nombre_campo}</span>
                    <span><span class="material-symbols-outlined">location_on</span>${partido.nombre_ciudad}</span>
                </div>
                <div class="popup-footer">
                    <span class="popup-precio">${partido.precio}€</span>
                </div>
            </div>
        </div>
    `;

    L.marker([lat, lng])
        .bindPopup(popupContent, { maxWidth: 280, minWidth: 280 })
        .addTo(leafletMapDetail)
        .openPopup();
}
 
// ── INIT ──────────────────────────────────────────────────────────────────────

function loadEvent() {
    var filtro = JSON.parse(localStorage.getItem('filter')) || false;
 
    if (filtro) {
        ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event', filtro);
    } else {
        ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event');
    }
}
 
function ajaxForSearch(url, filtro) {
    filtro = filtro || [];
    ajaxPromise(url, 'POST', 'JSON', { filter: JSON.stringify(filtro) })
        .then(function(data) {
            $('#containerPartidos').empty();
 
            if (data == 'error') {
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
                        loop: p.imgs_partido.length > 1,
                        slidesPerView: 1,
                        autoHeight: false,
                        navigation: {
                            prevEl: `#swiper-${p.id_partido} .swiper-button-prev`,
                            nextEl: `#swiper-${p.id_partido} .swiper-button-next`,
                        }
                    });
                }
                leafletMap_all(data);
            }
        }).catch(function() {
            // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Function ajxForSearch SHOP";
        });
}
 
// ── FILTROS DINÁMICOS ─────────────────────────────────────────────────────────
 
function print_filters() {
    ajaxPromise('module/shop/controller/controller_shop.php?op=get_filters_config', 'GET', 'JSON')
    .then(function(data) {
 
        let html = '<div class="div-filters">';
 
        data.forEach(function(filtro) {
            const col = filtro.db_column;
 
            if (filtro.html_type === 'select') {
                html += `<select class="filter_select dynamic-select" id="select_${col}">
                            <option value="">${filtro.display_name}</option>`;
                filtro.valores.forEach(function(v) {
                    html += `<option value="${v}">${v}</option>`;
                });
                html += `</select>`;
 
            } else if (filtro.html_type === 'radio') {
                html += `<div class="filter-radio-group">
                            <span class="filter-group-label">${filtro.display_name}</span>`;
                filtro.valores.forEach(function(v) {
                    html += `<label class="filter-radio-label">
                                <input type="radio" name="${col}" value="${v}">
                                <span>${v}</span>
                             </label>`;
                });
                html += `</div>`;
 
            } else if (filtro.html_type === 'check') {
                html += `<div class="filter-check-group">
                            <span class="filter-group-label">${filtro.display_name}</span>`;
                filtro.valores.forEach(function(v) {
                    html += `<label class="filter-check-label">
                                <input type="checkbox" name="${col}" value="${v}" class="filter-checkbox">
                                <span>${v}</span>
                             </label>`;
                });
                html += `</div>`;
 
            } else if (filtro.html_type === 'slider') {
                const min = filtro.valores.min;
                const max = filtro.valores.max;
                html += `<div class="filter-slider-group">
                            <span class="filter-group-label">${filtro.display_name}</span>
                            <span id="price-display" class="filter-price-display">${min}€ - ${max}€</span>
                            <div id="slider-range"
                                 data-column="${col}"
                                 data-min="${min}"
                                 data-max="${max}"
                                 class="filter-slider-track">
                            </div>
                         </div>`;
            }
        });
 
        html += `
            <button class="btn-primary" id="btn-filter">
                <span class="material-symbols-outlined">filter_list</span>
                Filtrar
                <span id="filter-badge" class="filter-badge" style="display:none;"></span>
            </button>
            <button class="btn-volver" id="btn-remove-filter">
                <span class="material-symbols-outlined">close</span>
                Limpiar
            </button>
        </div>`;
 
        $('.filters').html(html);
 
        // Inicializar slider jQuery UI
        if ($('#slider-range').length > 0) {
            const minVal = parseInt($('#slider-range').attr('data-min'));
            const maxVal = parseInt($('#slider-range').attr('data-max'));
 
            $('#slider-range').slider({
                range: true,
                min: minVal,
                max: maxVal,
                values: [minVal, maxVal],
                slide: function(event, ui) {
                    $('#price-display').text(ui.values[0] + '€ - ' + ui.values[1] + '€');
                },
                stop: function() {
                    // Auto-aplicar al soltar el slider
                    applyFilters();
                }
            });
        }
 
        highlightFilters();
        updateFilterBadge();
 
    }).catch(function(err) {
        console.error('Error cargando filtros:', err);
    });
}
 
function highlightFilters() {
    var filtros = JSON.parse(localStorage.getItem('filter'));
    if (!filtros) return;
 
    filtros.forEach(function(item) {
        const columna = item[0];
        const valor   = item[1];
 
        if ($('#select_' + columna).length > 0) {
            $('#select_' + columna).val(valor);
        }
 
        const inputs = $('input[name="' + columna + '"]');
        if (inputs.length > 0) {
            if (Array.isArray(valor)) {
                valor.forEach(function(v) {
                    $('input[name="' + columna + '"][value="' + v + '"]').prop('checked', true);
                });
            } else {
                $('input[name="' + columna + '"][value="' + valor + '"]').prop('checked', true);
            }
        }
 
        if (columna === 'precio' && $('#slider-range').hasClass('ui-slider')) {
            $('#slider-range').slider('values', [valor[0], valor[1]]);
            $('#price-display').text(valor[0] + '€ - ' + valor[1] + '€');
        }
    });
}
 
// ── LÓGICA DE FILTROS ─────────────────────────────────────────────────────────
 
/**
 * Recoge el estado actual de todos los controles de filtro y devuelve el array de filtros.
 * No toca localStorage, solo lee el DOM.
 */
function collectFilters() {
    var filtro = [];
 
    $('.dynamic-select').each(function() {
        const val = $(this).val();
        if (val && val !== '') {
            const col = $(this).attr('id').replace('select_', '');
            filtro.push([col, val]);
        }
    });
 
    $('input[type="radio"]:checked').each(function() {
        filtro.push([$(this).attr('name'), $(this).val()]);
    });
 
    const checks = {};
    $('input[type="checkbox"]:checked').each(function() {
        const col = $(this).attr('name');
        if (!checks[col]) checks[col] = [];
        checks[col].push($(this).val());
    });
    for (let col in checks) {
        filtro.push([col, checks[col]]);
    }
 
    if ($('#slider-range').length > 0 && $('#slider-range').hasClass('ui-slider')) {
        const values  = $('#slider-range').slider('values');
        const col     = $('#slider-range').attr('data-column');
        const minVal  = parseInt($('#slider-range').attr('data-min'));
        const maxVal  = parseInt($('#slider-range').attr('data-max'));
        // Solo añadir el slider si el usuario lo ha movido de su posición por defecto
        if (values[0] !== minVal || values[1] !== maxVal) {
            filtro.push([col, values]);
        }
    }
 
    return filtro;
}
 
/**
 * Calcula cuántos filtros hay activos y actualiza el badge del botón.
 */
function updateFilterBadge() {
    const filtro = collectFilters();
    const $badge = $('#filter-badge');
 
    if (filtro.length > 0) {
        $badge.text(filtro.length).show();
    } else {
        $badge.hide();
    }
}
 
/**
 * Recoge los filtros, guarda en localStorage, lanza la búsqueda y actualiza el badge.
 */
function applyFilters() {
    const filtro = collectFilters();
 
    if (filtro.length > 0) {
        localStorage.setItem('filter', JSON.stringify(filtro));
    } else {
        localStorage.removeItem('filter');
    }
 
    updateFilterBadge();
    ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event', filtro);
}

function destroyMapDetail() {
    if (leafletMapDetail) {
        leafletMapDetail.remove();
        leafletMapDetail = null;
    }
}
 
// ── CLICKS ────────────────────────────────────────────────────────────────────
 
function clicks() {
    $(document).on('click', '.btn-tickets', function() {
        var id = this.getAttribute('id');
        if (id) loadDetails(id);
    });
 
    $(document).on('click', '#btn-volver', function() {
    if ($('.date_img').hasClass('slick-initialized')) {
        $('.date_img').slick('unslick');
    }
    destroyMapDetail();
    $('#details-shop').empty();
    $('#seccion-detalle').hide();
    $('#seccion-lista').show();
});
 
    // Botón Filtrar: sigue funcionando de forma manual
    $(document).on('click', '#btn-filter', function() {
        applyFilters();
    });
 
    // Limpiar filtros
    $(document).on('click', '#btn-remove-filter', function() {
        localStorage.removeItem('filter');
        $('.dynamic-select').prop('selectedIndex', 0);
        $('input[type="radio"]').prop('checked', false);
        $('input[type="checkbox"]').prop('checked', false);
        if ($('#slider-range').hasClass('ui-slider')) {
            const min = parseInt($('#slider-range').attr('data-min'));
            const max = parseInt($('#slider-range').attr('data-max'));
            $('#slider-range').slider('values', [min, max]);
            $('#price-display').text(min + '€ - ' + max + '€');
        }
        updateFilterBadge();
        ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event', []);
    });
 
    // ── Auto-aplicar al cambiar cualquier control ─────────────────────────────
 
    // Select
    $(document).on('change', '.dynamic-select', function() {
        applyFilters();
    });
 
    // Radio buttons
    $(document).on('change', 'input[type="radio"]', function() {
        applyFilters();
    });
 
    // Checkboxes
    $(document).on('change', 'input[type="checkbox"].filter-checkbox', function() {
        applyFilters();
    });
 
    // El slider usa el evento "stop" registrado dentro de print_filters()
    // para auto-aplicar al soltar el handle.
}
 
// ── LOAD DETAILS ──────────────────────────────────────────────────────────────
 
function loadDetails(id) {
    ajaxPromise('module/shop/controller/controller_shop.php?op=details_event&id=' + id, 'GET', 'JSON')
    .then(function(data) {
        $('#details-shop').empty();
 
        const p = data[0];
        const f = p.fecha_partido.split('-');
        const mes = MESES[parseInt(f[1]) - 1];
 
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
                            <div class="partido-detail-item">
                                <span class="material-symbols-outlined">sell</span>
                                <span>${p.precio}€</span>
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
 
        for (let row in data[1]) {
            $('<div></div>').attr({ 'class': 'date_img_dentro' }).appendTo('.date_img')
                .html(`<img src="${data[1][row].img}" alt="${p.nombre_partido}"/>`);
        }
 
        $('#seccion-lista').hide();
        $('#seccion-detalle').show();
        leafletMap_single(data[0]);
 
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
    print_filters();
    loadEvent();
    clicks();
});
