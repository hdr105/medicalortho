
<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('orders'); ?></h1>
        </div>

        <section class="p-0" id="portfolio">
            <div class="container-fluid p-0">
                <div class="row no-gutters popup-gallery">
                    <?php 
                    if(!empty($subCategories)){
                    foreach ($subCategories as $category) { 
                        $image_path = base_url('files/category_images/').$category['image'];
                        $page_path = get_uri('orders/products/').$category['id'];
                       
                    ?>

                    <div class="col-lg-3 col-sm-6">
                        <a class="portfolio-box" href="<?php echo $page_path; ?>">
                            <img class="img-fluid max" src="<?php echo  $image_path; ?>" alt="category">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                </div>
                            </div>
                            <h5 class="text-center"><?php echo $category['name']; ?></h5>
                        </a>

                    </div>
                    <?php 
                  } 
                }
                else
                {
                  echo "no records";
                }
                ?>

                </div>
            </div>
        </section>
    </div>
</div>
