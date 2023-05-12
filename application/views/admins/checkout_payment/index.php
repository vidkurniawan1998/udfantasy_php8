<?php echo $tab_language ?>
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
            <h3 class="kt-portlet__head-title">
                Management Page <?php echo $row->title; ?>
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body" style="overflow-x:auto;">

        <form method="post" action="<?php echo base_url('proweb/checkout_payment/update/' . $row->id); ?>" enctype="multipart/form-data" class="form-send">
            <input type="hidden" name="type" value="<?php echo $type ?>">

            <div class="form-group">
                <label for="exampleSelect1">Title Top Menu</label>
                <textarea class="form-control" name="title_menu"><?php echo $row->title_menu ?></textarea>
            </div>

            <div class="form-group">
                <label for="exampleSelect1">Title Page</label>
                <textarea class="form-control" name="title"><?php echo $row->title ?></textarea>
            </div>

            <div class="form-group">
                <label for="exampleSelect1">Sub Title</label>
                <textarea class="form-control" name="title_sub"><?php echo $row->title_sub ?></textarea>
            </div>

            <div class="form-group">
                <label for="exampleSelect1">Bank Account</label>
                <br/>
                <span class="kt-switch kt-switch--lg kt-switch--icon">
                    <label>
                        <input type="checkbox"
                               class="data-1-status" <?php echo $row->data_1_status == 'yes' ? 'checked="checked"' : ''; ?> value="yes"
                               name="data_1_status">
                        <span></span>
                    </label>
                </span>
            </div>

            <div class="form-group">
                <div class="data-1-wrapper">
                    <h4>Add Bank Account</h4>
                    <div class="data-1-wrapper">
                        <ol>
                            <?php $row_data_1 = json_decode($row->data_1, TRUE); ?>

                            <?php
                            foreach ($row_data_1['account_number'] as $key => $title) { ?>
                                <li>
                                    <div class="form-group">
                                        <label for="exampleSelect1">Bank Name</label>
                                        <input class="form-control" name="data_1[bank_name][]" value="<?php echo $row_data_1['bank_name'][$key] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelect1">Bank Account Number</label>
                                        <input class="form-control" name="data_1[account_number][]" value="<?php echo $row_data_1['account_number'][$key] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelect1">Under the Name of</label>
                                        <input class="form-control" name="data_1[under_behalf][]" value="<?php echo $row_data_1['under_behalf'][$key] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelect1">Bank Logo</label>
                                        <br/>
                                        <img src="<?php echo $this->main->image_preview_url($row_data_1['images'][$key]) ?>" class="img-thumbnail" width="200">
                                        <br/><br/>
                                            <input type="hidden" name="images_old[]" value="<?php echo $row_data_1['images'][$key] ?>">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="images[]" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        <span class="form-text text-muted"><?php if (!empty($show['status_sub_gambar_note'])) { echo $show['status_sub_gambar_note']; } ?></span>
                                    </div>

                                    <button type="button" class="btn btn-danger btn-data-1-hapus">Remove</button>
                                    <br/>
                                    <br/>
                                    <br/>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                    <button type="button" class="btn btn-success btn-data-1-tambah">Add Data</button>
                </div>
            </div>

            <div class="form-group">
                <label for="exampleSelect1">Status SEO</label>
                <br/>
                <span class="kt-switch kt-switch--lg kt-switch--icon">
                    <label>
                        <input type="checkbox"
                               class="status-seo" <?php echo $row->status_seo == 'yes' ? 'checked="checked"' : ''; ?> value="yes"
                               name="status_seo">
                        <span></span>
                    </label>
                </span>
            </div>

            <div class="status-seo-wrapper">
                <div class="form-group">
                    <label for="exampleSelect1">Meta title</label>
                    <input type="text" class="form-control" value="<?php echo $row->meta_title ?>" name="meta_title">
                </div>
                <div class="form-group">
                    <label for="exampleSelect1">Meta Description</label>
                    <input type="text" class="form-control" value="<?php echo $row->meta_description ?>"
                           name="meta_description">
                </div>
                <div class="form-group">
                    <label for="exampleSelect1">Meta Keywords</label>
                    <input type="text" class="form-control" value="<?php echo $row->meta_keywords ?>"
                           name="meta_keywords">
                </div>
            </div>

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
            <label for="exampleSelect1">Bank Name</label>
            <input class="form-control" name="data_1[bank_name][]">
        </div>

        <div class="form-group">
            <label for="exampleSelect1">Bank Account Number</label>
            <input class="form-control" name="data_1[account_number][]">
        </div>

        <div class="form-group">
            <label for="exampleSelect1">Under the Name of</label>
            <input class="form-control" name="data_1[under_behalf][]">
        </div>

        <div class="form-group">
            <label for="exampleSelect1">Bank Logo</label>
            <br/>
            <img src="" class="img-thumbnail" width="200">
            <br/><br/>
                <input type="hidden" name="images_old[]" value="">
            <div class="custom-file">
                <input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="images[]" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
        </div>

        <button type="button" class="btn btn-danger btn-data-1-hapus">Remove</button>
        <br/>
        <br/>
        <br/>
    </li>
</div>
