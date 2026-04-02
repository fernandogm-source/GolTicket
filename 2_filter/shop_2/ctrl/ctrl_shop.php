<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/CONCESIONARIO';
include($path . "/module/shop/model/DAO_shop.php");

switch ($_GET['op']) {
    case 'list':
        include('module/shop/view/shop.html');
        break;

    case 'all_cars':
        try {
            $daoshop = new DAOShop();
            $Dates_Cars = $daoshop->select_all_cars();
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($Dates_Cars)) {
            echo json_encode($Dates_Cars);
        } else {
            echo json_encode("error");
        }
        break;

    case 'details_car';
        try {
            $daoshop = new DAOShop();
            $Date_car = $daoshop->select_one_car($_GET['id']);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        try {
            $daoshop_img = new DAOShop();
            $Date_images = $daoshop_img->select_imgs_car($_GET['id']);
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($Date_car || $Date_images)) {

            $rdo = array();
            $rdo[0] = $Date_car;
            $rdo[1][] = $Date_images;

            echo json_encode($rdo);
        } else {
            echo json_encode("error");
        }
        break;

    case 'filters':
        try {
            $daoFilter = new DAOShop();
            $Dates_filter_Cars = $daoFilter->select_filter_cars();
        } catch (Exception $e) {
            echo json_encode("error");
        }

        if (!empty($Dates_filter_Cars)) {
            echo json_encode($Dates_filter_Cars);
            exit;
        } else {
            echo json_encode("error");
        }
        break;

    default;
        include("module/exceptions/views/pages/error404.php");
        break;
}
