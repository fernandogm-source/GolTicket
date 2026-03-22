const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
 
function loadEvent() {
    ajaxForSearch('module/shop/controller/controller_shop.php?op=all_event');
}
 
function ajaxForSearch(url) {
    ajaxPromise(url, 'POST', 'JSON')
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
 
                    $('<div></div>').attr({ 'id': p.id_partido, 'class': 'partido-card' }).appendTo('#containerPartidos')
                        .html(`
                            <div class="partido-card-img" style="background-image: url('${p.img_campo}')"></div>
                            <div class="partido-fecha">
                                <span class="partido-fecha-dia">${f[0]}</span>
                                <span class="partido-fecha-mes">${mes}</span>
                                <span class="partido-fecha-anyo">${f[2]}</span>
                            </div>
                            <p class="partido-nombre">${p.nombre_partido}</p>
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
                        `);
                }
            }
        }).catch(function() {
            // window.location.href = "index.php?module=ctrl_exceptions&op=503&type=503&lugar=Function ajxForSearch SHOP";
        });
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
        $('.date_img').empty();
        $('.date_event').empty();
        $('#seccion-detalle').hide();
        $('#seccion-lista').show();
    });
}
 
function loadDetails(id) {
    ajaxPromise('module/shop/controller/controller_shop.php?op=details_event&id=' + id, 'GET', 'JSON')
    .then(function(data) {
        $('.date_img').empty();
        $('.date_event').empty();
 
        const p = data[0];
        const f = p.fecha_partido.split('-');
        const mes = MESES[parseInt(f[1]) - 1];
 
        // Imágenes para el carrusel
        for (let row in data[1]) {
            $('<div></div>').attr({ 'class': 'date_img_dentro' }).appendTo('.date_img')
                .html(`<img src="${data[1][row].img}" alt="${p.nombre_partido}"/>`);
        }
 
        // Detalle del partido
        $('<div></div>').attr({ 'id': p.id_partido, 'class': 'date_event_dentro' }).appendTo('.date_event')
            .html(`
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
            `);
 
        // Mostrar sección detalle ANTES de inicializar slick
        $('#seccion-lista').hide();
        $('#seccion-detalle').show();
 
        // Slick slider — se inicializa después del show() para que calcule bien el ancho
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
 
$(document).ready(function() {
    loadEvent();
    clicks();
});