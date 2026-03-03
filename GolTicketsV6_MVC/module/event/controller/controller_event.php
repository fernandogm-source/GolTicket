<?php
// $data = 'hola crtl user';
// die('<script>console.log('.json_encode( $data ) .');</script>');

include("module/event/model/DAOevent.php");
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

        if (isset($_POST['create'])) {
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
                    /* echo '<script language="javascript">setTimeout(() => {
                            toastr.success("Creado en la base de datos correctamente");
                        }, 1000);</script>'; */
                    echo '<script language="javascript">setTimeout(() => {
                            window.location.href = "index.php?page=controller_user&op=list";
                        }, 2000);</script>';
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

        if (isset($_POST['update'])) {
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
                    /* echo '<script language="javascript">setTimeout(() => {
                            toastr.success("Creado en la base de datos correctamente");
                        }, 1000);</script>'; */
                    echo '<script language="javascript">setTimeout(() => {
                            window.location.href = "index.php?page=controller_user&op=list";
                        }, 2000);</script>';
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

        if (!isset($_POST['update'])) {
            try {
                $daouser = new DAOevent();
                $rdo = $daouser->select_event($_GET['id']);
                $user = $rdo;
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

        if (isset($_POST['delete'])) {
            try {
                $daoevent = new DAOevent();
                $rdo = $daoevent->delete_event($_GET['id']);
            }
            catch (Exception $e) {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }
            if ($rdo) {
                /* echo '<script language="javascript">setTimeout(() => {
                        toastr.success("Borrado en la base de datos correctamente");
                    }, 1000);</script>'; */
                echo '<script language="javascript">setTimeout(() => {
                        window.location.href = "index.php?page=controller_event&op=list";
                    }, 2000);</script>';
            }
            else {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }
        }

        include("module/event/view/delete_event.php");
        break;
    default:
        include("view/inc/error404.php");
        break;
}