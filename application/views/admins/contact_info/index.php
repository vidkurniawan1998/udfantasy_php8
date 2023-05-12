<?php echo $tab_language ?>
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
            <h3 class="kt-portlet__head-title">
                Management Contact Info
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <form method="post" action="<?php echo base_url('proweb/contact_info/update'); ?>"
              enctype="multipart/form-data"
              class="form-send">

            <?php foreach ($contact_info as $info) { ?>
                <?php if ($info->type == 'phone') { ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"><?php echo $info->title; ?></label>
                            <input type="hidden" name="id[]" value="<?php echo $info->id; ?>">
                            <input type="hidden" name="type[]" value="<?php echo $info->type; ?>">
                            <textarea class="form-control" name="description[]"><?php echo $info->description; ?></textarea>
                            <?php if ($info->type == 'google_maps'){ ?>
                                <span style="color:red">insert only the contect of the "src" from the embeded maps code</span>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleSelect1">Use Phone</label>
                            <select class="form-control" name="use[]">
                                <?php if ($info->use == 'yes'){ ?>
                                    <option value="yes" selected>Yes</option>
                                    <option value="no">No</option>
                                <?php } else { ?>
                                    <option value="yes">Yes</option>
                                    <option value="no" selected>No</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleSelect1">Use Text</label>
                            <input type="hidden" name="id_text" value="<?php echo $phone_text_use->id; ?>">
                            <select class="form-control" name="use_text">
                                <?php if ($phone_text_use->use == 'yes'){ ?>
                                    <option value="yes" selected>Yes</option>
                                    <option value="no">No</option>
                                <?php } else { ?>
                                    <option value="yes">Yes</option>
                                    <option value="no" selected>No</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php } else if($info->type != 'phone_text_link' && $info->type != 'whatsapp_link' && $info->type != 'email_link' && $info->type != 'phone_link') { ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1"><?php echo $info->title; ?></label>
                            <input type="hidden" name="id[]" value="<?php echo $info->id; ?>">
                            <input type="hidden" name="type[]" value="<?php echo $info->type; ?>">
                            <?php if ($info->type == 'line_link') { ?>
                                <textarea class="form-control" name="description[]"><?php echo str_replace('http://line.me/ti/p/~','', $info->description); ?></textarea>
                            <?php } else { ?>
                                <textarea class="form-control" name="description[]"><?php echo $info->description; ?></textarea>
                            <?php } ?>
                            <?php if ($info->type == 'google_maps'){ ?>
                                <span style="color:red">insert only the content of the "src" from the embeded maps code</span>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleSelect1">Use</label>
                            <select class="form-control" name="use[]">
                                <?php if ($info->use == 'yes'){ ?>
                                    <option value="yes" selected>Yes</option>
                                    <option value="no">No</option>
                                <?php } else { ?>
                                    <option value="yes">Yes</option>
                                    <option value="no" selected>No</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <br/><br/>
            <br/><br/>
            <br/><br/>
            <button type="submit" class="btn btn-success btn-elevate btn-pill btn-elevate-air btn-lg btn-floating">
                Simpan
            </button>
        </form>
    </div>
</div>

<div class="data-1-data hide">
    <li>
        <div class="form-group">
            <label for="exampleSelect1">Judul</label>
            <textarea class="form-control" name="data_1[title][]"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleSelect1">Deskripsi</label>
            <textarea class="form-control" name="data_1[description][]"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleSelect1">Nama Gambar</label>
            <textarea class="form-control" name="data_1[images_edit][]"></textarea>

        </div>
        <button type="button" class="btn btn-danger btn-data-1-hapus">Hapus</button>
        <br/>
        <br/>
        <br/>
    </li>
</div>
