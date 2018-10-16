    <style type="text/css">
    section {
      padding: 8rem 0;
    }

    .section-heading {
      margin-top: 0;
    }

    ::-moz-selection {
      color: #fff;
      background: #212529;
      text-shadow: none;
    }

    ::selection {
      color: #fff;
      background: #212529;
      text-shadow: none;
    }

    img::-moz-selection {
      color: #fff;
      background: transparent;
    }

    img::selection {
      color: #fff;
      background: transparent;
    }

    img::-moz-selection {
      color: #fff;
      background: transparent;
    }

    .portfolio-box {
      position: relative;
      display: block;
      max-width: 650px;
      margin: 0 auto;
    }

    .portfolio-box .portfolio-box-caption {
      position: absolute;
      bottom: 0;
      display: block;
      width: 100%;
      height: 100%;
      text-align: center;
      opacity: 0;
      color: #fff;
      background: rgba(240, 95, 64, 0.9);
      -webkit-transition: all 0.2s;
      transition: all 0.2s;
    }

    .portfolio-box .portfolio-box-caption .portfolio-box-caption-content {
      position: absolute;
      top: 50%;
      width: 100%;
      -webkit-transform: translateY(-50%);
      transform: translateY(-50%);
      text-align: center;
    }

    .portfolio-box .portfolio-box-caption .portfolio-box-caption-content .project-category,
    .portfolio-box .portfolio-box-caption .portfolio-box-caption-content .project-name {
      padding: 0 15px;
      font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;
    }

    .portfolio-box .portfolio-box-caption .portfolio-box-caption-content .project-category {
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .portfolio-box .portfolio-box-caption .portfolio-box-caption-content .project-name {
      font-size: 18px;
    }

    .portfolio-box:hover .portfolio-box-caption {
      opacity: 1;
    }

    .portfolio-box:focus {
      outline: none;
    }
    .max{
      width: 100%;
    }

    @media (min-width: 768px) {
      .portfolio-box .portfolio-box-caption .portfolio-box-caption-content .project-category {
        font-size: 16px;
      }
      .portfolio-box .portfolio-box-caption .portfolio-box-caption-content .project-name {
        font-size: 22px;
      }
    }

  </style>
  <div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
      <div class="page-title clearfix">
        <h1><?php echo lang('orders'); ?></h1>
      </div>

      <section class="p-0" id="portfolio">
        <div class="container-fluid p-0">
          <div class="row no-gutters popup-gallery">
            <?php 
            if(!empty($categories))
            {
              foreach ($categories as $category) { 
                $image_path = base_url('files/category_images/').$category['image'];
                $page_path = get_uri('orders/subCategory/').$category['id'];
                ?>
                <div class="col-lg-3 col-sm-6">
                  <a class="portfolio-box" href="<?php echo $page_path; ?>">
                    <img class="img-fluid max" src="<?php echo  $image_path; ?>" alt="category">
                    <div class="portfolio-box-caption">
                      <div class="portfolio-box-caption-content">
                        <div class="project-category text-faded">

                        </div>
                        <div class="project-name">
                          <?php echo $category['name']; ?>
                        </div>
                      </div>
                    </div>
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
