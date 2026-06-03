const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

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

  if (tabId === 'liked') {
      loadLikedEvents();
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

$(document).ready(function () {
    if (document.getElementById('reg-username') || $('.sidebar-username').length > 0) {
        loadUserProfile();
    }

    // EVENTO PARA LOS BOTONES DE EDICIÓN INDEPENDIENTES
    $(document).on('click', '.btn-inline-edit', function() {
        var button = $(this);
        var targetField = button.data('target'); // Sabe si es "username" o "password"
        var input = $('#reg-' + targetField);
        
        // Si el input está bloqueado, pasamos a MODO EDICIÓN
        if (input.prop('readonly')) {
            input.prop('readonly', false); // Permitimos escribir
            input.addClass('input-editing-mode'); // Estilo visual de edición
            input.focus(); // Colocamos el cursor automáticamente
            
            // Cambiamos el icono del botón por un Checkmark de guardar
            button.html('<span class="material-symbols-outlined">check</span>');
            button.addClass('btn-inline-save');
        } 
        // Si el input ya estaba editable, significa que el usuario pulsó el Check para GUARDAR
        else {
            // Validamos antes de enviar al servidor
            if (validate_single_field(targetField, input.val())) {
                
                var token = localStorage.getItem('token_JWT');
                // Serializamos solo el campo específico que estamos modificando junto con el token
                var data = 'token=' + token + '&' + input.attr('name') + '=' + encodeURIComponent(input.val());

                ajaxPromise('index.php?page=controller_profile&op=update_account', 'POST', 'JSON', data)
                    .then(function(result) {
                        var msgBox = document.getElementById('msg-register');
                        
                        if (result === "success") {
                            msgBox.innerHTML = "Campo " + targetField + " actualizado.";
                            msgBox.className = "auth-msg auth-msg--success";
                            
                            // Bloqueamos el input de nuevo
                            input.prop('readonly', true);
                            input.removeClass('input-editing-mode');
                            
                            // Restauramos el botón al icono original de lapicero
                            button.html('<span class="material-symbols-outlined">edit</span>');
                            button.removeClass('btn-inline-save');
                            
                            if(targetField === 'password') {
                                input.val(''); // Limpiamos visualmente el hash si fue contraseña
                            }
                            
                            // Recargamos datos de la interfaz (Navbar, Sidebars...)
                            loadUserProfile();
                        } else if (result === "no_changes") {
                            // Si guardó el mismo valor sin cambiar nada
                            input.prop('readonly', true);
                            input.removeClass('input-editing-mode');
                            button.html('<span class="material-symbols-outlined">edit</span>');
                            button.removeClass('btn-inline-save');
                        } else {
                            msgBox.innerHTML = "Error al actualizar el campo.";
                            msgBox.className = "auth-msg auth-msg--error";
                        }
                    }).catch(function(err) {
                        console.log("Error crítico en la actualización inline: ", err);
                    });
            }
        }
    });
});

// Función de validación enfocada por campos individuales
function validate_single_field(field, value) {
    var msgBox = document.getElementById('msg-register');
    msgBox.innerHTML = "";
    msgBox.className = "auth-msg";

    if (field === 'username') {
        var username_exp = /^[a-zA-Z0-9_]{5,20}$/;
        if (value.trim().length < 5) {
            msgBox.innerHTML = "El username debe tener al menos 5 caracteres.";
            msgBox.className = "auth-msg auth-msg--error";
            return false;
        }
        if (!username_exp.test(value)) {
            msgBox.innerHTML = "El usuario no admite caracteres especiales.";
            msgBox.className = "auth-msg auth-msg--error";
            return false;
        }
    }

    if (field === 'password') {
        var passwd_exp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}$/;
        if (value.length < 8) {
            msgBox.innerHTML = "La contraseña debe tener mínimo 8 caracteres.";
            msgBox.className = "auth-msg auth-msg--error";
            return false;
        }
        if (!passwd_exp.test(value)) {
            msgBox.innerHTML = "La contraseña requiere mayúsculas, minúsculas y un carácter especial.";
            msgBox.className = "auth-msg auth-msg--error";
            return false;
        }
    }
    return true;
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

function loadLikedEvents() {
    var token = localStorage.getItem('token_JWT');
    if (!token) {
        console.log("No se encontró ningún token JWT en localStorage");
        return;
    }

    ajaxPromise('module/profile/controller/controller_profile.php?op=get_liked_events', 'POST', 'JSON', { 'token': token })
        .then(function(data) {
            // Revisa qué imprime esto en la consola F12 para ver el mensaje de error real del servidor
            console.log("Datos recibidos del servidor:", data);

            var container = $('#containerLikedEvents');
            container.empty();

            // CORRECCIÓN: Validamos si viene un error de backend o si el objeto NO es un array
            if (!data || data.status === 'error' || !Array.isArray(data) || data.length === 0) {
                console.log("No se pueden procesar las cards (datos vacíos o estructura de error):", data.message || "Sin mensaje");
                container.append('<p class="no-likes-msg">No has dado "Me gusta" a ningún partido todavía o ha ocurrido un problema.</p>');
                return;
            }

            // Si pasa el filtro, ahora sí es un Array seguro y no lanzará 'data.forEach is not a function'
            data.forEach(function(p) {
                const f = p.fecha_partido.split('-');
                const mes = MESES[parseInt(f[1]) - 1]; 

                let slidesHTML = '';
                if (p.imgs_partido && p.imgs_partido.length > 0) {
                    p.imgs_partido.forEach(function(img) {
                        slidesHTML += `<div class="swiper-slide"><img src="${img}" alt="${p.nombre_partido}"/></div>`;
                    });
                } else {
                    slidesHTML = `<div class="swiper-slide"><img src="${p.img_campo}" alt="${p.nombre_partido}"/></div>`;
                }

                $('<div></div>').attr({ 'id': 'liked-' + p.id_partido, 'class': 'partido-card' }).appendTo(container)
                    .html(`
                        <div class="swiper partido-card-swiper" id="swiper-liked-${p.id_partido}">
                            <div class="swiper-wrapper">${slidesHTML}</div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <div class="partido-fecha">
                                <span class="partido-fecha-dia">${f[2]}</span>
                                <span class="partido-fecha-mes">${mes}</span>
                                <span class="partido-fecha-anyo">${f[0]}</span>
                            </div>
                            <div class="partido-precio-badge">${p.precio}€</div>
                        </div>
                        <div class="partido-card-body">
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
                            <div class="partido-card-footer">
                                <button class="btn-tickets" onclick="window.location.href='index.php?page=controller_shop&op=view&detalle=${p.id_partido}'">Ver entradas</button>
                            </div>
                        </div>
                    `);

                new Swiper(`#swiper-liked-${p.id_partido}`, {
                    speed: 500,
                    loop: p.imgs_partido && p.imgs_partido.length > 1,
                    slidesPerView: 1,
                    navigation: {
                        prevEl: `#swiper-liked-${p.id_partido} .swiper-button-prev`,
                        nextEl: `#swiper-liked-${p.id_partido} .swiper-button-next`,
                    }
                });
            });
        }).catch(function(err) {
            console.error("Error crítico en la promesa de eventos liked:", err);
        });
}