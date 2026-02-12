<?php
session_start();

// Recuperar errores de la sesión
$event_nameERR = $_SESSION['errors']['event_nameERR'] ?? "";
$event_descriptionERR = $_SESSION['errors']['event_descriptionERR'] ?? "";
$event_organitationERR = $_SESSION['errors']['event_organitationERR'] ?? "";
$event_dateERR = $_SESSION['errors']['event_dateERR'] ?? "";
$event_hourERR = $_SESSION['errors']['event_hourERR'] ?? "";
$event_placeERR = $_SESSION['errors']['event_placeERR'] ?? "";
$event_cityERR = $_SESSION['errors']['event_cityERR'] ?? "";
$event_durationERR = $_SESSION['errors']['event_durationERR'] ?? "";
$event_capacityERR = $_SESSION['errors']['event_capacityERR'] ?? "";
$event_priceERR = $_SESSION['errors']['event_priceERR'] ?? "";
$event_ticketsERR = $_SESSION['errors']['event_ticketsERR'] ?? "";
$event_servicesERR = $_SESSION['errors']['event_servicesERR'] ?? "";
$event_localERR = $_SESSION['errors']['event_localERR'] ?? "";
$event_visitorERR = $_SESSION['errors']['event_visitorERR'] ?? "";
$event_ticket_typeERR = $_SESSION['errors']['event_ticket_typeERR'] ?? "";
$event_typeERR = $_SESSION['errors']['event_typeERR'] ?? "";
$event_stateERR = $_SESSION['errors']['event_stateERR'] ?? "";

// Recuperar valores
$event_name = $_SESSION['values']['event_name'] ?? "";
$event_description = $_SESSION['values']['event_description'] ?? "";
$event_organitation = $_SESSION['values']['event_organitation'] ?? "";
$event_date = $_SESSION['values']['event_date'] ?? "";
$event_hour = $_SESSION['values']['event_hour'] ?? "";
$event_place = $_SESSION['values']['event_place'] ?? "";
$event_city = $_SESSION['values']['event_city'] ?? "";
$event_duration = $_SESSION['values']['event_duration'] ?? "";
$event_capacity = $_SESSION['values']['event_capacity'] ?? "";
$event_price = $_SESSION['values']['event_price'] ?? "";
$event_tickets = $_SESSION['values']['event_tickets'] ?? "";
$event_services = $_SESSION['values']['event_services'] ?? [];
$event_local = $_SESSION['values']['event_local'] ?? "";
$event_visitor = $_SESSION['values']['event_visitor'] ?? "";
$event_ticket_type = $_SESSION['values']['event_ticket_type'] ?? [];
$event_type = $_SESSION['values']['event_type'] ?? "";
$event_state = $_SESSION['values']['event_state'] ?? "";

