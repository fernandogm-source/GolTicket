function validate() {
    let hayErrores = false;

    // Resetear clases y textos de error
    $(".error").removeClass("error");
    $(".error-text").text("");

    const usuario = $("#usuario").val() || "";
    const pass = $("#pass").val() || "";
    const nombre = $("#nombre").val() || "";
    const dni = $("#DNI").val() || "";
    const fecha = $("#fecha").val() || "";
    const edad = $("#edad").val() || "";
    const pais = $("#pais").val() || "";
    const observaciones = $("#observaciones").val() || "";

    // Arrays para checkboxes y selects múltiples o radios
    const sexo = $("input[name='sexo']:checked").length;
    const idioma = $("#idioma\\[\\]").val() || [];
    const aficion = $("input[name='aficion[]']:checked").length;

    /* ===== USUARIO ===== */
    if (!usuario || !/^[a-zA-Z]*$/.test(usuario)) {
        $("#usuario").addClass("error");
        $("#error_usuario").text("❌ El usuario introducido no es válido");
        hayErrores = true;
    }

    /* ===== PASSWORD ===== */
    const passwordRegex = /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
    if (!pass || !passwordRegex.test(pass)) {
        $("#pass").addClass("error");
        $("#error_pass").text("❌ La contraseña introducida no es válida");
        hayErrores = true;
    }

    /* ===== NOMBRE ===== */
    if (!nombre || !/^[a-zA-Z]*$/.test(nombre)) {
        $("#nombre").addClass("error");
        $("#error_nombre").text("❌ El nombre introducido no es válido");
        hayErrores = true;
    }

    /* ===== DNI ===== */
    if (!dni || dni.length < 9) {
        $("#DNI").addClass("error");
        $("#error_DNI").text("❌ El DNI introducido no es válido");
        hayErrores = true;
    }

    /* ===== RADIO SEXO ===== */
    if (sexo === 0) {
        $("#error_sexo").text("❌ No has seleccionado ningún género");
        hayErrores = true;
    }

    /* ===== FECHA ===== */
    if (!fecha) {
        $("#fecha").addClass("error");
        $("#error_fecha_nacimiento").text("❌ No has introducido ninguna fecha");
        hayErrores = true;
    }

    /* ===== EDAD ===== */
    if (!edad || !/^[0-9]{1,2}$/.test(edad)) {
        $("#edad").addClass("error");
        $("#error_edad").text("❌ La edad introducida no es válida");
        hayErrores = true;
    }

    /* ===== PAIS ===== */
    if (!pais) {
        $("#pais").addClass("error");
        $("#error_pais").text("❌ No has seleccionado ningún país");
        hayErrores = true;
    }

    /* ===== SELECT IDIOMA ===== */
    if (idioma.length === 0 || (idioma.length === 1 && idioma[0] === "")) {
        $("#idioma\\[\\]").addClass("error");
        $("#error_idioma").text("❌ No has seleccionado ningún idioma");
        hayErrores = true;
    }

    /* ===== OBSERVACIONES ===== */
    if (!observaciones) {
        $("#observaciones").addClass("error");
        $("#error_observaciones").text("❌ El texto introducido no es válido");
        hayErrores = true;
    }

    /* ===== CHECKBOX AFICIÓN ===== */
    if (aficion === 0) {
        $("#error_aficion").text("❌ No has seleccionado ninguna afición");
        hayErrores = true;
    }

    return !hayErrores; // Retorna false impidiendo la subida si hayErrores es true
}