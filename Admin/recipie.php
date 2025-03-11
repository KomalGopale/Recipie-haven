<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once '../Models/CommonModel.php';

$model = new CommonModel();
$table1 = 'recipie';
$table2 = 'category';
$joinCondition = 'recipie.category_id = category.id';
$whereCondition = 'category.active = 1';

$recipie_data = $model->getInnerJoinRecords($table1, $table2, $joinCondition, $whereCondition);

?>
<!-- Begin Page Content -->
<div class="container-fluid">

<?php require_once './includes/confirm_alert.php'?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Recipie</h1>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank"
        href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Recipies</h6>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Time</th>
                    <th>Servings</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($recipie_data as $recipie) {
                ?>
                <tr>
                    <td><?php echo $recipie['id']; ?></td>
                    <td><?php echo $recipie['name']; ?></td>
                    <td><?php echo $recipie['category']; ?></td>
                    <td><?php echo $recipie['time']; ?></td>
                    <td><?php echo $recipie['servings']; ?></td>
                    <td>
                        <img src="./uploads/recipie/<?php echo $recipie['recipie_image']; ?>" 
                        alt="<?php echo $recipie['recipie_image']; ?>" width="100" height="100">
                    </td>
                    <td>
                        <a href="toggle_status.php?id=<?php echo $recipie['id']; ?>&status=<?php echo $recipie['active']; ?>&table=recipie" 
                            class="btn btn-sm <?php echo ($recipie['active'] == 1) ? 'btn-success' : 'btn-danger'; ?>">
                            <?php echo ($recipie['active'] == 1) ? 'Published' : 'Unpublished'; ?>
                        </a>
                    </td>
                    <td class="d-flex justify-content-around" style="border-bottom: none !important;">
                        <a href="add_recipie.php?id=<?php echo $recipie['id']; ?>" class="text-primary">
                        <i class="far fa-edit"></i>
                        </a>
                        <a href="delete_recipie.php?id=<?php echo $recipie['id']; ?>" class="text-danger " onclick="return confirm('Are you sure you want to delete this recipe?');">
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