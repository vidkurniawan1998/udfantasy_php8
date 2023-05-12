<?php echo $tab_language ?>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
            <h3 class="kt-portlet__head-title">
                Management Section Home Products by Category
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <form method="post" action="<?php echo base_url('proweb/home_products_by_category/update/' . $row->id); ?>" enctype="multipart/form-data" class="form-send">

            <input type="hidden" name="type" value="<?php echo $type ?>">
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
                                </div>
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
        <button type="button" class="btn btn-danger btn-data-1-hapus">Remove</button>
        <br/>
        <br/>
        <br/>
    </li>
</div>
