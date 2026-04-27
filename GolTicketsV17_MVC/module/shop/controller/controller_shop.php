<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV17_MVC/';
include($path . "/module/shop/model/DAO_shop.php");

switch ($_GET['op']) {
    case 'view':
        include('module/shop/view/shop.html');
        break;

    case 'all_event':
        try {
            $daoshop = new DAOShop();
            $filter = isset($_POST['filter']) ? json_decode($_POST['filter'], true) : [];
            $dates_event = $daoshop->select_all_event($filter);
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($dates_event)) {
            echo json_encode($dates_event);
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
}
