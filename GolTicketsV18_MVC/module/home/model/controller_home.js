function loadCarousel() {
    ajaxPromise('module/home/controller/controller_home.php?op=homePageCarousel', 'GET', 'JSON')
    .then(function(data) {
        for (let row = 0; row < data.length; row++) {
        $('<div></div>')
            .addClass('swiper-slide partido-slide')
            .appendTo('#containerCarousel')
            .html(`
            <div class="partido-slide-inner" style="background-image: url('${data[row].img_campo}'); cursor:pointer;"data-id="${data[row].id_partido}"attr-id="${data[row].id_partido}">
                <div class="partido-slide-overlay"></div>
                <div class="partido-slide-info">
                <span class="partido-slide-name">${data[row].nombre_partido}</span>
                <div class="partido-slide-meta">
                    <span>${data[row].fecha_partido}</span>
                    <span class="separador">·</span>
                    <span>${data[row].nombre_competicion}</span>
                </div>
                </div>
            </div>
            `);
        }


        new Swiper('.swiper-partidos', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: { delay: 3000, pauseOnMouseEnter: true, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination-partidos', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
        
    });
}

function loadCategories() {
    ajaxPromise('module/home/controller/controller_home.php?op=homePageCategory', 'GET', 'JSON')
    .then(function(data) {
        for (let row = 0; row < data.length; row++) {
            $('<div></div>')
                .addClass('category-card')
                .attr('id', `cat_${row}`)
                .appendTo('#containerCategories')
                .html(`
                <div class="category-icon">
                    <img class="logo-icon" src="${data[row].img_competicion}">
                </div>
                <span>${data[row].nombre_competicion}</span>
                `);
}

        // Sin Swiper aquí
    });
}

function loadCities() {
    ajaxPromise('module/home/controller/controller_home.php?op=homePageCities', 'GET', 'JSON')
    .then(function(data) {
        for (let row = 0; row < data.length; row++) {
            $('<div></div>')
                .addClass('swiper-slide')
                .attr('id', `cit_${row}`)
                .appendTo('#containerCities')
                .html(`
                <div class="category-card city-card" 
                    style="background-image:url('${data[row].img_ciudad}');
                            background-size:cover;
                            background-position:center;">
                    <span class="city-name">${data[row].nombre_ciudad}</span>
                </div>
                `);
            }


        new Swiper('.swiper-cities', {
            slidesPerView: 4,
            spaceBetween: 16,
            loop: true,                    // vuelve al inicio al llegar al final
            navigation: { nextEl: '#next-cit', prevEl: '#prev-cit' },
            grabCursor: true,
        });
    });
}

function loadTeams() {
    ajaxPromise('module/home/controller/controller_home.php?op=homePageTeams', 'GET', 'JSON')
    .then(function(data) {
        for (let row = 0; row < data.length; row++) {
            $('<div></div>')
                .addClass('swiper-slide')
                .attr('id', `tea_${row}`)
                .appendTo('#containerTeams')
                .html(`
                <div class="category-card">
                    <div class="category-icon">
                    <img class="logo-icon" src="${data[row].img_equipo}">
                    </div>
                    <span>${data[row].nombre_equipo}</span>
                </div>
                `);
            }


        new Swiper('.swiper-teams', {
            slidesPerView: 4,
            spaceBetween: 16,
            loop: true,
            navigation: { nextEl: '#next-tea', prevEl: '#prev-tea' },
            grabCursor: true,
        });
    });
}

function clicks() {

  // Clic en tarjeta de Competición → filtrar shop por nombre_competicion
  $(document).on('click', '.category-card', function () {
    const nombre = $(this).find('span').text().trim();
    if (!nombre) return;

    const filter = [['co.nombre_competicion', nombre]];
    localStorage.setItem('filter', JSON.stringify(filter));
    window.location.href = 'index.php?page=controller_shop&op=view';
  });

  // Clic en tarjeta de Ciudad → filtrar shop por nombre_ciudad
  $(document).on('click', '.city-card', function () {
    const nombre = $(this).find('.city-name').text().trim();
    if (!nombre) return;

    const filter = [['ci.nombre_ciudad', nombre]];
    localStorage.setItem('filter', JSON.stringify(filter));
    window.location.href = 'index.php?page=controller_shop&op=view';
  });

  // Clic en tarjeta de Equipo → filtrar shop por nombre_equipo
  $(document).on('click', '.swiper-teams .category-card', function () {
    const nombre = $(this).find('span').text().trim();
    if (!nombre) return;

    const filter = [['nombre_equipo', nombre]];
    localStorage.setItem('filter', JSON.stringify(filter));
    window.location.href = 'index.php?page=controller_shop&op=view';
  });

    $(document).on('click', '.partido-slide-inner', function () {
        const id = $(this).attr('attr-id') || $(this).data('id');
            if (!id) return;
        window.location.href = 'index.php?page=controller_shop&op=view&detalle=' + id;
    });
}

$(document).ready(function () {
    //console.log('controller_home.js loaded');

    loadCarousel();

    //console.log('1. Document ready');
    
    loadCategories();
    
    //console.log('2. Después de loadCategories');
    
    loadCities();
    
    //console.log('3. Después de loadCities');
    
    loadTeams();
    
    //console.log('4. Después de loadTeams');

    clicks();
});
