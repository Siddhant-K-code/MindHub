<?php
session_start();
if(!isset($_SESSION['member'])) {
    header('Location: login.php');
    exit();
}