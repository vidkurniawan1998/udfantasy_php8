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
                    <li class="breadcrumb-item active"><?php echo $page->title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="term_conditions">
                        <?php echo $page->description ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>