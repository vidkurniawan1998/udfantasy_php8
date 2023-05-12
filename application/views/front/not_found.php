<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>" title="<?php echo $home->title ?>"><?php echo $home->title ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title_sub ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section">
        <div class="error_wrap">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-10 order-lg-first">
                        <div class="text-center">
                            <div class="error_txt">404</div>
                            <h5 class="mb-2 mb-sm-3"><?php echo $dict_404_title_1 ?></h5>
                            <p><?php echo $dict_404_title_2 ?></p>
                            <a href="<?php echo site_url() ?>" class="btn btn-fill-out" title="<?php echo $dict_404_button_1 ?>"><?php echo $dict_404_button_1 ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>