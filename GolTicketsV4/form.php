<?php
  $errores = $_SESSION['errores'] ?? [];
  $old = $_SESSION['old'] ?? $data ?? [];
  unset($_SESSION['errores'], $_SESSION['old']);

function errorCampo(string $campo, array $errores): ?string {
  return $errores[$campo] ?? null;
  }
$ticketTypeAva = [
    'general'   => 'General',
    'vip'       => 'VIP',
    'premium'   => 'Premium',
    'infantil'  => 'Infantil',
    'grada'     => 'Grada',
    'palco'     => 'Palco'
];  
$event_servicesAva = [
    'parking'       => 'Parking',
    'taquillas'     => 'Taquillas',
    'merchandising' => 'Merchandising'
];
$event_typeAva = [
    'laliga'            => 'LaLiga',
    'laliga2'           => 'LaLiga 2',
    'copa_del_rey'      => 'Copa del Rey',
    'champions_league'  => 'Champions League'
];
$event_stateAva = [
    'programado'    => 'Programado',
    'en_venta'      => 'En venta',
    'agotado'       => 'Agotado',
    'cancelado'     => 'Cancelado',
    'finalizado'    => 'Finalizado'
];
$servicesSelected = json_decode($old['event_services'], true) ?? [];
$ticketsSelected = json_decode($old['ticket_type'], true) ?? [];
$typeSelected = $old['event_competition'] ?? '';
$stateSelected = $old['event_state'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GolTickets</title>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
      <link rel="stylesheet" href="form.css">
    
</head>
<body>


<form action="form_validation.php" method="post" id="formGol">
    <input type="hidden" name="event_id" value="<?= $old['event_id'] ?? '' ?>"> 

    <h2><span class="icono">⚽</span> GolTickets</h2>

    <label>Nombre del evento:</label>
    <input type="text" name="event_name" id="event_name" 
            value="<?= htmlspecialchars($old['event_name'] ?? '') ?>"
            class="<?= errorCampo('event_name', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_name">
        <?= htmlspecialchars(errorCampo('event_name', $errores) ?? '') ?>
    </div>

    <label>Descripción del evento:</label>
    <textarea rows="3" type="text" name="event_description" id="event_description"
            class="<?= errorCampo('event_description', $errores) ? 'error' : '' ?>">
        <?= htmlspecialchars($old['event_description'] ?? '') ?></textarea>
    <div class="error-text" id="error-event_description">
        <?= htmlspecialchars(errorCampo('event_description', $errores) ?? '') ?>
    </div>

    <label>Organización del evento:</label>
    <input type="text" name="event_organization" id="event_organization" 
            value="<?= htmlspecialchars($old['event_organization'] ?? '') ?>"
            class="<?= errorCampo('event_organization', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_organization">
        <?= htmlspecialchars(errorCampo('event_organization', $errores) ?? '') ?>
    </div>

    <label>Fecha del evento: (DD/MM/AAAA)</label>
    <input type="text" name="event_date" id="event_date" 
            value="<?= htmlspecialchars($old['event_date'] ?? '') ?>"
            class="<?= errorCampo('event_date', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_date">
        <?= htmlspecialchars(errorCampo('event_date', $errores) ?? '') ?>
    </div>

    <label>Hora del evento:</label>
    <input type="text" name="event_hour" id="event_hour" 
            value="<?= htmlspecialchars($old['event_hour'] ?? '') ?>"
            class="<?= errorCampo('event_hour', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_hour">
        <?= htmlspecialchars(errorCampo('event_hour', $errores) ?? '') ?>
    </div>

    <label>Lugar del evento:</label>
    <input type="text" name="event_place" id="event_place" 
            value="<?= htmlspecialchars($old['event_place'] ?? '') ?>"
            class="<?= errorCampo('event_place', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_place">
        <?= htmlspecialchars(errorCampo('event_place', $errores) ?? '') ?>
    </div>

    <label>Ciudad del evento:</label>
    <input type="text" name="event_city" id="event_city" 
            value="<?= htmlspecialchars($old['event_city'] ?? '') ?>"
            class="<?= errorCampo('event_city', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_city">
        <?= htmlspecialchars(errorCampo('event_city', $errores) ?? '') ?>
    </div>

    <label>Duración del evento (minutos):</label>
    <input type="text" name="event_duration" id="event_duration" 
            value="<?= htmlspecialchars($old['event_duration'] ?? '') ?>"
            class="<?= errorCampo('event_duration', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_duration">
        <?= htmlspecialchars(errorCampo('event_duration', $errores) ?? '') ?>
    </div>

    <label>Capacidad del evento:</label>
    <input type="text" name="event_capacity" id="event_capacity" 
            value="<?= htmlspecialchars($old['event_capacity'] ?? '') ?>"
            class="<?= errorCampo('event_capacity', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_capacity">
        <?= htmlspecialchars(errorCampo('event_capacity', $errores) ?? '') ?>
    </div>

    <label>Precio del evento (€):</label>
    <input type="text" name="event_price" id="event_price" 
            value="<?= htmlspecialchars($old['event_price'] ?? '') ?>"
            class="<?= errorCampo('event_price', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_price">
        <?= htmlspecialchars(errorCampo('event_price', $errores) ?? '') ?>
    </div>

    <label>Entradas disponibles:</label>
    <input type="text" name="event_disponibility" id="event_disponibility" 
            value="<?= htmlspecialchars($old['event_disponibility'] ?? '') ?>"
            class="<?= errorCampo('event_disponibility', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_disponibility">
        <?= htmlspecialchars(errorCampo('event_disponibility', $errores) ?? '') ?>
    </div>

    <label>Servicios disponibles:</label>
<div class="checkbox-group">
        <label>
            <?php foreach ($event_servicesAva as $valor => $label): ?>
            <label class="opcion">
                <input type="checkbox" name="event_services[]" value="<?= $valor ?>"
                       <?= in_array($valor, $servicesSelected) ? 'checked' : '' ?>>
                <?= $label ?>
            </label>
        <?php endforeach; ?>
        <div class="error-text" id="error-services">
            <?= errorCampo('event_services',$errores) ?>
        </div>
        </label>
    </div>

    <label>Equipo local:</label>
    <input type="text" name="event_local" id="event_local" 
            value="<?= htmlspecialchars($old['event_local'] ?? '') ?>"
            class="<?= errorCampo('event_local', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_local">
        <?= htmlspecialchars(errorCampo('event_local', $errores) ?? '') ?>
    </div>

    <label>Equipo visitante:</label>
    <input type="text" name="event_visitor" id="event_visitor" 
            value="<?= htmlspecialchars($old['event_visitor'] ?? '') ?>"
            class="<?= errorCampo('event_visitor', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_visitor">
        <?= htmlspecialchars(errorCampo('event_visitor', $errores) ?? '') ?>
    </div>

    <label>Tipos de entrada:</label>
    <div class="checkbox-group">
            <?php foreach ($ticketTypeAva as $valor => $label): ?>
            <label class="opcion">
                <input type="checkbox" name="ticket_type[]" value="<?= $valor ?>"
                       <?= in_array($valor, $ticketsSelected) ? 'checked' : '' ?>>
                <?= $label ?>
            </label>
        <?php endforeach; ?>
        <div class="error-text" id="error-tickets">
            <?= errorCampo('ticket_type',$errores) ?>
        </div>
    </div>

      <label>Tipo de partido:</label>
  <div class="radio-group">
         <?php foreach ($event_typeAva as $valor => $label): ?>
            <label class="opcion">
                <input type="radio" name="event_competition" value="<?= $valor ?>"
                       <?= $typeSelected === $valor ? 'checked' : '' ?>>
                <?= $label ?>
            </label>
        <?php endforeach; ?>
        <div class="error-text" id="error-type">
            <?= errorCampo('event_competition',$errores) ?>
        </div>
  </div>

  <label>Estado del evento:</label>
  <div class="radio-group">
     <?php foreach ($event_stateAva as $valor => $label): ?>
            <label class="opcion">
                <input type="radio" name="event_state" value="<?= $valor ?>"
                       <?= $stateSelected === $valor ? 'checked' : '' ?>>
                <?= $label ?>
            </label>
        <?php endforeach; ?>
        <div class="error-text" id="error-state">
            <?= errorCampo('event_state',$errores) ?>
        </div>
  </div>

    <br><br>
    <div class="form-buttons">
    <a href="index.php" class="btn-volver">
        <span class="arrow">←</span>
        <span class="text">Volver</span>
    </a>
    <button type="submit" class="submit">Crear Evento</button>
</div>

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