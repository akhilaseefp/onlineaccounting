<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script> -->
 <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>

<!--  -->
<script src="<?php echo base_url(); ?>js/jquery1.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#searchproduct").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>


<script type="text/javascript">
	$(document).ready(function () {


		$("#productcode").change(function(){

    // var productcode = $("#name option[value='" + $('#productcode').val() + "']").attr('label');
    var productcode = $('#productcode').val();
			try{
			  $.ajax({
				  type: "POST",
				  dataType:'json',
				  url: "<?php echo base_url();?>index.php/Onlinecontrol/getmrp",
				  data: {
					'b':productcode
				  },
				  
				  success: function (result) {
					var purchaserate = result[0]['purchaserate'];
					var productname = result[0]['pdt_name'];
					$('#purchaserate').val(purchaserate);
					$('#productname').val(productname);
					$('#totaldamagedamount').val(purchaserate);
				  },
				  error: function () {
					alert("Error Occur....!");
				  }

			  });
			}
			catch (err) {
			  alert(err.message);
			}
   		});

		   $("#qty").change(function(){
				var qty = document.getElementById("qty").value;
				var purchaserate = document.getElementById("purchaserate").value;
				if(qty==1)
				{
					$('#totaldamagedamount').val(purchaserate);
				}
				else
				{
					var totaldamagedamount = qty * purchaserate;
					$('#totaldamagedamount').val(totaldamagedamount);
				}
		   });

	});
</script>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Damage Stock
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Damage Stock</li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-default">

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
             <?php echo form_open_multipart('Stockcontrol/insertdamage') ?>
              <div class="row">
                <div class="col-md-12">
                  <label>Product Code :</label>
                  <input type="text" class="form-control" required list="name" autocomplete="off" name="productcode" id="productcode"></td>
							<datalist id="name">
							<?php foreach($product->result() as $gp){
                   			?>
							<option value="<?php echo $gp->pdt_code;?>" label="<?php echo $gp->pdt_name;?>">
								<?php  } ?>
						</datalist>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label>Reference No</label>
					        <input type="text" required class="form-control" autocomplete="off" name="referenceno" id="referenceno">
                </div>
              </div>

              <div style="display:none;" class="row">
                <div class="col-md-12">
                  <label>Product Name</label>
					        <input type="text" required class="form-control" autocomplete="off" name="productname" id="productname">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                <label class="form-control-placeholder">Date</label>
							  <input type="datetime" name="retdate" class="form-control" id="retdate" value="<?php date_default_timezone_set('Asia/Kolkata');
   echo date("Y-m-d H:i:s"); ?>">
                </div>
              </div>


              <div class="row">
              <div class="col-md-12">
			  		  <label>Branch :</label>
						  <select  class="form-control"  required name="branch" id="branch">
                <?php
                foreach ($branch->result() as $branch) { ?>
                <?php if($branch->branchid==$branchid){?>
                <option value="<?php echo $branch->branchid;?>" selected><?php echo $branch->branchname; ?></option>
                <?php }
                else{?>
                <option value="<?php echo $branch->branchid;?>"><?php echo $branch->branchname; ?></option>
                <?php }
                }?>
              </select>
                </div>
                

              </div>
              <div class="row">
                <div class="col-md-12">
					<label>Batch :</label>
                
					<td><input type="text" id="batch" required list="bat" class="form-control" name="batch"></td>
					<datalist id="bat">
					<?php foreach($batch->result() as $gp){
					?>
					<option value="<?php echo $gp->batchid;?>" label="<?php echo $gp->batchname;?>">
					<?php  } ?>
					</datalist>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label>Size :</label>
				  	<input type="text" required class="form-control" list="size" autocomplete="off" name="getsize" id="getsize">
					<datalist id ="size">
					<option value="" label="">
					<?php
					foreach ($size->result() as $row)
					{
                	?>
					<option value="<?php echo $row->sizeid; ?>" label="<?php echo $row->sizevalue; ?>">
					<?php } ?>
					</datalist>
              	</div>
				  </div>

                <div class="row">
                
                <div class="col-md-4">
					<label>Qty</label>
					<input type="text" value="1" required class="form-control" autocomplete="off" name="qty" id="qty">
              	</div>

				<div class="col-md-4">
					<label>Purchase Rate</label>
					<input type="text" required class="form-control" autocomplete="off" name="purchaserate" id="purchaserate">
              	</div>

				  <div class="col-md-4">
					<label>Total Damaged Amount</label>
					<input type="text" required class="form-control" autocomplete="off" name="totaldamagedamount" id="totaldamagedamount">
              	</div>
                
                 </div>
              
              <div class="row">
                <div class="col-md-6 margin" >
                  <input class="btn btn-success" type="submit" name="save" id="save" value="Save">
                  <input class="btn btn-danger" type="submit" name="" id="delete" value="Delete" formaction="<?php echo base_url(); ?>index.php/Stockcontrol/delete_damagestock">
                  <input class="btn btn-info" type="submit" name="" id="clear" value="Clear">
                  <input class="btn btn-warning" type="submit" name="" value="Close" action="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
                </div>
              </div>
            </form>
          </div>

          <div class="col-md-6">
            <div class="form-group"> <label>Search Product :</label>
              <input type="text" id="searchdamage" name="searchdamage" class="form-control" autocomplete="off">
            </div>
            <div class="table" style="position: relative;height:400px ;overflow: auto;">
              <TABLE id="table" width="100%" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Code</th>
                    <th style="">Reference No</th>
                     <th style="">Product Name</th>
                     <th style="">Date</th>
                      <th style="display: none;">Branch</th>
                    <th style="display: none;">Batch</th>
                    <th style="display: none;">Size</th>
                    <th>Qty</th>
                    <th style="">Purchase rate</th>
                    <th>Total Damaged Amount</th>
                    <th>Deleted</th>
                  </tr>
                </thead>
                <tbody id="myTable">
                  <?php
                  $n = 1;
                  foreach ($damage->result() as $row) { ?>
                    <tr>
                      <td><a><?php echo $n;?></a></td>
                      <td style=""><?php echo $row->productcode; ?></td>
                      <td style=""><?php echo $row->referenceno; ?></td>
                      <td><?php echo $row->productname; ?></td>                     
                       <td style=""><?php echo $row->date; ?></td>
                       <td style="display: none;"><?php echo $row->branchid; ?></td>
                       <td style="display: none;"><?php echo $row->batchid; ?></td>
                      <td style="display: none;"><?php echo $row->size; ?></td>
                      <td><?php echo $row->qty; ?></td>
                      <td style=""><?php echo $row->purchaserate; ?></td>
                      <td><?php echo $row->damagestockamount; ?></td>
                      <td><?php echo $row->deleted; ?></td>
                    </tr>
                  <?php $n++;
                  } ?>

                </tbody>


              </TABLE>
            </div>
          </div>
        </div>

          
      </div>
    </div>
  </section>
