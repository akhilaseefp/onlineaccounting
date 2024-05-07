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
			var a = $(this).closest("tr")[0].rowIndex;

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
						var purchaserate = result[0]['purchaserate'];
						var taxpercentage = result[0]['tax'];
						var netamount = mrp * Qty;
         
						var taxamount = mrp * Qty * taxpercentage / 100;

						if (a == 1) {
							
              $('#mrp').val(mrp);
							$('#amount1').val(mrp * Qty);
							$('#taxamount1').val(taxamount);
							$('#totalamount1').val(netamount + taxamount);
						} else {
							
              $('#mrp'+a).val(mrp);
							$('#amount' + a).val(mrp * Qty);
							$('#taxamount' + a).val(taxamount);
							$('#totalamount' + a).val(netamount + taxamount);
						}

            

						var tr = "tr" + ctr;
						var productcode = "productcode" + ctr;
						var unitprice = "unitprice" + ctr;
            var mrp = "mrp" + ctr;
						var qty = "qty" + ctr;
						var amount = "amount" + ctr;
						var batch = "batch" + ctr;
						var tax = "tax" + ctr;
						var taxamount = "taxamount" + ctr;
						var totalamount = "totalamount" + ctr;

						var rowCount = document.getElementById('dataTable').rows.length + 1;

						var newTr = '<tr><td>' + rowCount +
							'</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +
							productcode +
							'"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' +
							qty + '" name="productcode"></td><td><input type="text" id="' + batch +
							'" class="form-control" list="bat" name="" ></td><td><input type="text" id="' + mrp +
              '" class="form-control mrp" name=""></td><td><input type="text" id="' + amount +
							'" class="form-control" name=""></td><td><input type="text" id="' + taxamount +
							'" class="form-control"  name=""></td><td><input type="text" id="' + totalamount +
							'" class="form-control"  name=""></td><td style="display:none">' + ctr +
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

		try {totalstockamount=0;
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
       var mrp1 =0;
			for (var n = 1; n < table.rows.length; n++) {
				var i = 0;
				try {
					i = document.getElementById('dataTable').rows[n - 1].cells[8].innerHTML;
          mrp1=document.getElementById('dataTable').rows[n-1].cells[4].value;
				} catch (err) {

				}
       
				if (mrp1=="") { 

				} else {  var val = $('#productcode' + i).val();
          purchaserate = $('#name option').filter(function () {
                              return this.value == val;
                            }).data('purchaserate');
					rowqty = document.getElementById('qty' + i).value * 1;

					rownetamount = document.getElementById('amount' + i).value * 1;
					rowtaxamount = document.getElementById('taxamount' + i).value * 1;
					rowtotalamount = document.getElementById('totalamount' + i).value * 1;
				}

				qty = qty + rowqty;

				netamount = netamount + rownetamount;

				taxamount = taxamount + rowtaxamount;
				totalamount = totalamount + rowtotalamount;
        totalstockamount=totalstockamount+purchaserate*rowqty;

			}


			$('#totalqty').val(qty - 1);
			$('#totalamount').val(netamount);
			$('#taxamount').val(taxamount);
			var billdiscount = $('#billdiscount').val() * 1;
			var additionalcost = $('#additionalcost').val() * 1;
			$('#grandtotal').val(netamount + taxamount - billdiscount + additionalcost);
			document.getElementById("balance").value = (document.getElementById("paidamount").value * 1) - (document
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
			Sales Invoice
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
			<!-- <li><a href="#">Forms</a></li> -->
			<li class="active">Account Group</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-default">
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Invoice No</label>
							<?php foreach ($invoiceno->result() as $invno) {
                  ?>
							<input type="text" class="form-control" required autocomplete="off" value="<?php echo $invno->NO;?>"
								name="invoiceno" id="invoiceno">
							<?php
                  }
                  ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Customer</label>
							<select class="form-control" name="customer" id="customer">
                      <option value="0" data-balance="0.00">Select Customer</option>

								<?php
                      foreach ($customer->result() as $cust) {
                     ?>
								<option value="<?php echo $cust->customerid; ?>" data-balance="<?php echo $cust->currentbalance;?>">
									<?php echo $cust->customername; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales Order No</label>
							<input type="text" class="form-control" autocomplete="off" id="salesorderno" name="salesorderno">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4" style="">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales date</label>
							<input type="text" disabled="" class="form-control" id="salesdate" value="<?php echo date("Y-m-d") ?>"
								name="salesdate">
						</div>
					</div>
					<div class="col-md-4" style="">

						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Branch</label>
							<select class="form-control" name="branch" id="branch">
								<?php
                      foreach ($branch->result() as $branch) {
                     ?>
								<option value="<?php echo $branch->branchname; ?>"><?php echo $branch->branchname; ?></option>
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
								<th>QTY</th>
								<th class="d-none d-xl-block">BATCH</th>
							<!-- 	<th class="d-none d-xl-block" style="display:none">UNIT PRICE</th> -->
                <th class="d-none d-xl-block">MRP</th>
								<th class="d-none d-xl-block" style="">NET AMOUNT</th>
								<th class="d-none d-xl-block" style="">TAX AMOUNT</th>
								<th class="d-none d-xl-block">TOTAL AMOUNT</th>
								<th class="d-none d-xl-block" style="display: none;"></th>
								<th class="d-none d-xl-block"></th>
							</tr>
						</thead>
						<tbody id="dataTable" width="100%" class="table table-hover">
							<tr>
								<td>1</td>
								<td> <input type="text" class="form-control productcode2" list="name" autocomplete="off"
										name="productname" id="productcode1"></td>
								<datalist id="name">
									<?php foreach($product->result() as $gp){
                   ?>
									<option value="<?php echo $gp->pdt_code;?>" data-purchaserate="<?php echo $gp->purchaserate;?>"
										data-tax="<?php echo $gp->tax;?>" label="<?php echo $gp->pdt_name;?>">
										<?php  } ?>

								</datalist>
								<td>
									<input type="number" value="1" class="form-control qty" autocomplete="off" id="qty1"
										name="productcode">

								</td>
								<td><input type="text" id="batch" list="bat" class="form-control" name=""></td>
								<datalist id="bat">
									<?php foreach($batch->result() as $gp){
                   ?>
									<option value="<?php echo $gp->batchid;?>" label="<?php echo $gp->batchname;?>">
										<?php  } ?>
								</datalist>
								<!-- <td><input type="text" id="unitprice" class="form-control unitprice" name="" style="display:none"></td> -->
                  <td><input type="text" id="mrp" class="form-control mrp" name=""></td>
								<td><input type="text" id="amount1" class="form-control" name=""></td>

								<td><input type="text" id="taxamount1" class="form-control" name=""></td>
								<td><input type="text" id="totalamount1" class="form-control" name=""></td>
								<td style="display: none">1</td>
								<td><a href="" class="delete">X</a></td>



							</tr>
						</tbody>
					</TABLE>
					<input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
				</div>

				<hr>
				<div class="row col-md-12">
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Total Qty</label>
							<input type="text" class="form-control" name="totalqty" id="totalqty">
						</div>
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Total Amount</label>
							<input type="text" class="form-control" name="totalamount" id="totalamount">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Tax Amount</label>
							<input type="text" class="form-control" name="taxamount" id="taxamount">
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
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Cash/Bank</label>
								<select class="form-control" id="cashorbank" name="cashorbank">
									<?php
                      foreach ($BankAndcashLedgers->result() as $ledgers) {
                      
                     ?>
									<option value="<?php echo $ledgers->ledgername; ?>"><?php echo $ledgers->ledgername; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">paid Amount</label>
								<input type="text" value="0" name="paidamount" id="paidamount" class="form-control" required
									autocomplete="off">
							</div>
						</div>
						<div class="col-md-3 subpay">
							<div class="form-group">
								<label class="form-control-placeholder" for="contact-person">Balance</label>
								<input type="text" name="balance" id="balance" class="form-control" autocomplete="off">
							</div>
						</div>
					</fieldset>
				</div>
				<hr>
				<div class="row col-md-12 txn-bottom-form">
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Narration</label>
							<textarea class="form-control" style="line-height:3.5" name="narration" id="narration"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-placeholder" for="contact-person">Transportation Company</label>
							<input type="text" class="form-control" autocomplete="off" name="transportcompany" id="transportcompany">
						</div>
					</div>
				</div>
				</form>
				<hr>
				<div class="row col-md-12 form-group margin txn-bottom-form" style="text-align: center;">
					<div class="offset-md-4">
						<!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
						<input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave">
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
   var customer = document.getElementById('customer');   
  customer.onclick=function () {
    try {
   

      var balance = customer.options[customer.selectedIndex].getAttribute("data-balance");

  

      document.getElementById("oldbalance").value = balance;


    } catch (err) {
      alert(err.message);
    }




  }
  window.onload = function () {
    document.getElementById("oldbalance").value = "0.00";
  }
  $('#billdiscount').change(function () {
    calculation();


  });
  $('#additionalcost').change(function () {

    calculation();

  });
  $('#paidamount').change(function () {


    document.getElementById("balance").value = (document.getElementById("paidamount").value * 1) - (document
      .getElementById("grandtotal").value * 1);

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
      var QTY = $('#qty1').val()*1;

      var mrp = $('#mrp').val()*1;

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
    var amount = "amount" + ctr;
    var batch = "batch" + ctr;
    var tax = "tax" + ctr;
    var taxamount = "taxamount" + ctr;
    var totalamount = "totalamount" + ctr;

    var rowCount = document.getElementById('dataTable').rows.length + 1;
    var newTr = '<tr><td>' + rowCount +
      '</td><td ><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="' +
      productcode + '"></td><td> <input type="number" value="1" class="form-control qty" autocomplete="off" id="' +
      qty + '" name="productcode"></td><td><input type="text" id="' + batch +
      '" class="form-control " list="bat" name="" ></td><td><input type="text" id="' + mrp +
      '" class="form-control mrp" name=""></td><<td><input type="text" id="' + amount +
      '" class="form-control" name=""></td><td><input type="text" id="' + taxamount +
      '" class="form-control"  name=""></td><td><input type="text" id="' + totalamount +
      '" class="form-control"  name=""></td><td style="display:none">' + ctr +
      '</td> <td><a href="" class="delete" >X</a></td> </tr>';
    $('#dataTable1').append(newTr);



  });
</script>
			<script type="text/javascript">
				$(document).ready(function () {


					$('#btnsave').on('click', function () {

						alert(totalstockamount);

						var invoiceno = document.getElementById("invoiceno").value;
						var customer = document.getElementById("customer").value;
						var salesorderno = document.getElementById("salesorderno").value;
						var Paymentmode = document.getElementById("Paymentmode").value;
						var salesdate = document.getElementById("salesdate").value;
						var totalqty = document.getElementById("totalqty").value;
						var totalamount = document.getElementById("totalamount").value;

						var additionalcost = document.getElementById("additionalcost").value;
						var taxamount = document.getElementById("taxamount").value;
						var billdiscount = document.getElementById("billdiscount").value;
						var grandtotal = document.getElementById("grandtotal").value;
						var oldbalance = document.getElementById("oldbalance").value;
						var cashorbank = document.getElementById("cashorbank").value;

						var bank = document.getElementById("cashorbank").value;

						var paidamount = document.getElementById("paidamount").value;
						var branchid = document.getElementById("branch").value;
						var balance = document.getElementById("balance").value;
						var narration = document.getElementById("narration").value;
						var transportcompany = document.getElementById("transportcompany").value;
						$.noConflict();
						try {

							$.ajax({

								type: "POST",
								// dataType:"json",
								url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_salesinvoicemaster",
								data: {
									'invoiceno': invoiceno,
									'customer': customer,
									'salesorderno': salesorderno,
									'Paymentmode': Paymentmode,
									'salesdate': salesdate,
									'totalqty': totalqty,
									'totalamount': totalamount,
									'additionalcost': additionalcost,
									'taxamount': taxamount,
									'billdiscount': billdiscount,
									'grandtotal': grandtotal,
									'oldbalance': oldbalance,
									'cashorbank': cashorbank,
									'paidamount': paidamount,
									'balance': balance,
									'narration': narration,
									'transportcompany': transportcompany,
									'branchid': branchid
								},

								success: function (data) {
									alert("master");

									var table = document.getElementById('dataTable');
									for (var i = 1; i < table.rows.length; i++) {
										var productname = document.getElementById("dataTable").rows[i].cells[2].innerHTML;
										var productcode = document.getElementById("dataTable").rows[i].cells[3].innerHTML;
										var qty = document.getElementById("dataTable").rows[i].cells[4].innerHTML;
										var unitprice = document.getElementById("dataTable").rows[i].cells[5].innerHTML;
										var netamount = document.getElementById("dataTable").rows[i].cells[6].innerHTML;
										var tax = document.getElementById("dataTable").rows[i].cells[7].innerHTML;
										var taxamount = document.getElementById("dataTable").rows[i].cells[8].innerHTML;
										var amount = document.getElementById("dataTable").rows[i].cells[9].innerHTML;
										$.ajax({

											type: "POST",
											url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_salesinvoicedetails",
											data: {
												'invoiceno': invoiceno,
												'salesdate': salesdate,
												'productname': productname,
												'productcode': productcode,
												'qty': qty,
												'unitprice': unitprice,
												'netamount': netamount,
												'tax': tax,
												'taxamount': taxamount,
												'amount': amount,
												'branchid': branchid
											},
											success: function (data) {
												alert("table");
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
												// document.getElementById("dataTable").deleteRow(1);
												var tt = document.getElementById("grandtotal").value;
												document.getElementById("ttl").innerText = tt;
												var source = document.getElementById('dataTable');
												var destination = document.getElementById('tableB');
												var copy = source.cloneNode(true);
												copy.setAttribute('id', 'tableB');
												destination.parentNode.replaceChild(copy, destination);
												var content = document.getElementById("bill").innerHTML;
												var mywindow = window.open('', 'Print', 'height=600,width=800');
												mywindow.document.write(
													'<html><head><title>Print</title><link href="<?php echo base_url();?>css/stylebill.css">'
													);
												mywindow.document.write('</head><body >');
												mywindow.document.write(content);
												mywindow.document.write('</body></html>');

												mywindow.document.close();
												// mywindow.focus()
												// mywindow.print();
												mywindow.close();
											},
											error: function () {
												alert("error1");
											}



										}); //product insert ajax   



									} //for loop




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
			</script>
			<div id="barcodemrp" style="display: none;"></div>
			<svg id='barcode' style="display: none;"></svg>




			<!-- Jas  Save master and details End-->
