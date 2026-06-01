<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV22_MVC/';
include($path . "/module/shop/model/DAO_shop.php");

@session_start();
$_SESSION['tiempo'] = time();

switch ($_GET['op']) {
    case 'view':
        include('module/shop/view/shop.html');
        break;

    case 'all_event':
        try {
            $daoshop = new DAOShop();
            $filter = isset($_POST['filter']) ? json_decode($_POST['filter'], true) : [];
            $limit  = $_POST['limit'];
            $offset = $_POST['offset'];
            $orderby= $_POST['orderby'];
            $dates_event = $daoshop->select_all_event($filter,$limit,$offset,$orderby);
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($dates_event)) {
            echo json_encode($dates_event);
        } else {
            echo json_encode("error");
        }
        break;

    case 'all_event_count':
        try {
            $daoshop = new DAOShop();
            $filter = isset($_POST['filter']) ? json_decode($_POST['filter'], true) : [];
            $dates_count = $daoshop->select_all_event_count($filter);
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($dates_count)) {
            echo json_encode($dates_count);
        } else {
            echo json_encode("error");
        }
        break;

    case 'get_filters_config':
        try {
            $daoshop = new DAOShop();
            $config = $daoshop->get_dynamic_filters();
            header('Content-Type: application/json');
            echo json_encode($config);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(["error" => $e->getMessage()]);
        }
        exit;

    case 'details_event':
        try {
            $daoshop    = new DAOShop();
            $Date_event  = $daoshop->select_one_event($_GET['id']);
            $Date_images = $daoshop->select_imgs_event($_GET['id']);
            $Date_extras = $daoshop->select_extra_event($_GET['id']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit();
        }

        if (!empty($Date_event)) {
            $rdo    = array();
            $rdo[0] = $Date_event;
            $rdo[1] = $Date_images;
            $rdo[2] = $Date_extras;
            echo json_encode($rdo);
        } else {
            echo json_encode("error");
        }
        break;

    case 'count_events_related':
        $local     = $_POST['local'];
        $visitante = $_POST['visitante'];
        try {
            $dao = new DAOShop();
            $rdo = $dao->count_more_events_related($local, $visitante);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (empty($rdo)) {
            echo json_encode("error");
            exit;
        }
        echo json_encode($rdo);
        break;

    case 'events_related':

        $idPart    = $_POST['idPart'];
        $local     = $_POST['local'];
        $visitante = $_POST['visitante'];
        $loaded    = $_POST['loaded'];
        $items     = $_POST['items'];
        try {
            $dao = new DAOShop();
            $rdo = $dao->select_events_related($idPart,$local,$visitante, $loaded, $items);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;

    case 'update_most_visited':
        try {
            $daoshop = new DAOShop();
            $daoshop->update_visits_event($_GET['id']);
            echo json_encode("ok");
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;

    case 'control_likes':
        $token = $_POST['token'];
        $id_partido = $_POST['id_partido'];

        try {
            $json = decode_token($token);
            $dao = new DAOShop();
            $rdo = $dao->select_likes($id_partido, $json['username']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            if (count($dinfo) === 0) {
                $dao = new DAOShop();
                $rdo = $dao->like($id_partido, $json['username']);
                echo json_encode("0");
            } else {
                $dao = new DAOShop();
                $rdo = $dao->dislike($id_partido, $json['username']);
                echo json_encode("1");
            }
        }
        break;

    case 'load_likes_user';
        try {
            $json = decode_token($_POST['token']);
            $dao = new DAOShop();
            $rdo = $dao->select_load_likes($json['username']);
        } catch (Exception $e) {
            echo json_encode("error");
            exit;
        }
        if (!$rdo) {
            echo json_encode("error");
            exit;
        } else {
            $dinfo = array();
            foreach ($rdo as $row) {
                array_push($dinfo, $row);
            }
            echo json_encode($dinfo);
        }
        break;
}
