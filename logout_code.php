<?php
    include 'C:xampp/htdocs/Capstone_BeeMo/connection/mysql_connection.php';
    session_start();
    session_unset();
    session_destroy();

    header('location:index.php')
?>