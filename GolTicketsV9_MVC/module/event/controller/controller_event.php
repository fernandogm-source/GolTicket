<?php
// $data = 'hola crtl user';
// die('<script>console.log('.json_encode( $data ) .');</script>');

    $path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV8_MVC/';
    include($path . "module/event/model/DAOevent.php");
@session_start();

switch ($_GET['op']) {
    case 'list':

        /* $data = 'hola crtl user list';
        die('<script>console.log('.json_encode( $data ) .');</script>'); */

        try {
            $daoevent = new DAOevent();
            $rdo = $daoevent->select_all_event();
        }
        catch (Exception $e) {
            $callback = 'index.php?page=503';
            die('<script>window.location.href = "' . $callback . '";</script>');
        }

        if ($rdo === false) {
            $callback = 'index.php?page=503';
            die('<script>window.location.href = "' . $callback . '";</script>');
        }
        else {
            include("module/event/view/list_event.php");
        }
        break;

    case 'create':
        include("module/event/model/validate.php");
        $errores = [];
        $event = null; // Empty user for the form

        if ($_POST) {
            //
            //
            $errores = validate();
            if (empty($errores)) {
                try {
                    $daoevent = new DAOevent();
                    $rdo = $daoevent->insert_event($_POST);
                }
                catch (Exception $e) {
                    $callback = 'index.php?page=503';
                    die('<script>window.location.href = "' . $callback . '";</script>');
                }

                if ($rdo) {
                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Creado",
                        text: "Evento creado correctamente",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "index.php?page=controller_event&op=list";
                    });
                    </script>';
                }
                else {
                    $callback = 'index.php?page=503';
                    die('<script>window.location.href = "' . $callback . '";</script>');
                }
            }
            else {
                $event = [
                    'event_name'          => $_POST['event_name'] ?? '',
                    'event_description'   => $_POST['event_description'] ?? '',
                    'event_organization'  => $_POST['event_organization'] ?? '',
                    'event_date'          => $_POST['event_date'] ?? '',
                    'event_hour'          => $_POST['event_hour'] ?? '',
                    'event_place'         => $_POST['event_place'] ?? '',
                    'event_city'          => $_POST['event_city'] ?? '',
                    'event_duration'      => $_POST['event_duration'] ?? '',
                    'event_capacity'      => $_POST['event_capacity'] ?? '',
                    'event_price'         => $_POST['event_price'] ?? '',
                    'event_disponibility' => $_POST['event_disponibility'] ?? '',
                    'event_services'      => json_encode($_POST['event_services'] ?? []),
                    'event_local'         => $_POST['event_local'] ?? '',
                    'event_visitor'       => $_POST['event_visitor'] ?? '',
                    'ticket_type'         => json_encode($_POST['ticket_type'] ?? []),
                    'event_competition'   => $_POST['event_competition'] ?? '',
                    'event_state'         => $_POST['event_state'] ?? '',
                ];
                    /* $data = 'hola crtl user';
                    die('<script>console.log('.json_encode( $event ) .');</script>'); */
            }
        }
        include("module/event/view/form_event.php");
        break;

    case 'update':
        include("module/event/model/validate.php");
        $errores = [];
        $user = null;

        if ($_POST) {
            $errores = validate();
            if (empty($errores)) {
                try {
                    $daoevent = new DAOevent();
                    $rdo = $daoevent->update_event($_POST);
                }
                catch (Exception $e) {
                    $callback = 'index.php?page=503';
                    die('<script>window.location.href = "' . $callback . '";</script>');
                }

                if ($rdo) {
                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Modificado",
                        text: "Evento modificado correctamente",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "index.php?page=controller_event&op=list";
                    });
                    </script>';
                }
                else {
                    $callback = 'index.php?page=503';
                    die('<script>window.location.href = "' . $callback . '";</script>');
                }
            }
            else {
                $event = [
                    'event_name'          => $_POST['event_name'] ?? '',
                    'event_description'   => $_POST['event_description'] ?? '',
                    'event_organization'  => $_POST['event_organization'] ?? '',
                    'event_date'          => $_POST['event_date'] ?? '',
                    'event_hour'          => $_POST['event_hour'] ?? '',
                    'event_place'         => $_POST['event_place'] ?? '',
                    'event_city'          => $_POST['event_city'] ?? '',
                    'event_duration'      => $_POST['event_duration'] ?? '',
                    'event_capacity'      => $_POST['event_capacity'] ?? '',
                    'event_price'         => $_POST['event_price'] ?? '',
                    'event_disponibility' => $_POST['event_disponibility'] ?? '',
                    'event_services'      => json_encode($_POST['event_services'] ?? []),
                    'event_local'         => $_POST['event_local'] ?? '',
                    'event_visitor'       => $_POST['event_visitor'] ?? '',
                    'ticket_type'         => json_encode($_POST['ticket_type'] ?? []),
                    'event_competition'   => $_POST['event_competition'] ?? '',
                    'event_state'         => $_POST['event_state'] ?? '',
                ];
                    /* $data = 'hola crtl user';
                    die('<script>console.log('.json_encode( $event ) .');</script>'); */
            }
        }

        if (!$_POST) {
            try {
                $daoevent = new DAOevent();
                /* $data = 'hola crtl user';
                    die('<script>console.log('.json_encode( $_GET['id'] ) .');</script>'); */
                $rdo = $daoevent->select_event($_GET['id']);
                $event = $rdo;
            }
            catch (Exception $e) {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }

            if (!$rdo) {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }
        }

        include("module/event/view/form_event.php");
        break;

    case 'read':
        try {
            $daoevent = new DAOevent();
            $rdo = $daoevent->select_event($_GET['id']);
            $event = $rdo;
        }
        catch (Exception $e) {
            $callback = 'index.php?page=503';
            die('<script>window.location.href = "' . $callback . '";</script>');
        }
        if (!$rdo) {
            $callback = 'index.php?page=503';
            die('<script>window.location.href = "' . $callback . '";</script>');
        }
        else {
            include("module/event/view/read_event.php");
        }
        break;

    case 'delete':

            /* $data = 'hola crtl user delete1';
 			die('<script>console.log('.json_encode( $data ) .');</script>'); */

        if ($_POST) {
            try {
                $daoevent = new DAOevent();
                $rdo = $daoevent->delete_event($_GET['id']);
            }
            catch (Exception $e) {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }
            if ($rdo) {
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Borrado",
                        text: "Evento borrado correctamente",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "index.php?page=controller_event&op=list";
                    });
                    </script>';
            }
            else {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }
        }

        include("module/event/view/delete_event.php");
        break;

    case 'delete_all';
        if ($_POST){
            try{
                $daoevent = new DAOevent();
                $result = $daoevent -> delete_all_event();
            }catch (Exception $e){
                $callback = 'index.php?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if($result){
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Borrado",
                        text: "Eventos borrados correctamente",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "index.php?page=controller_event&op=list";
                    });
                    </script>';
            }else{
                $callback = 'index.php?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
        }
        
        include("module/event/view/delete_all_event.php");
        break;

    case 'dummies';
        if ($_POST){
            try{
                $daoevent = new DAOevent();
                $result = $daoevent -> dummies_event();
            }catch (Exception $e){
                $callback = 'index.php?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            
            if($result){
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Creados",
                        text: "Dummies insertados en la base de datos correctamente",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "index.php?page=controller_event&op=list";
                    });
                    </script>';
            }else{
                $callback = 'index.php?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
        }
        
        include("module/event/view/dummies_event.php");
        break;

    case 'read_modal':
        // echo json_encode("hola modal");
        // exit;
        // echo json_encode($_GET['modal']);
        // exit;
        // echo json_encode("error");
        // exit;

        try{
            $daoevent = new DAOevent();
            $rdo = $daoevent->select_event($_GET['modal']);
        }catch (Exception $e){
            echo json_encode("error");
            exit;
        }
        if(!$rdo){
    		echo json_encode("error");
            exit;
    	}else{
            echo json_encode($rdo);
            exit;
    	}
        break;

    default:
        include("view/inc/error404.php");
        break;
}