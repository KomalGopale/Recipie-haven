<?php 
session_start();
require_once '../../Models/CommonModel.php';

$user_id = $_SESSION['user_id']? $_SESSION['user_id'] : null;
$model = new CommonModel();

if(isset($_POST['submit']))
{ 
    $recipieName = $_POST['recipie_name'];
    $recipieId = $_POST['recipie_id']; 
    $ingredientName = $_POST['ingredients'];
    $quantity = $_POST['quantity'];
    $steps = isset($_POST['steps']) ? json_encode($_POST['steps'], JSON_UNESCAPED_SLASHES) : '';
    $category =  $_POST['category'];
    $time =  $_POST['time'];
    $servings =  $_POST['servings']; 
    $active = isset($_POST['active']) ? $_POST['active'] : 0 ;
    $recipie_image = $_POST['recipie_image'];

    //for ingredients and quantity to be combined 
    if(count($ingredientName) === count($quantity)){
        $ingredients = array_combine($ingredientName, $quantity);
        $ingredients = json_encode($ingredients, JSON_UNESCAPED_SLASHES);
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
        $recipieImage = $recipie_image;
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

    if(isset($recipieId) && $recipieId !== ''){
        $recipieStatus = $model->updateRecordById('recipie', $recipieData, $recipieId);
        $msg = "updated recipie successfully";
    } else {
        $recipieStatus = $model->insertRecord('recipie', $recipieData);
        $msg = "inserted recipie successfully";
    }

    if($recipieStatus){
        $_SESSION['success'] = $msg;
    }else{
        $_SESSION['error'] = "Something Went Wrong!";
    }
    
} else {
    $_SESSION['error'] = "Error in submitting the form"; 
}

header('Location: ../recipie.php');
exit;

?>