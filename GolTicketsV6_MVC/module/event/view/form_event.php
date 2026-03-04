<?php
$errores = $errores ?? [];

// $isUpdate = isset($user) && $user !== null && !empty($user['user']);
$isUpdate = isset($_GET['id']) ? true : false;
$action = $isUpdate ? "update" : "create";

// Fallback variables for creation or reloading
$e_name = $event['event_name'] ?? '';
$e_description = $event['event_description'] ?? '';
$e_organization = $event['event_organization'] ?? '';
$e_date = $event['event_date'] ?? '';
$e_hour = $event['event_hour'] ?? '';
$e_place = $event['event_place'] ?? '';
$e_city = $event['event_city'] ?? '';
$e_duration = $event['event_duration'] ?? '';
$e_capacity = $event['event_capacity'] ?? '';
$e_price = $event['event_price'] ?? '';
$e_disponibility = $event['event_disponibility'] ?? '';
$e_local = $event['event_local'] ?? '';
$e_visitor = $event['event_visitor'] ?? '';
$e_competition = $event['event_competition'] ?? '';
$e_state = $event['event_state'] ?? '';

// Arrays json (handle decoding if from DB, or arrays if from failed POST)
$e_services_raw = $event['event_services'] ?? '[]';
$e_services = is_array($e_services_raw) ? $e_services_raw : (json_decode($e_services_raw, true) ?? []);

$e_ticket_raw = $event['ticket_type'] ?? '[]';
$e_ticket = is_array($e_ticket_raw) ? $e_ticket_raw : (json_decode($e_ticket_raw, true) ?? []);


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

?>

<form autocomplete="on" method="post" name="form_event" id="form_event" onsubmit="return validate();"
        action="index.php?page=controller_event&op=<?= $action?>">
    
    <input type="hidden" name="event_id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
    
    <h2>
        <span class="icono">⚽</span>
        <?= $isUpdate ? 'Modificar evento' : 'Evento nuevo'?>
    </h2>

    <label>Nombre del evento:</label>
    <input type="text" name="event_name" id="event_name" 
            value="<?= htmlspecialchars($e_name) ?>"
            class="<?= errorCampo('event_name', $errores) ? 'error' : '' ?>" <?= $isUpdate ? 'readonly' : '' ?>>
    <div class="error-text" id="error-event_name">
        <?= htmlspecialchars(errorCampo('event_name', $errores) ?? '') ?>
    </div>

    <label>Descripción del evento:</label>
    <textarea rows="3" type="text" name="event_description" id="event_description"
            class="<?= errorCampo('event_description', $errores) ? 'error' : '' ?>">
        <?= htmlspecialchars($e_description) ?></textarea>
    <div class="error-text" id="error-event_description">
        <?= htmlspecialchars(errorCampo('event_description', $errores) ?? '') ?>
    </div>

    <label>Organización del evento:</label>
    <input type="text" name="event_organization" id="event_organization" 
            value="<?= htmlspecialchars($e_organization) ?>"
            class="<?= errorCampo('event_organization', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_organization">
        <?= htmlspecialchars(errorCampo('event_organization', $errores) ?? '') ?>
    </div>

    <label>Fecha del evento: (DD/MM/AAAA)</label>
    <input type="text" name="event_date" id="event_date" 
            value="<?= htmlspecialchars($e_date) ?>"
            class="<?= errorCampo('event_date', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_date">
        <?= htmlspecialchars(errorCampo('event_date', $errores) ?? '') ?>
    </div>

    <label>Hora del evento:</label>
    <input type="text" name="event_hour" id="event_hour" 
            value="<?= htmlspecialchars($e_hour) ?>"
            class="<?= errorCampo('event_hour', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_hour">
        <?= htmlspecialchars(errorCampo('event_hour', $errores) ?? '') ?>
    </div>

    <label>Lugar del evento:</label>
    <input type="text" name="event_place" id="event_place" 
            value="<?= htmlspecialchars($e_place) ?>"
            class="<?= errorCampo('event_place', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_place">
        <?= htmlspecialchars(errorCampo('event_place', $errores) ?? '') ?>
    </div>

    <label>Ciudad del evento:</label>
    <input type="text" name="event_city" id="event_city" 
            value="<?= htmlspecialchars($e_city) ?>"
            class="<?= errorCampo('event_city', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_city">
        <?= htmlspecialchars(errorCampo('event_city', $errores) ?? '') ?>
    </div>

    <label>Duración del evento (minutos):</label>
    <input type="text" name="event_duration" id="event_duration" 
            value="<?= htmlspecialchars($e_duration) ?>"
            class="<?= errorCampo('event_duration', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_duration">
        <?= htmlspecialchars(errorCampo('event_duration', $errores) ?? '') ?>
    </div>

    <label>Capacidad del evento:</label>
    <input type="text" name="event_capacity" id="event_capacity" 
            value="<?= htmlspecialchars($e_capacity) ?>"
            class="<?= errorCampo('event_capacity', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_capacity">
        <?= htmlspecialchars(errorCampo('event_capacity', $errores) ?? '') ?>
    </div>

    <label>Precio del evento (€):</label>
    <input type="text" name="event_price" id="event_price" 
            value="<?= htmlspecialchars($e_price) ?>"
            class="<?= errorCampo('event_price', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_price">
        <?= htmlspecialchars(errorCampo('event_price', $errores) ?? '') ?>
    </div>

    <label>Entradas disponibles:</label>
    <input type="text" name="event_disponibility" id="event_disponibility" 
            value="<?= htmlspecialchars($e_disponibility) ?>"
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
                       <?= in_array($valor, $e_services) ? 'checked' : '' ?>>
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
            value="<?= htmlspecialchars($e_local) ?>"
            class="<?= errorCampo('event_local', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_local">
        <?= htmlspecialchars(errorCampo('event_local', $errores) ?? '') ?>
    </div>

    <label>Equipo visitante:</label>
    <input type="text" name="event_visitor" id="event_visitor" 
            value="<?= htmlspecialchars($e_visitor) ?>"
            class="<?= errorCampo('event_visitor', $errores) ? 'error' : '' ?>">
    <div class="error-text" id="error-event_visitor">
        <?= htmlspecialchars(errorCampo('event_visitor', $errores) ?? '') ?>
    </div>

    <label>Tipos de entrada:</label>
    <div class="checkbox-group">
            <?php foreach ($ticketTypeAva as $valor => $label): ?>
            <label class="opcion">
                <input type="checkbox" name="ticket_type[]" value="<?= $valor ?>"
                       <?= in_array($valor, $e_ticket) ? 'checked' : '' ?>>
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
                       <?= $e_competition === $valor ? 'checked' : '' ?>>
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
                       <?= $e_state === $valor ? 'checked' : '' ?>>
                <?= $label ?>
            </label>
        <?php endforeach; ?>
        <div class="error-text" id="error-state">
            <?= errorCampo('event_state',$errores) ?>
        </div>
  </div>

    <br><br>
    <div class="form-buttons">
    <a href="index.php?page=controller_event&op=list">Volver</a>
    <input type="submit" name="<?= $action?>" id="<?= $action?>" value="<?= $isUpdate ? 'Modificar evento' : 'Crear evento'?>" />
</div>

</form>
