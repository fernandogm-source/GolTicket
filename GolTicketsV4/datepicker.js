$(function () {
    $.datepicker.setDefaults({
    closeText: "Cerrar",
    prevText: "< Ant",
    nextText: "Sig >",
    currentText: "Hoy",
    monthNames: [
      "Enero","Febrero","Marzo","Abril","Mayo","Junio",
      "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
    ],
    monthNamesShort: [
      "Ene","Feb","Mar","Abr","May","Jun",
      "Jul","Ago","Sep","Oct","Nov","Dic"
    ],
    dayNames: [
      "Domingo","Lunes","Martes","Miércoles",
      "Jueves","Viernes","Sábado"
    ],
    dayNamesShort: ["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],
    dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
    dateFormat: "dd/mm/yy",
    firstDay: 1
  });
  
  // Datepicker
  $("#event_date").datepicker({
    dateFormat: "dd/mm/yy",
    minDate: 1
  });

  // Timepicker
  $("#event_hour").timepicker({
    timeFormat: "HH:mm",
    stepMinute: 15,
    //hourMin: 9,
   //hourMax: 18,
    controlType: "select"
  });

  // Validación antes de enviar
  $("#formGol").on("submit", function (e) {
   
     
    let hayErrores = false;
    $(".error").removeClass("error");
    $(".error-text").text("");

     

    const event_name = $("#event_name").val().trim();
    const event_description = $("#event_description").val().trim();
    const event_organization = $("#event_organization").val().trim();
    const event_date = $("#event_date").val().trim();
    const event_hour = $("#event_hour").val().trim();
    const event_place = $("#event_place").val().trim();
    const event_city = $("#event_city").val().trim();
    const event_duration = $("#event_duration").val().trim();
    const event_capacity = $("#event_capacity").val().trim();
    const event_price = $("#event_price").val().trim();
    const event_disponibility = $("#event_disponibility").val().trim();
    const event_local = $("#event_local").val().trim();
    const event_visitor = $("#event_visitor").val().trim();
    const state = $("input[name='selected_state']:checked").val();
    const type = $("input[name='selected_type']:checked").val();
    const tickets = $("input[name='selected_tickets[]']:checked").length;
    const services = $("input[name='selected_services[]']:checked").length;


    const ahora = new Date();

    // NOMBRE
      if (!event_name) {
        
        $("#event_name").addClass("error");
        $("#error-event_name").text("❌ El nombre es obligatorio JS.");
        hayErrores = true;
      }

    // DESCRIPCION
    if (!event_description) {
      $("#event_description").addClass("error");
      $("#error-event_description").text("❌ La descripción es obligatoria.");
      hayErrores = true;
    }

    // ORGANIZACION
    if (!event_organization) {
      $("#event_organization").addClass("error");
      $("#error-event_organization").text("❌ La organización es obligatoria.");
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

    // CIUDAD
    if (!event_city) {
      $("#event_city").addClass("error");
      $("#error-event_city").text("❌ La ciudad es obligatoria.");
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

    // EQUIPO VISITANTE
    if (!event_visitor) {
      $("#event_visitor").addClass("error");
      $("#error-event_visitor").text("❌ El equipo visitante es obligatorio.");
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

    if (hayErrores) {
      e.preventDefault(); // bloquea submit si hay errores
    }
  });

});