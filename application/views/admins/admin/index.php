<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon-avatar"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Administrator
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
					<a href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#modal-create">
						<i class="la la-plus"></i>
						Add User
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
					<th>Username</th>
					<th>Name</th>
					<th>Email</th>
					<th width="130">Option</th>
				</tr>
			</thead>
			<?php $no = 1  ?>
			<tbody>
			<?php foreach ($admin as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea><?php echo json_encode($datas) ?></textarea>
					</td>
					<td><?php echo $no ?></td>
					<td><?php echo $datas->username ?></td>
					<td><?php echo $datas->name ?></td>
					<td><?php echo $datas->email ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit">Edit</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>proweb/admin/delete/<?php echo $datas->id ?>"
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

<form method="post" action="<?php echo base_url().'proweb/admin/createprocess' ;?>" class="form-send">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" placeholder="Name" name="name">
						</div>
						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control" placeholder="Username" name="username">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" placeholder="Password" name="password1">
						</div>
						<div class="form-group">
							<label>Password Confirmation</label>
							<input type="password" class="form-control" placeholder="Password" name="password2">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" placeholder="Email" name="email">
						</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">save</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="<?php echo base_url().'proweb/admin/update' ; ?>" class="form-send">
	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" placeholder="Name" name="name">
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control" name="id">
						<label>Username</label>
						<input type="text" class="form-control" placeholder="Username" name="username">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" placeholder="Password" name="password1">
					</div>
					<div class="form-group">
						<label>Password Confirmation</label>
						<input type="password" class="form-control" placeholder="Password" name="password2">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" placeholder="Email" name="email">
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


