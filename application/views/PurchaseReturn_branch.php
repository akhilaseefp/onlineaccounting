<script src="<?php echo base_url(); ?>js/jquery1.js"></script>
<script type="text/javascript">
	

var ctr=0;
var inv_no =0;
var	MASTERID=0;
$(document).ready(function(){

 ctr=document.getElementById('dataTable').rows.length;
});
</script><style>
a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #4CAF50;
  color: white;
}

.round {
  border-radius: 50%;
}
</style>
<script type="text/javascript">
	// $.noConflict();

 

	// var ctr = document.getElementById('dataTable').rows.length;
	$(document).ready(function() {


		$('#dataTable1').on('change', '.productcode2', function() {
		try{

			
			var a = $(this).closest("tr").find('.ctr').text();
			
				var productname =$('#name option').filter(function () {
				                       return this.value == val;
			                         }).data('purchaserate')*1; 

			
				var code = $('#productcode' + a).val();

			


			
				var val = code;
				var purchaserate =$('#name option').filter(function () {
				                       return this.value == val;
			                         }).data('purchaserate')*1; 
					var hsn =        $('#name option').filter(function () {
				                         return this.value == val;
			                          }).data('hsncode');
				var slab =         $('#name option').filter(function () {
				                    return this.value == val;
		                           	}).data('slab')*1;
				var taxpercentage=0;
				
						if(purchaserate>slab)
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
						var Qty = $('#qty' + a).val();
						
						
						purchaserate=purchaserate*100/(100+taxpercentage);
						var netamount = purchaserate * Qty;
						var taxamount = purchaserate * Qty * taxpercentage / 100;
                            
						    $('#tax' + a).val(taxpercentage);
							$('#unitprice' + a).val(purchaserate.toFixed(2));
							$('#amount' + a).val((purchaserate * Qty).toFixed(2));
							$('#hsn' + a).val(hsn);
							$('#taxamount' + a).val(taxamount.toFixed(2));
							$('#totalamount' + a).val((netamount + taxamount).toFixed(2));
							$('#batch'+a).val(0);
						

                         addnewrow();
						
						calculation();



				// 	},
				// 	error: function() {
				// 		alert('Error occur...!!');
				// 	}
				// });
			} catch (err) {
				alert(err.message);
			}

		});


	});

	function addnewrow(){
		ctr++;
		var tr = "tr" + ctr;
						var productcode = "productcode" + ctr;
						var unitprice = "unitprice" + ctr;
						var qty = "qty" + ctr;
						var size = "size" + ctr;
						var oldsize = "oldsize" + ctr;
						var hsn = "hsn" + ctr;
						var amount = "amount" + ctr;
						var batch = "batch" + ctr;
						var tax = "tax" + ctr;
						var taxamount = "taxamount" + ctr;
						var oldqty = "oldqty" + ctr;
						var totalamount = "totalamount" + ctr;

						var rowCount = document.getElementById('dataTable').rows.length + 1;
						var style ="display:none"
 var checkbox=document.getElementById('chk_tax');
						 if(checkbox.checked==true){      
      
                               style="display:table-cell"
            }

						var newTr = '<tr><td>' + rowCount +
							'</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +productcode +'"></td><td> <input type="number" value="1" class="form-control" autocomplete="off" id="' +hsn + '" name="productcode"></td><td><input type="text" id="' + size +
							'" class="form-control size"  name="" ></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' +qty + '" name="productcode"></td><td><input type="text" id="' + batch +
							'" class="form-control" list="bat" name=""></td><td><input type="text" id="' + unitprice +
							'" class="form-control unitprice" name=""></td><td><input type="text" id="' + amount +
							'" class="form-control" name=""></td><td style="'+style+'" class="taxd"><input type="text" id="' + tax +
							'" class="form-control taxd"  name=""></td><td style="'+style+'" class="taxamountd"><input type="text" id="' + taxamount +
							'" class="form-control taxamountd"  name=""></td><td style="'+style+'" class="totalamountd"><input type="text" id="' + totalamount +
							'" class="form-control totalamountd"  name=""></td><td class="ctr" style="display:none;">' + ctr +
							'</td> <td style=""><a href="" class="delete" >X</a></td><td style="display:none;"><input type="text" id="' + oldqty +
							'" class="form-control"  value="0"  name=""></td><td style="display:none;><input type="text" id="' + oldsize +
							'" class="form-control size"  name="" ></td> </tr>';
						$('#dataTable1').append(newTr);
	}

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
					i = document.getElementById('dataTable').rows[n - 1].cells[11].innerHTML;
                  
				} catch (err) {

				}
				if (document.getElementById('productcode' + i).value == null || document.getElementById('productcode' + i).value == "") 
				{
				}
				else 
				{
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
			$('#totalamount').val(netamount.toFixed(2));
			$('#taxamount').val(taxamount.toFixed(2));
			var billdiscount = $('#billdiscount').val() * 1;
			var additionalcost = $('#additionalcost').val() * 1;
			$('#grandtotal').val((netamount + taxamount - billdiscount + additionalcost).toFixed(2));
			document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document
				.getElementById("grandtotal").value * 1).toFixed(2);
		} catch (err) {
			alert(err);
		}
	}
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Purchase Return By Branch
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="#">Forms</a></li> -->
			<li class="active">Purchase Return By Branch</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-default">
			<div class="box-body">
				<!-- <div id="invbutton" class="noprint">
				<a href="#" class="previous" id="previous">&laquo; Previous</a>
