<?php 
session_start();
require_once '../../Models/CommonModel.php';

$user_id = $_SESSION['user_id']? $_SESSION['user_id'] : null;
$model = new CommonModel();

if(isset($_POST['submit']))
{ 
    $recipieName = $_POST['recipie_name'];
    $ingredientName = $_POST['ingredients'];
    $quantity = $_POST['quantity'];
    $steps =  $_POST['steps'];
    $category =  $_POST['category'];
    $time =  $_POST['time'];
    $servings =  $_POST['servings']; 
    $active = isset($_POST['active']) ? $_POST['active'] : 0 ;

    //for ingredients and quantity to be combined 
    if(count($ingredientName) === count($quantity)){
        $ingredients = array_combine($ingredientName, $quantity);
    } else {
        $_SESSION['error'] = "Ingredient count and quantity count is not same";
    }

    $category_id_data = $model->getRecordWhere('category', 'category_name', $category, ['id'], $limit = 1);
 
    $category_id = $category_id_data['id'];


    if (isset($_FILES['recipie_image']) && $_FILES['recipie_image']['error'] == 0){

        $targetDir = "../uploads/recipie/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $recipieImage = basename($_FILES["recipie_image"]["name"]);

        $targetFilePath = $targetDir . $recipieImage;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png", "webp"];

        $isInsert = 0;
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["recipie_image"]["tmp_name"], $targetFilePath)) {
                echo "Image uploaded successfully: " . $recipieImage;
                $isInsert = 1;
            } else {
                $_SESSION['error'] = "Error moving the uploaded file.";
            }
        } else {
            $_SESSION['error'] = "Only JPG, JPEG, PNG & webp files are allowed.";
        }
    }else{
        $_SESSION['error'] = "No file selected or an error occurred during upload.";
    }
   
    $recipieData = [
        'user_id' => $user_id,
        "name" => $recipieName,
        "ingredients" => $ingredients,
        "steps" => $steps,
        "category" => $category,
        "time" => $time,
        "servings" => $servings,
        "recipie_image" => $recipieImage,
        "active" => $active,
        "category_id" => $category_id,
    ];

    if($isInsert){
        $categoryInsert = $model->insertRecord('recipie', $recipieData);

        if($categoryInsert){
            $_SESSION['success'] = "Recipie inserted successfully";
        } else {
            $_SESSION['error'] = "Failed to insert recipie";
        }
    } else {
        $_SESSION['error'] = "Error to insert image";
    }
    
} else {
    $_SESSION['error'] = "Error in submitting the form"; 
}

header('Location: ../add_recipie.php');
exit;

?>