const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

// VARIABLES GLOBALES PARA LA PAGINACIÓN DE LIKES
let liked_limit = 3; // Número de partidos que se mostrarán por página
let liked_offset = 0;

function switchTab(tabId) {
  const tabs = ['personal', 'liked'];

  // Si nos pasan un tabId que no existe, forzamos un fallback a 'personal'
  if (!tabs.includes(tabId)) {
    tabId = 'personal';
  }

  tabs.forEach(t => {
    const view = document.getElementById(`view-${t}`);
    const btn = document.getElementById(`btn-${t}`);

    if (t === tabId) {
      if (view) view.classList.remove('hidden');
      if (btn) btn.classList.add('active');
    } else {
      if (view) view.classList.add('hidden');
      if (btn) btn.classList.remove('active');
    }
  });

  // SI SE SELECCIONA LA PESTAÑA "LIKED", REINICIAMOS EL OFFSET Y CARGAMOS SUS EVENTOS
  if (tabId === 'liked') {
    liked_offset = 0;
    load_likes_pagination();
  }
}

function updateProfile() {
    if (validate_updateProfile()) {
        var data = $('#form-profile').serialize();
        var msgBox = document.getElementById('msg-register');

        ajaxPromise('index.php?page=controller_profile&op=update_account', 'POST', 'JSON', data)
            .then(function(result) {
                if (result.status === "success") {
                    msgBox.innerHTML = result.message;
                    msgBox.className = "auth-msg auth-msg--success";
                    
                    $('.sidebar-username').text($('#reg-username').val());
                    $('.header-username').text($('#reg-username').val());
                } else {
                    msgBox.innerHTML = result.message;
                    msgBox.className = "auth-msg auth-msg--error";
                }
            }).catch(function(err) {
                console.log("Error en la petición: ", err);
            });
    }
}

function validate_updateProfile() {
    var error = false;
    var username = document.getElementById('reg-username').value;
    var username_exp = /^[a-zA-Z0-9_]{5,20}$/;
    var msgBox = document.getElementById('msg-register');

    msgBox.innerHTML = "";
    msgBox.className = "auth-msg";

    if (username.length === 0) {
        msgBox.innerHTML = "Tienes que escribir el usuario";
        msgBox.className = "auth-msg auth-msg--error";
        error = true;
    } else if (username.length < 5) {
        msgBox.innerHTML = "El username tiene que tener 5 caracteres como mínimo";
        msgBox.className = "auth-msg auth-msg--error";
        error = true;
    } else if (!username_exp.test(username)) {
        msgBox.innerHTML = "No se pueden poner caracteres especiales en el usuario";
        msgBox.className = "auth-msg auth-msg--error";
        error = true;
    }

    return !error;
}

function loadUserProfile() {
    var token = localStorage.getItem('token_JWT');

    if (!token) {
        console.log("No hay token en localStorage, redirigiendo a auth...");
        window.location.href = "index.php?page=controller_auth&op=view";
        return;
    }

    ajaxPromise('index.php?page=controller_profile&op=get_user_data', 'POST', 'JSON', { 'token': token })
        .then(function(result) {
            if (result == "error" || result == "error_token" || result == "error_user") {
                console.log("Error de autenticación en perfil, limpiando sesión...");
                localStorage.removeItem('token_JWT');
                window.location.href = "index.php?page=controller_auth&op=view";
            } else {
                if (document.getElementById('reg-username')) {
                    document.getElementById('reg-username').value = result.username;
                }
                if (document.getElementById('reg-email')) {
                    document.getElementById('reg-email').value = result.mail;
                }

                $('.sidebar-username').text(result.username);
                $('.header-username').text(result.username);

                if (result.avatar) {
                    $('.sidebar-avatar img').attr('src', result.avatar);
                    $('.profile-avatar img').attr('src', result.avatar);
                    $('.header-avatar img').attr('src', result.avatar);
                }
            }
        }).catch(function(textStatus) {
            console.log("La solicitud de perfil ha fallado: " + textStatus);
        });
}

// ==========================================
//  FUNCIONES NUEVAS PARA PAGINACIÓN DE LIKES
// ==========================================