<a href="#" class="next" id="next">Next &raquo;</a></div> -->
				<div class="row">
					<div class="col-md-4">
						<label>Voucher no :</label>
						
							<input type="text" readonly="" name="voucherno" class="form-control" required autocomplete="off" id="voucherno" value="<?php echo $voucherno->result_array()[0]['NO'];?>">
											</div>
					<div class="col-md-4">
						<label>Supplier :</label>
						
						<input readonly="" type="text" class="form-control" list="supplier1" autocomplete="off" id="supplier" name="supplier" value="">
						
						<datalist id="supplier1">
							<?php foreach($supplier->result() as $gp){
                                      ?>
							<option value="<?php echo $gp->suppliername;?>" data-supplierbalance="<?php echo $gp->currentbalance;?>" data-address="<?php echo $gp->address;?>" data-city="<?php echo $gp->city;?>" data-mobile="<?php echo $gp->mobile;?>" label="<?php echo $gp->ledgerid;?>" selected ></option>
							<?php  } ?>

						</datalist>
						
					</div>
					<div class="col-md-4" style="display: none;">
						<label>Order no :</label>
						<input type="text" id="orderno"  name="orderno" class="form-control" autocomplete="off">
					</div>
					<div class="col-md-4" style="margin-top: 30px;">
						<label>Tax </label>
						<input type="checkbox" id="chk_tax" name="chk_tax" class="" autocomplete="off" checked>
					<!-- </div>
					<div class="col-md-3"  style="margin-top: 30px;"> -->
						<label>IGST </label>
						<input type="radio" id="rdb_igst" name="rdb_igst" class="" autocomplete="off" onclick="igst()" checked>
					<!-- </div>
					<div class="col-md-2"  style="margin-top: 30px;"> -->
						<label>SGST </label>
						<input type="radio" id="rdb_sgst" name="rdb_sgst" class="" onclick="sgst(this)" autocomplete="off">
					</div>
					<script type="text/javascript">
						function igst(){
							if(document.getElementById("rdb_igst").checked == true){
                                document.getElementById("rdb_sgst").checked = false;
							}else{
								document.getElementById("rdb_sgst").checked = true;
							}
                         

						}
						function sgst(){
							if(document.getElementById("rdb_sgst").checked == true){
                                document.getElementById("rdb_igst").checked = false;
							}else{
								document.getElementById("rdb_igst").checked = true;
							}
                         

						}
					</script>

				</div>
				<div class="row">
					<div class="col-md-4">
						<label>Vendor invoice no :</label>
						
							<input type="text" value="" readonly="" name="vendorinvoiceno" class="form-control" id="vendor" autocomplete="off">
					</div>
					<div class="col-md-4">
						<label>Invoice date :</label>
						<input type="date" name="invoicedate" class="form-control" readonly="" id="invoicedate" value="<?php $d=strtotime("now");; echo date("Y-m-d",$d);?>"> 
						
					</div>
					<div class="col-md-4">
						<label>Branch :</label>
						<select class="form-control" disabled="" name="branch" id="branch">
							<?php
										foreach ($branch->result() as $gp)
										{?>
											
									<option value="<?php echo $gp->branchid; ?>"><?php echo $gp->branchname; ?></option>
									
									<?php } ?>
							
						</select>
					</div>
				</div>
				<hr>
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
								<th style="">HSN CODE</th>
								<th class="d-none d-xl-block">SIZE</th>
								<th>QTY</th>
								
								<!-- <th style="">sqft</th> -->
								<th class="d-none d-xl-block">BATCH</th>
								<th class="d-none d-xl-block">UNIT PRICE</th>
								<th class="d-none d-xl-block" style="">NET AMOUNT</th>
								<th class="d-none d-xl-block taxd" style="">TAX %</th>
								<th class="d-none d-xl-block taxamountd" style="">TAX AMOUNT</th>
								<th class="d-none d-xl-block totalamountd">TOTAL AMOUNT</th>
								<th style="display: none;" class="d-none d-xl-block"></th>
								<th style="display: none;" class="d-none d-xl-block"></th>
								<th style="display: none;">old</th>
								<th style="display: none;">old size</th>
							</tr>
						</thead>
						<tbody id="dataTable" width="100%" border="1" class="table table-hover">
							<datalist id="name">
							<?php foreach($product->result() as $gp){
                   			?>
							<option value="<?php echo $gp->pdt_name;?>" label ="<?php echo $gp->pdt_code;?>" data-tax="<?php echo $gp->tax;?>" data-taxlow="<?php echo $gp->taxlow;?>" data-taxhigh="<?php echo $gp->taxhigh;?>" data-slab="<?php echo $gp->slab;?>" data-purchaserate="<?php echo $gp->purchaserate;?>" data-hsncode="<?php echo $gp->hsncode;?>">
								<?php  } ?>
								<!-- <option value="HTML"> -->

						</datalist>
								
						<datalist id="datalistunit1">
							<?php foreach($unit->result() as $gp){
								?>
								<option label="<?php echo $gp->unitid;?>" value="<?php echo $gp->unitname;?>"></option>
							<?php  } ?>
						</datalist>

						<datalist id="datalistunit">
							<?php foreach($unit->result() as $gp){
								?>
								<option label="<?php echo $gp->unitid;?>" value="<?php echo $gp->unitname;?>"></option>
							<?php  } ?>
						</datalist>

						<datalist id ="size">

							<?php
							foreach ($size->result() as $row)
							{
								?>
								<option label="<?php echo $row->sizeid; ?>" value="<?php echo $row->sizevalue; ?>">
								<?php } ?>
							</datalist> 

							
								
								<datalist id="bat">
									<?php foreach($batch->result() as $gp){
                   					?>
									<option value="<?php echo $gp->batchid;?>" label="<?php echo $gp->batchname;?>">
										<?php  } ?>
								</datalist>
							
						</tbody>
					</TABLE>
					 <div class="col-md-4">
					<input style="display: none;" class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow"></div>
					 <form   method="post" id="form_img" enctype="multipart/form-data" accept-charset="utf-8">
          <div style="display: none;" class="col-md-8">
            <label>Attachment :</label>
             <input type="file" name="image[]" multiple >
            <span class="error image"></span>
            <div id="imageref"></div>
          </div>
          </form>
				</div>
				<hr>
				
					<div class="row">
						<div class="col-md-6">
							<label>Narration :</label>
							<textarea class="form-control" id="narration" readonly="" name="Narration"></textarea>
						</div>
						<div class="col-md-6">
							<label>Transportation Company :</label>
							<textarea id="company" class="form-control" readonly="" name="transportationcompany"></textarea>
						</div>
					</div>
					<hr>
					<fieldset>
						<label style=>Total Stock Amt:</label>
						<input type="text" value="" class="form-control" readonly="" name="totalstockamount" id="totalstockamount" style="">

						<div class="row">
							<div class="col-md-6">
								<label>Total Qty :</label>
								<input type="text" value="" class="form-control" readonly="" name="totalqty" id="totalqty">
							</div>
							<div class="col-md-6">
								<label>Total Amount :</label>
								<input type="text" class="form-control" value="" readonly="" name="totalamount" id="totalamount">
								<input type="hidden" value="" id="oldta" name="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Additional Cost :</label>
								<input type="text" value="0" class="form-control" readonly="" value="" name="additionalcost" id="additionalcost">
								<input type="hidden" value="0.00" id="oldac" name="">
							</div>
							<div class="col-md-6">
								<label>Tax Amount :</label>
								<input type="text" class="form-control" value="0.00" readonly="" name="taxamount" id="taxamount">
								<input type="hidden" value="0.00" id="oldtx" name="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Bill Discount :</label>
								<input type="text"  value="0.00" class="form-control" readonly="" name="billdiscount" id="billdiscount">
								<input type="hidden" value="0.00" id="oldbd" name="">
							</div>
							<div class="col-md-6">
								<label>Grand Total :</label>
								<input type="text" class="form-control" value="0.00" readonly="" name="grandtotal" id="grandtotal">
								<input type="hidden" value="0.00" id="oldgt" name="">
							</div>
						</div>
					</fieldset>
					<hr>
					<fieldset style="font-size: 14px;background: #f0f0f0; font-style: bolder"><span style="text-align: center;"><h4 style="background-color: darkkhaki; padding: 5px; font-weight: 800;">PAYMENT</h4></span>
						
						<div class="row form-group">
							<div class="col-md-4 form-group">
								<label style="color: black">Old Balance :</label>
								<input type="text" name="oldbalance" readonly="" id="oldbalance" class="form-control" autocomplete="off">
							</div>
							<div class="col-md-4 form-group">
								<label style="color: black">Cash :</label>
								<select class="form-control" disabled="" id="cash" name="cash" >
									
									<?php
										foreach ($CashLedgers->result() as $cledger)
										{ ?>
											
									<option value="<?php echo $cledger->ledgerid; ?>"><?php echo $cledger->ledgername; ?></option>
									
									<?php } ?>
								</select>
							</div>

							<div class="col-md-4 form-group">
								<label style="color: black">Bank :</label>
								<select class="form-control" disabled="" id="bank" name="bank" >
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
								<input type="text" readonly="" name="balance" id="balance" value="0.00" class="form-control" autocomplete="off">
								<input type="hidden" value="0.00" id="oldbl" name="">
							</div>

							<div class="col-md-4 form-group">
								<label style="color: black">Paid Cash :</label>
								<input type="text" readonly="" value="0.00" name="paidcash" id="paidcash" class="form-control" required autocomplete="off">
								<input type="hidden" value="0.00" id="oldpc" name="oldpc">
							</div>

							<div class="col-md-4 form-group">
								<label style="color: black">Paid Bank :</label>
								<input type="text" readonly="" value="0.00" name="paidbank" id="paidbank" class="form-control" required autocomplete="off">
								<input type="hidden" value="0.00" id="oldpb" name="oldpb">
							</div>

						</div>
						
					</fieldset>
					<hr>

					<div class="row margin" style="text-align: center">

						<input class="btn btn-warning" type="button" name="btnclose" value="Print" id="btnclose" >

					</div>

				<div class="row margin" style="text-align: center">


			<div class="offset-md-4" style="display: none;">

				<input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave">
				<!-- <input class="btn btn-success" type="button" name="btnupdate" id="btnupdate" value="Update"> -->

				<input class="btn btn-danger" type="submit" name="btndelete" id="btndelete" value="Delete">
				<input class="btn btn-info" type="button" name="btnclear" value="Clear">
				<input class="btn btn-warning" type="button" name="btnbarcode" value="Barcode" id="btnbarcode" >

			</div>
				</div>
			</div>
		</div>
	</section>
