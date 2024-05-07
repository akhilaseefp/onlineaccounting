<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>
<script type="text/javascript">
	// $.noConflict();
	var ctr = 1;
  var totalstockamount =0;
	$(document).ready(function () {
		$('#dataTable1').on('change', '.productcode2', function () {
			ctr++;
			// var a = $(this).closest("tr")[0].rowIndex;
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
					url: "<?php echo base_url(); ?>index.php/Esalescontrol/Autofill_New",
					data: {
						'b': code
					},
					success: function (result) { var val = code;
						var Qty = $('#qty' + a).val();
             			var mrp = result[0]['mrp'];
             			var hsn = result[0]['hsncode'];
             			var weight = result[0]['weight'];
             			// var sq = result[0]['sqft'];
						var purchaserate = result[0]['purchaserate'];
						var taxpercentage =0;
						// if("tax"=="tax"){
						// 	taxpercentage = result[0]['tax'];
						// }
						// else{
						// 	taxpercentage = 0;
						// }
						var slab =         $('#name option').filter(function () {
				                    return this.value == val;
		                           	}).data('slab')*1;
				
				
						if(mrp>slab)
						{
							taxpercentage =$('#name option').filter(function () {
				                  return this.value == val;
			                     }).data('taxhigh')*1;
						}
						else
						{
							taxpercentage = $('#name option').filter(function () {
				                      return this.value == val;
			                      }).data('taxlow')*1;
							
						}
						mrp=mrp*100/(100+taxpercentage);
						var netamount = mrp * Qty;
						var taxamount = mrp * Qty * taxpercentage / 100;
						if (a == 1)
						{				
              				$('#mrp1').val(mrp.toFixed(2));
							$('#amount1').val(netamount.toFixed(2));
							$('#tax1').val(taxpercentage);
							$('#taxamount1').val(taxamount);
							$('#hsn1').val(hsn);
							$('#weight1').val(weight);
							$('#descri1' + a).val(descri);
							// $('#size').val(size);
							// $('#sq1').val(sq);
							$('#totalamount1').val((netamount + taxamount).toFixed(2));
							$('#cost1').val(purchaserate);
						} else {
							
              				$('#mrp'+a).val(mrp.toFixed(2));
							$('#amount' + a).val(netamount.toFixed(2));
							$('#tax'+a).val(taxpercentage);
							$('#taxamount' + a).val(taxamount);
							$('#weight'+a).val(weight);
							$('#hsn' + a).val(hsn);
							$('#descri' + a).val(descri);
							$('#cost'+a).val(purchaserate);
							// $('#size' + a).val(size);
							// $('#sq' + a).val(sq);
							$('#totalamount' + a).val((netamount + taxamount).toFixed(2));
						}

						var tr = "tr" + ctr;
						var productcode = "productcode" + ctr;
						var unitprice = "unitprice" + ctr;
                        var mrp = "mrp" + ctr;
                        var weight = "weight" + ctr;
						var qty = "qty" + ctr;
						var size = "size" + ctr;
						var hsn = "hsn" + ctr;
						var descri = "descri" + ctr;
						// var sqft = "sqft" + ctr;
						// var sq = "sq" + ctr;<td style="display:none;"> <input type="number" value="1" class="form-control sqft" autocomplete="off" id="' + sqft + '" name="productcode"></td><td style="display:none;"> <input type="number" class="form-control sq" autocomplete="off" id="' + sq + '" name="productcode"></td> // to add in row
						var amount = "amount" + ctr;
						var batch = "batch" + ctr;
						var tax = "tax" + ctr;
						var cost = "cost" + ctr;
						var taxamount = "taxamount" + ctr;
						var totalamount = "totalamount" + ctr;
						var rowCount = document.getElementById('dataTable').rows.length + 1;
						var newTr = '<tr><td>' + rowCount +
							'</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' + productcode +'"></td><td style="display:none"> <input type="number" value="1" class="form-control" autocomplete="off" id="' + hsn + '" name="productcode"></td><td> <input type="text" class="form-control descri" autocomplete="off" id="' + descri + '" name="descri"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' + qty + '" name="productcode"></td><td><input type="text" id="' + size +'" class="form-control" list="size" name="" ></td><td style="display:none"><input type="text"  value="0" id="' + batch + '" class="form-control" list="bat" name="" ></td><td><input type="text" id="' + mrp + '" class="form-control mrp" name="" value="0.00"></td><td style="display:none"><input type="text" id="' + amount + '" class="form-control" name=""></td><td style="display:none"><input type="text" id="' + tax + '" class="form-control"  name=""></td><td style="display:none"><input type="text" id="' + taxamount + '" class="form-control"  name=""></td><td><input type="text" id="' + totalamount + '" class="form-control"  name=""></td><td class="ctr" style="display:none">' + ctr + '</td> <td><a href="" class="delete" >X</a></td> <td style="display:none"><input type="text" id="' + cost + '" class="form-control"  name=""></td><td style="display:none"><input type="text" id="' + weight + '" class="form-control weight" value=""  name=""></td></tr>';
							
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
			
			totalstockamount=0;
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
	       var purchaserate =0;
		   var  totalweight=0;
	       var mrp1 =0;
			for (var n = 1; n < table.rows.length; n++) {
				var i = 0;
				try {
					
				i = document.getElementById('dataTable').rows[n - 1].cells[12].innerHTML;
          		mrp1=$('#mrp'+i).val();
				} catch (err) {

				}
				
				if (document.getElementById('productcode'+i).value==null || document.getElementById('productcode'+i).value=="" ) { 
					
				} else { 
					var val = $('#productcode' + i).val();
      				purchaserate = $('#name option').filter(function () {
                      return this.value == val;
                    }).data('purchaserate');
					rowqty = document.getElementById('qty' + i).value * 1;
					rowweight = document.getElementById('weight' + i).value * 1;
					rownetamount = document.getElementById('amount' + i).value * 1;
					rowtaxamount = document.getElementById('taxamount' + i).value * 1;
					rowtotalamount = document.getElementById('totalamount' + i).value * 1;
            		qty = qty + rowqty;
					totalweight=totalweight+(rowqty*rowweight);
			        netamount = netamount + rownetamount;
			        taxamount = taxamount + rowtaxamount;
			        totalamount = totalamount + rowtotalamount;
			        totalstockamount=totalstockamount+purchaserate*rowqty;
				}

			}
             var conversionrate=0.00;
             var charge=0.00;
			$('#totalweight').val(totalweight.toFixed(2));
			if($('#country').val()!="" && $('#country').val()!=null){
			 charge = $("#countrylist option[value='" + $('#country').val() + "']").attr('data-charge');
	
	 conversionrate = $("#countrylist option[value='" + $('#country').val() + "']").attr('data-conversionrate');
	 		}
	var totalweight=$('#totalweight').val();
	if(totalweight<1){
		totalweight=1;
	}
	var deliverycharge=charge*conversionrate*totalweight/CONVERSIONRATE;
	$('#deliverycharge').val(deliverycharge);
			$('#totalqty').val((qty).toFixed(2));
			$('#totalamount').val( netamount.toFixed(2));
			 var state=$('#state').val();
              if (state=="Karnataka") {

              	$('#cgst').val((taxamount/2).toFixed(2));
              	$('#sgst').val((taxamount/2).toFixed(2));
              	$('#igst').val('0.00');
              }
              else{
              	$('#cgst').val('0.00');
              	$('#sgst').val('0.00');
              	$('#igst').val((taxamount).toFixed(2));
              }
			$('#taxamount').val(taxamount.toFixed(2));
			var billdiscount = $('#billdiscount').val();
			
			var deliverycharge = $('#deliverycharge').val();
			var pointredeem = $('#pointredeem').val() * 1;
			// billdiscount=+pointredeem;
			var additionalcost = $('#additionalcost').val() * 1;
			var grandtotal=(netamount + taxamount - pointredeem + additionalcost+deliverycharge*1).toFixed(2);
			$('#grandtotal').val(grandtotal);
			



			document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1) + (document.getElementById("billdiscount").value * 1) ) - (document
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
			Ecommerce Sales Invoice
		</h1>
		
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="#">Forms</a></li> -->
			<li class="active">Ecommerce Sales Invoice</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-default">
			<div class="box-body">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Ecommerce Invoice No</label>
							<?php foreach ($invoiceno->result() as $invno) {
								?>
							<input type="text" class="form-control" required autocomplete="off" value="<?php echo $invno->NO;?>"
								name="invoiceno" id="invoiceno" style="width: fit-content;">
							<?php
							}
							?>
						</div>
					</div>
					<div class="col-md-2" style="">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales date (Y/m/d)</label>
							<input type="datetime" class="form-control" id="salesdate" value="<?php $d=strtotime("now");$e=strtotime("-7 hours",$d); echo date("Y-m-d H:i:s",$d);?>" name="salesdate">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Customer</label>
							<input type="text" class="form-control" list="customerlist" required autocomplete="off"  name="customer" id="customer">
							<!-- <option value="0"  data-balance="0.00">Select Customer</option> -->
							<datalist id="customerlist">
								<?php
								foreach ($customer->result() as $cust)
								{
								?>
								<option value="<?php echo $cust->customerid; ?>" data-phonenumber="<?php echo $cust->phonenumber;?>" data-points="<?php echo $cust->points;?>" data-custname="<?php echo $cust->customername;?>" data-balance="<?php echo $cust->currentbalance;?>" data-cust="<?php echo $cust->customerid;?>" data-addr="<?php echo $cust->address;?>" label="<?php echo $cust->phonenumber;?>"></option>
								<?php } ?>
							</datalist>
						</div>
					</div>

					<div class="col-md-2" style="max-width: fit-content;">
						<div class="form-group">
						<button id="show_add_customer" style="background-color: green; color: #ffff!important; padding: 7px;margin-top: 22px;"><a style="color: white;"   ><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;</a></button>
					</div>
					</div>
					<div class="col-md-2 " id="add_customer_column" >
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Customer Name</label>
							<input type="text" class="form-control" autocomplete="off" id="customer_name" name="customer_name" value="">
						</div>
					</div>
					<div class="col-md-2 " id="add_customer_column1">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Mobile No</label>
							<input type="text" class="form-control" autocomplete="off" id="customer_mobile" name="customer_mobile" value="">
							<button id="add_customer" >ADD</button>
						</div>
					</div>
					<script type="text/javascript">
						$(document).ready(function () {
							function show_add_cutomer(){
								alert();
								document.getElementById("add_customer_column").style.display="block";
							}

							$('#show_add_customer').on('click', function() {this.disabled=true;

								document.getElementById("add_customer_column").style.display="block";
								document.getElementById("add_customer_column1").style.display="block";
								var cus_no = document.getElementById("customer").value;
								$('#customer_mobile').val(cus_no);

							});

							$('#add_customer').on('click', function () {this.disabled=true;


								var customer_name = document.getElementById("customer_name").value;
								var customer_mobile = document.getElementById("customer_mobile").value;

								try {
									$.ajax({
										type: "POST",
										url: "<?php echo base_url() ?>index.php/Esalescontrol/add_customer",
										data: {
											'customer_name': customer_name,
											'customer_mobile': customer_mobile,

										},
										success: function (data) 
										{
											alert(data);
											alert(" Succesfully...!");
											location.reload();
										},
										error: function (request, status, error) {
											alert("error");

										}
									});

								}
								catch (err) {
									alert(err.message);
								}
							});
						});

					</script>
					<div class="col-md-2">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales Order No</label>
							<input type="text" class="form-control" autocomplete="off" id="salesorderno" name="salesorderno" value="">
						</div>
					</div>
			<!-- 	</div>
				<div class="row">
			 -->		
					<div class="col-md-4" style="display: none;">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Branch</label>
							<select class="form-control" name="branch" id="branch">
								<?php
                      foreach ($branch->result() as $branch) { ?>
								<?php if($branch->branchid==$branchid){?>
								<option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>" selected ><?php echo $branch->branchname; ?></option>
								<?php }
								else{?>
								<option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>"selected ><?php echo $branch->branchname; ?></option>
								<?php }
							  }?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Salesman</label>
							<select class="form-control" name="salesman" id="salesman">
								<?php
								foreach ($salesman->result() as $sal) {


									if($sal->salesmanid == 18)
									{
										echo "<option selected='selected' value='".$sal->salesmanid."'>".$sal->salesmanname."</option>";
									}
									else
									{
										echo "<option value='".$sal->salesmanid."'>".$sal->salesmanname."</option>";
									}
									
								} ?>
							</select>
						</div>
					</div>
				</div>
				<hr>
				

        <div class="table table-responsible">
        	<?php
        			//print_r($product->result()); die();
        		 ?>

					<TABLE id="dataTable1" border="1" class="table table-striped table-hover">
						<thead>
							<tr>
								<th>SL.NO</th>
								<th>PRODUCT NAME</th>
								<th style="display:none">HSN CODE</th>
								<th>Description</th>
								<th>QTY</th>
								<th class="d-none d-xl-block">SIZE</th>
								<!-- <th>SQFT</th> -->
								<!-- <th style="display:none;">Sq</th> -->
								<th style="display:none" class="d-none d-xl-block">BATCH</th>
                                <th class="d-none d-xl-block">MRP</th>
								<th style="display:none" class="d-none d-xl-block" style="">NET AMOUNT</th>
								<th style="display:none" class="d-none d-xl-block" style="">TAX AMOUNT</th>
								<th class="d-none d-xl-block">TOTAL AMOUNT</th>
								<th class="d-none d-xl-block" style="display: none;"></th>
								<th class="d-none d-xl-block"></th>
								<th class="d-none d-xl-block" style="display: none;"></th>
							</tr>
						</thead>
						<tbody id="dataTable" width="100%" class="table table-hover">
								<tr>
								<td>1</td>
								<td> <input type="text" class="form-control productcode2" list="name" autocomplete="off"
										name="productname" id="productcode1"></td>
								<datalist id="name">
									<?php foreach($product->result() as $gp){ ?>
									<option value="<?php echo $gp->pdt_code;?>"  data-purchaserate="<?php echo $gp->purchaserate;?>"
										data-tax="<?php echo $gp->tax;?>" label="<?php echo $gp->pdt_name;?>" data-taxlow="<?php echo $gp->taxlow;?>" data-taxhigh="<?php echo $gp->taxhigh;?>" data-slab="<?php echo $gp->slab;?>">
									</option>
										<?php  } ?>
								</datalist>
								<td style="display:none">
									<input type="number" class="form-control qty" autocomplete="off" id="hsn1" name="productcode">
								</td>
								<td>
									<input type="text" class="form-control descri" autocomplete="off" id="descri1" name="descri">
								</td>
								<td>
									<input type="number" value="1" class="form-control qty" autocomplete="off" id="qty1" name="productcode">
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
									<input type="number" value="1" class="form-control sqft" autocomplete="off" id="sqft1"
										name="productcode">

								</td>
								<td style="display:none;">
									<input type="number"   class="form-control sq" autocomplete="off" id="sq1"
										name="productcode">

								</td> -->
								<td style="display:none"><input type="text" value="0" id="batch" list="bat" class="form-control" name=""></td>
								<datalist id="bat">
									<?php foreach($batch->result() as $gp){
                   					?>
									<option value="<?php echo $gp->batchid;?>" label="<?php echo $gp->batchname;?>">
										<?php  } ?>
								</datalist>
								<!-- <td><input type="text" id="unitprice" class="form-control unitprice" name="" style="display:none"></td> -->
                  				<td><input type="text" id="mrp1" class="form-control mrp" name="" value="0.00"></td>
								<td style="display:none"><input type="text" id="amount1" class="form-control" name=""></td>
								<td style="display:none"><input type="text" id="tax1" class="form-control" name=""></td>
								<td style="display:none"><input type="text" id="taxamount1" class="form-control" name=""></td>
								<td><input type="text" id="totalamount1" class="form-control" name=""></td>
								<td class="ctr" style="display: none">1</td>
								<td><a href="" class="delete">X</a></td>
								<td style="display:none"><input type="text" id="cost1" class="form-control" name=""></td>
								<td style="display:none"><input type="text" id="weight1" class="form-control" name=""></td>
							</tr>
						</tbody>
					</TABLE>
					<input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
				</div>

				<hr>
				<div class="row col-md-12">
					<div class="col-md-3" style="display:none;">
						<div class="form-group"  style="display:none;">
							<label class="form-control-placeholder" for="contact-person">Delivery Charge</label>
							<input type="hidden" class="form-control" name="totalqty" id="totalqty">
							<input type="text" class="form-control" name="deliverycharge" id="deliverycharge" value="0.00">
						</div>
						<div class="form-group"  style="display:none;">
							<label class="form-control-placeholder" for="contact-person">Total Amount</label>
							<input type="text" class="form-control" name="totalamount" id="totalamount">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group" style="display:none;">
							<label class="form-control-placeholder" for="contact-person">Tax Amount</label>
							<input type="text" class="form-control" name="taxamount" id="taxamount">
							<input type="hidden" class="form-control" name="cgst" id="cgst">
							<input type="hidden" class="form-control" name="sgst" id="sgst">
							<input type="hidden" class="form-control" name="igst" id="igst">
						</div>
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Additional Cost</label>
							<input type="text" value="0" class="form-control" name="additionalcost" id="additionalcost">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Bill Discount</label>
							<input type="text" value="0" class="form-control" name="billdiscount" id="billdiscount">
						</div>
						
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Grand Total</label>
							<input type="text" class="form-control" name="grandtotal" id="grandtotal">
						</div>
					</div>
				</div>
				<div class="row col-md-12">
					<fieldset style="border-color: #e4dddda8;width: 100%;">
						<legend style="width: auto;">Payment</legend>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Old Balance</label>
								<input type="text" name="oldbalance" id="oldbalance" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay" style="display:none;">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Cash</label>
								<select class="form-control" id="cash" name="cash">
									<?php
									  foreach ($CashLedgers->result() as $cledger)
									  {
                     				?>
									<option value="<?php echo $cledger->ledgerid; ?>"><?php echo $cledger->ledgername; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-3 subpay" style="display:none;">
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

						<div class="col-md-3 subpay" style="display:none;">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Point Balance</label>
								<input type="text" id="pointbalance" name="pointbalance" class="form-control" autocomplete="off">
							</div>
						</div>
					<!-- </fieldset> -->
				<!-- </div>
				<div class="row col-md-12"> -->
				<!-- <fieldset style="border-color: #e4dddda8;width: 100%;"> -->
						
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Paid Cash</label>
								<input type="text" value="0" name="paidcash" id="paidcash" class="form-control" required
									autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Paid Bank</label>
								<input type="text" value="0" name="paidbank" id="paidbank" class="form-control" required
									autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Balance</label>
								<input type="text" name="balance" id="balance" class="form-control" autocomplete="off">
								<input style="display:none;" type="text" name="totalweight" id="totalweight" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay" style="display:none;">
						<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Points Redeemed</label>
								<input type="text" value="0" name="pointredeem" id="pointredeem" class="form-control" required
									autocomplete="off">
							</div>
						</div>
						</fieldset>
				</div>
				<hr>
				<div class="row col-md-12 txn-bottom-form" style="display:none;">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Narration</label>
							<textarea class="form-control" style="line-height:3.5" name="narration" id="narration"></textarea>
						</div>
					</div>
					<div class="col-md-6" style="display:none;">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Transportation Company</label>
							<input type="text" class="form-control" autocomplete="off" name="transportcompany" id="transportcompany">
						</div>
						
							<!-- <div id="barcodemrp" style="display: none;"></div>
						    <div style="display: none;">
						      <svg id='barcode'></svg>
						    </div>
						  	<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> Shipping Address </a> -->
					</div>

				</div>
				</form>
				<hr>

				<div class="row col-md-12 form-group margin txn-bottom-form" style="text-align: center;">

					<div class="col-md-4">

						<form id="myForm">
						<label for="child" style="margin-right: 20px; ">SHIPPING FROM</label>
							
							<input type="radio" checked="" name="radioName" value="1" /> INR 
							<input type="radio" name="radioName" onclick="calc();" value="3" /> UAE 
							<input type="radio" name="radioName" value="2" /> USA 
						</form>

					</div>

					<div class="offset-md-4">

						

						<!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal"> Save </a>
					
						<!-- <input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave"> -->
						<input class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete">
						<input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
						<input class="btn btn-warning" type="button" name="btnclose" value="Print" id="btnclose" >
					</div>
				</div>
			</div>

<!-- Modal1 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
        <!-- <form id="userform" method="post"> -->
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
				<div class="modal-body modal-body-sub_agile">
				<div class="col-md-8 modal_body_left modal_body_left1" style="text-align:left; width: 100%;">
    			<h2 style="margin:50px; text-align: center;">Add Shipping Address</h2>

				<div class="col-md-12">
					<div style=""  class="styled-input agile-styled-input-top">
					<?php foreach ($orderid->result() as $invno) {?>
					<label style="font-size:22px;">Order ID : <?php echo $invno->NO;?></label>

					<input style="display: none;" type="text" value="<?php echo $invno->NO;?>" name="order_id" id="order_id" class="validate form-control" required>
					<span></span>
					<?php } ?>
					</div>
				</div>
				<hr><hr>

    			<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Custmer Name</label>
                <input type="text" name="cus_name" id="cus_name" class="validate form-control" required>
				<span></span>
				</div>
				</div>
				
				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Custmer Id</label>
                <input type="text" name="cus_id" id="cus_id" class="validate form-control" required>
				<span></span>
				</div>
				</div>

				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Address</label>
                <textarea type="textarea" name="ship_address" id="ship_address" class="validate form-control" required></textarea>

                <textarea style="display: none;" type="textarea" name="prmnt_address" id="prmnt_address" class="validate form-control" required></textarea>
				<span></span>
				</div>
				</div>

				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Address2</label>
                <textarea type="textarea" name="ship_address2" id="ship_address2" class="validate form-control"></textarea>
				<span></span>
				</div>
				</div>


				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">City</label>
                <input type="text" name="ship_address" id="city" class="validate form-control" required></input>
				<span></span>
				</div>
				</div>

				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Phne_number</label>
                <input type="text" name="number" id="number1" class="validate form-control" required>
				<span></span>
				</div>
				</div>

				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Phne_number 2</label>
                <input type="text" name="number2" id="number2" class="validate form-control">
				<span></span>
				</div>
				</div>

				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Pin_code</label>
                <input type="text" name="pin" id="pin" class="validate form-control" required>
				<span></span>
				</div>
				</div>

				<div class="col-md-6">
				<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">land Mark</label>
                <input type="text" name="mark" id="mark" class="validate form-control" required>
				<span></span>
				</div>
				</div>


<script type="text/javascript">
	function calc()
	{

		document.getElementById("emirates").style.display = "block";

		document.getElementById("india").style.display = "none";

		$('#country').val('United Arab Emirates');

		// if (document.getElementById('xxx').checked) 
		// {
		// 	document.getElementById('totalCost').value = 10;
		// } else {
		// 	calculate();
		// }
	}
</script>

		<div class="col-md-6">

			<div style=""  id="india" class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">State</label>
				<select name="state" id="state" class="form-control" >
					<option value="Andhra Pradesh">Andhra Pradesh</option>
					<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
					<option value="Arunachal Pradesh">Arunachal Pradesh</option>
					<option value="Assam">Assam</option>
					<option value="Bihar">Bihar</option>
					<option value="Chandigarh">Chandigarh</option>
					<option value="Chhattisgarh">Chhattisgarh</option>
					<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
					<option value="Daman and Diu">Daman and Diu</option>
					<option value="Delhi">Delhi</option>
					<option value="Lakshadweep">Lakshadweep</option>
					<option value="Puducherry">Puducherry</option>
					<option value="Goa">Goa</option>
					<option value="Gujarat">Gujarat</option>
					<option value="Haryana">Haryana</option>
					<option value="Himachal Pradesh">Himachal Pradesh</option>
					<option value="Jammu and Kashmir">Jammu and Kashmir</option>
					<option value="Jharkhand">Jharkhand</option>
					<option value="Karnataka">Karnataka</option>
					<option value="Kerala" selected>Kerala</option>
					<option value="Madhya Pradesh">Madhya Pradesh</option>
					<option value="Maharashtra">Maharashtra</option>
					<option value="Manipur">Manipur</option>
					<option value="Meghalaya">Meghalaya</option>
					<option value="Mizoram">Mizoram</option>
					<option value="Nagaland">Nagaland</option>
					<option value="Odisha">Odisha</option>
					<option value="Punjab">Punjab</option>
					<option value="Rajasthan">Rajasthan</option>
					<option value="Sikkim">Sikkim</option>
					<option value="Tamil Nadu">Tamil Nadu</option>
					<option value="Telangana">Telangana</option>
					<option value="Tripura">Tripura</option>
					<option value="Uttar Pradesh">Uttar Pradesh</option>
					<option value="Uttarakhand">Uttarakhand</option>
					<option value="West Bengal">West Bengal</option>
				</select>
				<span></span>
			</div>

			<div style="display: none;"   id="emirates" class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Emirates</label>
				<select name="state" id="state" class="form-control" >
					<option value="Dubai">Dubai</option>
					<option value="Abu Dhabi">Abu Dhabi</option>
					<option value="Sharjah">Sharjah</option>
					<option value="Fujairah">Fujairah</option>
					<option value="Ajman">Ajman</option>
					<option value="Umm al-Qaiwain">Umm al-Qaiwain</option>
					<option value="Ra's al-Khaimah">Ra's al-Khaimah</option>

				</select>
				<span></span>
			</div>

		</div>



		<div class="col-md-6">
			<div style=""  class="styled-input agile-styled-input-top">
				<label style="font-size:17px;">Country</label>
				<input type="text" class="form-control" value="India" list="countrylist" required autocomplete="off"  name="country" id="country" required>
				<div id="helper" style="display:none;position:absolute;z-index:200;border:1pt solid #ccc;"></div>
				<!-- <option value="0"  data-balance="0.00">Select Customer</option> -->
				<datalist id="countrylist">

					<?php
					foreach ($country->result() as $cust)
					{
						?>
						<option value="<?php echo $cust->country_name; ?>" label="<?php echo $cust->country_id;?>"  data-conversionrate="<?php echo $cust->conversionrate;?>" data-charge="<?php echo $cust->charge;?>"></option>
					<?php } ?>
				</datalist>

				<span></span>
			</div>
		</div>

<script>
	$(function(){
    // make a copy of datalist 
    var dl="";
    $("#orderTypes option").each(function(){
            dl+="<div class='dlOption'>"+$(this).val()+"</div>";
    });
    $("#helper").html(dl);
    $("#helper").width( $("#dlInput").width() );

    $(document).on("click","#dlInput",function(){
        // display list if it has value
        var lv=$("#dlInput").val();
        if( lv.length ){
                $("#orderTypes").attr("id","orderTypesHide");
                $("#helper").show();
        }
    });

    $(document).on("click",".dlOption",function(){
        $("#dlInput").val( $(this).html() );
        $("#helper").hide();
    });

    $(document).on("change","#dlInput",function(){
        if( $(this).val()==="" ){
            $("#orderTypesHide").attr("id","orderTypes");
            $("#helper").hide();
        }
    }); 
}); 
</script>



              <div class="modal-footer" style="text-align: center; ">
			<!-- <input type="submit" name="action" class="btn btn-success" value="Add"> -->
			<input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave" style="width: 100%; margin-top: 30px;">
			<!-- <input type="button" id="sizebtn" name="action" class="btn btn-success" value="Save"style="width: 100%; margin-top: 30px;"> -->
              </div>
				</div>
				<div class="col-md-4 modal_body_right modal_body_right1">
					<!-- </form> -->
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
        </form>
				<!-- //Modal content-->
		</div>
		</div>
<!-- //Modal1 -->

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

					addr = $('#customerlist option').filter(function ()
					{return this.value == val;}).data('addr');
					document.getElementById("ship_address").value = addr;
					document.getElementById("prmnt_address").value = addr;

					points = $('#customerlist option').filter(function ()
					{return this.value == val;}).data('points');
					document.getElementById("pointbalance").value = points;

					phonenumber = $('#customerlist option').filter(function ()
					{return this.value == val;}).data('phonenumber');
					document.getElementById("number1").value = phonenumber;

					cust = $('#customerlist option').filter(function ()
					{return this.value == val;}).data('cust');
					document.getElementById("cus_id").value = cust;

					custname = $('#customerlist option').filter(function ()
					{return this.value == val;}).data('custname');
					document.getElementById("cus_name").value = custname;

				}
				catch(err)
				{
					alert(err.message);
				}
			});
			
   			// var customer = document.getElementById('customer');   
  			// customer.onchange=function () {
    		// try
			// {
			// 	var balance = customer.options[customer.selectedIndex].getAttribute("data-balance");
			// 	custname = customer.options[customer.selectedIndex].getAttribute("data-custname");
			// 	points = customer.options[customer.selectedIndex].getAttribute("data-points");
			// 	custpho = customer.options[customer.selectedIndex].getAttribute("data-phonenumber");
				
			// 	document.getElementById("oldbalance").value = balance;
			// 	document.getElementById("pointbalance").value = points;
				
    		// }
			// catch(err)
			// {
			// 	alert(err.message);
    		// }
			// }

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
		  			url:"<?php echo base_url();?>index.php/Esalescontrol/autogenerate_einv",
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
			var CONVERSIONRATE=0.00;
  window.onload = function () {
    document.getElementById("oldbalance").value = "0.00";
    document.getElementById("pointbalance").value = "0.00";
	CONVERSIONRATE=<?php echo $conversionrate->result_array()[0]['conversionrate'];?>;

  }
  $('#billdiscount').change(function () {
    calculation();
  });
 $('#deliverycharge').change(function () {
    calculation();
  });

  $('#pointredeem').change(function () {
calculation();
 });

  $('#additionalcost').change(function () {

    calculation();

  });


  $('#paidcash').change(function () {


    document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)+(document.getElementById("billdiscount").value * 1)) - (document
      .getElementById("grandtotal").value * 1);

  });
  $('#paidbank').change(function () {
document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
});

  $('#dataTable1').on('keyup change', '.qty', function () {


    var a = $(this).closest("tr")[0].rowIndex;

    rowcalculation(a);
    calculation();
  });
  $('#dataTable1').on('change', '.mrp', function () {


    var a = $(this).closest("tr")[0].rowIndex;
    rowcalculation(a);
    calculation();


  });
