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
  $("#form").on("submit", function (e) {
    const fechaStr = $("#event_date").val();
    const horaStr = $("#event_hour").val();
    if (!fechaStr || !horaStr) return;

    const [d, m, y] = fechaStr.split("/");
    const [hh, mm] = horaStr.split(":");

    const fechaSeleccionada = new Date(y, m - 1, d, hh, mm);
    const ahora = new Date();
  });

});