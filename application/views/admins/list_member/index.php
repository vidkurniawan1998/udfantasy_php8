<?php echo $tab_language ?>

<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management Member
			</h3>
		</div>
	</div>
	<div class="kt-portlet__body" style="overflow-x:auto;">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
			<tr>
				<th width="20">No</th>
				<th>Name</th>
				<th>Email</th>
                <th>Phone</th>
				<th width="150">Option</th>
				<th class="d-none"></th>
			</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
			<?php foreach ($member as $datas) : ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->name ?></td>
					<td><?php echo $datas->email ?></td>
                    <td><?php echo $datas->phone ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-detail" data-tinymce="true">Detail</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>proweb/list_member/delete/<?php echo $datas->id ?>"
						   class="btn btn-danger btn-elevate btn-elevate-air btn-delete">Delete</a>
					</td>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
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

<form method="post" action="" enctype="multipart/form-data"
	  class="form-send">

	<div class="modal" id="modal-detail" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Name</label>
						<input type="text" class="form-control" placeholder="Name" name="name" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Email</label>
						<input type="text" class="form-control" placeholder="Email" name="email" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="phone" disabled>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>


