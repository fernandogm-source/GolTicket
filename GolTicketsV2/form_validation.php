<?php
session_start();
// define variables and set to empty values
$event_name = $event_description = $event_organitation = $event_date = $event_hour = $event_place = "";
$event_city = $event_duration = $event_capacity = $event_price = $event_tickets = $event_services = "";
$event_local = $event_visitor = $event_ticket_type = $event_type = $event_state = "";

$event_nameERR = $event_descriptionERR = $event_organitationERR = $event_dateERR = $event_hourERR = $event_placeERR = "";
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
        // Validar formato dd/mm/yyyy
        $fechaObj = DateTime::createFromFormat('d/m/Y', $event_date);
        $errores = DateTime::getLastErrors();
        if (!$fechaObj || $errores['warning_count'] > 0 || $errores['error_count'] > 0) {
        $event_dateERR="Fecha inválida.";
        }
        // Validar que no sean anteriores
        $hoy = new DateTime();
        if ($fechaObj < $hoy) {
        $event_dateERR="No se permiten fechas anteriores.";
        }
    }



    if (empty($_POST["event_hour"])) {
        $event_hourERR = "Hour is required";
    } else {
        $event_hour = test_input($_POST["event_hour"]);
        // Validar hora
        $horaObj = DateTime::createFromFormat('H:i', $event_hour);
        $errHora = DateTime::getLastErrors();
        if (!$horaObj || $errHora['error_count'] > 0) {
        $event_hourERR=" Hora inválida.";
}
    }

    if (empty($_POST["event_place"])) {
        $event_placeERR = "Place is required";
    } else {
        $event_place = test_input($_POST["event_place"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_place)) {
            $event_placeERR = "Only letters and white space allowed";
        }        
    }

    if (empty($_POST["event_city"])) {
        $event_cityERR = "City is required";
    } else {
        $event_city = test_input($_POST["event_city"]);
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_city)) {
            $event_cityERR = "Only letters and white space allowed";
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
        if (!preg_match("/^[a-zA-Z-'ñ ]*$/",$event_local)) {
            $event_localERR = "Only letters and white space allowed";
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


 $_SESSION['errors'] = [
        'event_nameERR' => $event_nameERR,
        'event_descriptionERR' => $event_descriptionERR,
        'event_organitationERR' => $event_organitationERR,
        'event_dateERR' => $event_dateERR,
        'event_hourERR' => $event_hourERR,
        'event_placeERR' => $event_placeERR,
        'event_cityERR' => $event_cityERR,
        'event_durationERR' => $event_durationERR,
        'event_capacityERR' => $event_capacityERR,
        'event_priceERR' => $event_priceERR,
        'event_ticketsERR' => $event_ticketsERR,
        'event_servicesERR' => $event_servicesERR,
        'event_localERR' => $event_localERR,
        'event_visitorERR' => $event_visitorERR,
        'event_ticket_typeERR' => $event_ticket_typeERR,
        'event_typeERR' => $event_typeERR,
        'event_stateERR' => $event_stateERR
    ];
    
    $_SESSION['values'] = [
        'event_name' => $event_name,
        'event_description' => $event_description,
        'event_organitation' => $event_organitation,
        'event_date' => $event_date,
        'event_hour' => $event_hour,
        'event_place' => $event_place,
        'event_city' => $event_city,
        'event_duration' => $event_duration,
        'event_capacity' => $event_capacity,
        'event_price' => $event_price,
        'event_tickets' => $event_tickets,
        'event_services' => $event_services,
        'event_local' => $event_local,
        'event_visitor' => $event_visitor,
        'event_ticket_type' => $event_ticket_type,
        'event_type' => $event_type,
        'event_state' => $event_state
    ];

    header("Location: index.php");
    exit();

} 

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

