<?php
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once '../Models/CommonModel.php';
$model = new CommonModel();
@$id = $_GET['id'];
if (isset($id)) {
    $recipie_data = $model->getRecordWhere('recipie', 'id', $id);
}
$category_data = $model->getAllRecordsByFields('category', ['category_name'], ['active' => 1]);
?>
<div class="container-fluid">

<?php require_once './includes/confirm_alert.php'?>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Recipie</h1>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Recipie</h6>
                </div>
                <div class="card-body">
                <form id = "add-recipie" method = "POST" action = "./controllers/RecipieController.php" enctype="multipart/form-data">                        <input type="hidden" name="category_id" value="<?php echo isset($cat_val[0]['id']) ? $cat_val[0]['id'] : '' ?>">
                <input type="hidden" name="recipie_id" value="<?php echo isset($recipie_data[0]['id']) ? $recipie_data[0]['id'] : '' ?>">
                    <div class="form-group">
                        <label for="recipie_name">Recipie Name</label>
                        <input type="text" class="form-control" id="recipie_name" name = "recipie_name" value = "<?php echo isset($recipie_data[0]['name']) ? $recipie_data[0]['name'] : '' ?>" required>
                    </div>
                    <div class="form-group" id="ingredient-fields">
                        <label for="cook-steps">Ingredients</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ingredient</th>
                                        <th>Quantity</th>
                                        <th style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ingredient-table">
                                <?php $ingredients = isset($recipie_data[0]['ingredients']) ? json_decode($recipie_data[0]['ingredients'], true) : [];
                                    if($ingredients){
                                        $i = 1;
                                        foreach($ingredients as $ingredient => $quantity){ ?>
                                            <tr>
                                                <td><input type="text" name="ingredients[]" class="form-control" placeholder="Enter ingredient" value = "<?php echo isset($ingredient) ? $ingredient: '';?>" required></td>
                                                <td><input type="text" name="quantity[]" class="form-control" placeholder="Enter quantity" value = "<?php echo isset($quantity) ? $quantity: '';?>" required></td>
                                                <?php if($i == 1) { ?>
                                                    <td><button type="button" class="btn btn-primary add-row">+</button></td>
                                                <?php } else { ?>
                                                    <td><button type="button" class="btn btn-danger add-row">-</button></td>
                                                <?php } $i++; ?>
                                            </tr>
                                        <?php } 
                                    } else { ?>
                                        <tr>
                                            <td><input type="text" name="ingredients[]" class="form-control" placeholder="Enter ingredient" required></td>
                                            <td><input type="text" name="quantity[]" class="form-control" placeholder="Enter quantity" required></td>
                                            <td><button type="button" class="btn btn-primary add-row">+</button></td>
                                        </tr>
                                    <?php } 
                                ?>
                                </tbody>
                            </table>
                    </div>
                    <div class="form-group">
                        <label for="cook-steps">Cooking Steps</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Step Number</th>
                                    <th style="width: 80%;">Description</th>
                                    <th style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="steps-table">
                                <?php
                                    $steps = isset($recipie_data[0]['steps']) ? json_decode($recipie_data[0]['steps'], true) : [];
                                    if($steps){
                                        $i = 1;
                                        foreach($steps as $step){ ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><textarea name="steps[]" class="form-control" rows="1" placeholder="Enter step" required><?= htmlspecialchars($step); ?></textarea></td>
                                                <?php if($i == 1){ ?>
                                                    <td><button type="button" class="btn btn-primary add-step">+</button></td>
                                                <?php } else { ?>
                                                    <td><button type="button" class="btn btn-danger remove-step">-</button></td>
                                                <?php } $i++; ?>
                                            </tr>
                                        <?php }
                                    } else {
                                        ?>
                                            <tr>
                                                <td>1</td>
                                                <td><textarea name="steps[]" class="form-control" rows="1" placeholder="Enter step" required></textarea></td>
                                                <td><button type="button" class="btn btn-primary add-step">+</button></td>
                                            </tr>
                                        <?php 
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <select class="custom-select" id="category" name="category" required>
                                <option selected value="">Choose...</option>
                                <?php
                                    foreach ($category_data as $category) {
                                        $selected = (isset($recipie_data[0]['category']) && $category == $recipie_data[0]['category']) ? 'selected' : '';
                                        echo "<option value=\"$category\" $selected>$category</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time">Cooking Time (In Minutes)</label>
                            <input type="number" class="form-control" id="time" name="time" required value = "<?php echo isset($recipie_data[0]['time']) ? $recipie_data[0]['time'] : '' ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="servings">No Of Servings</label>
                            <input type="number" class="form-control" id="servings" name="servings" required value = "<?php echo isset($recipie_data[0]['servings']) ? $recipie_data[0]['servings'] : '' ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipie_image">Choose Recipie Image</label>
                            <input type="file" class="form-control-file mt-2" id="recipie_image" name="recipie_image" value = "<?php echo isset($recipie_data[0]['id']) ? $recipie_data[0]['id'] : '' ?>">
                            <input type="hidden" name="recipie_image" value="<?php echo isset($recipie_data[0]['recipie_image'])? $recipie_data[0]['recipie_image']:'' ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <?php if(isset($recipie_data[0]['recipie_image'])){ ?>
                            <label for="recipie_image">Uploaded Image</label>
                            <img src="<?php echo './uploads/recipie/' . $recipie_data[0]['recipie_image']; ?>" width = "100" height = "100" alt="">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group d-flex">
                        <label for="active">Publish</label>
                        <div class="ml-4 custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" <?php echo (isset($recipie_data[0]['active']) && $recipie_data[0]['active'] == 1)? "checked" : '';?> value="1">
                            <label class="custom-control-label" for="active"></label>
                        </div>
                    </div>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once 'includes/footer.php'; ?>

<script>
       //ingredients    
        $(document).ready(function(){
            $(".add-row").click(function(){
                let newRow = `<tr>
                    <td><input type="text" name="ingredients[]" class="form-control" placeholder="Enter ingredient" required></td>
                    <td><input type="text" name="quantity[]" class="form-control" placeholder="Enter quantity" required></td>
                    <td><button type="button" class="btn btn-danger remove-row">-</button></td>
                </tr>`;
                $("#ingredient-table").append(newRow);
            });

            $(document).on("click", ".remove-row", function(){
                $(this).closest("tr").remove();
            });
        });

        // steps
        $(document).ready(function(){
            let stepCount = 1;

            $(".add-step").click(function(){
                stepCount++;
                let newRow = `<tr>
                    <td>${stepCount}</td>
                    <td><textarea name="steps[]" class="form-control" rows="1" placeholder="Enter step" required></textarea></td>
                    <td><button type="button" class="btn btn-danger remove-step">-</button></td>
                </tr>`;
                $("#steps-table").append(newRow);
            });

            $(document).on("click", ".remove-step", function(){
                $(this).closest("tr").remove();
                stepCount--;
                updateStepNumbers();
            });

            function updateStepNumbers() {
                $("#steps-table tr").each(function(index) {
                    $(this).find("td:first").text(index + 1);
                });
            }
        });
    </script>