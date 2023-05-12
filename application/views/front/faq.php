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
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="heading_s1 mb-3 mb-md-5">
                        <h3><?php echo $page->title ?></h3>
                    </div>
                    <div id="accordion" class="accordion accordion_style1">
                        <?php $data_1 = json_decode($page->data_1, TRUE); ?>
                        <?php foreach ($data_1['title'] as $key => $title) { ?>
                        <div class="card">
                            <div class="card-header" id="heading-<?php echo $key ?>">
                                <h6 class="mb-0"><a class="collapsed" data-toggle="collapse" href="#collapse-<?php echo $key ?>" aria-expanded="false" aria-controls="collapse-<?php echo $key ?>" title="<?php echo $title ?>"><?php echo $title ?></a></h6>
                            </div>
                            <div id="collapse-<?php echo $key ?>" class="collapse" aria-labelledby="heading-<?php echo $key ?>" data-parent="#accordion">
                                <div class="card-body">
                                    <p><?php echo $data_1['description'][$key] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>