</div>


<script src="<?php echo base_url(); ?>js/jquery.js"></script> 
<script type="text/javascript">
	 $('#invbutton').on('click', '.previous', function (e) {
   
    inv_no=inv_no-1;
    $('#voucherno').val(inv_no);
     loadinvoice(inv_no);
  });
</script>
<script type="text/javascript">
	 var max=0;
   $('#invbutton').on('click', '.next', function (e) {
 if(inv_no>=max){
 $('#voucherno').val(max);
  inv_no=max;
  }
  else{
 inv_no=inv_no*1+1;
  $('#voucherno').val(inv_no);
   loadinvoice(inv_no);
 
  }
   });
</script>
<script type="text/javascript">
	  $('#voucherno').on('change', '', function (e) {
   
    inv_no=$('#voucherno').val();
      loadinvoice(inv_no);
  });
  </script>
  <script>
	  function loadinvoice(a){
	  	
                  // $.noConflict();
						try {
							$.ajax({
								type: "POST",
								// dataType:"json",
								url: "<?php echo base_url() ?>index.php/Purchasecontrol/loadpurchasereturninvoice",
								data: {
									'voucherno' : a
								},
											success: function (data) {
											
												document.getElementById("btnsave").disabled = true;
											// document.getElementById("btnupdate").disabled = false;
											document.getElementById("btndelete").disabled = false;
											
											    
												var master=JSON.parse(data);
												if (master['master'].length==0) {alert("no such invoice exists "); 
												ctr=1;
												document.getElementById("btnsave").disabled = false;
											// document.getElementById("btnupdate").disabled = true;
											 document.getElementById("btndelete").disabled = true;

                                                $('#chk_tax').prop("disabled", false);
                                                                     $('#rdb_igst').prop("disabled", false);
                                                                     $('#rdb_sgst').prop("disabled", false);

 document.getElementById("supplier").value="";
									          document.getElementById("orderno").value ="";
									           // document.getElementById("invoicedate").value =master['master'][0]['invoicedate'];
									        
									    document.getElementById("invoicedate").value =  "";

									             document.getElementById("branch").value ="";
								             document.getElementById("narration").value ="";
								              document.getElementById("totalqty").value ="";	
										               document.getElementById("totalamount").value ="";
										               document.getElementById("oldta").value ="";	
										                document.getElementById("taxamount").value ="";	
									                 document.getElementById("oldtx").value ="";	
										                 document.getElementById("additionalcost").value ="";
									                  document.getElementById("billdiscount").value ="";									                   document.getElementById("grandtotal").value ="";							                   
									                   document.getElementById("oldac").value ="";
									                   document.getElementById("oldbd").value ="";
									                   document.getElementById("oldgt").value ="";	
									                   document.getElementById("oldbalance").value ="";	
									                    document.getElementById("cash").value ="";	                         
									                  document.getElementById("bank").value ="";	                          
									                   document.getElementById("paidcash").value ="";					                            
									                    document.getElementById("paidbank").value ="";					                               
									                    document.getElementById("balance").value ="";				                               
									                     document.getElementById("oldpc").value ="";					                             
									                     document.getElementById("oldpb").value ="";	
									                     document.getElementById("oldbl").value ="";
									                     $('#dataTable  tr').remove();
									                     addnewrow();



											}
												else{
													// alert(data);
                                                  
                                                   var supplierid = master['master'][0]['suppliername'];
									               document.getElementById("supplier").value=$("#supplier1 option[label='"+supplierid+"']").val();
									               
									          document.getElementById("vendor").value =master['master'][0]['vendorinvoiceno'];
									           // document.getElementById("invoicedate").value =master['master'][0]['invoicedate'];
									         var aa=  new Date(  master['master'][0]['invoicedate']); 
									    document.getElementById("invoicedate").value =  aa.toLocaleDateString('en-CA');

									             document.getElementById("branch").value =master['master'][0]['branchid'];
									             document.getElementById("narration").value =master['master'][0]['narration'];
									              document.getElementById("totalqty").value =master['master'][0]['totalqty'];
									               document.getElementById("totalamount").value =master['master'][0]['totalamount'];
									               document.getElementById("oldta").value =master['master'][0]['totalamount'];
									                document.getElementById("taxamount").value =master['master'][0]['taxamount'];
									                 document.getElementById("oldtx").value =master['master'][0]['taxamount'];
									                 document.getElementById("additionalcost").value =master['master'][0]['additionalcost'];
									                  document.getElementById("billdiscount").value =master['master'][0]['billdiscount'];
									                   document.getElementById("grandtotal").value =master['master'][0]['grandtotal'];
									                    document.getElementById("oldac").value =master['master'][0]['additionalcost'];
									                  document.getElementById("oldbd").value =master['master'][0]['billdiscount'];
									                   document.getElementById("oldgt").value =master['master'][0]['grandtotal'];
									                     document.getElementById("oldbalance").value =master['master'][0]['oldbalance'];
									                       document.getElementById("cash").value =master['master'][0]['cash'];
									                         document.getElementById("bank").value =master['master'][0]['bank'];
									                           document.getElementById("paidcash").value =master['master'][0]['paidcash'];
									                             document.getElementById("paidbank").value =master['master'][0]['paidbank'];
									                               document.getElementById("balance").value =master['master'][0]['balance'];
									                                document.getElementById("oldpc").value =master['master'][0]['paidcash'];
									                             document.getElementById("oldpb").value =master['master'][0]['paidbank'];
									                               document.getElementById("oldbl").value =master['master'][0]['balance'];
																   
									                               if(master['master'][0]['withtax']=="true"){
									                               	document.getElementById("chk_tax").checked = true;
																	   
									                               	if(master['master'][0]['igst']=="true"){
									                               	 document.getElementById("rdb_igst").checked = true;
									                               	  document.getElementById("rdb_sgst").checked = false;
									                               	}
									                               	else{
									                               		document.getElementById("rdb_igst").checked = false;
									                               	  document.getElementById("rdb_sgst").checked = true;
									                               	}

									                               }
									                               else{
									                               		document.getElementById("chk_tax").checked = false;

									                               }
                                                                
                                                                    


// 									                                var str=master['master'][0]['imagepath'];
//                var res = str.split(",");
//                var imageref="";
//                var imagefolder="<?php echo base_url();?>images/";
//                for(i=0;i<res.length;i++)
//                 {                    
//                   imageref=imageref+'<a href="'+imagefolder+res[i]+'" target="_blank">' + res[i] + '</a>';
//                }

//                 document.getElementById("imageref").innerHTML=imageref;

									       
									                                  $('#dataTable  tr').remove();
									                                 
	ctr=1;
	var i=0;
   for(i=0;i<master['detailes'].length;i++){
	   
   	var tr = "tr" + ctr;
    var productcode = "productcode" + ctr;
    var unitprice = "unitprice" + ctr;
    var mrp = "mrp" + ctr;
   
    var qty = "qty" + ctr;
    var size = "size" + ctr;
     var oldsize = "oldsize" + ctr;
    var hsn = "hsn" + ctr;
    // var sqft = "sqft" + ctr;
    // var sq = "sq" + ctr;
    var amount = "amount" + ctr;
    var batch = "batch" + ctr;
    var tax = "tax" + ctr;
    var taxamount = "taxamount" + ctr;
    var totalamount = "totalamount" + ctr;
     var oldqty = "oldqty" + ctr;
      var masterid = "masterid" + ctr;
      var btnsub="btnsub"+ctr;
     var pdt_codev =master['detailes'][i]['productname'];
      var hsncodev =master['detailes'][i]['hsncode'];
      
        var qtyv =master['detailes'][i]['qty'];
         // var unitname =master['detailes'][i]['size'];
         var sizev=master['detailes'][i]['size'];
         // $("#datalistunit1 option[label='"+unitname+"']").val();
          var unitpricev =master['detailes'][i]['unitprice'];
           var netamountv =master['detailes'][i]['netamount'];
            var taxamountv =master['detailes'][i]['taxamount'];
            var taxv =master['detailes'][i]['taxpercent'];
              var amountv =master['detailes'][i]['amount'];
               var batchidv =master['detailes'][i]['expirydate']; 
                // var pdtsqfv =totalsqfv/nsheetsv;
                var masteridv=master['detailes'][i]['purchasereturnid'];
                MASTERID=masteridv;
				// alert(masteridv);
	var newTr = '<tr><td>'+ (i+1) +'</td><td><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +productcode +'" value="' +pdt_codev + '" readonly></td><td style=""><input type="text" value="' +hsncodev + '" class="form-control hsn1" autocomplete="off" id="' +hsn + '" name="productcode" readonly></td><td style=""><input type="text" id="' + size +'" class="form-control size" list="unit" name="size"  value="' +sizev + '" readonly></td><td><input type="number" value="'+qtyv+'" class="form-control qty" name="qty" autocomplete="off" id="' + qty + '" readonly></td><td style=""><input type="text" value="'+batchidv+'" id="' + batch +'" class="form-control"  list="bat" name="" readonly></td><td><input type="text" id="' + unitprice +'" class="form-control mrp" name="" value="'+unitpricev+'" readonly></td><td style=""><input type="text" id="' + amount +'" class="form-control" name="" value="' +netamountv + '" readonly></td><td class="taxd" style=""><input type="text" id="' + tax +'" class="form-control taxd"  name="" value="'+taxv+'"></td><td style="" class="taxamountd"><input type="text" id="' + taxamount +'" class="form-control taxamountd"  name="" value="'+taxamountv+'"></td><td class="totalamountd"><input type="text" id="' + totalamount +'" class="form-control"  name="" value="' +amountv + '"></td><td class="ctr" style="display:none">' + ctr +'</td></td> <td style="display:none"> <input type="text" class="form-control masterid" autocomplete="off" id="' +masterid + '" name="masterid" value="'+masteridv+'"></td><td style="display:none"><input type="number" value="'+qtyv+'" class="form-control qty" name="qty" autocomplete="off" id="' + oldqty + '" ></td> <td style="display:none"><input type="text" id="' + oldsize +'" class="form-control" list="unit" name="size"  value="' +sizev + '" ></td><td>X</td></tr>';
					 		
					                   	$('#dataTable1').append(newTr);
					                   	ctr=ctr+1;
					                                  }
					                                  if(master['master'][0]['withtax']=='true'){
                                                                             document.getElementById('chk_tax').checked=true;
                                                                              $(".taxd").css({"display":"table-cell"});
                                                                              $(".taxamountd").css({"display":"table-cell"});
                                                                              $(".totalamountd").css({"display":"table-cell"});
                                                                     }else{
                                                                      document.getElementById('chk_tax').checked=false;
                                                                       $(".taxd").css({"display":"none"});
                                                                       $(".taxamountd").css({"display":"none"});
                                                                        $(".totalamountd").css({"display":"none"});
                                                                     }
                                                                     if(master['master'][0]['igst']=='true'){
                                                                           document.getElementById('rdb_igst').checked=true;
                                                                        document.getElementById('rdb_sgst').checked=false;
                                                                     }else{
                                                                        document.getElementById('rdb_igst').checked=false;
                                                                        document.getElementById('rdb_sgst').checked=true;
                                                                     }
                                                                     $('#chk_tax').prop("disabled", true);
                                                                     $('#rdb_igst').prop("disabled", true);
                                                                     $('#rdb_sgst').prop("disabled", true);
												}
												
												
												

											},
											error: function (data) {
												var myJSON = JSON.stringify(data);
												alert("in details");
									alert(myJSON);
											}

										});

                   }
				catch(err)
				{
					alert(err.message);
				}

	  	
	  }
