
<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="style.css">  
</head>
<body>

<?php
// define variables and set to empty values
$event_name = $event_description = $event_organitation = $event_date = $event_hour = $event_release_date = $event_place = "";
$event_city = $event_duration = $event_capacity = $event_price = $event_tickets = $event_services = "";
$event_local = $event_visitor = $event_ticket_type = $event_type = $event_state = "";

$event_nameERR = $event_descriptionERR = $event_organitationERR = $event_dateERR = $event_hourERR = $event_release_dateERR = $event_placeERR = "";
$event_cityERR = $event_durationERR = $event_capacityERR = $event_priceERR = $event_ticketsERR = $event_servicesERR = "";
$event_localERR = $event_visitorERR = $event_ticket_typeERR = $event_typeERR = $event_stateERR = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["event_name"])) {
        $event_nameERR = "Name is required";
    } else {
        $event_name = test_input($_POST["event_name"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_name)) {
            $event_nameERR = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["event_description"])) {
        $event_descriptionERR = "Description is required";
    } else {
        $event_description = test_input($_POST["event_description"]);
    }

    if (empty($_POST["event_organitation"])) {
        $event_organitationERR = "Organitation is required";
    } else {
        $event_organitation = test_input($_POST["event_organitation"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_organitation)) {
            $event_organitationERR = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["event_date"])) {
        $event_dateERR = "Date is required";
    } else {
        $event_date = test_input($_POST["event_date"]);
        if (!preg_match("/^[[0-9]{4}[-][0-9]{2}[-][0-9]{2}]*$/",$event_date)) {
            $event_dateERR = "El formato que has utilizado no es correcto";
        }       
    }

    if (empty($_POST["event_hour"])) {
        $event_hourERR = "Hour is required";
    } else {
        $event_hour = test_input($_POST["event_hour"]);
    }

    if (empty($_POST["event_release_date"])) {
        $event_release_dateERR = "Release date is required";
    } else {
        $event_release_date = test_input($_POST["event_release_date"]);
    }

    if (empty($_POST["event_place"])) {
        $event_placeERR = "Place is required";
    } else {
        $event_place = test_input($_POST["event_place"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_organitation)) {
            $event_organitationERR = "Only letters and white space allowed";
        }        
    }

    if (empty($_POST["event_city"])) {
        $event_cityERR = "City is required";
    } else {
        $event_city = test_input($_POST["event_city"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_organitation)) {
            $event_organitationERR = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["event_duration"])) {
        $event_durationERR = "Duration is required";
    } else {
        $event_duration = test_input($_POST["event_duration"]);
    }

    if (empty($_POST["event_capacity"])) {
        $event_capacityERR = "Capacity is required";
    } else {
        $event_capacity = test_input($_POST["event_capacity"]);
    }

    if (empty($_POST["event_price"])) {
        $event_priceERR = "Price is required";
    } else {
        $event_price = test_input($_POST["event_price"]);
    }

    if (empty($_POST["event_tickets"])) {
        $event_ticketsERR = "Tickets are required";
    } else {
        $event_tickets = test_input($_POST["event_tickets"]);
    }

    if (empty($_POST["event_services"])) {
        $event_servicesERR = "Select at least one service";
    } else {
        $event_services = $_POST["event_services"];
    }

    if (empty($_POST["event_local"])) {
        $event_localERR = "Local team is required";
    } else {
        $event_local = test_input($_POST["event_local"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_organitation)) {
            $event_organitationERR = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["event_visitor"])) {
        $event_visitorERR = "Visitor team is required";
    } else {
        $event_visitor = test_input($_POST["event_visitor"]);
    }

    if (empty($_POST["event_ticket_type"])) {
        $event_ticket_typeERR = "Select at least one ticket type";
    } else {
        $event_ticket_type = $_POST["event_ticket_type"];
    }

    if (empty($_POST["event_type"])) {
        $event_typeERR = "Select event type";
    } else {
        $event_type = test_input($_POST["event_type"]);
    }

    if (empty($_POST["event_state"])) {
        $event_stateERR = "Select event state";
    } else {
        $event_state = test_input($_POST["event_state"]);
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

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

    <label>Fecha del evento: (YYYY-MM-DD)</label>
    <input type="text" name="event_date" value="<?php echo $event_date; ?>">
    <span class="error">* <?php echo $event_dateERR; ?></span>

    <label>Hora del evento:</label>
    <input type="text" name="event_hour" value="<?php echo $event_hour; ?>">
    <span class="error">* <?php echo $event_hourERR; ?></span>

    <label>Fecha de publicación: (YYYY-MM-DD)</label>
    <input type="text" name="event_release_date" value="<?php echo $event_release_date; ?>">
    <span class="error">* <?php echo $event_release_dateERR; ?></span>

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


