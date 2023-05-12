<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title_menu; ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>" title="<?php echo $home->title_menu; ?>"><?php echo $home->title_menu; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title_menu; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3><?php echo $page->title; ?></h3>
                            </div>
                            <form method="post" action="<?php echo site_url('user-profile/process-reset-password') ?>" enctype="multipart/form-data" class="form-send">
                                <div class="form-group">
                                    <input type="password" required="" class="form-control" id="bioPassword" name="password" placeholder="<?php echo $dict_reset_password_placeholder_1 ?>">
                                    <span toggle="#bioPassword" class="fa fa-fw fa-eye field-icon toggle-password">
                                    <input type="hidden" name="id" value="<?php echo $member->id ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required="" type="password" id="bioPasswordConfirm" name="password_confirm" placeholder="<?php echo $dict_reset_password_placeholder_2 ?>">
                                    <span toggle="#bioPasswordConfirm" class="fa fa-fw fa-eye field-icon toggle-password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login"><?php echo $dict_reset_password_submit ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>