</script>
<script type="text/javascript">
	function clear(){
									ctr=1;
									document.getElementById("btnsave").disabled = false;
									// document.getElementById("btnupdate").disabled = true;
									document.getElementById("btndelete").disabled = true;
									$('#chk_tax').prop("disabled", false);
									$('#rdb_igst').prop("disabled", false);
									$('#rdb_sgst').prop("disabled", false);
									document.getElementById("supplier").value="";
									document.getElementById("orderno").value ="";
									// document.getElementById("invoicedate").value =master['master'][0]['invoicedate'];
									document.getElementById("invoicedate").value =  "";
									document.getElementById("branch").value ="";
									document.getElementById("narration").value ="";
									document.getElementById("totalqty").value ="";
									document.getElementById("totalamount").value ="";
										               document.getElementById("oldta").value ="";	
										                document.getElementById("taxamount").value ="";	
									                 document.getElementById("oldtx").value ="";	
										                 document.getElementById("additionalcost").value ="";
									                  document.getElementById("billdiscount").value ="";									                   document.getElementById("grandtotal").value ="";							                   
									                   document.getElementById("oldac").value ="";
									                   document.getElementById("oldbd").value ="";
									                   document.getElementById("oldgt").value ="";	
									                   document.getElementById("oldbalance").value ="";	
									                   // document.getElementById("cash").value ="";	                         
									                 // document.getElementById("bank").value ="";	                          
									                   document.getElementById("paidcash").value ="0.00";					                            
									                    document.getElementById("paidbank").value ="0.00";					                               
									                    document.getElementById("balance").value ="0.00";				                               
									                     document.getElementById("oldpc").value ="";					                             
									                     document.getElementById("oldpb").value ="";	
									                     document.getElementById("oldbl").value ="";
									                     $('#dataTable  tr').remove();
									                     addnewrow();

									                     
									                      $.ajax({
																type: "POST",
																dataType: "json",
																url: "<?php echo base_url() ?>index.php/Purchasecontrol/Autogenerate_PurchaseRetVoucherNo",
																data: {

																},

																success: function (data) {
																	// alert("voucher no retrieved");
																	$("#voucherno").val(data[0].NO);
																	inv_no=$("#voucherno").val();
																	max=inv_no;
																	
																},
																error: function (data) {
																	var result1 = JSON.stringify(data);
																	alert(result1);
																}

															});


	}