// Limpiar sesión
unset($_SESSION['errors']);
unset($_SESSION['values']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
      <link rel="stylesheet" href="style.css">
    <title>GolTickets</title>
</head>
<body>


<form method="post" action="form_validation.php" id="form">  

    <h2>Crear Evento</h2>
    <label class="error">* Campos obligatorios</label>

    <label>Nombre del evento:</label>
    <input type="text" name="event_name" value="<?php echo $event_name; ?>">
    <span class="error">* <?php echo $event_nameERR; ?></span>

    <label>Descripción del evento:</label>
    <textarea name="event_description" rows="3"><?php echo $event_description; ?></textarea>
    <span class="error">* <?php echo $event_descriptionERR; ?></span>

    <label>Organización del evento:</label>
    <input type="text" name="event_organitation" value="<?php echo $event_organitation; ?>">
    <span class="error">* <?php echo $event_organitationERR; ?></span>

    <label>Fecha del evento: (DD/MM/AAAA)</label>
    <input type="text" id="event_date" name="event_date" value="<?php echo $event_date; ?>">
    <span class="error">* <?php echo $event_dateERR; ?></span>

    <label>Hora del evento:</label>
    <input type="text" id="event_hour" name="event_hour" value="<?php echo $event_hour; ?>">
    <span class="error">* <?php echo $event_hourERR; ?></span>

    <label>Lugar del evento:</label>
    <input type="text" name="event_place" value="<?php echo $event_place; ?>">
    <span class="error">* <?php echo $event_placeERR; ?></span>

    <label>Ciudad del evento:</label>
    <input type="text" name="event_city" value="<?php echo $event_city; ?>">
    <span class="error">* <?php echo $event_cityERR; ?></span>

    <label>Duración del evento (minutos):</label>
    <input type="text" name="event_duration" value="<?php echo $event_duration; ?>">
    <span class="error">* <?php echo $event_durationERR; ?></span>

    <label>Capacidad del evento:</label>
    <input type="text" name="event_capacity" value="<?php echo $event_capacity; ?>">
    <span class="error">* <?php echo $event_capacityERR; ?></span>

    <label>Precio del evento (€):</label>
    <input type="text" step="0.01" name="event_price" value="<?php echo $event_price; ?>">
    <span class="error">* <?php echo $event_priceERR; ?></span>

    <label>Entradas disponibles:</label>
    <input type="text" name="event_tickets" value="<?php echo $event_tickets; ?>">
    <span class="error">* <?php echo $event_ticketsERR; ?></span>

    <label>Servicios disponibles:</label>
    <div class="checkbox-group">
        <label>
            <input type="checkbox" name="event_services[]" value="parking"
                <?php if (is_array($event_services) && in_array("parking", $event_services)) echo "checked"; ?>>
            Parking
        </label>

        <label>
            <input type="checkbox" name="event_services[]" value="taquillas"
                <?php if (is_array($event_services) && in_array("taquillas", $event_services)) echo "checked"; ?>>
            Taquillas
        </label>

        <label>
            <input type="checkbox" name="event_services[]" value="acceso a tienda de merchandising"
                <?php if (is_array($event_services) && in_array("acceso a tienda de merchandising", $event_services)) echo "checked"; ?>>
            Acceso a tienda de merchandising
        </label>
    </div>
    <span class="error">* <?php echo $event_servicesERR; ?></span>

    <label>Equipo local:</label>
    <input type="text" name="event_local" value="<?php echo $event_local; ?>">
    <span class="error">* <?php echo $event_localERR; ?></span>

    <label>Equipo visitante:</label>
    <input type="text" name="event_visitor" value="<?php echo $event_visitor; ?>">
    <span class="error">* <?php echo $event_visitorERR; ?></span>

    <label>Tipos de entrada:</label>
    <div class="checkbox-group">
        <?php
        $ticket_types = ["general", "vip", "premium", "palco", "grada"];
        foreach ($ticket_types as $type) {
            $checked = (is_array($event_ticket_type) && in_array($type, $event_ticket_type)) ? "checked" : "";
            echo "<label><input type='checkbox' name='event_ticket_type[]' value='$type' $checked> ".ucfirst($type)."</label>";
        }
        ?>
    </div>
    <span class="error">* <?php echo $event_ticket_typeERR; ?></span>

      <label>Tipo de partido:</label>
  <div class="radio-group">
      <label><input type="radio" name="event_type" value="laliga" 
          <?php if($event_type=="laliga") echo "checked"; ?>> LaLiga</label>

      <label><input type="radio" name="event_type" value="laliga2" 
          <?php if($event_type=="laliga2") echo "checked"; ?>> LaLiga 2</label>

      <label><input type="radio" name="event_type" value="copa_del_rey" 
          <?php if($event_type=="copa_del_rey") echo "checked"; ?>> Copa del Rey</label>

      <label><input type="radio" name="event_type" value="champions_league" 
          <?php if($event_type=="champions_league") echo "checked"; ?>> Champions League</label>
  </div>
  <span class="error">* <?php echo $event_typeERR;?></span>

  <label>Estado del evento:</label>
  <div class="radio-group">
      <label><input type="radio" name="event_state" value="programado" 
          <?php if($event_state=="programado") echo "checked"; ?>> Programado</label>

      <label><input type="radio" name="event_state" value="en_venta" 
          <?php if($event_state=="en_venta") echo "checked"; ?>> En venta</label>

      <label><input type="radio" name="event_state" value="agotado" 
          <?php if($event_state=="agotado") echo "checked"; ?>> Agotado</label>

      <label><input type="radio" name="event_state" value="cancelado" 
          <?php if($event_state=="cancelado") echo "checked"; ?>> Cancelado</label>

      <label><input type="radio" name="event_state" value="finalizado" 
          <?php if($event_state=="finalizado") echo "checked"; ?>> Finalizado</label>
  </div>
  <span class="error">* <?php echo $event_stateERR;?></span>

    <br><br>
    <input class="submit" type="submit" name="submit" value="Crear Evento">

</form>

      <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery UI -->
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <!-- Timepicker Addon -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
  <!-- JS -->
  <script src="datepicker.js"></script>

</body>
</html>