//    $('#dataTable1').on('change', '.sqft', function () {

//     var a = $(this).closest("tr")[0].rowIndex;
//     var st = $('#sq' + a).val();
//     var nw = $('#sqft' + a).val();
//     var ns = nw / st;
//     $('#qty' +a).val(ns);

// alert(ns);

//     rowcalculation(a);
//     calculation();


//   });

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
      var QTY = $('#qty1').val()*1;

      var mrp = $('#mrp1').val()*1;

      $('#amount1').val(QTY * mrp);
      var val = $('#productcode1').val();
      


      var tax =$('#tax1').val();

      var netamount = QTY * mrp;
      var taxamount = netamount * tax / 100;


      $('#taxamount1').val(taxamount);
      $('#totalamount1').val((taxamount + netamount).toFixed(2));

    } else {
      var QTY = $('#qty' + a).val();

      var mrp = $('#mrp' + a).val();

      $('#amount' + a).val(QTY * mrp);
       var val = $('#productcode' + a).val();

    
   

      var tax = $('#tax'+a).val();


      var netamount = QTY * mrp;
      var taxamount = netamount * tax / 100;
      $('#taxamount' + a).val(taxamount);
      $('#totalamount' + a).val((taxamount + netamount).toFixed(2));

    }
  }
</script>
<script type="text/javascript">
	
	$("#state").change(function ()
			{
				try
				{

              var totaltaxamount=$('#taxamount').val();
              var state=$('#state').val();
              if (state=="Karnataka") {

              	$('#cgst').val((totaltaxamount/2).toFixed(2));
              	$('#sgst').val((totaltaxamount/2).toFixed(2));
              	$('#igst').val('0.00');


              }
              else{
              	$('#cgst').val('0.00');
              	$('#sgst').val('0.00');
              	$('#igst').val((totaltaxamount).toFixed(2));

              }


				}
				catch(err)
				{
					alert(err.message);
				}
			});
