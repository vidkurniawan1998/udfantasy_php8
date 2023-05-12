<?php //echo $tab_language 
?>
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Management Products
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<!--					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm btn-create" data-toggle="modal"-->
					<!--					   data-target="#modal-create">-->
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm btn-create">
						<i class="la la-plus"></i>
						Add Products
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body" style="overflow-x:auto;">
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
				<tr>
					<th class="d-none"></th>
					<th class="d-none"></th>
					<th width="20">No</th>
					<th>Title</th>
					<th>Price</th>
					<th>Status</th>
					<th width="130">Option</th>
				</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
				<?php foreach ($products as $datas) : ?>
					<tr>
						<td class="d-none data-row">
							<textarea><?php echo json_encode($datas) ?></textarea>
						</td>

						<td class="d-none data-image-row">
							<textarea><?php echo json_encode($products_image[$datas->id]); ?></textarea>
						</td>
						<td><?php echo $no ?></td>
						<td><?php echo $datas->title ?></td>
						<td><?php echo 'Rp. ' . $this->main->format_money($datas->price) ?></td>
						<td>
							<form action="">
								<div class="col-3">
									<span class="kt-switch">
										<label>
											<input type="checkbox" <?= ($datas->use == 'yes') ? 'checked="true"' : ''; ?> name="" class="switchbutton" data-idproducts="<?= $datas->id ?>" value="hide/show" />
											<span></span>
										</label>
									</span>
								</div>
							</form>
						</td>
						<td>
							<a href="javascript:;" class="btn btn-success btn-elevate btn-elevate-air btn-edit" data-tinymce="true">Edit</a>
							<a href="#" data-action="<?php echo base_url() ?>proweb/products_content/delete/<?php echo $datas->id ?>" class="btn btn-danger btn-elevate btn-elevate-air btn-delete">Delete</a>
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

