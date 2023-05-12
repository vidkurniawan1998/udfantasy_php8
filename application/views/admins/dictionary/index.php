<form class="form-send" method="post" action="<?php echo base_url('proweb/dictionary/update') ?>">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
                <h3 class="kt-portlet__head-title">
                    Management Kamus Web
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th width="20">No</th>
                    <th width="300" class="text-center">Variabel Kamus</th>
                    <?php foreach ($language as $row) { ?>
                        <th class="text-center">
                            <img src="<?php echo $this->main->image_preview_url($row->thumbnail) ?>" width="40"><br/>
                            <?php echo $row->title ?>
                        </th>
                    <?php } ?>
                </tr>
                </thead>
                <?php foreach ($dictionary as $key => $row) { ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td><?php echo $row->dict_variable ?></td>

                        <?php foreach ($language as $row_language) {
                            $dict_word = $this->db
                                ->where(array('id_language' => $row_language->id, 'dict_variable' => $row->dict_variable))
                                ->get('dictionary')
                                ->row()
                                ->dict_word;
                            ?>
                            <td>
                                <input type="text" class="form-control"
                                       name="dict_word[<?php echo $row->dict_variable ?>][<?php echo $row_language->id ?>]"
                                       value="<?php echo $dict_word ?>">
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
    <button type="submit" class="btn btn-success btn-elevate btn-pill btn-elevate-air btn-lg btn-floating">Simpan</button>
</form>