</script>



<script type="text/javascript"> var max=0;
	$("#supplier").change(function() {
		try {
			var val = $('#supplier').val();

			var balance = $('#supplier1 option').filter(function() {
				return this.value == val;
			}).data('supplierbalance');

			document.getElementById("oldbalance").value = balance;

		} catch (err) {
			alert(err.message);
		}

	});

	
	window.onload = function () { 
		addnewrow();
		document.getElementById("oldbalance").value = "0.00";
		 inv_no = document.getElementById("voucherno").value;
		 max=inv_no;
		 document.getElementById("btnsave").disabled=false;
    // document.getElementById("btnupdate").disabled=true;
    document.getElementById("btndelete").disabled=true;
    var loadinvno="<?php echo $loadinvno ?>";
   if(loadinvno!=0){
   	$('#voucherno').val(loadinvno);
   	 inv_no = loadinvno;
		
   	 loadinvoice(loadinvno);

   }
	}

	$('#billdiscount').change(function() {
		calculation();


	});
	$('#additionalcost').change(function() {

		calculation();

	});
	$('#paidcash').on('keyup change', function () {


		document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
	});

	$('#paidbank').on('keyup change', function ()
	{
	document.getElementById("balance").value = ((document.getElementById("paidcash").value * 1)+(document.getElementById("paidbank").value * 1)) - (document.getElementById("grandtotal").value * 1);
	});
	$('#dataTable1').on('change', '.unitprice', function() {
		var no = $(this).closest("tr")[0].rowIndex;
	var a =document.getElementById("dataTable1").rows[no].cells[11].innerHTML;
		rowcalculation(a);
		calculation();
	});
	$('#dataTable1').on('change', '.taxd', function() {
		var no = $(this).closest("tr")[0].rowIndex;
	var a =document.getElementById("dataTable1").rows[no].cells[11].innerHTML;
		rowcalculation(a);
		calculation();
	});
	$('#dataTable1').on('change', '.taxamountd', function() {
		var no = $(this).closest("tr")[0].rowIndex;
	var a =document.getElementById("dataTable1").rows[no].cells[11].innerHTML;
		rowcalculation(a);
		calculation();
	});

	$('#dataTable1').on('click', '.delete', function(e) {
		e.preventDefault();
		$(this).closest('tr').remove();
		var table = document.getElementById('dataTable1');
		var ab = table.rows.length;
		for (var i = 1; i < table.rows.length ; i++) {
			table.rows[i].cells[0].innerHTML = i;
		}
		calculation();
	});
	$('#dataTable1').on('keyup change', '.size', function () {

	var no = $(this).closest("tr")[0].rowIndex;
	var a =document.getElementById("dataTable1").rows[no].cells[11].innerHTML;
	var str =$(this).closest("tr").find('.size').val();
	var res = str.split(",");
  	var s= [];
  	var i=0;
  	var qty =0*1;
  	var b="";
  	for(i=0;i<res.length;i++)
  	{
	 	b= res[i].split(".");
  		s.push(a[0]);
  		if(b.length==2)
 		{
			 qty=qty+b[1]*1;
		}
		else
		{
			qty=qty+1*1;
		}
		
	}
	s.push(qty);
	$(this).closest("tr").find('.qty').val(qty);
	rowcalculation(a);
	calculation();
	});

	$('#dataTable1').on('keyup change', '.qty', function() {
		try{ 
	var no = $(this).closest("tr")[0].rowIndex;
	var a =document.getElementById("dataTable1").rows[no].cells[11].innerHTML;
 	rowcalculation(a);
	calculation();
	}
	catch(error){ alert(error.message);
	
		}
	});
	function rowcalculation(a) 
	{
		var QTY = $('#qty' + a).val();
		var purchaserate = $('#unitprice' + a).val();
		var val = $('#productcode' + a).val();
		var taxpercentage=$('#tax' + a).val();					
		var netamount = QTY * purchaserate;
		var taxamount = netamount * taxpercentage / 100;
		$('#unitprice' + a).val(purchaserate);
		$('#amount' + a).val((QTY * purchaserate).toFixed(2));
		$('#taxamount' + a).val(taxamount.toFixed(2));
		$('#totalamount' + a).val((taxamount + netamount).toFixed(2));
	}
</script>

<script type="text/javascript">

$('#chk_tax').on('change', '', function (e)
{
	var checkbox=document.getElementById('chk_tax');
	if(checkbox.checked==true)
	{
		$(".taxd").css({"display":"table-cell"});
        $(".taxamountd").css({"display":"table-cell"});
        $(".totalamountd").css({"display":"table-cell"});
	}
	else
	{
		$(".taxd").css({"display":"none"});
   	  	$(".taxamountd").css({"display":"none"});
      	$(".totalamountd").css({"display":"none"});
	}
  	var table = document.getElementById('dataTable1');
	for (var i = 1; i < table.rows.length; i++)
	{ 
	  no =document.getElementById("dataTable1").rows[i].cells[11].innerHTML;
	  var purchaserate=$('#name option').filter(function ()
	  {
		  return this.value == val;
		  }).data('purchaserate')*1;
		  if($('#chk_tax').prop("checked")==false)
		  {
			  taxpercentage=0;
			  }
			  else
			  {
				  var slab = $('#name option').filter(function () {
				                    return this.value == val;
		                           	}).data('slab')*1;
						if(purchaserate>slab)
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
                        purchaserate=purchaserate*100/(100+taxpercentage);
				}
				$('#unitprice' + no).val(purchaserate);
				rowcalculation(no);
			}
			calculation();
		});
  
  </script>

<script type="text/javascript">

	$('#addrow').on('click', function() {
		
    try{
		addnewrow();
    }
	catch(err){
		alert(err.message);
		}
	});

</script>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">

	$(document).ready(function () {

				$('#btnclear').on('click', function () {this.disabled=true;alert();
					 clear();
					});
					//Save product
				});