<form method="post" action="<?php echo base_url() . 'proweb/products_content/createprocess'; ?>" enctype="multipart/form-data" class="form-send" id="form-create">
	<input type="hidden" name="id_language" value="<?php echo $id_language ?>">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content sub-category">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Products</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<!--					<div class="form-group">-->
					<!--						<label for="exampleSelect1">Author</label>-->
					<!--						<select name="id_team" class="form-control">-->
					<!--                            --><?php //foreach($team as $row) { 
														?>
					<!--                            <option value="--><?php //echo $row->id 
																		?><!--">--><?php //echo $row->title 
																										?><!--</option>-->
					<!--                            --><?php //} 
														?>
					<!--                        </select>-->
					<!--					</div>-->
					<div class="form-group">
						<label for="exampleSelect1">Products Category</label>
						<select name="id_products_category" id="id_products_category" class="form-control main-category">
							<option value="">Select Category</option>
							<?php foreach ($products_category as $row) { ?>
								<option value="<?php echo $row->id ?>"><?php echo $row->title ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Products Sub Category</label>
						<select name="id_products_sub_category" id="id_products_sub_category" class="form-control">
							<!--                            --><?php //foreach($products_sub_category as $row) { 
																?>
							<!--                                <option value="--><?php //echo $row->id 
																					?><!--">--><?php //echo $row->title 
																													?><!--</option>-->
							<!--                            --><?php //} 
																?>
						</select>
					</div>
					<!--                    <div class="form-group">-->
					<!--                        <label for="exampleSelect1">Products Region</label>-->
					<!--                        <select name="id_products_region" id="id_products_region" class="form-control main-region">-->
					<!--                            <option value="">Select Region</option>-->
					<!--                            --><?php //foreach($products_region as $row) { 
														?>
					<!--                                <option value="--><?php //echo $row->id 
																			?><!--">--><?php //echo $row->title 
																											?><!--</option>-->
					<!--                            --><?php //} 
														?>
					<!--                        </select>-->
					<!--                    </div>-->
					<div class="form-group">
						<label for="exampleSelect1">SKU</label>
						<input type="text" class="form-control" placeholder="SKU" name="sku">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">English Title</label>
						<input type="text" class="form-control" placeholder="English Title" name="title_eng">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Thumbnail</label>
						<br />
						<!--                        <table role="presentation" class="table table-striped clearfix">-->
						<!--                            <tbody class="files"> </tbody>-->
						<!--                        </table>-->
						<div class="thumbnail-preview"></div>
						<div id="cloned-thumbnail" class="cloned-thumbnail hidden">
							<img src="" alt="" class="img-thumbnail">
							<!--                            <a href="javascript:();" class="btn btn-danger remove-thumbnail">Remove</a>-->
						</div>
						<img src="" alt="" class="img-thumbnail">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-multi-img" accept="image/*" name="thumbnail[]" id="customFile" multiple>
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Thumbnail Alt</label>
						<input type="text" class="form-control" name="thumbnail_alt">
						<span class="form-text text-muted"><?php echo $this->main->help_thumbnail_alt() ?></span>
					</div>
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>Description</label>
						<textarea class="tinymce" id="exampleTextarea" rows="3" name="description"></textarea>
					</div>
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>English Description</label>
						<textarea class="tinymce" id="exampleTextarea" rows="3" name="description_eng"></textarea>
					</div>
					<div class="form-group product-info">
						<div class="row">
							<div class="col-md-10">
								<label for="information">Product Information</label>
							</div>
							<div class="col-md-2">
								<a href="javascript:();" class="btn btn-primary" onclick="clone_row_product('#modal-create')">Add Info</a>
								<input type="hidden" name="count_product_info" value="0">
							</div>
						</div>
						<div class="container-info"></div>
						<div class="hidden mt-3" id="product-row">
							<div class="col-md-6">
								<input type="text" class="form-control information-name" placeholder="Information Name" name="">
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control information-value" placeholder="Information Value" name="">
							</div>
							<div class="col-md-2">
								<a href="javascript:();" class="btn btn-danger remove-info" onclick="remove_row_product()">Remove</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Price</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Rp.</div>
							</div>
							<input type="text" class="form-control" id="exampleInputAmount" placeholder="Price" name="price">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Promoted Item</label>
						<br />
						<span class="kt-switch kt-switch--lg kt-switch--icon">
							<label>
								<input type="checkbox" class="promotion-status" <?php echo $row->status_seo == 'yes' ? 'checked="checked"' : ''; ?> value="yes" name="promotion_status">
								<span></span>
							</label>
						</span>
					</div>

					<div class="promotion-status-wrapper">
						<div class="form-group">
							<label for="exampleSelect1">Promotion Price</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Rp.</div>
								</div>
								<input type="text" class="form-control" id="exampleInputAmount" placeholder="Price" name="promotion_price">
							</div>
						</div>
						<div class="form-group">
							<label for="exampleSelect1">Promotion Statement</label>
							<input type="text" class="form-control" value="" placeholder="Promotion Statement" name="promotion_statement">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Is New</label>
						<select class="form-control" name="is_new">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Use As Featured</label>
						<select class="form-control" name="use">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Best Seller</label>
						<select class="form-control" name="best_seller">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="<?php echo base_url() . 'proweb/products_content/update'; ?>" enctype="multipart/form-data" class="form-send" id="form-edit">

	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content sub-category">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Products</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<!--					<div class="form-group">-->
					<!--						<label for="exampleSelect1">Author</label>-->
					<!--						<select name="id_team" class="form-control">-->
					<!--                            --><?php //foreach($team as $row) { 
														?>
					<!--                            <option value="--><?php //echo $row->id 
																		?><!--">--><?php //echo $row->title 
																										?><!--</option>-->
					<!--                            --><?php //} 
														?>
					<!--                        </select>-->
					<!--					</div>-->
					<div class="form-group">
						<label for="exampleSelect1">Products Category</label>
						<select name="id_products_category" id="id_products_category" class="form-control">
							<option value="">Select Category</option>
							<?php foreach ($products_category as $row) { ?>
								<option value="<?php echo $row->id ?>"><?php echo $row->title ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Products Sub Category</label>
						<input type="hidden" name="id_products_sub_category">
						<select name="id_products_sub_category" id="id_products_sub_category" class="form-control"">
<!--                            --><?php //foreach($products_sub_category as $row) { 
									?>
<!--                                <option value=" --><?php //echo $row->id 
														?><!--">--><?php //echo $row->title 
																						?><!--</option>-->
							<!--                            --><?php //} 
																?>
						</select>
					</div>
					<!--                    <div class="form-group">-->
					<!--                        <label for="exampleSelect1">Products Region</label>-->
					<!--                        <select name="id_products_region" id="id_products_region" class="form-control main-region">-->
					<!--                            <option value="">Select Region</option>-->
					<!--                            --><?php //foreach($products_region as $row) { 
														?>
					<!--                                <option value="--><?php //echo $row->id 
																			?><!--">--><?php //echo $row->title 
																											?><!--</option>-->
					<!--                            --><?php //} 
														?>
					<!--                        </select>-->
					<!--                    </div>-->
					<div class="form-group">
						<label for="exampleSelect1">Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">English Title</label>
						<input type="text" class="form-control" placeholder="Title" name="title_eng">
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Thumbnail</label>
						<br />
						<div class="thumbnail-uploaded"></div>
						<div class="thumbnail-preview"></div>
						<div id="cloned-thumbnail-edit" class="cloned-thumbnail hidden">
							<img src="" alt="" class="img-thumbnail">
							<a href="javascript:();" class="btn btn-danger remove-thumbnail">Remove</a>
						</div>
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-multi-img" accept="image/*" name="thumbnail[]" multiple id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<span class="form-text text-muted"><?php echo $this->main->file_info() ?></span>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Thumbnail Alt</label>
						<input type="text" class="form-control" name="thumbnail_alt">
						<span class="form-text text-muted"><?php echo $this->main->help_thumbnail_alt() ?></span>
					</div>
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>Description</label>
						<textarea class="tinymce" id="description" rows="3" name="description"></textarea>
					</div>
					<div class="form-group" style="margin-left: 20px; margin-right: 20px">
						<label>English Description</label>
						<textarea class="tinymce" id="description_eng" rows="3" name="description_eng"></textarea>
					</div>
					<div class="form-group product-info">
						<div class="row">
							<div class="col-md-10">
								<label for="information">Product Information</label>
							</div>
							<div class="col-md-2">
								<a href="javascript:();" class="btn btn-primary" onclick="clone_row_product('#modal-edit')">Add Info</a>
								<input type="hidden" name="count_product_info" value="0">
							</div>
						</div>
						<div class="container-info"></div>
						<div class="hidden mt-3" id="product-row">
							<div class="col-md-6">
								<input type="text" class="form-control information-name" placeholder="Information Name" name="">
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control information-value" placeholder="Information Value" name="">
							</div>
							<div class="col-md-2">
								<a href="javascript:();" class="btn btn-danger remove-info" onclick="remove_row_product()">Remove</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Price</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Rp.</div>
							</div>
							<input type="text" class="form-control" id="exampleInputAmount" placeholder="Price" name="price">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Promoted Item</label>
						<br />
						<span class="kt-switch kt-switch--lg kt-switch--icon">
							<label>
								<input type="checkbox" class="promotion-status" value="yes" name="promotion_status">
								<span></span>
							</label>
						</span>
					</div>

					<div class="promotion-status-wrapper">
						<div class="form-group">
							<label for="exampleSelect1">Promotion Price</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Rp.</div>
								</div>
								<input type="text" class="form-control" id="exampleInputAmount" placeholder="Price" name="promotion_price">
							</div>
						</div>
						<div class="form-group">
							<label for="exampleSelect1">Promotion Statement</label>
							<input type="text" class="form-control" value="" placeholder="Promotion Statement" name="promotion_statement">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Is New</label>
						<select class="form-control" name="is_new">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Use As Featured</label>
						<select class="form-control" name="use">
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Best Seller</label>
						<select class="form-control" name="best_seller">
							<option value="no">No</option>
							<option value="yes">Yes</option>
						</select>
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
		<br />
		<br />
		<br />
	</li>
</div>