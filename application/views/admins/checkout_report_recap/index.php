<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
            <h3 class="kt-portlet__head-title">
                Rekap Laporan Penjualan <?php echo $row->title; ?>
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <form method="post" action="<?php echo base_url('proweb/checkout_report_recap/print_report_recap'); ?>" enctype="multipart/form-data" class="">
<!--            <input type="hidden" name="type" value="--><?php //echo $type ?><!--">-->

            <div class="form-group">
                <div class="row justify-content-center">
                    <div class="form-group col-3">
                        <label for="TanggalDari">Tanggal Dari</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" name="date_from">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-3">
                        <label for="TanggalSampai">Tanggal Sampai</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" name="date_to">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-success btn-pill btn-lg margin-0-auto">Print</button>
                </div>
            </div>
        </form>
    </div>
</div>