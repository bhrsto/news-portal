<?php
include "connect.php";
session_start();

if (isset($_POST['logout'])) {
    // Odjava - uništavanje sesijskih podataka
    session_destroy();

    // Preusmjeravanje na prijavu ili drugu odgovarajuću stranicu
    header('Location: login.php');
    exit();
}
?>