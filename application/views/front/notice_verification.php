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
                    <div class="checkout-payment">
                        <div class="checkout-timer text-center">
                            <span><p class="giant-icon"><i class="ion ionicons ion-alert-circled"></i></p></span>
                            <span><p>Pendaftaran Berhasil!<?php  //$dict_signup_verification_title_1 ?></p></span>
                            <span><p class="center-info-text">Mohon verifikasi akun anda! <br> Dengan mengklik link verifikasi akun yang telah kami kirim ke email pendaftaran anda!<?php  //$dict_signup_verification_title_1 ?></p></span>
                            <span><p class="small-info-text mt-4">Jika anda tidak mendapatkan email verifikasi dari kami. Klik <a href="<?php echo site_url('signup/resend_verification/'.$member->activation_token) ?>" class="process-link">link ini</a>, untuk mengirim ulang email verifikasi.</p></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>