</script>
<script type="text/javascript">
	$(document).ready(function () {
	$("#country").change(function ()
			{
				try
				{
	var charge = $("#countrylist option[value='" + $('#country').val() + "']").attr('data-charge');
	var conversionrate = $("#countrylist option[value='" + $('#country').val() + "']").attr('data-conversionrate');
	var totalweight=$('#totalweight').val();
	if(totalweight<1){
		totalweight=1;
	}
	var deliverycharge=charge*conversionrate*totalweight/CONVERSIONRATE;
	$('#deliverycharge').val(deliverycharge);
	calculation();

	}
				catch(err)
				{
					alert(err.message);
				}
			});
	});

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
    var weight = "weight" + ctr;
    var descri = "descri" + ctr;
    // var sqft = "sqft" + ctr;
    // var sq = "sq" + ctr;
    var amount = "amount" + ctr;
    var batch = "batch" + ctr;
    var tax = "tax" + ctr;
     var cost = "cost" + ctr;
    var taxamount = "taxamount" + ctr;
    var totalamount = "totalamount" + ctr;
    var rowCount = document.getElementById('dataTable').rows.length + 1;
    var newTr = '<tr><td>' + rowCount + '</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' + productcode + '"></td><td style="display:none"> <input type="number" value="1" class="form-control" autocomplete="off" id="' + hsn + '" name="productcode"></td><td> <input type="text" class="form-control descri" autocomplete="off" id="' + descri + '" name="descri"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' + qty + '" name="productcode"></td><td><input type="text" id="' + size + '" class="form-control" list="size" name="" ></td><td style="display:none"><input type="text" value="0" id="' + batch + '" class="form-control" list="bat" name="" ></td><td><input type="text" id="' + mrp + '" class="form-control mrp" name="" value="0.00"></td><td style="display:none"><input type="text" id="' + amount + '" class="form-control" name=""></td><td style="display:none"><input type="text" id="' + tax + '" class="form-control"  name=""></td><td style="display:none"><input type="text" id="' + taxamount + '" class="form-control"  name=""></td><td><input type="text" id="' + totalamount + '" class="form-control"  name=""></td><td class="ctr" style="display:none">' + ctr + '</td> <td><a href="" class="delete" >X</a></td><td style="display:none"><input type="text" id="' + cost + '" class="form-control"  name=""></td><td style="display:none"><input type="text" id="' + weight + '" class="form-control weight" value=""  name=""></td>  </tr>';
    $('#dataTable1').append(newTr);



  });
