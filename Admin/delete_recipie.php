<?php
session_start();
require_once '../Models/CommonModel.php';
$model = new CommonModel();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $isDeleted = $model->deleteRecordById('recipie', $id);

    if($isDeleted){
        $_SESSION['success'] = "Recipie deleted successfully";
    }else{
        $_SESSION['error'] = "Failed to delete recipie";
    }
    
}
header('Location: recipie.php');
exit;