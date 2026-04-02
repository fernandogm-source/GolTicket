<?php
if (isset($_GET['page'])) {
    switch($_GET['page']) {
        case "homepage":
        case "controller_home":
            include("module/home/controller/controller_home.php");
            break;
        case "controller_shop":
            include("module/shop/controller/controller_shop.php");
            break;
        case "404":
            include("view/inc/error404.php");
            break;
        case "503":
            include("view/inc/error503.php");
            break;
        default:
            include("module/home/controller/controller_home.php");
            break;
    }
} else {
    include("module/home/controller/controller_home.php");
}
?>
