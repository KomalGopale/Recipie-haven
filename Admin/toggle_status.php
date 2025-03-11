<?php
session_start();
require_once '../Models/CommonModel.php';
$model = new CommonModel();


if(isset($_GET['id']) && isset($_GET['status']) && isset($_GET['table'])){
    $id = $_GET['id'];
    $table = $_GET['table'];
    $status = ($_GET['status'] == 1)? 0 : 1;
    $publishStatus = ($status)? 'Published' : 'Unpublished';

    $data = ['active' => $status];

    $allowedTables = ['recipie', 'category'];
    if (!in_array($table, $allowedTables)) {
        die("Invalid table name");
    }

    $isStatusUpdated = $model->updateRecordById($table, $data, $id);

    if($isStatusUpdated){
        $_SESSION['success'] =  "Recipie " . $publishStatus . " Successfully";
    } else {
        $_SESSION['error'] = "Failed to upadate recipie Status";
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();

}