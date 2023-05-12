<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management Delivery Coverage
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
<!--					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm btn-create" data-toggle="modal"-->
<!--					   data-target="#modal-create">-->
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm btn-create">
						<i class="la la-plus"></i>
						Add Delivery Coverage
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
			<tr>
				<th class="d-none"></th>
				<th width="20">No</th>
				<th>District</th>
                <th>Price</th>
				<th width="130">Option</th>
			</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
			<?php foreach ($delivery_coverage as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
					</td>
					<td><?php echo $no ?></td>
					<td><?php if (empty($datas->district_name)) { echo 'DEFAULT PRICE'; } else { echo $datas->district_name; } ?></td>
                    <td>Rp. <?php echo $this->main->format_money($datas->price) ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit" data-tinymce="true">Edit</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>proweb/delivery_coverage/delete/<?php echo $datas->id ?>"
						   class="btn btn-danger btn-elevate btn-elevate-air btn-delete">Delete</a>
					</td>
				</tr>
				<?php $no++ ?>
			<?php endforeach; ?>
			</tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>
<!--begin::Modal-->

<form method="post" action="<?php echo base_url() . 'proweb/delivery_coverage/createprocess'; ?>" enctype="multipart/form-data"
	  class="form-send" id="form-create">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content sub-category">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Delivery Coverage</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
                    <div class="form-group">
                        <label for="exampleSelect1">District</label>
                        <select name="id_district" class="form-control input-select2" style="width: 100%">
                            <option value="">Select District</option>
                            <option value="0">Default Price</option>
                            <?php foreach($districts as $district) { ?>
                                <option value="<?php echo $district->id ?>"><?php echo $district->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Price</label>
                        <input type="text" class="form-control" name="price">
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="<?php echo base_url() . 'proweb/delivery_coverage/update'; ?>" enctype="multipart/form-data"
	  class="form-send" id="form-edit">

	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Delivery Coverage</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
                    <div class="form-group">
                        <label for="exampleSelect1">District</label>
                        <select name="id_district" class="form-control input-select2" style="width: 100%">
                            <option value="">Select District</option>
                            <option value="0">Default Price</option>
                            <?php
                            foreach($districts as $district) {
                            ?>
                                <option value="<?php echo $district->id ?>"><?php echo $district->name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Price</label>
                        <input type="text" class="form-control" name="price">
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</form>



<div class="data-1-data hide">
    <li>
        <div class="form-group">
            <label for="exampleSelect1">Title</label>
            <textarea class="form-control" name="data_1[title][]"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleSelect1">Deskripsi</label>
            <textarea class="form-control" name="data_1[description][]"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleSelect1">Add Picture</label>
            <textarea class="form-control" name="data_1[images_edit][]"></textarea>

        </div>
        <button type="button" class="btn btn-danger btn-data-1-hapus">Remove</button>
        <br/>
        <br/>
        <br/>
    </li>
</div>


