<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once '../Models/CommonModel.php';
$model = new CommonModel();

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $category_data = $model->getRecordWhere('category', 'id', $id);

    echo "<pre>";
    echo "category data: " . print_r($category_data); 
}

?>
<div class="container-fluid">
    
    <?php require_once './includes/confirm_alert.php'?>
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Category</h1>
    
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Category</h6>
                    </div>
                    <div class="card-body">
                    <form id="add-category" method = "POST" action = "./controllers/CategoryController.php" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value = "<?php echo $category_data[0]['category_name'];?>" required>
                            </div>
                            <div class="form-group col-md-6">
                       
                                <label for="category_image">Choose Category Image</label>
                                <input type="file" class="form-control-file mt-2" id="category_image" name="category_image" required>

                                <label for="category_name">Uploaded Image</label>
                                <?php if(isset($category_data[0]['category_img'])){ ?>
                                <img src="./uploads/category/<?php echo $category_data[0]['category_img']; ?>" 
                                alt="<?php echo $category_data[0]['category_img']; ?>" width="120" height="120">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label for="active">Publish</label>
                            <div class="ml-4 custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="active" name="active" value="1">
                                <label class="custom-control-label" for="active"></label>
                            </div>
                        </div>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Save</button>
                        <input type="hidden" name="type" value = "edit">
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    