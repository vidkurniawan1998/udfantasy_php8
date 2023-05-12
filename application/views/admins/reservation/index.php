<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				View Reservation
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">

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
				<th>first_name</th>
				<th>last_name</th>
				<th>email</th>
				<th>phone</th>
				<th>nationality</th>
				<th>tour start</th>
				<th>total adult</th>
				<th>total children</th>
				<th>message</th>
			</tr>
			</thead>
			<?php $no = 1  ?>
			<tbody>
			<?php foreach ($reservation as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
					</td>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->title ?></td>
					<td><?php echo $datas->first_name ?></td>
					<td><?php echo $datas->last_name ?></td>
					<td><?php echo $datas->email ?></td>
					<td><?php echo $datas->phone ?></td>
					<td><?php echo $datas->country ?></td>
					<td><?php echo $datas->tour_start ?></td>
					<td><?php echo $datas->total_adult ?></td>
					<td><?php echo $datas->total_children ?></td>
					<td><?php echo $datas->message ?></td>
				</tr>
				<?php $no++ ?>
			<?php endforeach; ?>
			</tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>
<!--begin::Modal-->


