<?php
    $page = $_GET['page'] ?? '';
    if ($page === "controller_home" || $page === "homepage" || $page === "") {
        include("view/inc/top_page_home.php");
    } elseif($page === "controller_shop") {
        include("view/inc/top_page_shop.php");
    } else {
        include("view/inc/top_page.php");
    }
    session_start();
?>

<?php include("view/inc/header.php"); ?>

<?php include("view/inc/pages.php"); ?>

<?php include("view/inc/footer.php"); ?>

<?php include("view/inc/bottom_page.php"); ?>
