<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management Contact
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#modal-create">
						<i class="la la-plus"></i>
						Add Contact
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
				<th>position</th>
				<th>title</th>
				<th>url</th>
				<th>publish</th>
				<th>images</th>
				<th width="130">Option</th>
			</tr>
			</thead>
			<?php $no = 1  ?>
			<tbody>
			<?php foreach ($contact as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
					</td>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->position ?></td>
					<td><?php echo $datas->title ?></td>
					<td><?php echo $datas->url ?></td>
					<td><?php echo $datas->publish ?></td>
					<td>
						<?php //echo $datas->image ?>
						<img src="<?php echo base_url() ?>upload/<?php echo $datas->image ?>" alt="Icon" height="42" width="42">
					</td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit">Edit</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>contact/delete/<?php echo $datas->id ?>"
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

<form method="post" action="<?php echo base_url().'proweb/contact/createprocess' ;?>" enctype="multipart/form-data" class="form-send">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add About</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="id">
						<label for="exampleSelect1">Position</label>
						<select class="form-control" id="exampleSelect1" name="position">
							<option value="Yahoo">Yahoo</option>
							<option value="Skype">Skype</option>
							<option value="Link">Link</option>
						</select>
					</div>
					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label>Url</label>
						<input type="text" class="form-control" placeholder="Url" name="url">
					</div>
					<div class="form-group">
						<input type="hidden" name="id">
						<label for="exampleSelect1">Publish</label>
						<select class="form-control" id="exampleSelect1" name="publish">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</div>
					<div class="form-group">
						<label>Image</label>
						<div></div>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="berkas">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
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

<form method="post" action="<?php echo base_url().'proweb/contact/update' ; ?>" enctype="multipart/form-data" class="form-send">
	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit About</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="id">
						<input type="hidden" name="image">
						<label for="exampleSelect1">Position</label>
						<select class="form-control" id="exampleSelect1" name="position">
							<option value="Yahoo">Yahoo</option>
							<option value="Skype">Skype</option>
							<option value="Link">Link</option>
						</select>
					</div>
					<div class="form-group">
						<label>Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label>Url</label>
						<input type="text" class="form-control" placeholder="Url" name="url">
					</div>
					<div class="form-group">
						<input type="hidden" name="id">
						<label for="exampleSelect1">Publish</label>
						<select class="form-control" id="exampleSelect1" name="publish">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
					</div>
					<div class="form-group">
						<label>Image</label>
						<div></div>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="berkas">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-primary" name="submit" value="upload">
				</div>
			</div>
		</div>
	</div>
</form>


