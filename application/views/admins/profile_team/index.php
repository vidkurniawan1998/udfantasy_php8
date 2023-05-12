<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management Profile Team
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#modal-create">
						<i class="la la-plus"></i>
						Add Team
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
				<th width="20">No</th>
				<th>Name</th>
				<th>Avatar</th>
				<th>Position</th>
				<th>Use</th>
				<th width="130">Option</th>
				<th class="d-none"></th>
			</tr>
			</thead>
			<?php $no = 1  ?>
			<tbody>
			<?php foreach ($team as $datas) : ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->title ?></td>
					<td>
						<img src="<?php echo $this->main->image_preview_url($datas->thumbnail) ?>" alt="Icon" width="<?php echo $this->main->image_size_preview() ?>">
					</td>
					<td><?php echo $datas->position ?></td>
					<td><?php echo $datas->use ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit">Edit</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>proweb/gallery_photo/delete/<?php echo $datas->id ?>"
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

<form method="post" action="<?php echo base_url().'proweb/profile_team/createprocess' ;?>" enctype="multipart/form-data" class="form-send" >
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Team</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Name</label>
						<input type="text" class="form-control" placeholder="Name" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Position</label>
						<input type="text" class="form-control" placeholder="position" name="position">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Use</label>
						<select class="form-control" name="use">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Avatar</label>
						<br />
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="thumbnail" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
					</div>
                    <div class="form-group" style="margin-left: 20px; margin-right: 20px">
                        <label>Description</label>
                        <textarea class="tinymce" id="exampleTextarea" rows="3" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Meta title</label>
                        <input type="text" class="form-control" placeholder="Meta Title" name="meta_title">
                        <span class="form-text text-muted"><?php echo $this->main->help_meta() ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Meta Description</label>
                        <input type="text" class="form-control" placeholder="Meta description" name="meta_description">
                        <span class="form-text text-muted"><?php echo $this->main->help_meta() ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Meta Keywords</label>
                        <input type="text" class="form-control" placeholder="Meta keywords" name="meta_keywords">
                        <span class="form-text text-muted"><?php echo $this->main->help_meta() ?></span>
                    </div>
<!--					<div class="form-group">-->
<!--						<label>Thumbnail Alt</label>-->
<!--						<textarea class="form-control"  id="exampleTextarea" rows="3" name="thumbnail_alt"></textarea>-->
<!--						<span class="form-text text-muted">--><?php //echo $this->main->help_thumbnail_alt() ?><!--</span>-->
<!--					</div>-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="<?php echo base_url().'proweb/profile_team/update' ; ?>" enctype="multipart/form-data" class="form-send" >
	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Team</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden"name="id">
						<label for="exampleSelect1">Name</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
                    <div class="form-group">
                        <label for="exampleSelect1">Position</label>
                        <input type="text" class="form-control" placeholder="position" name="position">
                    </div>
					<div class="form-group">
						<label for="exampleSelect1">Use</label>
						<select class="form-control" name="use">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Avatar</label>
						<br />
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-img" accept="image/*" name="thumbnail" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
					</div>

                    <div class="form-group" style="margin-left: 20px; margin-right: 20px">
                        <label>Description</label>
                        <textarea class="tinymce" id="exampleTextarea" rows="3" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Meta title</label>
                        <input type="text" class="form-control" placeholder="Meta Title" name="meta_title">
                        <span class="form-text text-muted"><?php echo $this->main->help_meta() ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Meta Description</label>
                        <input type="text" class="form-control" placeholder="Meta description" name="meta_description">
                        <span class="form-text text-muted"><?php echo $this->main->help_meta() ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Meta Keywords</label>
                        <input type="text" class="form-control" placeholder="Meta keywords" name="meta_keywords">
                        <span class="form-text text-muted"><?php echo $this->main->help_meta() ?></span>
                    </div>

<!--					<div class="form-group">-->
<!--						<label>Thumbnail Alt</label>-->
<!--						<textarea class="form-control"  id="exampleTextarea" rows="3" name="thumbnail_alt"></textarea>-->
<!--						<span class="form-text text-muted">--><?php //echo $this->main->help_thumbnail_alt() ?><!--</span>-->
<!--					</div>-->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-primary" name="submit" value="upload">
				</div>
			</div>
		</div>
	</div>
</form>


