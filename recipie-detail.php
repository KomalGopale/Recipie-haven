<?php 
require_once 'Public/Includes/header.php';
require_once 'Models/CommonModel.php';
$model = new CommonModel();
@$id = $_GET['id'];

if (isset($id)) {
    $recipie_data = $model->getRecordWhere('recipie', 'id', $id );
    $recipie_data = $recipie_data[0];
    $steps = json_decode($recipie_data['steps'], true);
    $ingredients = json_decode($recipie_data['ingredients'], true);
}

?>

  <!-- ##### Breadcumb Area Start ##### -->
  <div class="breadcumb-area bg-img bg-overlay" style="background-image: url(Public/img/bg-img/breadcumb3.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-text text-center">
                        <h2>Recipe</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <div class="receipe-post-area section-padding-80">
        <!-- Receipe Slider -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="receipe-slider owl-carousel">
                    <img src="./Admin/uploads/recipie/<?php echo $recipie_data['recipie_image'];?>" alt="<?php echo $recipie_data['recipie_image'];?>">
                        <!-- <img src="Public/img/bg-img/bg5.jpg" alt="">
                        <img src="Public/img/bg-img/bg5.jpg" alt=""> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Receipe Content Area -->
        <div class="receipe-content-area">
            <div class="container">

                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <h2><?php echo $recipie_data['name']?></h2>
                            <div class="receipe-duration">
                                <h6>Cooking time : <?php echo $recipie_data['time']?> minutes</h6>
                                <h6>Yields : <?php echo $recipie_data['servings']?> servings</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="receipe-ratings text-right my-5">
                            <div class="ratings">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>
                            <a href="#" class="btn delicious-btn">For Begginers</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <?php
                            $i = 1; 
                            foreach($steps as $step){
                                ?> 
                                <div class="single-preparation-step d-flex">
                                    <h4><?php echo $i++; ?>.</h4>
                                    <p><?php echo $step; ?></p>
                                </div>
                                <?php
                            }
                        ?>
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4">
                        <div class="ingredients">
                            <h4>Ingredients</h4>
                            <?php 
                            foreach($ingredients as $ingredient => $quantity){
                                ?>
                                    <!-- Custom Checkbox -->
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1"><?php echo $quantity; ?>&nbsp;<?php echo $ingredient; ?></label>
                                    </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="section-heading text-left">
                            <h3>Leave a comment</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="contact-form-area">
                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="email" class="form-control" id="email" placeholder="E-mail">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn delicious-btn mt-30" type="submit">Post Comments</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php  require_once 'Public/Includes/footer.php' ?>