<?php 
require_once 'Public/Includes/header.php';
require_once 'Models/CommonModel.php';

//get all data from category table
$model = new CommonModel();
$category_data = $model->getRecordWhere('category', 'active', '1', ['id', 'category_name', 'category_img']);

// echo "<pre>" . print_r($category_data, true); 

?>
 
 <!-- ##### Best Category Area Start ##### -->
 <section class="best-receipe-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>The best Categories</h3>
                    </div>
                </div>
            </div>

            <div class="row">

                <!-- Single Best Category Area -->

                <?php 
                    foreach($category_data as $category){
                    
                    ?> <div class="col-12 col-sm-6 col-lg-4">
                        <div class="single-best-receipe-area mb-30">
                        <a href="category-detail.php?id=<?php echo $category['id'];?>"><img src="./Admin/uploads/category/<?php echo $category['category_img'];?>" alt=""></a>
                            <div class="receipe-content">
                                <a href="category-detail.php?id=<?php echo $category['id'];?>">
                                    <h5><?php echo $category['category_name'];?></h5>
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
                    
                <?php  }?>
                
            </div>
        </div>
    </section>
    <!-- ##### Best Receipe Area End ##### -->

<?php  require_once 'Public/Includes/footer.php' ?>