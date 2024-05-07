<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<script type="text/javascript">
	var ctr = 0;
	$(document).ready(function () {

		ctr = document.getElementById('dataTable').rows.length;
	});
</script>

<script type="text/javascript">
	// $.noConflict();
	// var ctr = 1;
	var totalstockamount = 0;
	$(document).ready(function () {


		$('#dataTable1').on('change', '.productcode2', function () {
// alert("gf");
			ctr++;
			var a = $(this).closest("tr").find('.ctr').text();
			if (a == 1) {
				var code = $('#productcode1').val();
			} else {
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
						var mrp = result[0]['mrp'];
						var hsn = result[0]['hsncode'];
						var purchaserate = result[0]['purchaserate'];
						var taxpercentage =0;
						if("tax"=="sales with tax"){
							taxpercentage = result[0]['tax'];
						}
						else{
							taxpercentage = 0;
						}
						var netamount = mrp * Qty;
						var taxamount = mrp * Qty * taxpercentage / 100;
						if (a == 1)
						{
							$('#mrp1').val(mrp);
							$('#amount1').val(mrp * Qty);
							$('#taxamount1').val(taxamount);
							$('#hsn1').val(hsn);
							// $('#size').val(size);
							// $('#sq1').val(sq);
							$('#totalamount1').val(netamount + taxamount);
						}
						else
						{
							$('#mrp' + a).val(mrp);
							$('#amount' + a).val(mrp * Qty);
							$('#taxamount' + a).val(taxamount);
							$('#hsn' + a).val(hsn);
							// $('#size' + a).val(size);
							// $('#sq' + a).val(sq);
							$('#totalamount' + a).val(netamount + taxamount);
						}



						var tr = "tr" + ctr;
						var productcode = "productcode" + ctr;
						var unitprice = "unitprice" + ctr;
						var mrp = "mrp" + ctr;
						var qty = "qty" + ctr;
						var size = "size" + ctr;
						var hsn = "hsn" + ctr;
						// var sqft = "sqft" + ctr;
						// var sq = "sq" + ctr;<td style="display:none;"> <input type="number" value="1" class="form-control sqft" autocomplete="off" id="' + sqft + '" name="productcode"></td><td style="display:none;"> <input type="number" class="form-control sq" autocomplete="off" id="' + sq + '" name="productcode"></td> // to add in row
						var amount = "amount" + ctr;
						var batch = "batch" + ctr;
						var tax = "tax" + ctr;
						var taxamount = "taxamount" + ctr;
						var totalamount = "totalamount" + ctr;
						var oldqty = "oldqty" + ctr;

						var rowCount = document.getElementById('dataTable').rows.length + 1;

						var newTr = '<tr><td>' + rowCount +
							'</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +
							productcode +
							'"></td><td style="display:none"> <input type="number" value="1" class="form-control" autocomplete="off" id="' +
							hsn + '" name="productcode"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' +
							qty + '" name="productcode"></td><td><input type="text" id="' + size +
							'" class="form-control" list="size" name="" ></td><td style="display:none"><input type="text" id="' +
							batch +
							'" class="form-control" list="bat" name="" ></td><td><input type="text" id="' +
							mrp +
							'" class="form-control mrp" name="" value="0.00"></td><td><input type="text" id="' +
							amount +
							'" class="form-control" name=""></td><td style="display:none"><input type="text" id="' +
							taxamount +
							'" class="form-control"  name=""></td><td><input type="text" id="' +
							totalamount +
							'" class="form-control"  name=""></td><td class="ctr" style="display:none">' +
							ctr +
							'</td> <td ><a href="" class="delete" >X</a></td><td style="display:none;"><input type="text" id="' +
							oldqty +
							'" class="form-control"  value="0"  name=""></td> </tr>';
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
			totalstockamount = 0;
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
			var purchaserate = 0;
			var mrp1 = 0;
			for (var n = 1; n < table.rows.length; n++) {
				var i = 0;
				try {
					i = document.getElementById('dataTable').rows[n - 1].cells[10].innerHTML;
					mrp1 = $('#mrp' + i).val();
				} catch (err) {

				}

				if (document.getElementById('productcode' + i).value == null || document.getElementById('productcode' + i)
					.value == "") {

				} else {
					var val = $('#productcode' + i).val();
					purchaserate = $('#name option').filter(function () {
						return this.value == val;
					}).data('purchaserate');
					rowqty = document.getElementById('qty' + i).value * 1;

					rownetamount = document.getElementById('amount' + i).value * 1;
					rowtaxamount = document.getElementById('taxamount' + i).value * 1;
					rowtotalamount = document.getElementById('totalamount' + i).value * 1;
					qty = qty + rowqty;

					netamount = netamount + rownetamount;
					taxamount = taxamount + rowtaxamount;
					totalamount = totalamount + rowtotalamount;
					totalstockamount = totalstockamount + purchaserate * rowqty;
				}

			}


			$('#totalqty').val((qty).toFixed(2));
			$('#totalamount').val( netamount.toFixed(2));
			$('#taxamount').val((taxamount).toFixed(2));
			var billdiscount = $('#billdiscount').val();
			var pointredeem = $('#pointredeem').val() * 1;
			var additionalcost = $('#additionalcost').val() * 1;
			$('#grandtotal').val((netamount + taxamount - billdiscount - pointredeem + additionalcost).toFixed(2));
			document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document
				.getElementById("grandtotal").value * 1);
		} catch (err) {
			alert(err);
		}


	}
</script>
<!-- <link rel="stylesheet" href="<?php echo base_url();?>css/stylebill.css"> -->
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Sales Update
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="#">Forms</a></li> -->
			<li class="active">Sales Update</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-default">
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Invoice No</label>
							
							<input type="text" class="form-control" required autocomplete="off"
								value="<?php echo $master['invoiceno'];?>" name="invoiceno" id="invoiceno">
								<input type="hidden" class="form-control"  autocomplete="off"
								value="<?php echo $master['salesmasterid'];?>" name="masterid" id="masterid">
							
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Customer</label>
							<input type="text" class="form-control" list="customerlist" required autocomplete="off"  name="customer" id="customer" value="<?php echo  $master['customerid'];?>">
								<!-- <option value="0" data-balance="0.00">Select Customer</option> -->

								<datalist id="customerlist">
								<?php
								foreach ($customer->result() as $cust)
								{
								?>
								<option value="<?php echo $cust->customerid; ?>" data-phonenumber="<?php echo $cust->phonenumber;?>" data-points="<?php echo $cust->points;?>" data-custname="<?php echo $cust->customername;?>" data-balance="<?php echo $cust->currentbalance;?>" label="<?php echo $cust->phonenumber;?>"></option>
								<?php } ?>
							</datalist>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales Order No</label>
							<input type="text" value="<?php echo $master['salesorderno'];?>" class="form-control"
								autocomplete="off" id="salesorderno" name="salesorderno">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales date</label>
							<input type="text" disabled="" class="form-control" value="<?php echo  $master['salesdate'];?>"
								id="salesdate" value="<?php $d=strtotime("now");$e=strtotime("-7 hours",$d); echo date("Y-m-d H:i:s",$e);?>"  name="salesdate">
						</div>
					</div>
					<div class="col-md-4" style="">

						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Branch</label>
							<select class="form-control" name="branch" id="branch">
								<?php
                      foreach ($branch->result() as $branchh) { ?>
								<?php if($branchh->branchid==$master['branchid']){?>
									
								<option value="<?php echo $branchh->branchid;?>"  data-branchname="<?php echo $branchh->branchname;?>" data-address="<?php echo $branchh->address;?>" data-gstno="<?php echo $branchh->gstno;?>" data-phonenumber="<?php echo $branchh->phonenumber;?>" selected ><?php echo $branchh->branchname; ?></option>
								
								<?php }
								else{?>
								<option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>" ><?php echo $branch->branchname; ?></option>
								<?php }
							  }?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Salesman</label>
							<select class="form-control" name="salesman" id="salesman">
                      <option value="0" data-balance="0.00">Select Salesman</option>

								<?php
                      foreach ($salesman->result() as $sal) {
                     ?>
								<option value="<?php echo $sal->salesmanid; ?>">
									<?php echo $sal->salesmanname; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<hr>


				<div class="table table-responsible">
					<TABLE id="dataTable1" border="1" class="table table-striped table-hover">
						<thead>
							<tr>
								<th>SL.NO</th>
								<th>PRODUCT NAME</th>
								<th style="display:none">HSN CODE</th>
								<th>QTY</th>
								<th class="d-none d-xl-block">SIZE</th>
								<th style="display:none" class="d-none d-xl-block">BATCH</th>
								<!-- 	<th class="d-none d-xl-block" style="display:none">UNIT PRICE</th> -->
								<th class="d-none d-xl-block">MRP</th>
								<th class="d-none d-xl-block" style="display:none">NET AMOUNT</th>
								<th class="d-none d-xl-block" style="display:none">TAX AMOUNT</th>
								<th class="d-none d-xl-block">TOTAL AMOUNT</th>
								<th class="d-none d-xl-block" style="display: none;"></th>
								<th style="" class="d-none d-xl-block"></th>
								<th style="display: none;">old hsn</th>
								<th style="display: none;">old qty</th>
							</tr>
						</thead>
						<tbody id="dataTable" width="100%" class="table table-hover">
												<?php
							$n=1; 
							foreach($detailes->result() as $pt){
							?>
							<tr>
								<td>1</td>
								<td> <input type="text" value="<?php echo $pt->productcode;?>"
										class="form-control productcode2" list="name" autocomplete="off"
										name="productname" id="<?php echo "productcode".$n;?>">
								</td>
								<datalist id="name">
									<?php foreach($product->result() as $gp){
                                    ?>
									<option value="<?php echo $gp->pdt_code;?>"
										data-purchaserate="<?php echo $gp->purchaserate;?>"
										data-tax="<?php echo $gp->tax;?>" label="<?php echo $gp->pdt_name;?>">
										<?php  } ?>

								</datalist>
								<td style="display: none;">
									<input type="number" class="form-control qty" value="<?php echo $pt->hsncode;?>" autocomplete="off" id="hsn1" name="productcode">
								</td>
								<td><input type="number" value="<?php echo $pt->qty;?>" class="form-control qty"autocomplete="off" id="<?php echo "qty".$n;?>" name="productcode">
								</td>								
								<td>
								<input type="text" id="<?php echo "size".$n;?>" value="<?php echo $pt->size; ?>" required class="form-control" list="size" autocomplete="off"	name="size" required></td>
										<datalist id ="size">
										<?php
									  			foreach ($size->result() as $row)
									  			{
                     						?>											 
											 <option value="<?php echo $row->sizeid; ?>" label="<?php echo $row->sizevalue; ?>">
										<?php } ?>
										</datalist>
								</td>
								<td style="display:none"><input type="text" id="<?php echo "batch".$n;?>" value="<?php echo $pt->batchid;?>" list="bat"
										class="form-control" name=""></td>
								<datalist id="bat">
									<?php foreach($batch->result() as $gp){
                                      ?>
									<option value="<?php echo $gp->batchid;?>" label="<?php echo $gp->batchname;?>">
										<?php  } ?>
								</datalist>
								<!-- <td><input type="text" id="unitprice" class="form-control unitprice" name="" style="display:none"></td> -->
								<td><input type="text" id="<?php echo "mrp".$n;?>" value="<?php echo $pt->unitprice;?>" class="form-control mrp" name="" value="0.00"></td>
								<td style="display:none"><input type="text" id="<?php echo "amount".$n;?>" value="<?php echo $pt->netamount;?>" class="form-control" name=""></td>
								<td style="display:none"><input type="text" id="<?php echo "taxamount".$n;?>" value="<?php echo $pt->taxamount;?>" class="form-control" name=""></td>
								<td><input type="text" id="<?php echo "totalamount".$n;?>" value="<?php echo $pt->amount;?>" class="form-control" name=""></td>
								<td class="ctr" style="display: none"><?php echo $n;?></td>
								<td style=""><a href="" class="delet"></a></td>
								<td style="display: none;"><input type="text" id="<?php echo "oldhsn".$n;?>" value="<?php echo $pt->hsncode;?>" class="form-control" name=""></td>
								<td style="display: none;"><input type="text" id="<?php echo "oldqty".$n;?>" value="<?php echo $pt->qty;?>" class="form-control" name=""></td>
							</tr>
							<?php
							$n++;
                 	 }?>
                 	</tbody>
					</TABLE>
					
					<input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
				</div>
				<hr>
				<div class="row col-md-12">
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Total Qty</label>
							<input type="text" class="form-control" value="<?php echo $master['totalqty'];?>" name="totalqty"
								id="totalqty">
						</div>
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Total Amount</label>
							<input type="text" class="form-control" value="<?php echo  $master['totalamount'];?>"
								name="totalamount" id="totalamount">
								<input type="hidden" class="form-control" value="<?php echo  $master['totalamount'];?>"
								name="totalamount" id="oldtotalamount">
								<input type="hidden" class="form-control" value="<?php echo  $master['stockamount'];?>"
								name="totalamount" id="oldstock">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Tax Amount</label>
							<input type="text" class="form-control" value="<?php echo  $master['taxamount'];?>"
								name="taxamount" id="taxamount"><input type="hidden" class="form-control" value="<?php echo  $master['taxamount'];?>"
								name="taxamount" id="oldtaxamount">
						</div>
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Additional Cost</label>
							<input type="text" value="<?php echo $master['additionalcost'];?>" class="form-control"name="additionalcost" id="additionalcost"><input type="hidden" value="<?php echo  $master['additionalcost'];?>" class="form-control"name="additionalcost" id="oldadditionalcost">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Bill Discount</label>
							<input type="text" value="<?php echo  $master['billdiscount'];?>" class="form-control"name="billdiscount" id="billdiscount">
							<input type="hidden" value="<?php echo  $master['billdiscount'];?>" class="form-control"name="billdiscount" id="oldbilldiscount">
						</div>
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Grand Total</label>
							<input type="text" class="form-control" value="<?php echo  $master['grandtotal'];?>"
								name="grandtotal" id="grandtotal">
							<input type="hidden" class="form-control" value="<?php echo  $master['grandtotal'];?>"
								name="grandtotal" id="oldgrandtotal">
						</div>
					</div>
				</div>
				<div class="row col-md-12">
					<fieldset style="border-color: #e4dddda8;width: 100%;">
						<legend style="width: auto;">Payment</legend>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Old Balance</label>
								<input type="text" name="oldbalance" id="oldbalance" class="form-control"
									autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Cash</label>
								<select class="form-control" id="cash" name="cash">
									<?php
                      foreach ($CashLedgers->result() as $cledger) {
                     				?>
									<option value="<?php echo $cledger->ledgerid; ?>"><?php echo $cledger->ledgername; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Bank</label>
								<select class="form-control" id="bank" name="bank">
									<?php
									  foreach ($BankLedgers->result() as $bledger)
									  {
                     				?>
									<option value="<?php echo $bledger->ledgerid; ?>"><?php echo $bledger->ledgername; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Point Balance</label>
								<input type="text" id="pointbalance" name="pointbalance" class="form-control" autocomplete="off">
							</div>
						</div>
					</fieldset>
				</div>
				<hr>
				<div class="row col-md-12">
					
				<fieldset style="border-color: #e4dddda8;width: 100%;">
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Balance</label>
								<input type="text" name="balance" value="<?php echo  $master['balance'];?>" id="balance" class="form-control" autocomplete="off">
								<input type="hidden" name="balance" value="<?php echo  $master['balance'];?>" id="oldbalance1" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Paid Cash</label>
								<input type="text" value="<?php echo  $master['paidcash'];?>" name="paidcash"
									id="paidcash" class="form-control" required autocomplete="off">
							<input type="hidden" value="<?php echo  $master['paidcash'];?>" name="paidcash" id="oldpaidcash" class="form-control" required autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Paid Bank</label>
								<input type="text" value="<?php echo  $master['paidbank'];?>" name="paidbank"
									id="paidbank" class="form-control" required autocomplete="off">
							<input type="hidden" value="<?php echo  $master['paidbank'];?>" name="paidbank" id="oldpaidbank" class="form-control" required autocomplete="off">
							
						</div>
					</div>
						<div class="col-md-3 subpay">
						<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Points Redeemed</label>
								<input type="text" value="0" name="pointredeem" id="pointredeem" class="form-control" required
									autocomplete="off">
							</div>
						</div>
						</fieldset>
						
				</div>
				<div class="row col-md-12 txn-bottom-form">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Narration</label>
							<textarea class="form-control" style="line-height:3.5" name="narration"
								id="narration"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Transportation Company</label>
							<input type="text" class="form-control" autocomplete="off" name="transportcompany"
								id="transportcompany">
						</div>
					</div>
				</div>
				</form>

				<hr>
				<div class="row col-md-12 form-group margin txn-bottom-form" style="text-align: center;">
					<div class="offset-md-4">
						<!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
						<!-- <input class="btn btn-success" type="button" name="btnsave" value="Update" id="btnsave"> -->
						<input class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete">
						<input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
						<input class="btn btn-warning" type="submit" name="btnclose" value="Close" id="btnclose">
					</div>
				</div>
			</div>
		



			<script type="text/javascript" href="js/bootstrap.js"></script>
			<script type="text/javascript" href="js/bootstrap.min.js"></script>
			<script type="text/javascript" href="js/jquery-3.1.1.js"></script>
			<script type="text/javascript" href="js/jquery-3.1.1.min.js"></script>
			<script type="text/javascript">
				var points = '';
				var custname = '';
				var custpho = '';
				$("#customer").change(function ()
				{
					try
					{
						var val = $('#customer').val();
						var balance = $('#customerlist option').filter(function ()
						{return this.value == val;}).data('balance');
						document.getElementById("oldbalance").value = balance;
						custname = $('#customerlist option').filter(function ()
						{return this.value == val;}).data('custname');
						points = $('#customerlist option').filter(function ()
						{return this.value == val;}).data('points');
						document.getElementById("pointbalance").value = points;
						custpho = $('#customerlist option').filter(function ()
						{return this.value == val;}).data('phonenumber');
					}
					catch(err)
					{
						alert(err.message);
					}
				});

				var branchname='';
			var branchadd='';
			var branchpho='';
			var gstno='';
			var branch = document.getElementById('branch');
			branch.onchange=function ()
			{
				var branchid = document.getElementById('branch').value;
				$.ajax({
		  			type: "POST",
		  			dataType:"json",
		  			url:"<?php echo base_url();?>index.php/Salescontrol/autogenerate_inv",
		  			data: {
			  			'branchid':branchid
					},
					success: function (result) {
						var inv=result[0]['NO'];
						$('#invoiceno').val(inv);
					},
					error: function (xhr) {
                      alert(xhr.responseText);
					}
				});
				try
				{
					branchname = branch.options[branch.selectedIndex].getAttribute("data-branchname");
					branchadd = branch.options[branch.selectedIndex].getAttribute("data-address");
					branchpho = branch.options[branch.selectedIndex].getAttribute("data-phonenumber");
					gstno = branch.options[branch.selectedIndex].getAttribute("data-gstno");
				}
				catch(err)
				{
					alert(err.message);
				}
			}
			
			var salesmanname='';
			var salesman = document.getElementById("salesman");
			salesman.onchange=function ()
			{
				try
				{
					salesmanname= salesman.options[salesman.selectedIndex].text;
				}
				catch(err)
				{
					alert(err.message);
				}
			}
			
			window.onload = function () {
					document.getElementById("oldbalance").value = "0.00";
					document.getElementById("pointbalance").value = "0.00";
					document.getElementById("cash").value="<?php echo  $master['cash'];?>";
					document.getElementById("bank").value="<?php echo  $master['bank'];?>";
				}

				$('#billdiscount').change(function () {
					calculation();
				});

				$('#pointredeem').change(function () {
					calculation();
				});


				$('#additionalcost').change(function () {
					calculation();
				});
				
				$('#paidcash').change(function () {
					
					document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
				});
					
				$('#paidbank').change(function () {
					document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
				});


				$('#dataTable1').on('change', '.qty', function () {


					var a = $(this).closest("tr")[0].rowIndex;

					rowcalculation(a);
					calculation();
				});
				$('#dataTable1').on('change', '.mrp', function () {


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
						var QTY = $('#qty1').val() * 1;

						var mrp = $('#mrp1').val() * 1;

						$('#amount1').val(QTY * mrp);
						var val = $('#productcode1').val();



						var tax = $('#name option').filter(function () {
							return this.value == val;
						}).data('tax');

						var netamount = QTY * mrp;
						var taxamount = netamount * tax / 100;


						$('#taxamount1').val(taxamount);
						$('#totalamount1').val(taxamount + netamount);

					} else {
						var QTY = $('#qty' + a).val();

						var mrp = $('#mrp' + a).val();

						$('#amount' + a).val(QTY * mrp);
						var val = $('#productcode' + a).val();




						var tax = $('#name option').filter(function () {
							return this.value == val;
						}).data('tax');


						var netamount = QTY * mrp;
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
					var mrp = "mrp" + ctr;
					var qty = "qty" + ctr;
					var size = "size" + ctr;
					var hsn = "hsn" + ctr;
					var amount = "amount" + ctr;
					var batch = "batch" + ctr;
					var tax = "tax" + ctr;
					var taxamount = "taxamount" + ctr;
					var totalamount = "totalamount" + ctr;
					var oldqty = "oldqty" + ctr;
					var rowCount = document.getElementById('dataTable').rows.length + 1;
					var newTr = '<tr><td>' + rowCount +
						'</td><td ><input type="text" class="form-control productcode2" list="name" autocomplete="off" name="productname" id="' +
						productcode +
						'"></td><td style="display:none"> <input type="number" value="1" class="form-control" autocomplete="off" id="' + hsn + '" name="productcode"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' +
						qty + '" name="productcode"></td><td><input type="text" id="' + size + '" class="form-control" list="size" name="" ></td><td style="display:none"><input type="text" id="' + batch +
						'" class="form-control " list="bat" name="" ></td><td><input type="text" id="' + mrp +
						'" class="form-control mrp" name="" value="0.00"></td><td style="display:none"><input type="text" id="' + amount +'" class="form-control" name=""></td><td style="display:none"><input type="text" id="' + taxamount +
						'" class="form-control"  name=""></td><td><input type="text" id="' + totalamount +
						'" class="form-control"  name=""></td><td style="display:none" class="ctr">' + ctr +
						'</td> <td><a href="" class="delete" >X</a></td><td class="ctr" style="display:none;"><input type="text" id="' +oldqty + '" class="form-control" value="0"  name=""> </tr>';
					$('#dataTable1').append(newTr);
				});
			</script>
			<script type="text/javascript">
				$(document).ready(function () {
					$('#btnsave').on('click', function () {
						// alert(totalstockamount);
						var invoiceno = document.getElementById("invoiceno").value;
						var customer = document.getElementById("customer").value;
						var salesorderno = document.getElementById("salesorderno").value;
						// var Paymentmode = document.getElementById("Paymentmode").value;
						var salesdate = document.getElementById("salesdate").value;
						var totalqty = document.getElementById("totalqty").value;
						var totalamount = document.getElementById("totalamount").value;
						var oldtotalamount = document.getElementById("oldtotalamount").value;
						var additionalcost = document.getElementById("additionalcost").value;
						var taxamount = document.getElementById("taxamount").value;
						var oldtaxamount = document.getElementById("oldtaxamount").value;
						var billdiscount = document.getElementById("billdiscount").value;
						var oldbilldiscount = document.getElementById("oldbilldiscount").value;
						var grandtotal = document.getElementById("grandtotal").value;
						var oldgrandtotal = document.getElementById("oldgrandtotal").value;
						var oldbalance = document.getElementById("oldbalance").value;
						var oldstock = document.getElementById("oldstock").value;
						var cash = document.getElementById("cash").value;
						var bank = document.getElementById("bank").value;
						var paidcash = document.getElementById("paidcash").value;
						var paidbank = document.getElementById("paidbank").value;
						var oldpaidcash = document.getElementById("oldpaidcash").value;
						var oldpaidbank = document.getElementById("oldpaidbank").value;
						var branchid = document.getElementById("branch").value;
						var balance = document.getElementById("balance").value;
						var oldbalance1 = document.getElementById("oldbalance1").value;
						var narration = document.getElementById("narration").value;
						var transportcompany = document.getElementById("transportcompany").value;
						$.noConflict();
						try {
							$.ajax({
								type: "POST",
								// dataType:"json",
								url: "<?php echo base_url() ?>index.php/Salescontrol/update_salesinvoicemaster",
								data: {
									'invoiceno': invoiceno,
									'customer': customer,
									'salesorderno': salesorderno,
									'Paymentmode': 'cash',
									'salesdate': salesdate,
									'totalqty': totalqty,
									'totalamount': totalamount,
									'additionalcost': additionalcost,
									'taxamount': taxamount,
									'billdiscount': billdiscount,
									'grandtotal': grandtotal,
									'oldbalance': oldbalance,
									'cash': cash,
									'bank': bank,
									'paidcash': paidcash,
									'paidbank': paidbank,
									'totalstockamount': totalstockamount,
									'balance': balance,
									'narration': narration,
									'transportcompany': transportcompany,
									'branchid': branchid
								},
								success: function (data) {
									// var myJSON = JSON.stringify(data);
									// alert(myJSON);
									alert("master update");

									var table = document.getElementById('dataTable1');
									var invoiceno = document.getElementById("invoiceno").value;
									var salesdate = document.getElementById("salesdate").value;
									var branchid = document.getElementById("branch").value;
									var paidcash = document.getElementById("paidcash").value;
									var paidbank = document.getElementById("paidbank").value;
									var customer = document.getElementById("customer").value;
									var balance = document.getElementById("balance").value;
									var billdiscount = document.getElementById("billdiscount").value;

									for (var i = 1; i < table.rows.length-1; i++) {
										var product = $('#productcode' + i).val();
										  var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").attr('label');
										var mrp = 0;
										var old = 0;
										var hsn = 0;
										var size = 0;
										var qty = 0;
										var batch = 0;
										if (i == 1) {
											mrp = $('#mrp1').val();
											old = $('#oldqty1').val();
											qty = $('#qty1').val();
											hsn = $('#hsn1').val();
											size = $('#size1').val();
											batch = $('#batch').val();
										} else {
											mrp = $('#mrp' + i).val();
											size = $('#size'+ i).val();
											hsn = $('#hsn'+ i).val();
											qty = $('#qty' + i).val();
											old = $('#oldqty' + i).val();
											batch = $('#batch' + i).val();

										}
										// alert(old);
										var netamount = $('#amount' + i).val();
										// var tax = $('#tax'+i).val();
										var tax = 0.00;
										var taxamount = $('#taxamount' + i).val();
										// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
										// Finaltaxamount=parseInt(Finaltaxa mount,10) +parseInt(taxamount,10);
										var amount = $('#totalamount' + i).val();
										// alert(netamount);
										$.ajax({

											type: "POST",
											url: "<?php echo base_url() ?>index.php/Salescontrol/updatesalesinvoicedetails",
											data: {
												'salesmasterid':data,
												'invoiceno': invoiceno,
												'salesdate': salesdate,
												'productname': productname,
												'productcode': product,
												'qty': qty,
												'hsn': hsn,
												'size': size,
												'mrp': mrp,
												'old': old,
												'netamount': netamount,
												'tax': tax,
												'taxamount': taxamount,
												'amount': amount,
												'branchid': branchid,
												'batchid': batch
											},
											success: function (data) {
												var myJSON = JSON.stringify(data);
												
											},
											error: function (data) {
												var myJSON = JSON.stringify(data);
												alert("in details");
												alert(myJSON);
											}
										}); //product insert ajax   
									} //for loop

									$.ajax({
										type: "POST",
										url: "<?php echo base_url() ?>index.php/Salescontrol/SalesInvoice_DayBookUpdation",
										data: {
											'voucherno': invoiceno,
											'salesdate': salesdate,
											'totalamount': totalamount-oldtotalamount,
											'tax': taxamount-oldtaxamount,
											'paidcash': paidcash-oldpaidcash,
											'paidbank': paidbank-oldpaidbank,
											'paymentmode': 'cash',
											'discount': billdiscount-oldbilldiscount,
											'grandtotal': grandtotal-oldgrandtotal,
											'stock': totalstockamount-oldstock,
											'cash': cash,
											'bank':bank,
											'customer': customer,
											'balance': balance-oldbalance1,	
										},

										success: function (data) {
											var result1 = JSON.stringify(data);
											// alert(result1);
											alert(
												"DayBook Insertion successfully completed");
											//PurchaseInvoice_AccountInsertion_Start
										},
										error: function (data) {
											var myJSON = JSON.stringify(data);
											alert(myJSON);
										}

									});



									//acccount insertion

								// 	$.ajax({
								// 		type: "POST",
								// 		url: "<?php echo base_url() ?>index.php/Salescontrol/SalesInvoice_AccountUpdation",
								// 		data: {
								// 			'totalamount': totalamount,
								// 			'oldtotalamount': oldtotalamount,
								// 			'tax': taxamount,
								// 			'oldtax': oldtaxamount,
								// 			'paidcash': paidcash,
								// 			'paidbank': paidbank,
								// 			'oldpaidcash': oldpaidcash,
								// 			'oldpaidbank': oldpaidbank,
								// 			'paymentmode': 'cash',
								// 			'discount': billdiscount,
								// 			'olddiscount': oldbilldiscount,
								// 			'grandtotal': grandtotal,
								// 			'oldgrandtotal': oldgrandtotal,
								// 			'stock': totalstockamount,
								// 			'oldstock': oldtotalstockamount,
								// 			'cash': cash,
								// 			'bank': bank,
								// 			'customer': customer,
								// 			'balance': balance,
								// 			'oldbalance': oldbalance1
								// 		},

								// 		success: function (data) {
								// 			var result1 = JSON.stringify(data);
								// 			alert(result1);
								// 			alert(
								// 				"Account Insertion successfully completed");
											

								// 			alert("complete");
								// 	$('#orderno').val('');
								// 				$('#vendor').val('');
								// 				$('#invoicedate').val('');
								// 				$('#payment').val('');
								// 				$('#narration').val('');
								// 				$('#company').val('');
								// 				$('#totalqty').val('');
								// 				$('#totalamount').val('');
								// 				$('#additionalcost').val('');
								// 				$('#taxamount').val('');
								// 				$('#billdiscount').val('');
								// 				$('#grandtotal').val('');
								// 				$('#oldbalance').val('');
								// 				$('#cash').val('');
								// 				$('#bank').val('');
								// 				$('#paidcash').val('');
								// 				$('#paidbank').val('');
								// 				$('#pointredeem').val('');
								// 				$('#pointbalance').val('');
								// 				$('#balance').val('');
								// 				$('#dataTable  tr').remove();
								// 				ctr=1;
								// 				var tr = "tr" + ctr;
								// 				//PurchaseInvoice_AccountInsertion_Start
								// 		},
								// 		error: function (data) {
								// 			var myJSON = JSON.stringify(data);
								// 			alert(myJSON);
								// 		}

								// 	});
								location.reload();

								}, //master success
								error: function (data) {
									var myJSON = JSON.stringify(data);
									alert(myJSON);
								}
							});

						} //try
						catch (err) {
							alert(err.message);
						}
					});

					//Save product

				});
				$(document).ready(function () {
					$('#btndelete').on('click', function () {
						var masterid =document.getElementById("masterid").value;
						var invoiceno = document.getElementById("invoiceno").value;		
						var invno =invoiceno;			
						var customer = document.getElementById("customer").value;
						var customer1 =customer;
						var salesorderno = document.getElementById("salesorderno").value;
						// var Paymentmode = document.getElementById("Paymentmode").value;
						var salesdate = document.getElementById("salesdate").value;
						var date = salesdate;
						var totalqty = document.getElementById("totalqty").value;
						var totalamount = document.getElementById("totalamount").value;
						var additionalcost = document.getElementById("additionalcost").value;
						var taxamount = document.getElementById("taxamount").value;
						var taxamount1 = taxamount;
						var billdiscount = document.getElementById("billdiscount").value;
						var billdiscount1=billdiscount;
						var grandtotal = document.getElementById("grandtotal").value;
						var grandtotal1 =grandtotal;
						var oldbalance = document.getElementById("oldbalance").value;
						var paidcash = document.getElementById("paidcash").value;
						var paidcash1 =paidcash;
						var paidbank = document.getElementById("paidbank").value;
						var paidbank1 =paidbank;
						var cashaccount=document.getElementById("cash").value;
						var bankaccount=document.getElementById("bank").value;
						var branchid = document.getElementById("branch").value;
						var branchhid =branchid;
						var balance = document.getElementById("balance").value;
						var balance1 = balance;
						var narration = document.getElementById("narration").value;
						var transportcompany = document.getElementById("transportcompany").value;
						var totalstockamount = document.getElementById("oldstock").value;

						$.noConflict();
						try {
							$.ajax({
								type: "POST",
								// dataType:"json",
								url: "<?php echo base_url() ?>index.php/Salescontrol/delete_salesinvoicemaster",
								data: {
									'invoiceno': invoiceno,
									'masterid' : masterid,
									'customer': customer,
									'salesorderno': salesorderno,
									'Paymentmode': 'cash',
									'salesdate': salesdate,
									'totalqty': totalqty,
									'totalamount': totalamount,
									'additionalcost': additionalcost,
									'taxamount': taxamount,
									'billdiscount': billdiscount,
									'grandtotal': grandtotal,
									'oldbalance': oldbalance,
									'cashorbank': paidcash,
									
									'balance': balance,
									'narration': narration,
									'transportcompany': transportcompany,
									'branchid': branchid

								},
								success: function (data) {
									var myJSON = JSON.stringify(data);
									
									
									var table = document.getElementById('dataTable1');
									for (var i = 1; i < table.rows.length; i++) {
										var product = $('#productcode' + i).val();
										var productname = "";
										var mrp = 0;
										var old = 0;
										var qty = 0;
										var batch = 0;
										var size =0;
										if (i == 1) {
											mrp = $('#mrp1').val();
											old = $('#oldqty1').val();
											qty = $('#qty1').val();
											batch = $('#batch1').val();
											size =$('#size1').val();
										} else {
											unitprice = $('#unitprice' + i).val();
											qty = $('#qty' + i).val();
											old = $('#oldqty' + i).val();
											batch = $('#batch' + i).val();
											size =$('#size'+i).val();

										}
										// alert(old);
										var netamount = $('#amount' + i).val();
										// var tax = $('#tax'+i).val();
										var tax = 0.00;
										var taxamount = $('#taxamount' + i).val();
										// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
										// Finaltaxamount=parseInt(Finaltaxa mount,10) +parseInt(taxamount,10);
										var amount = $('#totalamount' + i).val();
										
										
										
										$.ajax({

											type: "POST",
											url: "<?php echo base_url() ?>index.php/Salescontrol/deletesalesinvoicedetails",
											data: {
												'invoiceno': invno,
												'salesdate': salesdate,
												'productname': productname,
												'productcode': product,
												'qty': qty,
												'mrp': mrp,
												'old': old,
												'netamount': netamount,
												'tax': tax,
												'taxamount': taxamount,
												'amount': amount,
												'branchid': branchhid,
												'batchid': batch,
												'size' :size
											},
											success: function (data) {
												var myJSON = JSON.stringify(data);
												
												 
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
												$('#cashorbank').val('');

												$('#paidamount').val('');
												$('#balance').val('');
												// // document.getElementById("dataTable").deleteRow(1);
												// var tt = document.getElementById("grandtotal").value;
												// document.getElementById("ttl").innerText = tt;
												// var source = document.getElementById('dataTable');
												// var destination = document.getElementById('tableB');
												// var copy = source.cloneNode(true);
												// copy.setAttribute('id', 'tableB');
												// destination.parentNode.replaceChild(copy, destination);
												// var content = document.getElementById("bill").innerHTML;
												// var mywindow = window.open('', 'Print', 'height=600,width=800');
												// mywindow.document.write(
												// 	'<html><head><title>Print</title><link href="<?php echo base_url();?>css/stylebill.css">'
												// 	);
												// mywindow.document.write('</head><body >');
												// mywindow.document.write(content);
												// mywindow.document.write('</body></html>');

												// mywindow.document.close();
												// // mywindow.focus()
												// // mywindow.print();
												// mywindow.close();
											},
											error: function (data) {
												var myJSON = JSON.stringify(data);
												alert("in details");
												alert(myJSON);
											}



										}); //product insert ajax   



									} //for loop


									$.ajax({
										type: "POST",
										url: "<?php echo base_url() ?>index.php/Salescontrol/deleteSalesInvoice_DayBookInsertion",
										data: { 
											'voucherno': invno,
											'date': date,
											'totalamount': totalamount,
											'tax': taxamount1,
											'paidcash': paidcash1,
											'paidbank' :paidbank1,
											'paymentmode': 'cash',
											'discount': billdiscount1,
											'grandtotal': grandtotal1,
											'stock': totalstockamount,
											'customer': customer1,
											'balance': balance1,
											'cashaccount':cashaccount,
											'bankaccount' : bankaccount
										},

										success: function (data) {
											var result1 = JSON.stringify(data);
											alert(result1);
											alert(
												"DayBook Insertion successfully completed");
										},
										error: function (data) {
											var myJSON = JSON.stringify(data);
											alert(myJSON);
										}

									});


									//delete account sales
								// 	  $.ajax({
								// 				type: "POST",
								// 				url: "<?php echo base_url() ?>index.php/Salescontrol/deleteSalesInvoice_AccountInsertion",
								// 				data: {
								// 					'voucherno': invno,
								// 			'date': date,
								// 			'totalamount': totalamount,
								// 			'tax': taxamount1,
								// 			'paidcash': paidcash1,
								// 			'paidbank' :paidbank1,
								// 			'paymentmode': 'cash',
								// 			'discount': billdiscount1,
								// 			'grandtotal': grandtotal1,
								// 			'stock': totalstockamount,
								// 			'customer': customer1,
								// 			'balance': balance1,
								// 			'cashaccount':cashaccount,
								// 			'bankaccount' : bankaccount
								// 				},

								// 				success: function (data) {
								// 						var result1 = JSON.stringify(data);
								// 									alert(result1);
								// 					alert("Account Insertion successfully completed");
								// 					//PurchaseInvoice_AccountInsertion_Start
								// 				},
								// 				error: function (data) {
								// 	var myJSON = JSON.stringify(data);
								// 	alert(myJSON);
								// }

								// 				});

												var bicus= $("#customer option:selected").text();
                                       $('#billcust').html(bicus);
                                       $('#billtotal').html(totalamount);
                                       $('#billgrand').html(grandtotal);
                                       $('#billtax').html(taxamount);
									   var grandtotal = (document.getElementById("grandtotal").value)*1;
									   var points = grandtotal*1/100;
									   var redpointbalance = (document.getElementById("pointbalance").value)*1;
									   //var pointbalance = redpointbalance+points;
									   var pointredeem = (document.getElementById("pointredeem").value)*1;
									   var pointbalance = (redpointbalance+points-pointredeem).toFixed(2);
									   var billdiscount = document.getElementById("billdiscount").value;
									   var paidcash = (document.getElementById("paidcash").value)*1;
									   var paidbank = (document.getElementById("paidbank").value)*1;
									   var balance = ((document.getElementById("balance").value)*-1).toFixed(2);
									   var salesdate = document.getElementById("salesdate").value;
									   var invoiceno = document.getElementById("invoiceno").value;
									   var branchid = document.getElementById("branch").value;
									   var paidamount = paidcash + paidbank;
									   //var totalpoints = balance+points;
                                       //var content = document.getElementById("billing").innerHTML;
                                       //var not = document.getElementById("notices").innerHTML;
                                       //var foot = document.getElementById("billfoot").innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');
    mywindow.document.write('<html><head><title>Print</title><style>*{font-family: "Lucida Console", Monaco, monospace;}.moahead{font-size:25px;letter-spacing:3px;}hr{border-top: 1px dashed black;}</style>');
    mywindow.document.write('</head><body>');
    // mywindow.document.write(content);
    mywindow.document.write('<center><img width="200" height="200" src="<?php echo base_url();?>images/logo.png"><br><span class="moahead">Mall of Abayas</span><br><span>'+branchname+'</span><br><span>'+branchadd+'</span><br><span>PHONE : +91 '+branchpho+'</span><br><span>GSTNO :'+gstno+'</span></center><br><br><br><br><span>Cashier:'+salesmanname+'</span><br><br><span>Customer :'+custname+'</span><br><span>'+custpho+'</span><hr>');
    var table = document.getElementById('dataTable1');
    var n=1;
	for (var i = 1; i < table.rows.length-1; i++) 
	{
										var product = $('#productcode' + i).val();
										  var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").attr('label');
										var mrp = 0;
										var old = 0;
										var hsn = 0;
										var size = 0;
										var qty = 0;
										var batch = 0;
										if (i == 1) {
											mrp = $('#mrp1').val();
												hsn = $('#hsn1').val();
												// size = $('#size1').val();
												sizename =$("#size option[value='" + $('#size1').val() + "']").attr('label');
												// sqft = $('#sqft1').val();
												qty = $('#qty1').val();
												batch =  $('#batch').val();
										} else {
											mrp = $('#mrp' + i).val();
												hsn = $('#hsn' + i).val();
												// size = $('#size'+ i).val();
												sizename =$("#size option[value='" + $('#size'+i).val() + "']").attr('label');
												// sqft = $('#sqft' + i).val();
												qty = $('#qty' + i).val();
											    batch =  $('#batch' + i).val();

										}
										// alert(old);
										var netamount = $('#amount' + i).val();
										// var tax = $('#tax'+i).val();
										var tax = 0.00;
										var taxamount = $('#taxamount' + i).val();
										// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
										// Finaltaxamount=parseInt(Finaltaxa mount,10) +parseInt(taxamount,10);
										var amount = $('#totalamount' + i).val();
											mywindow.document.write('<br><div>'+productname+' ('+sizename+')</div><div>'+qty+'x '+amount+'</div><div style="float:right">'+amount+'</div><br>');
											n++;
	}
	mywindow.document.write('<hr><div>Points Earned<span style="float:right;">'+points+'</span></div><div>Point Balance<span style="float:right;">'+pointbalance+'</span></div><hr><div style="font-size:30px;s">Total<span style="float:right;">'+grandtotal+'</span></div><br><div>Discount<span style="float:right;">'+billdiscount+'</span></div><br><div>Grand Total<span style="float:right;">'+grandtotal+'</span></div><br><br><div>Amount Received<span style="float:right;">'+paidamount+'</span></div><br><div>Balance<span style="float:right;">'+balance+'</span></div><hr><center>Thank you for visiting MOA....!</center><center>Kindly give your registered mobile number to earn or redeem the reward points..!!</center><br><div>'+salesdate+'<span style="float:right;">'+branchid+'/'+invoiceno+'</span></div>');
    // mywindow.document.write('</tbody></table>');
    mywindow.document.write('</body></html>');
    mywindow.document.write(not);
    mywindow.document.write(foot);
    mywindow.document.close();
    mywindow.focus();
    mywindow.print();
	// mywindow.close();

								}, //master success
								error: function (data) {
									var myJSON = JSON.stringify(data);
									alert(myJSON);
								},
								complete: function (){ 
								}
							});

						} //try
						catch (err) {
							alert(err.message);
						}
						finally{ 
							
						}
					});

					//Save product

				});
			</script>