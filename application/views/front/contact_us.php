<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><?php echo $page->title_menu ?></h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>" title="<?php echo $home->title_menu ?>"><?php echo $home->title_menu ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page->title_menu ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="main_content">

    <div class="section pb_70">
        <div class="container">
            <div class="row">
                <?php
                $block_contact = array('address','email','phone');
                $count_contact = 0;
                foreach ($block_contact as $check) {
                    if (!empty($contact_info[$check]) && !empty($contact_info[$check.'_link'])) {
                        $count_contact++;
                    }
                }
                $count_contact_xl = 12/$count_contact;

                if (!empty($contact_info['address']) && !empty($contact_info['address_link'])) {
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-map2"></i>
                        </div>
                        <div class="contact_text">
                            <span>Address</span>
                            <a href="<?php echo $contact_info['address_link'] ?>" title="Address"><p><?php echo $contact_info['address']; ?></p></a>
                        </div>
                    </div>
                </div>
                <?php
                }

                if (!empty($contact_info['email']) && !empty($contact_info['email_link'])) {
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-envelope-open"></i>
                        </div>
                        <div class="contact_text">
                            <span>Email Address</span>
                            <a href="<?php echo $contact_info['email_link'] ?>" title="Email"><?php echo $contact_info['email'] ?> </a>
                        </div>
                    </div>
                </div>
                <?php
                }

                if (!empty($contact_info['phone']) && !empty($contact_info['phone_link'])) {
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-tablet2"></i>
                        </div>
                        <div class="contact_text">
                            <span>Phone</span>
                            <a href="<?php echo 'tel:'.$contact_info['phone_link'] ?>" title="Phone"><p>+ 457 789 789 65</p></a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heading_s1">
                        <h2><?php echo $page->title; ?></h2>
                    </div>
                    <p class="leads"><?php echo $page->description; ?></p>
                    <div class="field_form">
                        <form method="post" action="<?php echo site_url('contact-us/send')?>" class="form-send">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input required placeholder="Enter Name *" class="form-control" name="name" type="text">
                                </div>
                                <div class="form-group col-md-6">
                                    <input required placeholder="Enter Phone No. *" class="form-control" name="phone">
                                </div>
                                <div class="form-group col-md-12">
                                    <input required placeholder="Enter Email *" class="form-control" name="email" type="email">
                                </div>
                                <div class="form-group col-md-12">
                                    <textarea required placeholder="Message *" class="form-control" name="message" rows="4"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <?php echo $captcha; ?>
                                    <input placeholder="Enter Captcha" class="form-control mt-3" name="captcha">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" title="Submit Your Message!" class="btn btn-fill-out" name="submit" value="Submit">Send Message</button>
                                </div>
                                <div class="col-md-12">
                                    <div id="alert-msg" class="alert-msg text-center"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 pt-2 pt-lg-0 mt-4 mt-lg-0">
                    <div class="map-holder">
                        <iframe src="<?php echo $contact_info['google_maps']; ?>" class="border-0" width="100%" height="410" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>