<?php 
require_once 'Public/Includes/header.php';
require_once 'Models/CommonModel.php';
$model = new CommonModel();
@$id = $_GET['id'];

if (isset($id)) {
    $category_data = $model->getRecordWhere('category', 'id', $id);
    $recipie_data = $model->getRecordWhere('recipie', 'category_id', $id );
    $category_data = $category_data[0];
}


?>

<!-- ##### Best Receipe Area Start ##### -->
<section class="best-receipe-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h3>Recipies for <?php echo $category_data['category_name'];?></h3>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Single Best Receipe Area -->

            <?php 
                if(empty($recipie_data)){
                    ?>
                    <div class="section-heading col-12">
                        <h6>No recipies found for this category</h6>
                    </div>
                    <?php
                }else{
                    foreach ($recipie_data as $recipie) {
                    ?> <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <a href="recipie-detail.php?id=<?php echo $recipie['id']; ?>"><img src="./Admin/uploads/recipie/<?php echo $recipie['recipie_image']; ?>" alt="<?php echo $recipie['recipie_image']; ?>"></a>
                                <input type="hidden" name="recipie-id" value="<?php echo $recipie['id']; ?>">
                                <div class="receipe-content">
                                    <a href="recipie-detail.php?id=<?php echo $recipie['id']; ?>">
                                        <h5><?php echo $recipie['name']; ?></h5>
                                    </a>
                                    <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  } 
                }   
            ?>
        </div>
    </div>
</section>
<!-- ##### Best Receipe Area End ##### -->

<?php  require_once 'Public/Includes/footer.php' ?>