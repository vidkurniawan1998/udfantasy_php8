<?php //echo $tab_language ?>
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Holiday Checkout
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
<!--					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm btn-create" data-toggle="modal"-->
<!--					   data-target="#modal-create">-->
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm btn-create">
						<i class="la la-plus"></i>
						Add Holiday Checkout
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
				<th>Date Start</th>
                <th>Date Finish</th>
				<th width="130">Option</th>
			</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
			<?php foreach ($holiday_checkout as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea>
						<?php
						$datas->date_start = date('d-m-Y', strtotime($datas->date_start));
						$datas->date_finish = date('d-m-Y', strtotime($datas->date_finish));   
						echo json_encode($datas) 
						?></textarea>
					</td>
                    <td><?php echo $no ?></td>
					<td>
					<?= $this->main->format_tanggal($datas->date_start)
					?>
					</td>
					<td>
					<?= $this->main->format_tanggal($datas->date_finish)					
					?>
					</td>
					<td width="120">
						<a href="javascript:;"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit">Edit</a>
						<a href="#" data-action="<?php echo base_url() ?>proweb/Holiday_checkout/delete/<?php echo $datas->id ?>"
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
<!--Begin Modal-->

<!--Add Holiday Checkout-->
<form method="post" action="<?php echo base_url().'proweb/Holiday_checkout/createprocess' ;?>" enctype="multipart/form-data" class="form-send">

	<input type="hidden" name="id_language" value="<?php echo $id_language ?>">

	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Holiday Checkout</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Date Start</label>
						<input type="text" class="form-control input-date" placeholder="dd-mm-yyyy" name="date_start">
					</div>

					<div class="form-group">
						<label>Date Finish</label>
						<input type="text" class="form-control input-date" placeholder="dd-mm-yyyy" name="date_finish">
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

<!--Edit Time Operation-->
<form method="post" action="<?php echo base_url().'proweb/Holiday_checkout/update' ;?>" enctype="multipart/form-data" class="form-send">
	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<input type="hidden" name="id">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Holiday Checkout</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Date Start</label>
						<input type="text" class="form-control input-date" placeholder="dd-mm-yyyy" name="date_start">
					</div>
					<div class="form-group">
						<label>Date Finish</label>
						<input type="text" class="form-control input-date" placeholder="dd-mm-yyyy" name="date_finish">
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