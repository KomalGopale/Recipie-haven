<?php
session_start();
require_once '../Models/CommonModel.php';
$model = new CommonModel();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $isDeleted = $model->deleteRecordById('category', $id);

    if($isDeleted){
        $_SESSION['success'] = "Category deleted successfully";
    }else{
        $_SESSION['error'] = "Failed to delete category ";
    }
    
}
header('Location: category.php');
exit;