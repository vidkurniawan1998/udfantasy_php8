<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management Testimonial
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal"
					   data-target="#modal-create">
						<i class="la la-plus"></i>
						Add Testimonial
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
				<th>Title</th>
				<th>Thumbnail</th>
				<th>Use</th>
				<th width="130">Option</th>
			</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
			<?php foreach ($testimonial as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
					</td>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->title ?></td>
					<td><img src="<?php echo $this->main->image_preview_url($datas->thumbnail) ?>" width="<?php echo $this->main->image_size_preview() ?>" class="img-thumbnail"></td>
					<td><?php echo $datas->use ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit" data-tinymce="true">Edit</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>proweb/testimonial/delete/<?php echo $datas->id ?>"
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

<form method="post" action="<?php echo base_url() . 'proweb/testimonial/createprocess'; ?>" enctype="multipart/form-data"
	  class="form-send">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Testimonial</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Guest Name</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Publish</label>
						<select class="form-control" name="use">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Thumbnail</label>
						<br />
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="thumbnail" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
					</div>
					<div class="form-group">
						<label>Thumbnail Alt</label>
						<textarea class="form-control"  id="exampleTextarea" rows="3" name="thumbnail_alt"></textarea>
						<span class="form-text text-muted"><?php echo $this->main->help_thumbnail_alt() ?></span>
					</div>
					<div class="form-group">
						<label>Testimonial</label>
						<textarea class="form-control" id="exampleTextarea" rows="3" name="description"></textarea>
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

<form method="post" action="<?php echo base_url() . 'proweb/testimonial/update'; ?>" enctype="multipart/form-data"
	  class="form-send">

	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Testimonial</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Guest Name</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Publish</label>
						<select class="form-control" name="use">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Thumbnail</label>
						<br />
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="thumbnail" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
					</div>
					<div class="form-group">
						<label>Thumbnail Alt</label>
						<textarea class="form-control"  id="exampleTextarea" rows="3" name="thumbnail_alt"></textarea>
						<span class="form-text text-muted"><?php echo $this->main->help_thumbnail_alt() ?></span>
					</div>
					<div class="form-group">
						<label>Testimonial</label>
						<textarea class="form-control" id="exampleTextarea" rows="3" name="description"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</div>
		</div>
	</div>
</form>
