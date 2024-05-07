<script src="<?php echo base_url();?>js/jquery1.js"></script>

<script type="text/javascript">
	// $.noConflict();
	var ctr = 1;
	$(document).ready(function () {


		$('#dataTable1').on('change', '.productcode2', function () {

			ctr++;
			// var b = $(this).closest("tr")[0].rowIndex;
			// 	var	a = document.getElementById('dataTable').rows[b].cells[8].innerHTML; 
			// alert(a);
			// alert(ctr);
			var a = $(this).closest("tr").find('.ctr').text();
			if (a == 1)
			{
				var code = $('#productcode1').val();
			}
			else
			{
				var code = $('#productcode' + a).val();
			}


			try {
				$.ajax({

					type: "POST",
					dataType: 'json',
					url: "<?php echo base_url(); ?>index.php/Onlinecontrol/Autofill_New",
					data: {
						'b': code
					},
					success: function (result) {

						var Qty = $('#qty' + a).val();
						var purchaserate = result[0]['purchaserate'];
						var hsn = result[0]['hsncode'];
						alert(hsn);
						var taxpercentage = result[0]['tax'];
						var netamount = purchaserate * Qty;
						var taxamount = purchaserate * Qty * taxpercentage / 100;

						if (a == 1) {
							$('#unitprice').val(purchaserate);
							$('#amount1').val(purchaserate * Qty);
							$('#taxamount1').val(taxamount);
							$('#hsn1').val(hsn);
							$('#totalamount1').val(netamount + taxamount);
						} else {
							$('#unitprice' + a).val(result[0]['purchaserate']);
							$('#amount' + a).val(purchaserate * Qty);
							$('#hsn' + a).val(hsn);
							$('#taxamount' + a).val(taxamount);
							$('#totalamount' + a).val(netamount + taxamount);
						}

						

						var tr = "tr" + ctr;
						var productcode = "productcode" + ctr;
						var unitprice = "unitprice" + ctr;
						var qty = "qty" + ctr;
						var size = "size" + ctr;
						var hsn = "hsn" + ctr;
						// var sqft = "sqft" + ctr;<td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' + sqft + '" name="productcode"></td> //add to row
						var amount = "amount" + ctr;
						var batch = "batch" + ctr;
						var tax = "tax" + ctr;
						var taxamount = "taxamount" + ctr;
						var totalamount = "totalamount" + ctr;

						var rowCount = document.getElementById('dataTable').rows.length + 1;

						var newTr = '<tr><td>' + rowCount +
							'</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +
							productcode +
							'"></td><td> <input type="number" value="1" class="form-control" autocomplete="off" id="' +
							hsn + '" name="productcode"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' +
							qty + '" name="productcode"></td><td><input type="text" id="' + size +
							'" class="form-control" list="size" name="" ></td><td><input type="text" id="' + batch +
							'" class="form-control" list="bat" name=""></td><td><input type="text" id="' + unitprice +
							'" class="form-control unitprice" name=""></td><td><input type="text" id="' + amount +
							'" class="form-control" name=""></td><td><input type="text" id="' + taxamount +
							'" class="form-control"  name=""></td><td><input type="text" id="' + totalamount +
							'" class="form-control"  name=""></td><td class="ctr" style="display:none">' + ctr +
							'</td> <td><a href="" class="delete" >X</a></td> </tr>';
						$('#dataTable1').append(newTr);
						calculation();



					},
					error: function () {
						alert('Error occur...!!');
					}
				});
			} catch (err) {
				alert(err.message);
			}

		});


	});

	function calculation() {

		try {
			var table = document.getElementById('dataTable1');
			var ab = table.rows.length;
			var qty = 0.000;
			var netamount = 0.00;
			var taxamount = 0.00;
			var totalamount = 0.00;
			var rowqty = 0;
			var rownetamount = 0;
			var rowtaxamount = 0;
			var rowtotalamount = 0;
			for (var n = 1; n < table.rows.length; n++) {
				var i = 0;
				try {
					i = document.getElementById('dataTable').rows[n - 1].cells[10].innerHTML;

				} catch (err) {

				}

				if (document.getElementById('productcode'+i).value==null || document.getElementById('productcode'+i).value=="" ) {
					// alert("null");
				} else {
					rowqty = document.getElementById('qty' + i).value * 1;
					rownetamount = document.getElementById('amount' + i).value * 1;
					rowtaxamount = document.getElementById('taxamount' + i).value * 1;
					rowtotalamount = document.getElementById('totalamount' + i).value * 1;
					qty = qty + rowqty;

				netamount = netamount + rownetamount;
				taxamount = taxamount + rowtaxamount;
				totalamount = totalamount + rowtotalamount;
				}

			}

			$('#totalqty').val(qty);
			$('#totalamount').val(netamount);
			$('#taxamount').val(taxamount);
			var billdiscount = $('#billdiscount').val() * 1;
			var additionalcost = $('#additionalcost').val() * 1;
			$('#grandtotal').val(netamount + taxamount - billdiscount + additionalcost);
			document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document
				.getElementById("grandtotal").value * 1);
			
		} catch (err) {
			alert(err);
		}


	}
