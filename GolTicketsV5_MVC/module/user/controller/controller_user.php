<?php
// $data = 'hola crtl user';
// die('<script>console.log('.json_encode( $data ) .');</script>');

include("module/user/model/DAOUser.php");
@session_start();

switch ($_GET['op']) {
    case 'list':
        try {
            $daouser = new DAOUser();
            $rdo = $daouser->select_all_user();
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
            include("module/user/view/list_user.php");
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
        else {
            include("module/user/view/read_user.php");
        }
        break;

    case 'delete':
        if (isset($_POST['delete'])) {
            try {
                $daouser = new DAOUser();
                $rdo = $daouser->delete_user($_GET['id']);
            }
            catch (Exception $e) {
                $callback = 'index.php?page=503';
                die('<script>window.location.href = "' . $callback . '";</script>');
            }
            if ($rdo) {
                echo '<script language="javascript">setTimeout(() => {
                        toastr.success("Borrado en la base de datos correctamente");
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

        include("module/user/view/delete_user.php");
        break;
    default:
        include("view/inc/error404.php");
        break;
}