</div>


<script type="text/javascript">


var table = document.getElementById('table');

  for (var i = 1; i < table.rows.length; i++)
  {
    table.rows[i].onclick = function() 
    {
      document.getElementById("productcode").value = this.cells[1].innerHTML;
      document.getElementById("referenceno").value = this.cells[2].innerHTML;
      document.getElementById("productname").value = this.cells[3].innerHTML;
      document.getElementById("retdate").value = this.cells[4].innerHTML;
      document.getElementById("branch").value = this.cells[5].innerHTML;
      document.getElementById("batch").value = this.cells[6].innerHTML;
      document.getElementById("getsize").value = this.cells[7].innerHTML;
      // document.getElementById("unit").value = this.cells[8].innerHTML;
      // document.getElementById("tax").value = this.cells[9].innerHTML;
      document.getElementById("qty").value = this.cells[8].innerHTML;
      document.getElementById("purchaserate").value = this.cells[9].innerHTML;
      document.getElementById("totaldamagedamount").value = this.cells[10].innerHTML;
      document.getElementById("btnsave").disabled =true;
      document.getElementById("btndelete").disabled =false;
    }
  }


  // var clear = document.getElementById('clear');
  // clear.onclick = function() {
  //   document.getElementById("productid").value = "";
  //   document.getElementById("product").value = "";
  //   document.getElementById("code").value = "";
  //   document.getElementById("hsn").value = "";
  //   document.getElementById("group").value = "";
  //   document.getElementById("brand").value = "";
  //   document.getElementById("unit").value = "";
  //   document.getElementById("tax").value = "";
  //   document.getElementById("pur_rate").value = "";
  //   document.getElementById("dis_price").value = "";
  //   document.getElementById("mrp").value = "";
  //   document.getElementById("minimumstock").value = "";
  //   document.getElementById("openingstock").value = "";
  //   document.getElementById("unitname").value = "";
  //   document.getElementById("im").src = null;
  //   document.getElementById("img").value = "";
  //   document.getElementById("pos").checked = false;
  //   document.getElementById("ecommerce").checked = false;
  //   document.getElementById("reseller").checked = false;
  //   document.getElementById("imagepath").value = "";
  //   document.getElementById("narration").value = "";
  //   document.getElementById("currentstock").value = "";
  //   document.getElementById("save").value = "Save";
  // }




var unit = document.getElementById('unit');
unit.onclick = function()
{
  document.getElementById("unitname").value = unit.options[unit.selectedIndex].text;
}
var openingstock = document.getElementById('openingstock');
openingstock.onchange = function()
{
  var a = document.getElementById("openingstock").value;
  if(a > 0)
  {
    document.getElementById("bat").style.display = "block";
  }
  else
  {
    document.getElementById("bat").style.display = "none";
  }
}

</script>









