<?php
session_start();
require_once '../../Models/CommonModel.php';
require_once '../../Config/Database.php';

$model = new CommonModel();

if(isset($_POST['submit'])){

    $email = $_POST['username'];
    $password = $_POST['password'];
    $table = 'user';
    
    $user = $model->getRecordWhere($table, 'email', $email, '*', 1);

    if( $user && password_verify($password, $user['password']) ){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['success'] = "Welcome to dashboard";
        header('Location: ../dashboard.php');
        exit;
    }else{
        header('Location: ../index.php');
        exit;
    }
}
else{
    header('Location: ../index.php');
    exit;
}

?>