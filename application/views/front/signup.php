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
                    <li class="breadcrumb-item"><a href="<?php echo site_url() ?>" title="<?php echo $home->title; ?>"><?php echo $home->title; ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title; ?></li>
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
                                <h3><?php echo $dict_signup->title; ?></h3>
                            </div>
                            <form method="post" action="<?php echo site_url('signup/create') ?>" class="form-send" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" required="" class="form-control" name="name" placeholder="<?php echo $dict_signup_placeholder_name ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" required="" class="form-control" name="email" placeholder="<?php echo $dict_signup_placeholder_email ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required="" type="text" name="phone" placeholder="<?php echo $dict_signup_placeholder_phone ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required="" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required="" type="password" name="password_confirm" placeholder="<?php echo $dict_signup_placeholder_confirm ?>">
                                </div>
                                <div class="form-group">
                                    <?php echo $captcha ?>
                                    <input class="form-control mt-3" required="" type="text" name="captcha" placeholder="Captcha">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="register"><?php echo $dict_signup_button_register ?></button>
                                </div>
                            </form>
                            <div class="different_login">
                                <span> or</span>
                            </div>
                            <div class="form-note text-center"><?php echo $dict_signup_sign_have_account ?> <a href="<?php echo site_url('login') ?>" title="Log in">Log in</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>