<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Data Request Free Ebook
			</h3>
		</div>
	</div>
	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
			<tr>
				<th width="20">No</th>
				<th>Nama</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Pesan</th>
				<th>Waktu Request</th>
				<th>Status Kirim</th>
				<th>Waktu Kirim</th>
				<th width="130">Option</th>
			</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
			<?php foreach ($data as $datas) : ?>
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->name ?></td>
					<td><?php echo $datas->phone ?></td>
					<td><?php echo $datas->email ?></td>
					<td><?php echo $datas->message ?></td>
					<td><?php echo $datas->created_at ?></td>
					<td><?php echo $datas->status_send == 'no' ? 'Belum Kirim' : 'Sudah Kirim' ?></td>
                    <td><?php echo $datas->send_date ?></td>
					<td>
                        <?php if($datas->status_send == 'no') { ?>
                            <form action="<?php echo base_url('proweb/free_ebook/send/'.$datas->id) ?>" method="post" class="form-send">
                                <button type="submit"
                                        class="btn btn-success btn-elevate btn-elevate-air">Kirim Ebook</button>
                            </form>
                        <?php } ?>
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

<form method="post" action="<?php echo base_url() . 'proweb/blog_category/createprocess'; ?>" enctype="multipart/form-data"
	  class="form-send">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Title</label>
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
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>Description</label>
						<textarea class="tinymce" id="exampleTextarea" rows="3" name="description"></textarea>
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
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="<?php echo base_url() . 'proweb/blog_category/update'; ?>" enctype="multipart/form-data"
	  class="form-send">

	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Title</label>
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
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>Description</label>
						<textarea class="tinymce" id="exampleTextarea" rows="3" name="description"></textarea>
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
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</div>
		</div>
	</div>
</form>


