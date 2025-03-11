<?php 
session_start();
require_once '../../Models/CommonModel.php';

$user_id = $_SESSION['user_id']? $_SESSION['user_id'] : null;
$model = new CommonModel();

if(isset($_POST['submit']))
{
    $categoryName = $_POST['category_name']; 
    $category_id = $_POST['category_id'];
    $active = isset($_POST['active']) ? $_POST['active'] : 0 ;
    $image_name = $_POST['image_name'];

    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0){

        $targetDir = "../uploads/category/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $categoryImage = basename($_FILES["category_image"]["name"]);

        $targetFilePath = $targetDir . $categoryImage;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png", "webp"];

        $isInsert = 0;
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $targetFilePath)) {
                // $isInsert = 1;
            } else {
                $_SESSION['error'] = "Error moving the uploaded file.";
            }
        } else {
            $_SESSION['error'] = "Only JPG, JPEG, PNG & webp files are allowed.";
        }
    }else{
        $categoryImage = $image_name;
    }

    $categoryData = [
        'user_id' => $user_id,
        'category_name' => $categoryName,
        'category_img' => $categoryImage,
        'active' => $active,
    ];

    if(isset($category_id) && $category_id != ''){
        $categoryInsert = $model->updateRecordById('category', $categoryData, $category_id);
        $msg = "updated category successfully";
    } else {
        $categoryInsert = $model->insertRecord('category', $categoryData);
        $msg = "inserted category successfully";
    }
    if($categoryInsert){
        $_SESSION['success'] = $msg;
    }else{
        $_SESSION['error'] = "Something Went Wrong!";
    }
  
} else {

    $_SESSION['error'] = "Error in submitting the form"; 
}
header('Location: ../category.php');
exit;
?>