</script>
<script type="text/javascript">
	function newrow(ctr) {


	}
</script>





<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Purchase Invoice
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="#">Forms</a></li> -->
			<li class="active">Purchase Invoice</li>
		</ol>
	</section>
 	<section class="content">
		<div class="box box-default">
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
						<label>Voucher no :</label>
						<?php foreach($voucherno->result() as $gp){
                    ?>
						<input type="text" name="voucherno" class="form-control" required autocomplete="off" id="voucherno"
							value="<?php echo $gp->NO;?>">
						<?php  } ?>
					</div>
					<div class="col-md-4">
						<label>Supplier :</label>
						<input type="text" class="form-control" list="supplier1" autocomplete="off" id="supplier" name="supplier">
						<datalist id="supplier1">
							<?php foreach($supplier->result() as $gp){
                                      ?>
							<option value="<?php echo $gp->supplierid;?>" data-supplierbalance="<?php echo $gp->currentbalance;?>"
								label=" <?php echo $gp->suppliername;?>"></option>
							<?php  } ?>

						</datalist>


					</div>
					<div class="col-md-4">
						<label>Order no :</label>
						<input type="text" id="orderno" name="orderno" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label>Vendor invoice no :</label>
						<input type="text" name="vendorinvoiceno" class="form-control" id="vendor" autocomplete="off">
					</div>
					<div class="col-md-4">
						<label>Invoice date :</label>
						<input type="date" name="invoicedate" class="form-control" id="invoicedate"
							value="<?php echo date("Y-m-d");?>">
					</div>
					<div class="col-md-4">

						<label>Branch :</label>
						<select class="form-control" name="branch" id="branch">
							<?php foreach($branch->result() as $gp){
                   ?>
							<option value="<?php echo $gp->branchname;?>"><?php echo $gp->branchname;?></option>
							<?php  } ?>
						</select>
					</div>

				</div>
				<hr>

				<div class="row" style="display: none">
					<div class="col-md-3">
						<label>Product Name :</label>

						<input type="text" class="form-control" list="name" autocomplete="off" name="productname" id="productname">
						<datalist id="name1">
							<?php foreach($product->result() as $gp){
                   ?>
							<option value="<?php echo $gp->pdt_name;?>" data-tax="<?php echo $gp->tax;?>">
								<?php  } ?>
								<!-- <option value="HTML"> -->

						</datalist>
					</div>
					<div class="col-md-3">
						<label>Product Code :</label>

						<input type="text" class="form-control" list="languages" autocomplete="off" id="productcode11"
							name="productcode">
						<datalist id="languages">
							<?php foreach($product->result() as $gp){
                   ?>
							<option value="<?php echo $gp->pdt_code;?>">
								<?php  } ?>


						</datalist>
					</div>
					<div class="col-md-3">
						<label>Qty :</label>
						<input type="text" class="form-control" id="Qty1" name="Qty1" value="1">
					</div>
					<div class="col-md-3">
						<label>Unit Price :</label>
						<input type="text" class="form-control" name="unitprice1" id="unitprice1">
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-md-3">
						<label>Unit :</label>
						<select class="form-control" name="unit" id="unit">
							<?php foreach($unit->result() as $gp){
                ?>
							<option value="<?php echo $gp->unitid;?>"><?php echo $gp->unitname;?></option>
							<?php  } ?>
						</select>
					</div>
					<div class="col-md-3" style="display: none;">
						<label>group:</label>
						<select class="form-control" name="group" id="group">
							<?php foreach($group->result() as $gp){
                ?>
							<option value="<?php echo $gp->groupid;?>"><?php echo $gp->groupname;?></option>
							<?php  } ?>
						</select>
					</div>
					<div class="col-md-3">
						<label>Brand :</label>
						<select class="form-control" name="brand" id="brand">
							<?php foreach($brand->result() as $gp){
                 ?>
							<option value="<?php echo $gp->brandid;?>"><?php echo $gp->brandname;?></option>
							<?php  } ?>
						</select>
					</div>
					<div class="col-md-3" style="display: none;">
						<label>tax %</label>
						<input type="text" class="form-control" name="tax" id="tax">
					</div>
					<div class="col-md-3">
						<label>Batch Name :</label>
						<select class="form-control" name="batch" id="batch1">
							<?php foreach($batch->result() as $gp){
                 ?>
							<option value="<?php echo $gp->batchid;?>"><?php echo $gp->batchname;?></option>
							<?php  } ?>
						</select>
					</div>
				</div>
				<div class="row" style="display: none;">
					<div class="col-md-3">
						<label>MRP</label>
						<input type="text" class="form-control" name="mrp" id="mrp">
					</div>
				</div>

				<div class="table table-responsible">
					<TABLE id="dataTable1" border="1" class="table table-striped table-hover">
						<thead>
							<tr>
								<th>SL.NO</th>
								<th>PRODUCT NAME</th>
								<th>HSN CODE</th>
								<th>QTY</th>
								<th class="d-none d-xl-block">SIZE</th>
								<!-- <th style="">sqft</th> -->
								<th class="d-none d-xl-block">BATCH</th>
								<th class="d-none d-xl-block">UNIT PRICE</th>
								<th class="d-none d-xl-block" style="">NET AMOUNT</th>
								<th class="d-none d-xl-block" style="">TAX AMOUNT</th>
								<th class="d-none d-xl-block">TOTAL AMOUNT</th>
								<th class="d-none d-xl-block" style="display: none;"></th>
								<th class="d-none d-xl-block"></th>
							</tr>
						</thead>
						<tbody id="dataTable" width="100%" border="1" class="table table-hover">
							<tr>
								<td>1</td>
								<td> <input type="text" class="form-control productcode2" list="name" autocomplete="off"
										name="productname" id="productcode1"></td>
								<datalist id="name">
									<?php foreach($product->result() as $gp){
                   ?>
									<option value="<?php echo $gp->pdt_code;?>" data-qty="<?php echo $gp->purchaserate;?>"
										data-tax="<?php echo $gp->tax;?>" label="<?php echo $gp->pdt_name;?>">
										<?php  } ?>

								</datalist>
								<td>
									<input type="number" class="form-control qty" autocomplete="off" id="hsn1" name="productcode">
								</td>

								<td>
									<input  type="number" value="1" class="form-control qty" autocomplete="off" id="qty1"
										name="productcode">
								</td>

								<td> <input type="text" class="form-control" list="size" autocomplete="off"
										name="size" id="size1"></td>
										<datalist id ="size">
											
											<?php
									  			foreach ($size->result() as $row)
									  			{
                     						?>
										<option value="<?php echo $row->sizeid; ?>" label="<?php echo $row->sizevalue; ?>">
										<?php } ?>
										</datalist>
										
								
								<!-- <td>
								 <input style="" type="text" value="1" class="form-control qty" autocomplete="off" id="sqft"	name="productcode"> 
								</td> -->
								<td><input type="text" id="batch" list="bat" class="form-control" name=""></td>
								<datalist id="bat">
									<?php foreach($batch->result() as $gp){
                   ?>
									<option value="<?php echo $gp->batchid;?>" label="<?php echo $gp->batchname;?>">
										<?php  } ?>
								</datalist>
								<td><input type="text" id="unitprice" class="form-control unitprice" name=""></td>
								<td><input type="text" id="amount1" class="form-control" name=""></td>

								<td><input type="text" id="taxamount1" class="form-control" name=""></td>
								<td><input type="text" id="totalamount1" class="form-control" name=""></td>
								<td style="display: none;" class="ctr">1</td>
								<td><a href="" class="delete">X</a></td>
							</tr>
						</tbody>
					</TABLE>
					<input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<label>Narration :</label>
						<textarea class="form-control" id="narration" name="Narration"></textarea>
					</div>
					<div class="col-md-6">
						<label>Transportation Company :</label>
						<textarea id="company" class="form-control" name="transportationcompany"></textarea>
					</div>
				</div>
				<hr>
				<fieldset>
					<label style="">Total Stock Amt:</label>
					<input type="text" class="form-control" name="totalstockamount" id="totalstockamount" style="">

					<div class="row">
						<div class="col-md-6">
							<label>Total Qty :</label>
							<input type="text" class="form-control" name="totalqty" id="totalqty">
						</div>
						<div class="col-md-6">
							<label>Total Amount :</label>
							<input type="text" class="form-control" name="totalamount" id="totalamount">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Additional Cost :</label>
							<input type="text" value="0" class="form-control" name="additionalcost" id="additionalcost">
						</div>
						<div class="col-md-6">
							<label>Tax Amount :</label>
							<input type="text" class="form-control" name="taxamount" id="taxamount">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Bill Discount :</label>
							<input type="text" value="0" class="form-control" name="billdiscount" id="billdiscount">
						</div>
						<div class="col-md-6">
							<label>Grand Total :</label>
							<input type="text" class="form-control" name="grandtotal" id="grandtotal">
						</div>
					</div>
				</fieldset>
				<hr>
				<fieldset style="font-size: 14px;background: #f0f0f0; font-style: bolder">Payment
					<div class="row form-group">
						<div class="col-md-4 form-group">
							<label style="color: black">Old Balance :</label>
							<input type="text" name="oldbalance" id="oldbalance" class="form-control" autocomplete="off">
						</div>
						<div class="col-md-4 form-group">
							<label style="color: black">Cash :</label>
							<select class="form-control" id="cash" name="cash">
								<?php
                      			foreach ($CashLedgers->result() as $cledger) {
                     			?>
								<option value="<?php echo $cledger->ledgerid; ?>"><?php echo $cledger->ledgername; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-4 form-group">
							<label style="color: black">Bank :</label>
							<select class="form-control" id="bank" name="bank">
								<?php
                      			foreach ($BankLedgers->result() as $bledger) {
                     			?>
								<option value="<?php echo $bledger->ledgerid; ?>"><?php echo $bledger->ledgername; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4 form-group">
							<label style="color: black">Balance :</label>
							<input type="text" name="balance" id="balance" class="form-control" autocomplete="off">
						</div>
						<div class="col-md-4 form-group">
							<label style="color: black">Paid Cash :</label>
							<input type="text" value="0" name="paidcash" id="paidcash" class="form-control" required autocomplete="off">
						</div>
						<div class="col-md-4 form-group">
							<label style="color: black">Paid Bank :</label>
							<input type="text" value="0" name="paidbank" id="paidbank" class="form-control" required autocomplete="off">
						</div>
					</div>
				</fieldset>
				<hr>
				<div class="row margin" style="text-align: center">


					<div class="offset-md-4" style="display: inline-block">
						<input class="btn btn-success" type="button" name="btnsave" id="det" value="Save">
						<input class="btn btn-danger" type="submit" name="btndelete" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_customer">
						<input class="btn btn-info" type="submit" name="btnclear" formaction="javascript:void(0);" value="Clear">
						<input  class="btn btn-warning" type="submit" name="" value="Close" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<script src="<?php echo base_url(); ?>js/jquery.js"></script> -


<script type="text/javascript">
	$("#supplier").change(function () {
		try {
			var val = $('#supplier').val();

			var balance = $('#supplier1 option').filter(function () {
				return this.value == val;
			}).data('supplierbalance');



			document.getElementById("oldbalance").value = balance;


		} catch (err) {
			alert(err.message);
		}

	});
	window.onload = function () {
		document.getElementById("oldbalance").value = "0.00";
	}
	$('#billdiscount').on('keyup change', function () {
		calculation();


	});
	$('#additionalcost').on('keyup change', function () {

		calculation();

	});

	$('#paidcash').on('keyup change', function () {


		document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
	});

	$('#paidbank').on('keyup change', function ()
	{
		document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
	});



	$('#dataTable1').on('keyup change', '.qty', function () {


		var a = $(this).closest("tr")[0].rowIndex;

		rowcalculation(a);
		calculation();
	});
	$('#dataTable1').on('keyup change', '.unitprice', function () {


		var a = $(this).closest("tr")[0].rowIndex;
		rowcalculation(a);
		calculation();


	});
	$('#dataTable1').on('click', '.delete', function (e) {
		e.preventDefault();



		$(this).closest('tr').remove();
		var table = document.getElementById('dataTable1');
		var ab = table.rows.length;
		for (var i = 1; i < table.rows.length + 1; i++) {
			table.rows[i].cells[0].innerHTML = i;
		}



		calculation();
	});

	function rowcalculation(a) {
		if (a == 1) {
			var QTY = $('#qty1').val();

			var purchaserate = $('#unitprice').val();

			$('#amount1').val(QTY * purchaserate);
			var val = $('#productcode1').val();

			var tax = $('#name option').filter(function () {
				return this.value == val;
			}).data('tax');

			var netamount = QTY * purchaserate;
			var taxamount = netamount * tax / 100;

			$('#taxamount1').val(taxamount);
			$('#totalamount1').val(taxamount + netamount);

		} else {
			var QTY = $('#qty' + a).val();

			var purchaserate = $('#unitprice' + a).val();

			$('#amount' + a).val(QTY * purchaserate);
			var val = $('#productcode' + a).val();

			var tax = $('#name option').filter(function () {
				return this.value == val;
			}).data('tax');
			var netamount = QTY * purchaserate;
			var taxamount = netamount * tax / 100;
			$('#taxamount' + a).val(taxamount);
			$('#totalamount' + a).val(taxamount + netamount);

		}
	}
</script>
<script type="text/javascript">
	$('#addrow').on('click', function () {
		ctr++;

		var tr = "tr" + ctr;
		var productcode = "productcode" + ctr;
		var unitprice = "unitprice" + ctr;
		var qty = "qty" + ctr;
		var size = "size" + ctr;
		var hsn = "hsn" + ctr;
		// var sqft = "sqft" + ctr;<td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' + sqft + '" name="productcode"></td>
		var amount = "amount" + ctr;
		var batch = "batch" + ctr;
		var tax = "tax" + ctr;
		var taxamount = "taxamount" + ctr;
		var totalamount = "totalamount" + ctr;

		var rowCount = document.getElementById('dataTable').rows.length + 1;
		var newTr = '<tr><td>' + rowCount +
			'</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +
			productcode + '"></td><td> <input type="number" value="1" class="form-control" autocomplete="off" id="' + hsn + '" name="productcode"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' + qty + '" name="productcode"></td><td><input type="text" id="' + size + '" class="form-control" list="size" name="" ></td><td><input type="text" id="' + batch + '" class="form-control" list="bat" name=""></td><td><input type="text" id="' + unitprice + '" class="form-control unitprice" name=""></td><td><input type="text" id="' + amount + '" class="form-control" name=""></td><td><input type="text" id="' + taxamount + '" class="form-control"  name=""></td><td><input type="text" id="' + totalamount + '" class="form-control"  name=""></td><td class="ctr" style="display:none">' + ctr +'</td> <td><a href="" class="delete" >X</a></td> </tr>';
		$('#dataTable1').append(newTr);



	});
</script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {


				$('#det').on('click', function () {

						// var Finaltaxamount=0.00;
						var voucherno = document.getElementById("voucherno").value;
						var supplier = document.getElementById("supplier").value;
						var order = document.getElementById("orderno").value;
						var vendor = document.getElementById("vendor").value;
						var date = document.getElementById("invoicedate").value;
						var payment = 'cash';
						// alert (payment);
						var narration = document.getElementById("narration").value;
						var company = document.getElementById("company").value;
						var totalqty = document.getElementById("totalqty").value;
						var totalamount = document.getElementById("totalamount").value;
						var additionalcost = document.getElementById("additionalcost").value;
						var tax1 = document.getElementById("taxamount").value;
						var discount = document.getElementById("billdiscount").value;
						var mrp = document.getElementById("mrp").value;
						var total = document.getElementById("grandtotal").value;
						var oldbalance = document.getElementById("oldbalance").value;
						var cash = document.getElementById("cash").value;
						var bank = document.getElementById("bank").value;
						var branch = document.getElementById("branch").value;
						var paidcash = document.getElementById("paidcash").value;
						var paidbank = document.getElementById("paidbank").value;
						var balance = document.getElementById("balance").value;
						var TotalPurchasedStockAmount = document.getElementById("totalamount").value;
              // alert(TotalPurchasedStockAmount);
						$.noConflict();


						try {

							$.ajax({

									type: "POST",
									// dataType:"json",
									url: "<?php echo base_url() ?>index.php/Purchasecontrol/insertdetailes",
									data: {
										'voucherno': voucherno,
										'supplier': supplier,
										'order': order,
										'vendor': vendor,
										'date': date,
										'payment': payment,
										'narration': narration,
										'company': company,
										'totalqty': totalqty,
										'totalamount': totalamount,
										'additionalcost': additionalcost,
										'tax': tax1,
										'discount': discount,
										'total': total,
										'oldbalance': oldbalance,
										'cash': cash,
										'bank': bank,
										'paidcash': paidcash,
										'paidbank': paidbank,
										'mrp': mrp,
										// 'branch':branch,
										'balance': balance
									},
									success: function (data) {
										// alert("master");

										var ctr = 1;
										var table = document.getElementById('dataTable1');
										for (var i = 1; i < table.rows.length; i++) {
											var product = $('#productcode' + i).val();
											var productname = "";
											var unitprice = 0;
											var qty = 0;
											var batch=0;

											if (i == 1) {
												unitprice = $('#unitprice').val();
												qty = $('#qty1').val();
											 batch =  $('#batch').val();

											} else {
												unitprice = $('#unitprice' + i).val();
												qty = $('#qty' + i).val();
											    batch =  $('#batch' + i).val();

											}
                                            
											var mrp = "";
											var netamount = $('#amount' + i).val();

											// var tax = $('#tax'+i).val();
											var tax = 0.00;
											var taxamount = $('#taxamount' + i).val();
											// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
											// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
											var amount = $('#totalamount' + i).val();
											if (1 == 2) {

											} else {

												$.ajax({

														type: "POST",
														url: "<?php echo base_url() ?>index.php/Purchasecontrol/inserttable",
														data: {
															'voucherno': voucherno,
															'invoicedate': date,
															'productname': productname,
															'productcode': product,
															'qty': qty,
															'unitprice': unitprice,
															'netamount': netamount,
															'tax': tax,
															'taxamount': taxamount,
															'mrp': mrp,
															'branch': branch,
															'batch': batch,
															'amount': amount
														},
														success: function (data) {
															var result1 = JSON.stringify(data);
															// alert(result1);
															
															$('#orderno').val('');
															$('#vendor').val('');
															$('#invoicedate').val('');
															$('#payment').val('');
															$('#narration').val('');
															$('#company').val('');
															$('#totalqty').val('');
															$('#totalamount').val('');
															$('#additionalcost').val('');
															$('#taxamount').val('');
															$('#billdiscount').val('');
															$('#grandtotal').val('');
															$('#oldbalance').val('');
															$('#cash').val('');
															$('#bank').val('');
															$('#totalstockamount').val('');
															$('#paidcash').val('');
															$('#paidbank').val('');
															$('#balance').val('');
															$('#dataTable  tr').remove();
															for (var i = 0; i < qty; i++)
															{
																var divToPrint1 = document.getElementById("barcode");
																var divToPrint2 = document.getElementById("barcodemrp");
																document.getElementById("barcodemrp").innerHTML = unitprice;
																JsBarcode("#barcode", product, {
																	lineColor: "#000",
																	height: 40
																});
																// newWin = window.open("");
																// newWin.document.write("<center style='font-size=20'>MRP:" + unitprice +
																// " </center>");
																// newWin.document.write(divToPrint1.outerHTML);
																// newWin.print();
																// newWin.close();
															}
																document.getElementById("barcode").style.visibility = "hidden";
																document.getElementById("barcode").style.display = "none"; document.getElementById("barcodemrp").style.visibility = "hidden";
																},

																//end of second success

															error: function (data) 
															{
																var result1 = JSON.stringify(data);
																alert(result1);
																alert('Error occur...!! adding');
															}


														});

													//end of second ajax  
												} //end of else



											} //end of for loop

											//PurchaseInvoice_AccountInsertion_End
											//PurchaseInvoice_DayBookInsertion_Start

											$.ajax({
												type: "POST",
												url: "<?php echo base_url() ?>index.php/Purchasecontrol/PurchaseInvoice_DyaBookInsertion",
												data: {
													
													'voucherno': voucherno,
													'date': date,
													'totalamount': totalamount,
													'tax': tax1,
													'paidcash': paidcash,
													'paidbank': paidbank,
													'paymentmode': payment,
													'discount':discount,
													'balance':balance,
													'cash':cash,
													'bank':bank,
													'supplier':supplier
												},

												success: function (data) {
														var result1 = JSON.stringify(data);
																	// alert(result1);
													// alert("DayBook Insertion successfully completed");
													//PurchaseInvoice_AccountInsertion_Start
                                                   
													$.ajax({
														type: "POST",
														url: "<?php echo base_url() ?>index.php/Purchasecontrol/PurchaseInvoice_AccountInsertion",
														data: {
															'PurchaseDiscount': discount,
															'TotalPurchasedStockAmount': TotalPurchasedStockAmount,
															'TotalTaxAmt': tax1,
															'qty': qty,
															'unitprice': unitprice,
															'mrp': mrp,
															'balance': balance,
															'supplierid': supplier,
															'cash': cash,
															'bank': bank,
															'paidcash': paidcash,
															'paidbank': paidbank,
															'Bankaccount': bank
														},

														success: function (data) {
															// alert("Account Insertion successfully completed");
															var result1 = JSON.stringify(data);
																	// alert(result1);
															// //Autogenerate_VoucherNo_start

															$.ajax({
																type: "POST",
																dataType: "json",
																url: "<?php echo base_url() ?>index.php/Purchasecontrol/Autogenerate_PurchaseVoucherNo",
																data: {

																},

																success: function (data) {
																	// alert("voucher no retrieved");
																	$("#voucherno").val(data[0].NO);
																},
																error: function (data) {
																	var result1 = JSON.stringify(data);
																	alert(result1);
																}

															});
														},
														error: function (data) {
															var result1 = JSON.stringify(data);
															alert(result1);
														}

													});
												}

											});

											//PurchaseInvoice_DayBookInsertion_End



											// //Autogenerate_VoucherNo_End


            var bicus= $("#supplier option:selected").text();

                                       $('#billcust').html(bicus);
                                       $('#billtotal').html(totalamount);
                                       $('#billgrand').html(total);
                                       $('#billtax').html(taxamount);
                                              var content = document.getElementById("billing").innerHTML;
                                              var not = document.getElementById("notices").innerHTML;
                                              var foot = document.getElementById("billfoot").innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');
    mywindow.document.write('<html><head><title>Print</title>');
    mywindow.document.write('</head><body>');
    mywindow.document.write(content);
    mywindow.document.write('<table><thead><tr><th>SL.NO</th><th>PRODUCT NAME</th><th>QTY</th><th>UNIT PRICE</th><th>TAX AMOUNT</th><th>TOTAL AMOUNT</th></tr></thead><tbody>');
    var table = document.getElementById('dataTable1');
    var n=1;
									for (var i = 1; i < table.rows.length; i++) {
										var product = $('#productcode' + i).val();

											var productname = "";


											var mrp = 0;
											var qty = 0;
											var batch=0;
											if (i == 1) {
												mrp = $('#mrp1').val();
												qty = $('#qty1').val();

											} else {
												unitprice = $('#unitprice' + i).val();
												qty = $('#qty' + i).val();

											}
                                            
											var netamount = $('#amount' + i).val();
											// var tax = $('#tax'+i).val();
											var tax = 0.00;
											var taxamount = $('#taxamount' + i).val();
											// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
											// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
											var amount = $('#totalamount' + i).val();

 mywindow.document.write('<tr><td>'+n+'</td><td>'+product+'</td><td>'+qty+'</td><td>'+mrp+'</td><td>'+taxamount+'</td><td>'+amount+'</td></tr>');
n++;
										}
								 mywindow.document.write('<tr><td colspan="5">SUBTOTAL</td><td class="total" id="billtotal">'+totalamount+'</td></tr><tr><td colspan="5">TAX</td><td class="total" id="billtax">'+taxamount+'</td></tr><tr><td colspan="5" class="grand total">GRAND TOTAL</td><td class="grand total" id="billgrand">'+total+'</td></tr></tr><tr><td colspan="5" class="grand total">PAID AMOUNT</td><td class="grand total" id="billgrand">'+paidcash+'</td></tr></tr><tr><td colspan="5" class="grand total">BALANCE</td><td class="grand total" id="billgrand">'+balance+'</td></tr>');
    mywindow.document.write('</tbody></table>');
    mywindow.document.write('</body></html>');
    mywindow.document.write(not);
    mywindow.document.write(foot);

    mywindow.document.close();
    mywindow.focus();
    mywindow.print();
    mywindow.close(); 
                                        
                              









										}, //end of first success
										error: function (data) {
											var result1 = JSON.stringify(data);
											alert(result1);
											// alert('last');
										}
									}); //end of first ajax


							}
							catch (err) {
								alert(err.message);
							}
						});

					//Save product

				});
</script>
<div id="barcodemrp" style="display: none;"></div>
<svg id='barcode' style="display: none;"></svg>
</div>

			<div class="billing" id="billing" style="display: none;">
				<style type="text/css">
					.clearfix:after {
  content: "";
  display: table;
  clear: both;
}



.billing {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

.billhead{
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

.billfoot {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
</style>
<header class="clearfix">
      <div id="logo">
        <img src="logo.png">
      </div>
      <h1 class="billhead">INVOICE</h1>
     
      <div id="project">
        <div><span>CONTENT</span>PURCHASE INVOICE</div>
        <div><span>CLIENT</span> <span id="billcust"></span></div>
         </div>
    </header>
    <main>
     
      <div style="display: none">
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
  </div>
    </main>
      <div style="display: none">
    <footer class="billfoot" id="billfoot">
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</div>
			</div>