    <?php echo $tab_language ?>
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
            <h3 class="kt-portlet__head-title">
                Management Page <?php echo $row->title ?>
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <form method="post" action="<?php echo base_url('proweb/pages_item/update/' . $row->id); ?>" enctype="multipart/form-data" class="form-send">
            <?php
            foreach ($menu_list as $val){
                if ($row->type === 'checkout') {
                    foreach ($val['checkout']['sub_menu'] as $key => $val1) {
                        if ($key === 'checkout_page' || $key === 'checkout_payment'){
                            foreach ($val1['form_input'] as $key2 => $val2) {
                                $show[$key2] = $val2;
                            }
                        }
                    }
                } else {
                    foreach ($val[$row->type] as $key => $val1) {
                        if ($key == 'form_input') {
                            foreach ($val1 as $key2 => $val2) {
                                $show[$key2] = $val2;
                            }
                        }
                    }
                }
            }
            ?>

            <input type="hidden" name="type" value="<?php echo $type ?>">
            <?php if ($show['judul_top_menu']) { ?>
            <div class="form-group">
                <label for="exampleSelect1">Title Top Menu</label>
                <textarea class="form-control" name="title_menu"><?php echo $row->title_menu ?></textarea>
            </div>
            <?php } ?>

            <?php if ($show['judul_halaman']) { ?>
            <div class="form-group">
                <label for="exampleSelect1">Page Title</label>
                <textarea class="form-control" name="title"><?php echo $row->title ?></textarea>
            </div>
            <?php } ?>

            <?php if ($show['sub_judul']) { ?>
            <div class="form-group">
                <label for="exampleSelect1">Sub Judul</label>
                <textarea class="form-control" name="title_sub"><?php echo $row->title_sub ?></textarea>
            </div>
            <?php } ?>

            <?php if ($show['thumbnail']) { ?>
            <div class="form-group">
                <label for="exampleSelect1">Thumbnail</label>
                <br/>
                <img src="<?php echo $this->main->image_preview_url($row->thumbnail) ?>" class="img-thumbnail"
                     width="200">
                <br/><br/>
                <div class="custom-file">
                    <input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="thumbnail"
                           id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
            </div>
            <?php } ?>

            <?php if ($show['file']) { ?>
            <div class="form-group">
                <label for="exampleSelect1">File</label>
                <br/>
                <div class="custom-file">
                    <input type="file" class="custom-file-input browse-preview-img" name="file" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    <?php if ($row->file) { ?>
                        <br/>
                        <br/>
                        <a href="<?php echo $this->main->image_preview_url($row->file) ?>" target="_blank"
                           class="btn btn-success">Download File</a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <?php if ($show['description']) { ?>
            <div class="form-group" style="margin-left: 20px; margin-right: 20px">
                <label>Description</label>
                <textarea class="tinymce" id="exampleTextarea" rows="3" name="description"><?php echo $row->description ?></textarea>
            </div>
            <?php } ?>

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

            <?php if ($show['status_sub_konten']) { ?>
            <div class="form-group">
                <label for="exampleSelect1">Status Simple Sub Content</label>
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
            <div class="data-1-wrapper">
                <h4>Adding Item Data</h4>
                <div class="data-1-wrapper">
                    <ol>
                        <?php
                        $row_data_1 = json_decode($row->data_1, TRUE);
                        foreach ($row_data_1['id'] as $key => $data) { ?>
                            <li>
                                <div class="form-group">
                                    <label for="exampleSelect1">Item</label>
                                    <select class="form-control" name="data_1[id][]">
                                        <?php
                                            foreach ($items as $item) {
                                                if ($item->id == $data) {
                                            ?>
                                            <option value="<?php echo $item->id?>" selected><?php echo $item->title?></option>
                                                <?php
                                                } else {
                                                ?>
                                            <option value="<?php echo $item->id?>"><?php echo $item->title?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
<!--                                    <textarea class="form-control"-->
<!--                                              name="data_1[id][]">--><?php //echo $data ?><!--</textarea>-->
                                </div>
<!--                                <div class="form-group">-->
<!--                                    <label for="exampleSelect1">Deskripsi</label>-->
<!--                                    <textarea class="form-control"-->
<!--                                              name="data_1[description][]">--><?php //echo $row_data_1['description'][$key] ?><!--</textarea>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label for="exampleSelect1">Nama Gambar</label>-->
<!--                                    <textarea class="form-control"-->
<!--                                              name="data_1[images][]">--><?php //echo $row_data_1['images'][$key] ?><!--</textarea>-->
<!---->
<!--                                </div>-->
                                <button type="button" class="btn btn-danger btn-data-1-hapus">Hapus</button>
                                <br/>
                                <br/>
                                <br/>
                            </li>
                        <?php } ?>
                    </ol>
                </div>
                <button type="button" class="btn btn-success btn-data-1-tambah">Tambah Data</button>
            </div>
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
            <label for="exampleSelect1">Item</label>
            <select class="form-control" name="data_1[id][]">
                <?php foreach ($items as $item) { ?>
                    <option value="<?php echo $item->id?>"><?php echo $item->title?></option>
                <?php } ?>
            </select>
        </div>
<!--        <div class="form-group">-->
<!--            <label for="exampleSelect1">Description</label>-->
<!--            <textarea class="form-control" name="data_1[description][]"></textarea>-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="exampleSelect1">Add Picture</label>-->
<!--            <textarea class="form-control" name="data_1[images_edit][]"></textarea>-->
<!---->
<!--        </div>-->
        <button type="button" class="btn btn-danger btn-data-1-hapus">Remove</button>
        <br/>
        <br/>
        <br/>
    </li>
</div>
