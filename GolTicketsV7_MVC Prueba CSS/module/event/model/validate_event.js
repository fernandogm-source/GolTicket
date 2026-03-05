function validate(op) {
    let hayErrores = false;

    // Resetear clases y textos de error
    $(".error").removeClass("error");
    $(".error-text").text("");

    const event_name = $("#event_name").val() || "";
    const event_description = $("#event_description").val() || "";
    const event_organization = $("#event_organization").val() || "";
    const event_date = $("#event_date").val() || "";
    const event_hour = $("#event_hour").val() || "";
    const event_place = $("#event_place").val() || "";
    const event_city = $("#event_city").val() || "";
    const event_duration = $("#event_duration").val() || "";
    const event_capacity = $("#event_capacity").val() || "";
    const event_price = $("#event_price").val() || "";
    const event_disponibility = $("#event_disponibility").val() || "";
    const event_local = $("#event_local").val() || "";
    const event_visitor = $("#event_visitor").val() || "";
    const state = $("input[name='event_state']:checked").length;
    const type = $("input[name='event_competition']:checked").length;
    const tickets = $("input[name='ticket_type[]']:checked").length;
    const services = $("input[name='event_services[]']:checked").length;

    const ahora = new Date();


     // NOMBRE
      if (!event_name) {
        
        $("#event_name").addClass("error");
        $("#error-event_name").text("❌ El nombre es obligatorio JS.");
        hayErrores = true;
      }
      if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/.test(event_name)){
        $("#event_name").addClass("error");
        $("#error-event_name").text("❌ Solo se permiten letras y espacios.");
        hayErrores = true;
      }

    // DESCRIPCION
    if (!event_description) {
      $("#event_description").addClass("error");
      $("#error-event_description").text("❌ La descripción es obligatoria.");
      hayErrores = true;
    }
    if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/.test(event_description)){
      $("#event_description").addClass("error");
      $("#error-event_description").text("❌ Solo se permiten letras y espacios.");
      hayErrores = true;
    }

    // ORGANIZACION
    if (!event_organization) {
      $("#event_organization").addClass("error");
      $("#error-event_organization").text("❌ La organización es obligatoria.");
      hayErrores = true;
    }
    if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\d]*$/.test(event_organization)){
      $("#event_organization").addClass("error");
      $("#error-event_organization").text("❌ Solo se permiten letras y espacios.");
      hayErrores = true;
    }

    // FECHA
    if (!event_date) {
      $("#event_date").addClass("error");
      $("#error-event_date").text("❌ La fecha es obligatoria.");
      hayErrores = true;
    }

    // HORA
    if (!event_hour) {
      $("#event_hour").addClass("error");
      $("#error-event_hour").text("❌ La hora es obligatoria.");
      hayErrores = true;
    }

    // LUGAR
    if (!event_place) {
      $("#event_place").addClass("error");
      $("#error-event_place").text("❌ El lugar es obligatorio.");
      hayErrores = true;
    }
    if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/.test(event_place)){
      $("#event_place").addClass("error");
      $("#error-event_place").text("❌ Solo se permiten letras y espacios.");
      hayErrores = true;
    }

    // CIUDAD
    if (!event_city) {
      $("#event_city").addClass("error");
      $("#error-event_city").text("❌ La ciudad es obligatoria.");
      hayErrores = true;
    }
    if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]*$/.test(event_city)){
      $("#event_city").addClass("error");
      $("#error-event_city").text("❌ Solo se permiten letras y espacios.");
      hayErrores = true;
    }

    // DURACION
    if (!event_duration) {
      $("#event_duration").addClass("error");
      $("#error-event_duration").text("❌ La duración es obligatoria.");
      hayErrores = true;
    }

    // CAPACIDAD
    if (!event_capacity) {
      $("#event_capacity").addClass("error");
      $("#error-event_capacity").text("❌ La capacidad es obligatoria.");
      hayErrores = true;
    }

    // PRECIO
    if (!event_price) {
      $("#event_price").addClass("error");
      $("#error-event_price").text("❌ El precio es obligatorio.");
      hayErrores = true;
    }

    // DISPONIBILIDAD
    if (!event_disponibility) {
      $("#event_disponibility").addClass("error");
      $("#error-event_disponibility").text("❌ Las entradas disponibles son obligatorias.");
      hayErrores = true;
    }

    // EQUIPO LOCAL
    if (!event_local) {
      $("#event_local").addClass("error");
      $("#error-event_local").text("❌ El equipo local es obligatorio.");
      hayErrores = true;
    }
    if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\d]*$/.test(event_local)){
      $("#event_local").addClass("error");
      $("#error-event_local").text("❌ Solo se permiten letras y espacios y numeros.");
      hayErrores = true;
    }

    // EQUIPO VISITANTE
    if (!event_visitor) {
      $("#event_visitor").addClass("error");
      $("#error-event_visitor").text("❌ El equipo visitante es obligatorio.");
      hayErrores = true;
    }
    if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\d]*$/.test(event_visitor)){
      $("#event_visitor").addClass("error");
      $("#error-event_visitor").text("❌ Solo se permiten letras , espacios y numeros.");
      hayErrores = true;
    }

    // SERVICIOS
    if (services === 0) {
      $("#error-services").text("❌ Selecciona al menos un servicio.");
      hayErrores = true;
    }

    // TIPOS DE ENTRADA
    if (tickets === 0) {
      $("#error-tickets").text("❌ Selecciona al menos un tipo de entrada.");
      hayErrores = true;
    }

    // TIPO DE PARTIDO
    if (!type) {
      $("#error-type").text("❌ Selecciona un tipo de partido.");
      hayErrores = true;
    }

    // ESTADO DEL EVENTO
    if (!state) {
      $("#error-state").text("❌ Selecciona un estado.");
      hayErrores = true;
    }

     if (!hayErrores){
        if (op == 'create'){
            document.form_event.submit();
            document.form_event.action = "index.php?page=controller_event&op=create";
        }
        if (op == 'update'){
            document.form_event.submit();
            document.form_event.action = "index.php?page=controller_event&op=update&id=<?= htmlspecialchars($_GET['id'] ?? '')?>";
        }
    }

    if (op === 'delete'){
        document.delete_event.submit();
        document.delete_event.action = "index.php?page=controller_event&op=delete&id=<?= htmlspecialchars($_GET['id'] ?? '')?>";
    }
    if (op === 'delete_all'){
        document.delete_all_event.submit();
        document.delete_all_event.action = "index.php?page=controller_event&op=delete_all";
    }
    if (op === 'dummies'){
        document.dummies_event.submit();
        document.dummies_event.action = "index.php?page=controller_event&op=dummies";
    }
}