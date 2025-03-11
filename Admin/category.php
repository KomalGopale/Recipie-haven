<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once '../Models/CommonModel.php';

$model = new CommonModel();

$category_data = $model->getAllRecords('category');

?>
<!-- Begin Page Content -->
<div class="container-fluid">

<?php require_once './includes/confirm_alert.php'?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Category</h1>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All categories</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($category_data as $category){
                        ?>
                        <tr>
                            <td><?php echo $category['id']; ?></td>
                            <td><?php echo $category['category_name']; ?></td>
                            <td><img src="./uploads/category/<?php echo $category['category_img']; ?>" 
                            alt="<?php echo $category['category_img']; ?>" width="120" height="120"></td>
                            <td>
                                <a href="toggle_status.php?id=<?php echo $category['id']; ?>&status=<?php echo $category['active']; ?>&table=category" 
                                    class="btn btn-sm <?php echo ($category['active'] == 1) ? 'btn-success' : 'btn-danger'; ?>">
                                    <?php echo ($category['active'] == 1) ? 'Published' : 'Unpublished'; ?>
                                </a>
                            </td>
                            <td class="d-flex justify-content-around" style="border-bottom: none !important;">
                                <a href="add_category.php?id=<?php echo $category['id']; ?>" class="text-primary">
                                <i class="far fa-edit"></i>
                                </a>

                                <a href="delete_category.php?id=<?php echo $category['id']; ?>" class="text-danger " onclick="return confirm('Are you sure you want to delete this category?');">
                                <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php require_once 'includes/footer.php' ?>