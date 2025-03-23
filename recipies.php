<?php
require_once 'Public/Includes/header.php';
require_once 'Models/CommonModel.php';

//get all data from recipie table
$model = new CommonModel();
$recipie_data = $model->getRecordWhere('recipie', 'active', '1', ['id', 'name', 'recipie_image']);

?>

<!-- ##### Best Receipe Area Start ##### -->
<section class="best-receipe-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h3>The best Receipies</h3>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Single Best Receipe Area -->
            <?php
            foreach ($recipie_data as $recipie) {
            ?> <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-best-receipe-area mb-30">
                        <a href="recipie-detail.php?id=<?php echo $recipie['id']; ?>"><img src="./Admin/uploads/recipie/<?php echo $recipie['recipie_image']; ?>" alt="<?php echo $recipie['recipie_image']; ?>"></a>
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
            <?php  } ?>
        </div>
    </div>
</section>
<!-- ##### Best Receipe Area End ##### -->

<?php require_once 'Public/Includes/footer.php' ?>