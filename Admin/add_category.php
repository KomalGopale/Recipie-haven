<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once '../Models/CommonModel.php';
@$id = $_GET['id'];
if (isset($id)) {
    $model = new CommonModel();
    $cat_val = $model->getRecordWhere('category', 'id', $id);
}
?>

<div class="container-fluid">

    <?php require_once './includes/confirm_alert.php' ?>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Category</h1>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Category</h6>
                </div>
                <div class="card-body">
                    <form id="add-category" method="POST" action="./controllers/CategoryController.php" enctype="multipart/form-data">
                        <input type="hidden" name="category_id" value="<?php echo isset($cat_val[0]['id']) ? $cat_val[0]['id'] : '' ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo isset($cat_val[0]['category_name']) ? $cat_val[0]['category_name'] : ''; ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category_image">Choose Category Image</label>
                                <input type="file" class="form-control-file mt-2" id="category_image" name="category_image">
                                <input type="hidden" name="image_name" value="<?php echo isset($cat_val[0]['category_img'])? $cat_val[0]['category_img']:'' ?>">
                            </div>
                        </div>
                        <div class="form-group col-md-6 d-flex">
                            <label for="active">Publish</label>
                            <div class="ml-4 custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="active" name="active" <?php echo (isset($cat_val[0]['active']) && $cat_val[0]['active'] == 1)? "checked" : '';?> value="1">
                                <label class="custom-control-label" for="active"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <?php if(isset($cat_val[0]['category_img'])){ ?>
                            <img src="<?php echo './uploads/category/' . $cat_val[0]['category_img']; ?>" width = "100" height = "100" alt="">
                            <?php } ?>
                        </div>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                        <input type="hidden" name="type" value="add">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php' ?>