</script>
			<script type="text/javascript">
				$(document).ready(function () {
					
$('#btnsave').on('click', function () {

	document.getElementById("btnsave").disabled = true;
	
var cus_name = $('#cus_name').val();
var cus_id = $('#cus_id').val();
var order_id = $('#order_id').val();
var ship_address = $('#ship_address').val();
var prmnt_address = $('#prmnt_address').val();
var ship_address2 = $('#ship_address2').val();
var number1 = $('#number1').val();
var number2 = $('#number2').val();
var pin = $('#pin').val();
var mark = $('#mark').val();
var city = $('#city').val();
var state = $('#state').val();
var country = $("#countrylist option[value='" + $('#country').val() + "']").attr('label');

try {
	
$.ajax({
type: "POST",
dataType: 'json',
url: "<?php echo base_url(); ?>index.php/Esalescontrol/insertshipping",
data: {
'cus_name': cus_name,
'cus_id': cus_id,
'order_id': order_id,
'ship_address': ship_address,
'prmnt_address': prmnt_address,
'ship_address2': ship_address2,
'number1': number1,
'number2': number2,
'pin': pin,
'mark': mark,
'city' :city,
'state' :state,
'country' :country

},


success: function (data) {

	
var result = JSON.stringify(data);




},
error: function (request, status, error) {
        alert(request.responseText);
    }
});
} catch (err) {
alert(err.message);
}

						var invoiceno = document.getElementById("invoiceno").value;
						var customer = document.getElementById("customer").value;
						var billdiscount = document.getElementById("billdiscount").value;
						var salesorderno = document.getElementById("salesorderno").value;
						var salesman = document.getElementById("salesman").value;
						//var Paymentmode = document.getElementById("Paymentmode").value;
						var salesdate = document.getElementById("salesdate").value;
						var totalqty = document.getElementById("totalqty").value;
						var totalamount = document.getElementById("totalamount").value;
						var additionalcost = document.getElementById("additionalcost").value;
						var taxamount = document.getElementById("taxamount").value;
						var salesman = document.getElementById("salesman").value;
						var grandtotal = document.getElementById("grandtotal").value;
						var oldbalance = document.getElementById("oldbalance").value;
						var cash = document.getElementById("cash").value;
						var bank = document.getElementById("bank").value;
						var paidcash = document.getElementById("paidcash").value;
						var paidbank = document.getElementById("paidbank").value;
						var branchid = document.getElementById("branch").value;
						var pointredeem = document.getElementById("pointredeem").value;
						var balance = document.getElementById("balance").value;
						var narration = document.getElementById("narration").value;
						var transportcompany = document.getElementById("transportcompany").value;

						var ship = ($('input[name=radioName]:checked', '#myForm').val()); 
						//$.noConflict();

						try {
							$.ajax({
								type: "POST",
								// dataType:"json",
								url: "<?php echo base_url() ?>index.php/Esalescontrol/insert_ecommerce_ordermaster",
								data: {
									'invoiceno': invoiceno,
									'customer': customer,
									'salesorderno': salesorderno,
									'Paymentmode': 'cash',
									'salesdate': salesdate,
									'salesman': salesman,
									'totalqty': totalqty,
									'totalamount': totalamount,
									'additionalcost': additionalcost,
									'taxamount': taxamount,
									'billdiscount': billdiscount,
									'grandtotal': grandtotal,
									'oldbalance': oldbalance,
									'cash': cash,
									'bank': bank,
									'totalstockamount': totalstockamount,
									'paidcash': paidcash,
									'paidbank':paidbank,
									'balance': balance,
									'narration': narration,
									'transportcompany': transportcompany,
									'branchid': branchid,
									'pointredeem':pointredeem,
									'currencyid' :'1',
									'ship' :ship
									
								},

								success: function (data) {
										// var myJSON = JSON.stringify(data);
									// alert(myJSON);
									var table = document.getElementById('dataTable1');
									var invoiceno = document.getElementById("invoiceno").value;
									var salesdate = document.getElementById("salesdate").value;
									var branchid = document.getElementById("branch").value;
									var paidcash = document.getElementById("paidcash").value;
									var paidbank = document.getElementById("paidbank").value;
									var customer = document.getElementById("customer").value;
									var balance = document.getElementById("balance").value;
									var billdiscount = document.getElementById("billdiscount").value;

									
									for (var no = 1; no < table.rows.length-1; no++) {
									

										var i =document.getElementById("dataTable1").rows[no].cells[12].innerHTML;
										var product = $('#productcode' + i).val();
										  var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").attr('label');
										//   var productname="";
											var mrp = 0;
											var descri = 0;
											var qty = 0;
											var hsn = 0;
											var size = 0;
											var batch=0;
											var productcost=0;
											if (i == 1)
											{
												
												mrp = $('#mrp1').val();
												descri = $('#descri1').val();
												qty = $('#qty1').val();
												hsn = $('#hsn1').val();
												size = $('#size1').val();
											 	batch =  $('#batch').val();
											 	productcost=$('#cost1').val();
											}
											else
											{
												
												mrp = $('#mrp' + i).val();
												descri = $('#descri'+ i).val();
												size = $('#size'+ i).val();
												hsn = $('#hsn'+ i).val();
												qty = $('#qty' + i).val();
											    batch =  $('#batch' + i).val();
											    productcost=$('#cost'+i).val();
											}
                                            
											var netamount = $('#amount' + i).val();
											var tax = $('#tax'+i).val();
											
											var taxamount = $('#taxamount' + i).val();
											// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
											// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
											var amount = $('#totalamount' + i).val();
											// alert(netamount);
											// alert(invoiceno);
											if (1 == 2) {

											} else {
											
										$.ajax({
											type: "POST",
											url: "<?php echo base_url() ?>index.php/Esalescontrol/insert_ecommerce_orderdetails",
											data: {
												'salesmasterid':data,
												'invoiceno': invoiceno,
												'salesdate': salesdate,
												'productname': productname,
												'productcode': product,
												'i': i,
												// 'pointredeem': pointredeem,
												'qty': qty,
												'hsn': hsn,
												'size': size,
												'mrp': mrp,
												'netamount': netamount,
												'tax': tax,
												'taxamount': taxamount,
												'amount': amount,
												'branchid': branchid,
												'batchid':batch,
												'descri':descri,
												'productcost' :productcost,
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
										
									} //end of else
										

									} //for loop
                                             var igst=$('#igst').val();
                                              var cgst=$('#cgst').val();
                                               var sgst=$('#sgst').val();
                                           $.ajax({
												type: "POST",
												url: "<?php echo base_url() ?>index.php/Esalescontrol/SalesInvoice_DayBookInsertion",
												data: {
													'voucherno': invoiceno,
													'date': salesdate,
													'totalamount': totalamount,
													'tax': taxamount,
													'paidcash': paidcash,
													'paidbank': paidbank,
													'paymentmode': 'cash',
													'billdiscount':billdiscount,
													'grandtotal':grandtotal,
													'stock':totalstockamount,
													'cash': cash,
													'bank':bank,
													'customer':customer,
													'balance':balance,
													'igst' :igst,
													'cgst' :cgst,
													'sgst' :sgst
												},

												success: function (data) {
														var result1 = JSON.stringify(data);
																	// alert(result1);
													alert("DayBook Insertion successfully completed");
													location.reload();
													//PurchaseInvoice_AccountInsertion_Start
												},
												error: function (data) {
									var myJSON = JSON.stringify(data);
									alert(myJSON);
								}
												});
                                           prints();
	
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
			<script type="text/javascript">
				function prints(){
				 var bicus= $("#customer").val();
									   var customername = $("#customerlist option[value='" + bicus+ "']").data('custname');
                                       $('#billcust').html(bicus);
                                       $('#billtotal').html(totalamount);
                                       $('#billgrand').html(grandtotal);
                                       $('#billtax').html(taxamount);
									   var grandtotal = (document.getElementById("grandtotal").value)*1;
									   try{
									   var inwords = toWords(grandtotal);
									}catch(err){
										alert(err.message);
									}
									   var totalamount = (document.getElementById("totalamount").value)*1;
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
									   var cgst=$('#cgst').val();
									    var sgst=$('#sgst').val();
									     var igst=$('#igst').val();
									     var ship_address=$('#ship_address').val();
									     var  number1 = $('#number1').val();
									     var  state = $('#state').val();
				
									     

									  
    var mywindow = window.open('', 'Print', 'height=600,width=1000');
    
    mywindow.document.write('<html><head><title>Print</title><style>*{font-family: "Lucida Console", Monaco, monospace;}.imgg{float:left; padding:20px;}.moahead{font-size:30px;letter-spacing:9px;font-family: "Lucida Console";}center{border: 2px solid;}.invoice{color:white; font-size:20px; background-color:black;}hr{border-top: 1px dashed black;}</style>');
    mywindow.document.write('</head><body>');
    // mywindow.document.write(content);
    mywindow.document.write('<center><span class="imgg"><img width="60" height="60" src="<?php echo base_url();?>images/loo.png"></span><span class="invoice">INVOICE BILL</span><br><span class="moahead">MALL OF ABAYAS</span><br><span>First floor,No.88,Room No.F04,5th Block,</span><br><span>Koramangala Industrial Layout, Bengaluru, Karnataka, PIN 560095<br> info@mallofabayas.com | GSTIN: 29ABIFM2960LIZQ </span></center>');


	mywindow.document.write('<table cellspacing=0 border=1px solid black;>');

	mywindow.document.write('<tr><td style="padding:5px;" colspan="9"><b>Billed to </b></td></tr>');

	mywindow.document.write('<tr><td style="padding:5px;" colspan="9">Name:'+customername+'<br>address:'+ship_address+'<br>State:'+state+'<br>Contact: '+number1+'</td></tr>');

    mywindow.document.write('<thead><tr><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th></tr></thead><tbody>');

    mywindow.document.write('<thead><tr><th style="padding:10px;">Particulars (Descriptions & Specifications)</th><th style="padding: 10px;">HSN / SAC Code</th><th style="padding: 10px;">Reference No</th><th style="padding: 10px;">Qty</th><th style="padding: 10px;">Rate</th><th style="padding: 10px;">Amount</th><th style="padding: 10px;">CGST</th><th style="padding: 10px;">SGST</th><th style="padding: 10px;">IGST</th></tr></thead><tbody>');

    var table = document.getElementById('dataTable1');
    var n=1;
	for (var i = 1; i < table.rows.length-1; i++)
	{  var no =document.getElementById("dataTable1").rows[i].cells[12].innerHTML;
		var product = $('#productcode' + no).val();
		var productname = $("#name option[value='" + product+ "']").attr('label');
		var invoiceno = (document.getElementById("invoiceno").value)*1;
		var refno=invoiceno+"_"+no;
		// var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").data('label');
			var hsn= 0;
			// var sqft = 0;
			var mrp = 0;
			var sizename = 0;
			var qty = 0;
			var batch=0;
			var descr ="";
			if (no == 1) {
				sqft = $('#ttlsqf1').val();
				descri = $('#descri1').val();
				// nsheets = $('#nsheets1').val();
				mrp = $('#mrp1').val();
				hsn = $('#hsn1').val();
				// size = $('#size1').val();
				sizename =$("#size option[value='" + $('#size1').val() + "']").attr('label');
				qty = $('#qty1').val();
				batch =  $('#batch').val();
			} else {
				sqft = $('#ttlsqf' + no).val();
				descri = $('#descri'+no).val();
				// nsheets = $('#nsheets' + i).val();
				mrp = $('#mrp' + no).val();
				hsn = $('#hsn' + no).val();
				// size = $('#size'+ i).val();
				sizename =$("#size option[value='" + $('#size'+i).val() + "']").attr('label');
				qty = $('#qty' + no).val();
			    batch =  $('#batch' + no).val();
			}
			var netamount = $('#amount' + no).val();
			var tax = $('#tax'+no).val();
			var taxamount = $('#taxamount' + no).val();
			var cgstt=0;
			var sgstt=0;
			var igstt=0;
			if(state=="Karnataka"){
				cgstt=(taxamount/2);
				sgstt=(taxamount/2);
				igstt =0.00;
			}
			else{
				cgstt =0.00;
				sgstt=0.00;
				igstt=taxamount;
			}
			var taxamount = $('#taxamount' + no).val();
			// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
			// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
			var amount = $('#totalamount' + no).val();
			mywindow.document.write('<tr><td style="padding: 20px;">'+productname+' (Size :'+sizename+', '+descri+')</td><td style="padding: 20px;">'+hsn+'</td><td style="padding: 20px;">'+refno+'</td><td style="padding: 20px;">'+qty+'</td><td style="padding: 20px;">'+mrp+'</td><td style="padding: 20px;">'+netamount+'</td><td style="padding: 20px;">'+cgstt+'</td><td style="padding: 20px;">'+sgstt+'</td><td style="padding: 20px;">'+igstt+'</td></tr>');
			n++;
	}
	// mywindow.document.write('<tr><td colspan="4" style="font-size:30px;"><b>Total</b></td><td style="font-size:30px;" colspan="5"><b>'+(totalamount.toFixed(2))+'</b></td></tr>');

	mywindow.document.write('<tr><td  colspan="4" rowspan="5">CASH PAYMENT :'+paidcash+'<br>BANK PAYMENT :'+paidbank+'<br>BALANCE TO PAY :'+balance+'</td><td colspan="5"><b>Sub Total 	                     - Rs: '+totalamount+'/-  </b></td></tr><tr><td colspan="5">CGST 	                     - Rs: '+cgst+'/-  </td></tr><tr><td colspan="5">SGST                   - Rs:  '+sgst+'/- </td></tr><tr><td colspan="5">IGST 	                   - Rs : '+igst+'/- </td></tr><tr><td colspan="5">Discount 	                   - Rs : '+billdiscount+'/- </td></tr><tr></tr>');
	mywindow.document.write('<tr><td colspan="4" style="font-size:22px;"><b>Grand Total</b></td><td style="font-size:30px;" colspan="5"><b>'+(grandtotal.toFixed(2))+'</b></td></tr>');
	// <tr><td colspan="5">Grand Total	 	                -  '+(grandtotal.toFixed(2))+'/- </td>
	mywindow.document.write('<tr><td colspan="9">Invoice value (in words): '+inwords+'</td></tr>');
	mywindow.document.write('<tr><td colspan="4">TERMS AND CONDITIONS:<br><br>Subject to ERNAKULAM Destribution<br><br><br><br>E & 0.E</td><td colspan="5">For MALL OF ABAYAS:<br><br>Authrised Signature<br><br>Certify that the particulars given above are true and correct<br></td></tr>');
	mywindow.document.write('</tbody> </table>');
    mywindow.document.write('</body></html>');
	mywindow.document.write('<center>Thank you for visiting MALL OF ABAYAS....!</center><br><div>'+salesdate+'<span style="float:right;">'+branchid+'/'+invoiceno+'</span></div>');
	mywindow.document.write('<td style="padding: 20px;" colspan="6">----------------------------------------------------------------------------------------------------</td>');


    mywindow.document.write('<html><head><title>Print</title><style>*{font-family: "Lucida Console", Monaco, monospace;}.imgg{float:left; padding:20px;}.moahead{font-size:30px;letter-spacing:9px;font-family: "Lucida Console";}center{border: 2px solid;}.invoice{color:white; font-size:20px; background-color:black;}hr{border-top: 1px dashed black;}</style>');
    mywindow.document.write('</head><body>');

    mywindow.document.write('<center><span class="imgg"><img width="60" height="60" src="<?php echo base_url();?>images/loo.png"></span><span class="invoice">DELIVERY SLIP</span><br><span class="moahead">MALL OF ABAYAS</span><br><span>First floor,No.88,Room No.F04,5th Block,</span><br><span>Koramangala Industrial Layout, Bengaluru, Karnataka, PIN 560095<br> info@mallofabayas.com | GSTIN: 29ABIFM2960LIZQ </span></center>');

	mywindow.document.write('<table border=1px solid black; style="width: 100%;" >');

	mywindow.document.write('<tr><td style="padding:5px;" colspan="6"><b>Delivery Address </b></td></tr>');

	mywindow.document.write('<tr><td style="padding:5px;" colspan="6">Name:'+customername+'<br>address:'+ship_address+'<br>State:'+state+'<br>Contact:'+number1+'</td></tr>');

    mywindow.document.write('<thead><tr><th style="display:none;"></th><th style="display:none;"></th></tr></thead><tbody>');

    mywindow.document.write('<thead><tr><th style="padding:10px;">Particulars (Descriptions & Specifications)</th><th style="padding: 10px;">Qty</th></tr></thead><tbody>');
     var n=1;
	for (var i = 1; i < table.rows.length-1; i++)
	{  var no =document.getElementById("dataTable1").rows[i].cells[12].innerHTML;
		var product = $('#productcode' + no).val();
		var productname = $("#name option[value='" + product+ "']").attr('label');
		var invoiceno = (document.getElementById("invoiceno").value)*1;
		var refno=invoiceno+"_"+no;
		// var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").data('label');
			var hsn= 0;
			// var sqft = 0;
			var mrp = 0;
			var sizename = 0;
			var qty = 0;
			var batch=0;
			var descr ="";
			if (no == 1) {
				sqft = $('#ttlsqf1').val();
				descri = $('#descri1').val();
				// nsheets = $('#nsheets1').val();
				mrp = $('#mrp1').val();
				hsn = $('#hsn1').val();
				// size = $('#size1').val();
				sizename =$("#size option[value='" + $('#size1').val() + "']").attr('label');
				qty = $('#qty1').val();
				batch =  $('#batch').val();
			} else {
				sqft = $('#ttlsqf' + no).val();
				descri = $('#descri'+no).val();
				// nsheets = $('#nsheets' + i).val();
				mrp = $('#mrp' + no).val();
				hsn = $('#hsn' + no).val();
				// size = $('#size'+ i).val();
				sizename =$("#size option[value='" + $('#size'+i).val() + "']").attr('label');
				qty = $('#qty' + no).val();
			    batch =  $('#batch' + no).val();
			}
			var netamount = $('#amount' + no).val();
			var tax = $('#tax'+no).val();
			
			var taxamount = $('#taxamount' + no).val();
			// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
			// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
			var amount = $('#totalamount' + no).val();
			mywindow.document.write('<tr><td style="padding: 20px;">'+productname+' (RefNo : '+refno+' , Size :'+sizename+', '+descri+')</td><td style="padding: 20px;">'+qty+'</td></tr>');
			n++;
	}

    

    mywindow.document.write('<tr><td colspan="6">For Mall of abayas - Digital Verified:</td></tr>');


	mywindow.document.write('</tbody> </table>');


    mywindow.document.write('</body></html>');

    // mywindow.document.write(not);
    // mywindow.document.write(foot);

    var delayInMilliseconds = 3000; //3 second

setTimeout(function() {
  mywindow.document.close();
  mywindow.focus();
  mywindow.print();
}, delayInMilliseconds);
  

}
$(document).ready(function () {


				$('#btnclose').on('click', function () {

						prints();
									        
						});

					

				});
			</script>


<script>


//--->number to word > start

    var root = typeof self == 'object' && self.self === self && self ||
        typeof global == 'object' && global.global === global && global ||
        this;
 

	// Simplified https://gist.github.com/marlun78/885eb0021e980c6ce0fb
	function isFinite(value) {
	    return !(typeof value !== 'number' || value !== value || value === Infinity || value === -Infinity);
	}

 
	var ENDS_WITH_DOUBLE_ZERO_PATTERN = /(hundred|thousand|(m|b|tr|quadr)illion)$/;
	var ENDS_WITH_TEEN_PATTERN = /teen$/;
	var ENDS_WITH_Y_PATTERN = /y$/;
	var ENDS_WITH_ZERO_THROUGH_TWELVE_PATTERN = /(zero|one|two|three|four|five|six|seven|eight|nine|ten|eleven|twelve)$/;
	var ordinalLessThanThirteen = {
	    zero: 'zeroth',
	    one: 'first',
	    two: 'second',
	    three: 'third',
	    four: 'fourth',
	    five: 'fifth',
	    six: 'sixth',
	    seven: 'seventh',
	    eight: 'eighth',
	    nine: 'ninth',
	    ten: 'tenth',
	    eleven: 'eleventh',
	    twelve: 'twelfth'
	};

	/**
	 * Converts a number-word into an ordinal number-word.
	 * @example makeOrdinal('one') => 'first'
	 * @param {string} words
	 * @returns {string}
	 */
	function makeOrdinal(words) {
	    // Ends with *00 (100, 1000, etc.) or *teen (13, 14, 15, 16, 17, 18, 19)
	    if (ENDS_WITH_DOUBLE_ZERO_PATTERN.test(words) || ENDS_WITH_TEEN_PATTERN.test(words)) {
	        return words + 'th';
	    }
	    // Ends with *y (20, 30, 40, 50, 60, 70, 80, 90)
	    else if (ENDS_WITH_Y_PATTERN.test(words)) {
	        return words.replace(ENDS_WITH_Y_PATTERN, 'ieth');
	    }
	    // Ends with one through twelve
	    else if (ENDS_WITH_ZERO_THROUGH_TWELVE_PATTERN.test(words)) {
	        return words.replace(ENDS_WITH_ZERO_THROUGH_TWELVE_PATTERN, replaceWithOrdinalVariant);
	    }
	    return words;
	}

	function replaceWithOrdinalVariant(match, numberWord) {
	    return ordinalLessThanThirteen[numberWord];
	}

 
	/**
	 * Converts an integer into a string with an ordinal postfix.
	 * If number is decimal, the decimals will be removed.
	 * @example toOrdinal(12) => '12th'
	 * @param {number|string} number
	 * @returns {string}
	 */
	function toOrdinal(number) {
	    var num = parseInt(number, 10);
	    if (!isFinite(num)) throw new TypeError('Not a finite number: ' + number + ' (' + typeof number + ')');
	    var str = String(num);
	    var lastTwoDigits = num % 100;
	    var betweenElevenAndThirteen = lastTwoDigits >= 11 && lastTwoDigits <= 13;
	    var lastChar = str.charAt(str.length - 1);
	    return str + (betweenElevenAndThirteen ? 'th'
	            : lastChar === '1' ? 'st'
	            : lastChar === '2' ? 'nd'
	            : lastChar === '3' ? 'rd'
	            : 'th');
	}

 
	var TEN = 10;
	var ONE_HUNDRED = 100;
	var ONE_THOUSAND = 1000;
	var ONE_MILLION = 1000000;
	var ONE_BILLION = 1000000000;           //         1.000.000.000 (9)
	var ONE_TRILLION = 1000000000000;       //     1.000.000.000.000 (12)
	var ONE_QUADRILLION = 1000000000000000; // 1.000.000.000.000.000 (15)
	var MAX = 9007199254740992;             // 9.007.199.254.740.992 (15)

	var LESS_THAN_TWENTY = [
	    'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
	    'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
	];

	var TENTHS_LESS_THAN_HUNDRED = [
	    'zero', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
	];

	/**
	 * Converts an integer into words.
	 * If number is decimal, the decimals will be removed.
	 * @example toWords(12) => 'twelve'
	 * @param {number|string} number
	 * @param {boolean} [asOrdinal] - Deprecated, use toWordsOrdinal() instead!
	 * @returns {string}
	 */
	function toWords(number, asOrdinal) {
	    var words;
	    var num = parseInt(number, 10);
	    if (!isFinite(num)) throw new TypeError('Not a finite number: ' + number + ' (' + typeof number + ')');
	    words = generateWords(num);
	    return asOrdinal ? makeOrdinal(words) : words;
	}

	function generateWords(number) {
	    var remainder, word,
	        words = arguments[1];

	    // We’re done
	    if (number === 0) {
	        return !words ? 'zero' : words.join(' ').replace(/,$/, '');
	    }
	    // First run
	    if (!words) {
	        words = [];
	    }
	    // If negative, prepend “minus”
	    if (number < 0) {
	        words.push('minus');
	        number = Math.abs(number);
	    }

	    if (number < 20) {
	        remainder = 0;
	        word = LESS_THAN_TWENTY[number];

	    } else if (number < ONE_HUNDRED) {
	        remainder = number % TEN;
	        word = TENTHS_LESS_THAN_HUNDRED[Math.floor(number / TEN)];
	        // In case of remainder, we need to handle it here to be able to add the “-”
	        if (remainder) {
	            word += '-' + LESS_THAN_TWENTY[remainder];
	            remainder = 0;
	        }

	    } else if (number < ONE_THOUSAND) {
	        remainder = number % ONE_HUNDRED;
	        word = generateWords(Math.floor(number / ONE_HUNDRED)) + ' hundred';

	    } else if (number < ONE_MILLION) {
	        remainder = number % ONE_THOUSAND;
	        word = generateWords(Math.floor(number / ONE_THOUSAND)) + ' thousand,';

	    } else if (number < ONE_BILLION) {
	        remainder = number % ONE_MILLION;
	        word = generateWords(Math.floor(number / ONE_MILLION)) + ' million,';

	    } else if (number < ONE_TRILLION) {
	        remainder = number % ONE_BILLION;
	        word = generateWords(Math.floor(number / ONE_BILLION)) + ' billion,';

	    } else if (number < ONE_QUADRILLION) {
	        remainder = number % ONE_TRILLION;
	        word = generateWords(Math.floor(number / ONE_TRILLION)) + ' trillion,';

	    } else if (number <= MAX) {
	        remainder = number % ONE_QUADRILLION;
	        word = generateWords(Math.floor(number / ONE_QUADRILLION)) +
	        ' quadrillion,';
	    }

	    words.push(word);
	    return generateWords(remainder, words);
	}

	/**
	 * Converts a number into ordinal words.
	 * @example toWordsOrdinal(12) => 'twelfth'
	 * @param {number|string} number
	 * @returns {string}
	 */
	function toWordsOrdinal(number) {
	    var words = toWords(number);
	    return makeOrdinal(words);
	}



    var numberToWords = {
        toOrdinal: toOrdinal,
        toWords: toWords,
        toWordsOrdinal: toWordsOrdinal
    };

    if (typeof exports != 'undefined') {
        if (typeof module != 'undefined' && module.exports) {
            exports = module.exports = numberToWords;
        }
        exports.numberToWords = numberToWords;
    } else {
        root.numberToWords = numberToWords;
    }

//--->number to word > end
</script>
			
			<!-- Jas  Save master and details End-->

			