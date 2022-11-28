<?php
    include '../config.php';
    $order_id = $_GET["id"];
    /*sql to delete a record*/
    $sql = "DELETE FROM order_products WHERE order_id ='{$order_id}'";
    if (mysqli_query($conn, $sql)) {
        header("location:{$hostname}/admin/orders.php");
    } 
    mysqli_close($conn);
?>