</script>
<script type="text/javascript">
	$(document).ready(function () {


				$('#btnsave').on('click', function () 
				{
						this.disabled=true;
						// var Finaltaxamount=0.00;
						var voucherno = document.getElementById("voucherno").value;
						// var supplier = document.getElementById("supplier").label;
						var supplier = $("#supplier1 option[value='" + $('#supplier').val() + "']").attr('label');
						var order = document.getElementById("orderno").value;
						var vendor = document.getElementById("vendor").value;
						var date = document.getElementById("invoicedate").value;
						var payment = 'cash';
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
						var withtax = document.getElementById("chk_tax").checked;
						var igst = document.getElementById("rdb_igst").checked;
						var TotalPurchasedStockAmount = document.getElementById("totalamount").value;
						var imagepath ="";
						var formData = new FormData($("#form_img")[0]);
				 $.ajax({

                url : "<?php echo base_url() ?>index.php/Onlinecontrol/insert_jsimage",
                type : 'POST',
               	cache: false,
               	data: formData,
                enctype: 'multipart/form-data',
                contentType : false,
                processData : false,
                success: function(resp) {
                   imagepath=JSON.parse(resp);
						//$.noConflict();
              // alert(TotalPurchasedStockAmount);
						try {
							$.ajax({
									type: "POST",
									// dataType:"json",
									url: "<?php echo base_url() ?>index.php/Purchasecontrol/insertreturndetailes",
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
										'branch':branch,
										'balance': balance,
										'withtax' :withtax,
										'igst' :igst,
										'imagepath' :imagepath
									},
									success: function (data) {
										  
var count=0;
										
										var no =0;
										var table = document.getElementById('dataTable1');
										for (var i = 1; i < table.rows.length-1; i++) {
											no =document.getElementById("dataTable1").rows[i].cells[11].innerHTML;
											var product = $("#name option[value='" + $('#productcode'+no).val() + "']").attr('label');
											var val =$('#productcode'+no).val();
											// alert(product);
											var size = $('#size' + no).val();
											var sizes=size;
											// alert(no);
											// alert(product);
											// alert(size);
											// var product = $('#productcode' + i).val();
											var productname = $('#productcode'+no).val();
											var unitprice = 0;
											var qty = 0;
											var batch=0;
                                            var newunitprice = 0;
											
												unitprice = $('#unitprice' + no).val();
												
												qty = $('#qty' + no).val();
												hsncode= $('#hsn'+no).val();
											    batch =  $('#batch' + no).val();
											
											
                                            var slab = $('#name option').filter(function () {
				                                       return this.value == val;
		                                                                   	}).data('slab')*1;
			                                                         	var taxpercentage=0;
				
						                            if(unitprice>slab)
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
						                                    //    alert(newunitprice+"-"+taxpercentage);
											var mrp = "";
											var netamount = $('#amount' + no).val();

											var tax = $('#tax'+no).val();
											
											var taxamount = $('#taxamount' + no).val();
											// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
											// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
											var amount = $('#totalamount' + no).val();
											if (1 == 2) {

											} else {	$.ajax({

														type: "POST",
														url: "<?php echo base_url() ?>index.php/Purchasecontrol/insertreturntable",
														data: {
															'voucherno': voucherno,
															'invoicedate': date,
															'productname': productname,
															'productcode': product,
															'hsncode': hsncode,
															'qty': qty,
															'unitprice': unitprice,
															'size': size,
															'netamount': netamount,
															'tax': tax,
															'taxamount': taxamount,
															'mrp': mrp,
															'branch': branch,
															'batch': batch,
															'amount': amount,
															'purchasereturnid':data
														},
														success: function (data) {
															var result1 = JSON.stringify(data);

															// $('#orderno').val('');
															// $('#vendor').val('');
															// $('#invoicedate').val('');
															// $('#payment').val('');
															// $('#narration').val('');
															// $('#company').val('');
															// $('#totalqty').val('');
															// $('#totalamount').val('');
															// $('#additionalcost').val('');
															// $('#taxamount').val('');
															// $('#billdiscount').val('');
															// $('#grandtotal').val('');
															// $('#oldbalance').val('');
															// $('#cash').val('');
															// $('#bank').val('');
															// $('#totalstockamount').val('');
															// $('#paidcash').val('');
															// $('#paidbank').val('');
															// $('#balance').val('');
															// $('#dataTable  tr').remove();
															// for (var i = 0; i < qty; i++)
															// {  
															// 	// alert();
															// 	var divToPrint1 = document.getElementById("barcode");
															// 	var divToPrint2 = document.getElementById("barcodemrp");
															// 	document.getElementById("barcodemrp").innerHTML = unitprice;
															// 	JsBarcode("#barcode", product, {
															// 		lineColor: "#000",
															// 		height: 40
															// 	});
															// 	newWin = window.open("");
															// 	newWin.document.write("<center style='font-size=20'>MRP:" + unitprice +
															// 	" </center>");
															// 	newWin.document.write(divToPrint1.outerHTML);
															// 	newWin.print();
															// 	newWin.close();
															// }
															// 	document.getElementById("barcode").style.visibility = "hidden";
															// 	document.getElementById("barcode").style.display = "none"; document.getElementById("barcodemrp").style.visibility = "hidden";

																},

																//end of second success

															error: function (request, status, error) {
																alert(request.responseText);
																}


														});

													//end of second ajax  
												} //end of else



											} //end of for loop

											//PurchaseInvoice_AccountInsertion_End
											//PurchaseInvoice_DayBookInsertion_Start
											$.ajax({
												type: "POST",
												url: "<?php echo base_url() ?>index.php/Purchasecontrol/PurchaseReturn_DyaBookInsertion",
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
													     alert("purchase return saved succesfully");
															// location.reload();
														clear();
														
												}

											});
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
							},

																//end of second success

															error: function (request, status, error) {
        alert(request.responseText);
    }


														});
						});


					//Save product

				});
</script>
<script type="text/javascript">

// delete purchase

$(document).ready(function() {


		$('#btndelete').on('click', function() {

			this.disabled=true;
			// var Finaltaxamount=0.00;
			var voucherno = document.getElementById("voucherno").value;
			var supplier = $("#supplier1 option[value='" + $('#supplier').val() + "']").attr('label');
			var order = document.getElementById("orderno").value;
			var vendor = document.getElementById("vendor").value;
			var date = document.getElementById("invoicedate").value;
			var payment = 'cash';
			var narration = document.getElementById("narration").value;
			var company = document.getElementById("company").value;
			var totalqty = document.getElementById("totalqty").value;
			var totalamount = document.getElementById("totalamount").value;
			var additionalcost = document.getElementById("additionalcost").value;
			var tax1 = document.getElementById("taxamount").value;
			var discount = document.getElementById("billdiscount").value;
			var mrp = document.getElementById("mrp").value;
			// alert (payment);
			var total = document.getElementById("grandtotal").value;
			var oldbalance = document.getElementById("oldbalance").value;
			var bank = document.getElementById("bank").value;
			var cash = document.getElementById("cash").value;
			var branch = document.getElementById("branch").value;
			var paidcash = document.getElementById("paidcash").value;
			var paidbank = document.getElementById("paidbank").value;
			var balance = document.getElementById("balance").value;
			var TotalPurchasedStockAmount = document.getElementById("totalstockamount").value;
			var oldta = document.getElementById("oldta").value;
			var oldac = document.getElementById("oldac").value;
			var oldtx = document.getElementById("oldtx").value;
			var oldbd = document.getElementById("oldbd").value;
			var oldgt = document.getElementById("oldgt").value;
			var oldpc = document.getElementById("oldpc").value;
			var oldpb = document.getElementById("oldpb").value;
			var oldbl = document.getElementById("oldbl").value;


			// $.noConflict();
			try {

				$.ajax({

					type: "POST",
					// dataType:"json",
					url: "<?php echo base_url() ?>index.php/Purchasecontrol/deleteretdetailes",
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
						'bank': bank,
						'cash': cash,
						'paidcash': paidcash,
						'paidbank': paidbank,
						'mrp': mrp,
						'branch':branch,
						'balance': balance
					},
					success: function(data) {
						// alert("master");
						var ctr = 1;
						var table = document.getElementById('dataTable1');
						for (var i = 1; i < table.rows.length; i++) 
						{
							no =document.getElementById("dataTable1").rows[i].cells[11].innerHTML;
							var product = $("#name option[value='" + $('#productcode'+no).val() + "']").attr('label');
							// alert(product);
							var size = $('#size' + no).val();
							var productname = $('#productcode'+no).val();
							var unitprice = 0;
							var qty = 0;
							var batch = 0;
							var old = 0;
							if (i == 1) 
							{
								unitprice = $('#unitprice1').val();
								qty = $('#qty1').val();
								hsncode= $('#hsn1').val();
								old = $('#oldqty1').val();
								batch = $('#batch1').val();
							}
							else
							{
								unitprice = $('#unitprice' + no).val();
								qty = $('#qty' + no).val();
								hsncode= $('#hsn'+no).val();
								old = $('#oldqty' + no).val();
								batch = $('#batch' + no).val();
							}
							var mrp = "";
							var netamount = $('#amount' + no).val();
							// var tax = $('#tax'+i).val();
							var tax = 0.00;
							var taxamount = $('#taxamount' + no).val();
							// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
							// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
							var amount = $('#totalamount' + no).val();
							if (productname==null || productname=="") 
							{
							}
							else
							{
								alert();
								$.ajax({
									type: "POST",
									url: "<?php echo base_url() ?>index.php/Purchasecontrol/delete_purchaseretdetailes",
									data: {
										'voucherno': voucherno,
										'invoicedate': date,
										'productname': productname,
										'productcode': product,
										'qty': qty,
										'unitprice': unitprice,
										'size': size,
										'netamount': netamount,
										'tax': tax,
										'taxamount': taxamount,
										'mrp': mrp,
										'old': old,
										'branch': branch,
										'batch': batch,
										'amount': amount
									},

									success: function(data) {
										var result1 = JSON.stringify(data);
										// alert(result1);
										
										
										

									},
									//end of second success

									error: function(data) {
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
							url: "<?php echo base_url() ?>index.php/Purchasecontrol/PurchaseRetdelete_DyaBookInsertion",
							data: {
								'voucherno': voucherno,
								'date': date,
								'totalamount': totalamount,
								'tax': tax1,
								'paidbank': paidbank,
								'paidcash': paidcash,
								'paymentmode': payment,
								'discount': discount,
								'balance': balance,
								'bank': bank,
								'cash': cash,
								'supplier': supplier
							},

							success: function(data) {
								var result1 = JSON.stringify(data);
								// alert(result1);
								// alert("DayBook Insertion successfully completed");
								//PurchaseInvoice_AccountInsertion_Start

								
										// //Autogenerate_VoucherNo_start
alert("purchase deleted succesfully");
										clear();
							}

						});

						//PurchaseInvoice_DayBookInsertion_End



						// //Autogenerate_VoucherNo_End




					}, //end of first success
					error: function(data) {
						var result1 = JSON.stringify(data);
						alert(result1);
						alert('last');
					}
				}); //end of first ajax


			} catch (err) {
				alert(err.message);
			}
		});

		//Save product

	});
</script><script type="text/javascript">
	  $('#chk_tax').on('change', '', function (e) {
   
  var checkbox=document.getElementById('chk_tax');
  if(checkbox.checked==true){
      
       $(".taxd").css({"display":"table-cell"});
        $(".taxamountd").css({"display":"table-cell"});
        $(".totalamountd").css({"display":"table-cell"});

  }
  else{
  $(".taxd").css({"display":"none"});
   $(".taxamountd").css({"display":"none"});
    $(".totalamountd").css({"display":"none"});
  }
  var table = document.getElementById('dataTable1');
										for (var i = 1; i < table.rows.length; i++) { 
											
											no =document.getElementById("dataTable1").rows[i].cells[11].innerHTML;
											rowcalculation(no);
										}
										calculation();
  });</script>
<div id="barcodemrp" style="display: none;"></div>
<svg id='barcode' style="display: none;"></svg>
</div>

				<script type="text/javascript">
					function print(){
						var voucherno = document.getElementById("voucherno").value;
						var supplier = $('#supplier').val();
						// var order = document.getElementById("orderno").value;
						var vendor = document.getElementById("vendor").value;
						var date = document.getElementById("invoicedate").value;
						var payment = 'cash';
						var narration = document.getElementById("narration").value;
						var company = document.getElementById("company").value;
						var totalsqf = document.getElementById("totalqty").value;
						var totalamount = document.getElementById("totalamount").value;
						var additionalcost = document.getElementById("additionalcost").value;
						var tax1 = document.getElementById("taxamount").value;
						var igst=0;
						var cgst =0;
						var sgst =0;
						if(document.getElementById("rdb_igst").checked == true){
							var igst =tax1;

						}else{
							cgst=tax1/2;
							sgst=tax1/2;

						}
						var discount = document.getElementById("billdiscount").value;
						// var mrp = document.getElementById("mrp").value;
						var grandtotal = document.getElementById("grandtotal").value;
						 try{
									   var inwords = toWords(grandtotal);
									}catch(err){
										alert(err.message);
									}
						var oldbalance = document.getElementById("oldbalance").value;
						var cash = document.getElementById("cash").value;
						var bank = document.getElementById("bank").value;
						var branch = document.getElementById("branch").value;
                        var branchname=$("#branch option[value='"+branch+"']").text();
						var paidcash = document.getElementById("paidcash").value;
						var paidbank = document.getElementById("paidbank").value;
						var balance = document.getElementById("balance").value;
						var ship_address = $('#supplier1 option').filter(function() {
				                                            return this.value == supplier;
			                                      }).data('address');
						var state = $('#supplier1 option').filter(function() {
				                                            return this.value == supplier;
			                               }).data('city');
						var number1 = $('#supplier1 option').filter(function() {
			                                        	return this.value == supplier;
			                                 }).data('mobile');
						if(balance >0){
							paidcash=paidcash-balance;
							balance =0;
						}
						var paidcash1 =paidcash;
						var TotalPurchasedStockAmount = document.getElementById("totalamount").value;
													
													
            						   // var bicus= $("#supplier").val();
                     //                   $('#billcust').html(bicus);
                     //                   $('#datebill').html(date);
                     //                   $('#vouchernobill').html(voucherno);
                     //                   $('#vendorinvoicenobill').html(vendor);
                                              // var content = document.getElementById("billing").innerHTML;
                                              // var not = document.getElementById("notices").innerHTML;
                                              // var foot = document.getElementById("billfoot").innerHTML;
                                               var mywindow = window.open('', 'Print', 'height=600,width=1000');
    mywindow.document.write('<html><head><title>Print</title><style>*{font-family: "Lucida Console", Monaco, monospace;}.imgg{float:left; padding:20px;}.moahead{font-size:30px;letter-spacing:9px;font-family: "Lucida Console";}center{border: 2px solid;}.invoice{color:white; font-size:20px; background-color:black;}hr{border-top: 1px dashed black;}</style>');
    mywindow.document.write('</head><body>');
    // mywindow.document.write(content);
    mywindow.document.write('<center><span class="imgg"><img width="60" height="60" src="<?php echo base_url();?>images/loo.png"></span><span class="invoice">INVOICE BILL</span><br><span class="moahead">MALL OF ABAYAS</span><br><span>First floor,No.88,Room No.F04,5th Block,</span><br><span>Koramangala Industrial Layout, Bengaluru, Karnataka, PIN 560095<br> info@mallofabayas.com | GSTIN: 29ABIFM2960LIZQ </span></center>');


	mywindow.document.write('<table cellspacing=0 border=1px solid black;>');

	mywindow.document.write('<tr><td style="padding:5px;" colspan="9"><b>Billed to </b></td></tr>');

	mywindow.document.write('<tr><td style="padding:5px;" colspan="9">Name:'+branchname+'<br>address:'+ship_address+'<br>State:'+state+'<br>Contact: '+number1+'</td></tr>');
    mywindow.document.write('<thead><tr><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th></tr></thead><tbody>');
    mywindow.document.write('<thead><tr><th class="grand">SL.NO</th><th class="grand">PRODUCT NAME</th><th class="grand">QTY</th><th class="grand">UNIT PRICE</th><th class="grand">SIZE</th><th class="grand">IGST</th><th class="grand">CGST</th><th class="grand">SGST</th><th class="grand">TOTAL AMOUNT</th></tr></thead><tbody>');
    var table = document.getElementById('dataTable1');
    var n=1;
	var no=0;
									for (var i = 1; i < table.rows.length; i++) {

											no =document.getElementById("dataTable1").rows[i].cells[11].innerHTML;
											var product = $("#name option[value='" + $('#productcode'+no).val() + "']").attr('label');
											if(product==""||product==null){}
												else{
											// var size = $("#size option[value='" + $('#size'+no).val() + "']").attr('label');
                                             var size =$("#size"+no).val();

											var mrp = 0;
											var qty = 0;
											var batch=0;
											var unitprice ="";
											
												unitprice = $('#unitprice' + no).val();
												qty = $('#qty' + no).val();

											
											var productname = $('#productcode'+no).val();
                                            
											var netamount = $('#amount' + no).val();
											// var tax = $('#tax'+i).val();
											var tax = $('#tax' + no).val();
											var igs=0.00;
											var cgs=0.00;
											var sgs=0.00;
											if($('#chk_tax').prop("checked")==false){

                                              	tax=0; 
                                                 }
											var taxamount = $('#taxamount' + no).val();
											if(document.getElementById("rdb_igst").checked == true){
							var igs =taxamount;

						}else{
							cgs=taxamount/2;
							sgs=taxamount/2;

						}
											// Finaltaxamount=Finaltaxamount+(document.getElementById("dataTable").rows[i].cells[9].innerHTML);
											// Finaltaxamount=parseInt(Finaltaxamount,10) +parseInt(taxamount,10);
											var amount = $('#totalamount' + no).val();

 mywindow.document.write('<tr style="border:none;"><td style="text-align:center">'+n+'</td><td style="text-align:center">'+productname+'</td><td style="text-align:center">'+qty+'</td><td style="text-align:center">'+unitprice+'</td><td style="text-align:center">'+size+'</td><td style="text-align:center">'+igs+'</td><td style="text-align:center">'+cgs+'</td><td style="text-align:center">'+sgs+'</td><td style="text-align:left">'+amount+'</td></tr>');
n++;
}
										} 
								// mywindow.document.write('<tr><td colspan="4" style="font-size:22px;"><b>Total</b></td><td></td><td style="font-size:22px;" colspan="4"><b>'+totalamount+'</b></td></tr>');

	mywindow.document.write('<tr><td  colspan="5" rowspan="6">CASH PAYMENT :'+paidcash+'<br>BANK PAYMENT :'+paidbank+'<br>BALANCE TO PAY :'+balance+'</td><tr><td colspan="4"><b>Subtotal                   - Rs:  '+totalamount+'/- </b></td></tr><td colspan="4">CGST 	                     - Rs: '+cgst+'/-  </td></tr><tr><td colspan="4">SGST                   - Rs:  '+sgst+'/- </td></tr><tr><td colspan="4">IGST 	                   - Rs : '+igst+'/- </td></tr><tr><td colspan="4">Discount 	                   - Rs : '+discount+'/- </td></tr><tr></tr>');
	mywindow.document.write('<tr><td colspan="5" style="font-size:22px;"><b>Grand Total</b></td><td style="font-size:22px;" colspan="5"><b>'+grandtotal+'</b></td></tr>');

	mywindow.document.write('<tr><td colspan="9">Invoice value (in words): '+inwords+'</td></tr>');

	mywindow.document.write('<tr><td colspan="5">TERMS AND CONDITIONS:<br><br>Subject to ERNAKULAM Destribution<br><br><br><br>E & 0.E</td><td colspan="4">For MALL OF ABAYAS:<br><br>Authrised Signature<br><br>Certify that the particulars given above are true and correct<br></td></tr>');

	mywindow.document.write('</tbody> </table>');

    mywindow.document.write('</body></html>');


	mywindow.document.write('<center>Thank you for visiting MALL OF ABAYAS....!</center><br><div>'+date+'<span style="float:right;">'+branch+'/'+voucherno+'</span></div>');

	mywindow.document.write('<td style="padding: 20px;" colspan="6">----------------------------------------------------------------------------------------------------</td>');
 mywindow.document.write('<tr><td colspan="6">For Mall of abayas - Digital Verified:</td></tr>');


	mywindow.document.write('</tbody> </table>');


    mywindow.document.write('</body></html>');
    // mywindow.document.write(not);
    // mywindow.document.write(foot);

    // mywindow.document.close();
    mywindow.focus();
    mywindow.print();
    // mywindow.close();
					}
	$(document).ready(function () {


				$('#btnclose').on('click', function () {

						print();
									        
						});

					

				});
</script>

<!-- <div id="barcodemrp" style="display: none;"></div>
<svg id='barcode' style="display: none;"></svg> -->
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
  width: 100%;
}

#project span {
  color: #5D6975;
  text-align: right;
   font-size: 20px; 
  margin-right: 10px;
  /*display: inline-block;*/
 
}
#project span right {
  float: right;
 
}

#company {
  float: right;
  text-align: right;
}

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
        <!-- <img src="actizo.png"> -->
      </div>
      <h1 class="billhead">PURCHASE INVOICE</h1>
     
      <div id="project">
       <div class="row" style="width: 100%">
       
         <div class="col-xs-6"><span>Voucher no :</span><span id="vouchernobill"></span> <span>  Supplier :</span> <span id="billcust"></span><span class="right">   Vendor invoice no :</span><span id="vendorinvoicenobill" class="right"></span><span class="right">  Date :</span> <span id="datebill" class="right"></span></div>
         

       
        

         </div>
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


