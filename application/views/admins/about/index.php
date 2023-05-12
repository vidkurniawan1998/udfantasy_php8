<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management About
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#modal-create">
						<i class="la la-plus"></i>
						Add About
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
			<tr>
				<th class="d-none"></th>
				<th width="20">No</th>
				<th>title</th>
				<th>description</th>

				<th>meta title</th>
				<th>meta description</th>
				<th>meta keywords</th>
				<th width="130">Option</th>
			</tr>
			</thead>
			<?php $no = 1  ?>
			<tbody>
			<?php foreach ($about as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
					</td>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->title ?></td>
					<td><?php echo $datas->description ?></td>
					<td><?php echo $datas->meta_title ?></td>
					<td><?php echo $datas->meta_description ?></td>
					<td><?php echo $datas->meta_keywords ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit">Edit</a>

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



<form method="post" action="<?php echo base_url().'proweb/about/update' ; ?>" enctype="multipart/form-data" class="form-send" >
	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit About</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="id">
						<label for="exampleSelect1">Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>Description</label>
						<input type="hidden" name="description">
						<textarea class="tinymce" id="exampleTextarea" rows="3" name="description2"></textarea>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Meta title</label>
						<input type="text" class="form-control" placeholder="Meta Title" name="meta_title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Meta Description</label>
						<input type="text" class="form-control" placeholder="Meta description" name="meta_description">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Meta Keywords</label>
						<input type="text" class="form-control" placeholder="Meta keywords" name="meta_keywords">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
				</div>
			</div>
		</div>
	</div>
</form>