function load_likes_pagination() {
    var token = localStorage.getItem('token_JWT');
    if (!token) {
        console.log("No se encontró el token JWT en LocalStorage.");
        return;
    }

    // Apuntamos correctamente a tu controller_profile
    ajaxPromise('index.php?page=controller_profile&op=count_likes_user', 'POST', 'JSON', { 'token': token })
        .then(function(data) {
            if (data && typeof data.contador !== 'undefined') {
                let total_likes = parseInt(data.contador);
                if (total_likes > 0) {
                    load_liked_events(token, total_likes);
                } else {
                    $('.matches-grid').html('<p class="text-dim">Aún no tienes partidos añadidos a tu lista de favoritos.</p>');
                    $('#liked-pagination').html('');
                }
            } else {
                $('.matches-grid').html('<p class="text-dim">Aún no tienes partidos añadidos a tu lista de favoritos.</p>');
                $('#liked-pagination').html('');
            }
        }).catch(function(err) {
            console.log("Error al procesar la petición de conteo:", err);
        });
}

function load_liked_events(token, total_likes) {
    var data = {
        'token': token,
        'limit': liked_limit,
        'offset': liked_offset
    };

    // Apuntamos correctamente a tu controller_profile
    ajaxPromise('index.php?page=controller_profile&op=load_likes_user_paginated', 'POST', 'JSON', data)
        .then(function(partidos) {
            if (partidos === 'error' || !partidos.length) {
                $('.matches-grid').html('<p class="text-dim">Error al cargar favoritos.</p>');
                return;
            }
            
            let html = '';
            partidos.forEach(function(p) {
                let img = (p.imgs_partido && p.imgs_partido.length > 0) ? p.imgs_partido[0] : 'view/img/default-match.jpg';
                
                // Formateador de Fechas
                let dateParts = p.fecha_partido.split("-");
                let monthIdx = parseInt(dateParts[1], 10) - 1;
                let monthName = MESES[monthIdx] || 'SET';
                let day = dateParts[2];

                html += `
                    <div class="match-card profile-match-card redirect-details" data-id="${p.id_partido}" id="match-${p.id_partido}" style="cursor: pointer;">
                        <div class="match-img-wrapper">
                            <img src="${img}" alt="${p.nombre_partido}">
                            <div class="match-date-badge">
                                <span class="match-date-day">${day}</span>
                                <span class="match-date-month">${monthName}</span>
                            </div>
                        </div>
                        <div class="match-info">
                            <span class="match-competicion">${p.nombre_competicion}</span>
                            <h4>${p.nombre_partido}</h4>
                            <p class="match-lugar">
                                <span class="material-symbols-outlined">location_on</span> 
                                ${p.nombre_campo}, ${p.nombre_ciudad}
                            </p>
                        </div>
                    </div>
                `;
            });
            
            $('.matches-grid').html(html);
            build_liked_pagination(total_likes);
        }).catch(function(err) {
            console.log("Error cargando eventos gustados:", err);
        });
}

function build_liked_pagination(total_likes) {
    let total_pages = Math.ceil(total_likes / liked_limit);
    let current_page = (liked_offset / liked_limit) + 1;
    
    // Cambiamos a la clase 'pagination' idéntica a tu modulo tienda para heredar sus estilos perfectos
    let html_pag = '<div class="pagination">';

    for (let i = 1; i <= total_pages; i++) {
        let active_class = (i === current_page) ? 'active' : '';
        html_pag += `<button class="page-btn ${active_class}" data-page="${i}">${i}</button>`;
    }
    html_pag += '</div>';

    $('#liked-pagination').html(html_pag);
}

// COLOQUEMOS LOS ESCUCHADORES DE EVENTOS
$(document).ready(function () {
    loadUserProfile();

    // 1. Cambiar de página en favoritos
    $(document).on('click', '#liked-pagination .page-btn', function() {
        let page = $(this).data('page');
        liked_offset = (page - 1) * liked_limit;
        
        var token = localStorage.getItem('token_JWT');
        if (token) {
            load_likes_pagination();
        }
    });

    // 2. Redirección al detalle del partido en la tienda al hacer click en la tarjeta
    $(document).on('click', '.redirect-details', function() {
        let id_partido = $(this).data('id');
        // Redirige pasándole el parámetro 'detalle' por URL como espera tu tienda
        window.location.href = "index.php?page=controller_shop&op=view&detalle=" + id_partido;
    });
});