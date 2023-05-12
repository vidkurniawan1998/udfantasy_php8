<?php //echo $tab_language ?>
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg row">
		<div class="kt-portlet__head-label col-sm-12 col-md-6"><!--Kasi di label grid bootstrap col-->
			<span class="kt-portlet__head-icon">
				<i class="flaticon2-image-file"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Data List Checkout
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar col-sm-12 col-md-6"><!--Kasi grid bootstrap-->
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
                    <div class="row wrapper-filter-checkout mt-3">
                        <div class="form-group col-md-4">
                            <label for="filter-checkout-district">Filter District</label><br>
                            <select name="" id="filter-checkout-district" class="form-control filter-table-3 input-select2-clear" data-column="3">
                                <option value="">-Filter District-</option>
                                <?php
                                    foreach ($districts as $district) {
                                ?>
                                    <option value="<?= $district->name ?>"><?= $district->name ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="filter-checkout-payment-method">Filter Payment</label>
                            <select name="" id="filter-checkout-payment-method" class="form-control filter-table-4" data-column="4">
                                <option value="">Select an option</option>
                                <option value="bank transfer">Bank Transfer</option>
                                <option value="cod">COD</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="filter-checkout-status">Filter Status</label>
                            <select name="" id="filter-checkout-status" class="form-control filter-table-5" data-column="5">
                                <option value="">Select an option</option>
                                <option value="menunggu pembayaran">Menunggu Pembayaran</option>
                                <option value="dibayarkan">Dibayarkan</option>
                                <option value="barang dikirim">Barang Dikirim</option>
                                <option value="barang diterima">Barang Diterima</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body" style="overflow-x:auto;">
		<table class="table table-striped- table-bordered table-hover table-checkable datatable">
			<thead>
			<tr>
				<th class="d-none"></th>
				<th width="20">No</th>
                <th>Invoice</th>
                <th>District</th>
                <th>Payment Method</th>
                <th>Status</th>
				<th width="150">Option</th>
			</tr>
			</thead>
			<?php $no = 1 ?>
			<tbody>
			<?php foreach ($checkout as $datas) : ?>
				<tr>
					<td class="d-none data-row">
						<textarea class="data">
                            <?php
                                echo json_encode($datas);
                            ?>
                        </textarea>
						<textarea class="data_item">
                            <?php
                                echo json_encode($checkout_item[$datas->id]);
                            ?>
                        </textarea>
					</td>
					<td><?php echo $no ?></td>
                    <td><?php echo $datas->invoice ?></td>
                    <td><?php echo $datas->district_name ?></td>
                    <td><?php echo $datas->payment_method ?></td>
					<td><?php echo $datas->status ?></td>
					<td>
						<a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-detail" data-tinymce="true">Detail</a>
						<a href="#"
						   data-action="<?php echo base_url() ?>proweb/checkout/delete/<?php echo $datas->id ?>"
						   class="btn btn-danger btn-elevate btn-elevate-air btn-delete">Delete</a>
                        <br>
                        <a href="#"
						   class="btn btn-success btn-elevate btn-elevate-air btn-edit mt-1" style="font-size: .6vw;" data-tinymce="true">Status Pembayaran</a>
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

<form method="post" action="<?php echo base_url() . 'proweb/checkout_content/createprocess'; ?>" enctype="multipart/form-data"
	  class="form-send">
    <input type="hidden" name="id_language" value="2">
	<div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Checkout</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Invoice Number</label>
						<input type="text" class="form-control" placeholder="Invoice Number" name="invoice" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Name</label>
						<input type="text" class="form-control" placeholder="Buyer Name" name="name" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Email</label>
						<input type="text" class="form-control" placeholder="Email" name="email" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="member_phone" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Receiver Name</label>
						<input type="text" class="form-control" placeholder="Receiver name" name="receiver_name"disabled>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" id="exampleTextarea" rows="3" name="address" disabled></textarea>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">City / District</label>
						<input type="text" class="form-control" placeholder="City / District" name="district_name" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Postcode</label>
						<input type="text" class="form-control" placeholder="Postcode" name="postcode" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="phone" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Order Note</label>
						<input type="text" class="form-control" placeholder="Order Note" name="order_note" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Promocode</label>
						<input type="text" class="form-control" placeholder="Promocode" name="promocode" disabled>
					</div>
                </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="<?php echo base_url() . 'proweb/checkout/update'; ?>" enctype="multipart/form-data"
	  class="form-send">

	<div class="modal" id="modal-edit" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit About</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Invoice Number</label>
						<input type="text" class="form-control" placeholder="Invoice Number" name="invoice" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Name</label>
						<input type="text" class="form-control" placeholder="Buyer Name" name="name" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Email</label>
						<input type="text" class="form-control" placeholder="Email" name="email" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="member_phone" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Receiver Name</label>
						<input type="text" class="form-control" placeholder="Receiver name" name="receiver_name"disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Postcode</label>
						<input type="text" class="form-control" placeholder="Postcode" name="postcode" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="phone" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Order Note</label>
						<textarea class="form-control" id="exampleTextarea" rows="3" name="order_note" disabled></textarea>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Payment Method</label>
						<input type="text" class="form-control" placeholder="Payment Method" name="payment_method" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="menunggu pembayaran">Menunggu Pembayaran</option>
                            <option value="dibayarkan">Dibayarkan</option>
                            <option value="barang dikirim">Barang Dikirim</option>
                            <option value="barang diterima">Barang Diterima</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Payment Proof</label>
						<br />
						<img src="" class="img-thumbnail" width="200">
						<br /><br />
						<div class="custom-file">
							<input type="file" class="custom-file-input browse-preview-img hide" accept="image/*" name="payment_proof" id="customFile" disabled>
							<label class="custom-file-label hide" for="customFile">Choose file</label>
						</div>
					</div>
                    <div class="form-group">
                        <label for="">Ordered Items</label>
                        <table class="data-item table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
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

<form method="post" action="#" enctype="multipart/form-data"
	  class="form-send">

	<div class="modal" id="modal-detail" role="dialog" aria-labelledby="exampleModalLabel"
		 aria-hidden="true">

		<input type="hidden" name="id">

		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detail Checkout</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleSelect1">Invoice Number</label>
						<input type="text" class="form-control" placeholder="Invoice Number" name="invoice" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Name</label>
						<input type="text" class="form-control" placeholder="Buyer Name" name="name" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Email</label>
						<input type="text" class="form-control" placeholder="Email" name="email" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Buyer Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="member_phone" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Receiver Name</label>
						<input type="text" class="form-control" placeholder="Receiver name" name="receiver_name"disabled>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" id="exampleTextarea" rows="3" name="address" disabled></textarea>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">City / District</label>
						<input type="text" class="form-control" placeholder="City / District" name="district_name" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Postcode</label>
						<input type="text" class="form-control" placeholder="Postcode" name="postcode" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Phone</label>
						<input type="text" class="form-control" placeholder="Phone" name="phone" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Order Note</label>
						<input type="text" class="form-control" placeholder="Order Note" name="order_note" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Promocode</label>
						<input type="text" class="form-control" placeholder="Promocode" name="promocode" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Status</label>
						<input type="text" class="form-control" placeholder="Status" name="status" disabled>
					</div>
					<div class="form-group">
						<label for="exampleSelect1">Payment Method</label>
						<input type="text" class="form-control" placeholder="Payment Method" name="payment_method" disabled>
					</div>
                    <div class="form-group">
                        <label for="">Ordered Items</label>
                        <table class="data-item table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
				<div class="modal-footer">
                    <a class="btn btn-primary print-pdf" href="<?php echo site_url('checkout_content/print_pdf/') ?>" target="_blank">Print PDF</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>


