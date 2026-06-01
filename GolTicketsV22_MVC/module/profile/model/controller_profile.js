const MESES = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];

function switchTab(tabId) {
  const views = ['personal', 'liked'];
  const btns  = ['personal', 'security', 'payment', 'tickets', 'liked'];

  // Ocultar todas las vistas existentes
  views.forEach(v => {
    const el = document.getElementById(`view-${v}`);
    if (el) el.classList.add('hidden');
  });

  // Quitar activo de todos los botones
  btns.forEach(b => {
    const el = document.getElementById(`btn-${b}`);
    if (el) el.classList.remove('active');
  });

  // Mostrar vista si existe, si no fallback a personal
  const activeView = document.getElementById(`view-${tabId}`);
  if (activeView) {
    activeView.classList.remove('hidden');
  } else {
    document.getElementById('view-personal').classList.remove('hidden');
    tabId = 'personal';
  }

  // Activar botón
  const activeBtn = document.getElementById(`btn-${tabId}`);
  if (activeBtn) activeBtn.classList.add('active');
}

function updateProfile() {
    if (validate_updateProfile()) {
        var data = $('#form-profile').serialize();

        ajaxPromise('index.php?page=controller_profile&op=register', 'POST', 'JSON', data)
            .then(function(result) {
                console.log(result);
            }).catch(function(textStatus) {
                if (console && console.log) {
                    console.log("La solicitud ha fallado: " + textStatus);
                }
            });
    }
}

function validate_updateProfile() {
    var username_exp = /^(?=.{5,}$)(?=.*[a-zA-Z0-9]).*$/;
    var passwd_exp = /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/;
    var error = false;

    var username = document.getElementById('reg-username').value;
    var password = document.getElementById('reg-password').value;
    var msgBox   = document.getElementById('msg-register');


    msgBox.innerHTML = "";
    msgBox.className = "auth-msg";

    // Username
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

    // Password
    if (!error) {
        if (password.length === 0) {
            msgBox.innerHTML = "Tienes que escribir la contraseña";
            msgBox.className = "auth-msg auth-msg--error";
            error = true;
        } else if (password.length < 8) {
            msgBox.innerHTML = "La contraseña tiene que tener 8 caracteres como mínimo";
            msgBox.className = "auth-msg auth-msg--error";
            error = true;
        } else if (!passwd_exp.test(password)) {
            msgBox.innerHTML = "Debe contener mínimo 8 caracteres, mayúsculas, minúsculas y símbolos especiales";
            msgBox.className = "auth-msg auth-msg--error";
            error = true;
        }
    }

    if (error) return false;
    return true;
}