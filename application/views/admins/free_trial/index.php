<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Data Free Trial Request
			</h3>
		</div>
	</div>
	<div class="kt-portlet__body">
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
			<tr>
				<th width="20">No</th>
				<th>Nama</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Pesan</th>
				<th>Waktu Request</th>
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
				</tr>
				<?php $no++ ?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>