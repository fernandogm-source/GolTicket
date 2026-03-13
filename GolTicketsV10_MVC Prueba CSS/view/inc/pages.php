<?php
if (isset($_GET['page'])) {
    switch($_GET['page']) {
        case "homepage":
        case "controller_home":
            include("module/home/controller/controller_home.php");
            break;
        case "services":
            include("module/services/".$_GET['page'].".php");
            break;
        case "aboutus":
            include("module/aboutus/".$_GET['page'].".php");
            break;
        case "contactus":
            include("module/contact/".$_GET['page'].".php");
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
