<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/GolTicketsV22_MVC/';
include($path . "module/profile/model/DAOProfile.php");

@session_start();

$op = $_GET['op'] ?? 'view';

switch ($op) {
        case 'view':
            default:
                include("module/profile/view/profile.html");
                break;
        }