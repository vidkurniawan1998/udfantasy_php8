<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title_sub ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>" title="<?php echo $home->title; ?>"><?php echo $home->title; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about_img scene mb-4 mb-lg-0">
                        <img src="<?php echo $this->main->image_preview_url($page->thumbnail); ?>" alt="<?php $page->meta_title; ?>"/>
                    </div>
                </div>
                <div class="col-lg-6 text-justify">
                    <div class="heading_s1">
                        <h2><?php echo $page->title_sub; ?></h2>
                    </div>
                    <?php echo $page->description; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($page->data_1_status == 'yes') { ?>
    <?php $data_1 = json_decode($page->data_1, TRUE); ?>
    <div class="section bg_light_blue2 pb_70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="heading_s1 text-center">
                        <h2><?php echo $data_1['title_section']; ?></h2>
                    </div>
                    <p class="text-center leads"> <?php echo $data_1['description_section'] ?> </p>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php foreach ($data_1['title'] as $key => $title) { ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="icon_box icon_box_style4 box_shadow1">
                        <div class="icon">
<!--                            <i class="ti-pencil-alt"></i>-->
                            <div class="background-icon">
                                <img src="<?php echo $this->main->image_preview_url($data_1['images'][$key]); ?>" alt="<?php if (!empty($data_1['images_edit'][$key])) { echo $data_1['images_edit'][$key]; } else { echo $title; } ?>" class="about-icon-data">
                            </div>
                        </div>
                        <div class="icon_box_content">
                            <h5><?php echo $title; ?></h5>
                            <p><?php echo $data_1['description'][$key]; ?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>

</div>