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
        include("module/user/model/validate.php");
        $errores = [];
        $user = null; // Empty user for the form

        if (isset($_POST['create'])) {
            $errores = validate();
            if (empty($errores)) {
                try {
                    $daouser = new DAOUser();
                    $rdo = $daouser->insert_user($_POST);
                }
                catch (Exception $e) {
                    $callback = 'index.php?page=503';
                    die('<script>window.location.href = "' . $callback . '";</script>');
                }

                if ($rdo) {
                    echo '<script language="javascript">setTimeout(() => {
                            toastr.success("Creado en la base de datos correctamente");
                        }, 1000);</script>';
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
                $user = [
                    'user' => $_POST['usuario'] ?? '',
                    'pass' => $_POST['pass'] ?? '',
                    'name' => $_POST['nombre'] ?? '',
                    'dni' => $_POST['DNI'] ?? '',
                    'sex' => $_POST['sexo'] ?? '',
                    'birthdate' => $_POST['fecha_nacimiento'] ?? '',
                    'age' => $_POST['edad'] ?? '',
                    'country' => $_POST['pais'] ?? '',
                    'language' => json_encode($_POST['idioma'] ?? []),
                    'comment' => $_POST['observaciones'] ?? '',
                    'hobby' => json_encode($_POST['aficion'] ?? [])
                ];
            }
        }
        include("module/user/view/form_user.php");
        break;

    case 'update':
        include("module/user/model/validate.php");
        $errores = [];
        $user = null;

        if (isset($_POST['update'])) {
            $errores = validate();
            if (empty($errores)) {
                try {
                    $daouser = new DAOUser();
                    $rdo = $daouser->update_user($_POST);
                }
                catch (Exception $e) {
                    $callback = 'index.php?page=503';
                    die('<script>window.location.href = "' . $callback . '";</script>');
                }

                if ($rdo) {
                    echo '<script language="javascript">setTimeout(() => {
                            toastr.success("Modificado en la base de datos correctamente");
                        }, 1000);</script>';
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
                $user = [
                    'user' => $_POST['usuario'] ?? '',
                    'pass' => $_POST['pass'] ?? '',
                    'name' => $_POST['nombre'] ?? '',
                    'dni' => $_POST['DNI'] ?? '',
                    'sex' => $_POST['sexo'] ?? '',
                    'birthdate' => $_POST['fecha_nacimiento'] ?? '',
                    'age' => $_POST['edad'] ?? '',
                    'country' => $_POST['pais'] ?? '',
                    'language' => json_encode($_POST['idioma'] ?? []),
                    'comment' => $_POST['observaciones'] ?? '',
                    'hobby' => json_encode($_POST['aficion'] ?? [])
                ];
            }
        }

        if (!isset($_POST['update'])) {
            try {
                $daouser = new DAOUser();
                $rdo = $daouser->select_user($_GET['id']);
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

        include("module/user/view/form_user.php");
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