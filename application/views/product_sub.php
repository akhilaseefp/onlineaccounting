<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>
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


$('#category').on('change','#group', function () {

  var grp = $('#group').val();
  
  try {
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?php echo base_url(); ?>index.php/Onlinecontrol/Autofill_Hsn",
      data: {
        'b': grp
      },
      success: function (result) {

         var hsn = result[0]['hsncode'];
          $('#hsn').val(hsn);
          // alert(hsn);
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
</script><script>
$(document).ready(function () {
$('#sizebtn').click(function () {
var size = $('#sizename').val();
try {
  $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?php echo base_url(); ?>index.php/Onlinecontrol/insertsize",
      data: {
        'b': size
      },
    success: function (data) {
      var result = JSON.stringify(data);
        alert("Added Successfully .....!");

       
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
</script><script>
$(document).ready(function () {
$("#barcd").change(function(){ alert();
 
              try{
                var barcode = $("#languages option[value='" + $('#barcd').val() + "']").attr('label');
   var mrp = $("#languages option[value='" + $('#barcd').val() + "']").data('mrp');
                      $('#price').val(mrp);
                    

              }
              catch (err) {
                alert(err.message);
              }
     });

});
</script><script>
$(document).ready(function () {
$('#barbtn').click(function () {
  
  
  var barcode = $("#languages option[value='" + $('#barcd').val() + "']").attr('label');
  var pdtname = $('#barcd').val();
  var size = $("select.getsize").children("option:selected").val();
  var price = $('#price').val();
  
  // for (var i = 0; i < qty; i++)
	// {
    var divToPrint1 = document.getElementById("barcode");
    JsBarcode("#barcode", barcode, {
      lineColor: "#000",
      width: 9,
      height: 300
      });
      newWin = window.open("");
      newWin.document.write("<!DOCTYPE html><html><head></head><style>*{margin:0;padding:0;}.fon{font-family:'Verdana';font-weight: bold;} .si{text-transform:uppercase;}</style><body><div style='margin:auto;'><center class='fon' style='font-size:70px;overflow:hidden;'>" + pdtname + " </center><br><center>" + divToPrint1.outerHTML + " </center><br><span class='fon si' style='font-size:50px;margin-left:50px;'>" + barcode + " </span><br><div><span class='si fon' style='font-size:90px;margin-left:50px;'>" + size + " </span><span class='fon' style='font-size:90px;float:right;margin-right:50px;'><span class='fon' style='font-size:90px;float:left;margin-right:20px;'>&#8377;</span>" + price +".00</span></div></div></body></html>");
      newWin.focus();
      newWin.print();
      // newWin.close();
    // }
     document.getElementById("barcode").style.visibility = "hidden";
     document.getElementById("barcode").style.display = "none"; 
    $('#price').val('');
    $('#barcd').val('');
    $('#size').val('');
    $("#languages option[value='" + $('#barcd').val() + "']").attr('label').text('');

});
  
});
</script>


<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Sub Add Product
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Forms</a></li> -->
      <li class="active">Sub Add Product</li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <!-- <form  id="form_img" enctype="multipart/form-data"> -->
              <div class="row">
                <div class="col-md-6">
                  <label>Product name :</label>
                  <input type="text" id="product" name="product" class="form-control" required autocomplete="off">
                  <input style="" type="hidden" id="productid" name="productid" class="form-control" autocomplete="off">
                  
                </div>
                
                <div class="col-md-6">
                  <label>Brand :</label>
                  <select class="form-control" id="brand" name="brand" required>
                    <option value=""></option>
                    <?php foreach ($brand->result() as $gp) {
                      ?>
                      <option value="<?php echo $gp->brandid; ?>"><?php echo $gp->brandname; ?></option>
                    <?php  } ?>
                  </select>
                </div>
                
              </div>

              <div class="row">

                <div class="col-md-3" style ="">
                  <label>Product code :</label>
                  <input type="text" id="code" name="code" class="form-control" required autocomplete="off">
                  <?php
                  foreach ($code->result() as $key) { ?>
                    <input type="hidden" style="" value="<?php echo $key->NO; ?>" name="" id="unk">
                  <?php  } ?>
                </div>

                <div class="col-md-3" id="category">
                  <label>Category :</label>
                  <input type="text" class="form-control" list="name" autocomplete="off"
                    name="group" id="group">
                    <datalist id="name">
                  <?php foreach($group->result() as $gp){ ?>
                  <option value="<?php echo $gp->groupid;?>" data-hsn="<?php echo $gp->hsncode;?>" label="<?php echo $gp->groupname;?>">
                    <?php  } ?>
                </datalist>
                </div>

                <div class="col-md-3" style ="display: none;">
                  <label>HSN Code :</label>
                  <input type="text" name="hsn" id="hsn" class="form-control" autocomplete="on">
                </div>
               
                <div class="col-md-3">
                  <label>Purchase rate :</label>
                  <input type="text" name="pur_rate" id="pur_rate" class="form-control" autocomplete="on">
                </div>
                <div class="col-md-3">
                  <label>Sales Rate :</label>
                  <input type="text" name="mrp" id="mrp" class="form-control" autocomplete="on">
                </div>
                <div class="col-md-3" id ="divcurrentstock">
                  <label>Current Stock:</label>
                 <input type="text"  class="form-control" id="currentstock" name="currentstock">
                 </div>
              </div>

               <div class="row">
                 <div style ="display: none;" class="col-md-3">
                  <label>Squarefeet:</label>
                  <input type="text" value="1" class="form-control" id="square" name="square" >
                 </div>
                 <div class="col-md-3" style ="display: none;">
            <label>Unit :</label>
             <input style="" type="" id="unitname" name="unitname" list="unit" class="form-control" autocomplete="off">
              <input style="display: none;" type="" id="unitid" name="unitid" value="1" class="form-control" autocomplete="off">
          </div>
             <datalist id="unit">
              <?php foreach($unit->result() as $gp){
                ?>
              <option label="<?php echo $gp->unitid;?>" value="<?php echo $gp->unitname;?>"></option>
              <?php  } ?>
                      </datalist>
                  
                 
               </div>

              <div class="row">
                

                <div class="col-md-3">
                  <label>INR :</label>
                  <input type="text" name="dis_price" id="dis_price" class="form-control" autocomplete="on">
                </div>
                <div class="col-md-3">
                  <label>AED :</label>
                  <input type="text" name="aed" id="aed" class="form-control" autocomplete="on">
                </div>
                <div class="col-md-3">
                  <label>USD :</label>
                  <input type="text" name="usd" id="usd" class="form-control" autocomplete="on">
                </div>
                <div class="col-md-3" style="align-content: center;">
                 
                 <input style="margin-top: 25px;display: none;" class="btn btn-success" type="button" name="viewstock" id="viewstock" value="View Stock">
                 </div>
                <div class="col-md-3" style ="display: none;">
                  <label>Opening stock:</label>
                  <input type="text" class="form-control" id="openingstock" name="openingstock" value="0">
                 
                </div>
                <div class="col-md-3" style ="display: none;">
                  <label>Reorder level :</label>
                  <input type="text" class="form-control" id="minimumstock" name="minimumstock" value="0" autocomplete="on">
                </div>
                <!-- <div class="col-md-3">
                  <label>Tax :</label>
                  <input type="text" class="form-control" id="tax" name="tax" value="0" autocomplete="on">
                </div> -->
              </div>
              
              
              <div class="row">
                
                <div class="col-md-6">
                  <label>Narration :</label>
                  <textarea class="form-control" id="narration" name="narration"></textarea>
                </div>
                <div class="col-md-6">
                  <label>Product Image:</label>
                  <input type="file" class="form-control" name="img" id="img">
                </div>
              </div>
                <div class="row">
                
                <div class="col-md-6" style="padding-top:20px;">
                <input type="checkbox"  checked value="Yes" name="pos" id="pos"> POS
                <input type="checkbox"  checked value="Yes"  name="ecommerce" id="ecommerce"> Ecommerce
                <input type="checkbox" checked value="Yes" name="reseller" id="reseller"> Reseller
              </div>
                
                 </div>
                 <div class="row">
                 <div class="col-md-6"  id="bl" style="display: none;">
                  <label></label>
                <img width="100px" height="100px" src="" id="im">    
                <div style="padding-top:10px;"><input style="border:none;"  type="text" class="form-control" name="imagepath" id="imagepath"></div>
                 </div>
                
              </div>
              
              <div class="row">
                <div class="col-md-6 margin" >
                  <input class="btn btn-success" type="submit" name="save" id="btnsave" value="Save">

                  <input class="btn btn-danger" type="submit" name="" id="delete" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_product">
                  <input class="btn btn-info" type="button" name="" id="clear" value="Clear">
                  <input class="btn btn-warning" type="button" name="" value="Close" action="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
                 <!--  <input class="btn btn-warning" type="button" name="print" value="Print" action="" id="print"> -->
                </div>
                <div class="col-md-4 margin">
                <div id="barcodemrp" style="display: none;"></div>
                    <div style="display: none;">
                      <svg id='barcode'></svg>
                    </div>
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Size</a>
                  <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">Barcode</a>
                </div>
              </div>
            </form>
             <div class="table" style="position: relative;height:400px ;overflow: auto;">

              <TABLE id="stock" style="display: none;" width="100%" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Product</th>
                    <th style="">Branch</th>
                    <th style="display: none;">Expiry Date</th>
                    <th style="">Size</th>
                    <th style="">Current Stock</th>
                  </tr>
                </thead>
                <tbody id="stockdetails">
                    <tr>
                      <td>1</td>
                      <td style=""></td>
                      <td style=""></td>
                      <td style=""></td>
                      <td style="display: none;"></td>
                      <td style=""></td>
                    </tr>
                </tbody>
              </TABLE>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group"> <label>Search Product :</label>
              <input type="text" id="searchproduct" name="searchproduct" class="form-control" autocomplete="off">
          </div>
            <div class="table" style="position: relative;height:400px ;overflow: auto;">
              <TABLE id="table" width="100%" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th style="display: none;">id</th>
                    <th>Sl No</th>
                    <th>Product</th>
                    <th style="">Code</th>
                    <th style="display: none;">HSN</th>
                    <th style="display: none;">Discount Price</th>
                    <th style="display: none;">Parent group</th>
                    <th style="display: none;">brand</th>
                    <th style="">Purchase rate</th>
                    <th>INR</th>
                    <th>AED</th>
                    <th>USD</th>
                    <th style="display: none;">Sqarefeet</th>
                    <th style="display: none;">Minimum STOCK</th>
                    <th style="display: none;">OPENING STOCK</th>
                    <th style="display: none;">Narration</th>
                    <th>Current stock</th>
                    <th style="display: none;">img</th>
                  </tr>
                </thead>
                <tbody id="myTable">
                  <?php
                  $n = 1;
                  foreach ($product->result() as $row) { ?>
                    <tr>
                      <td style="display: none;"><?php echo $row->pdt_id; ?></td>
                      <td><a><?php echo $n; ?></a></td>
                      <td><?php echo $row->pdt_name; ?></td>
                      <td style=""><?php echo $row->pdt_code; ?></td>
                      <td style="display: none;"><?php echo $row->hsncode; ?></td>
                      <td style="display: none;"><?php echo $row->discountprice; ?></td>
                      <td style="display: none;"><?php echo $row->groupid; ?></td>
                      <td style="display: none;"><?php echo $row->brandid; ?></td>
                      <td style=""><?php echo $row->purchaserate; ?></td>
                      <td><?php echo $row->mrp; ?></td>
                      <td><?php echo $row->aed; ?></td>
                      <td><?php echo $row->usd; ?></td>
                      <td style="display: none;"></td>
                      <td style="display: none;"><?php echo $row->minimumstock; ?></td>
                      <td style="display: none;"><?php echo $row->openingstock; ?></td>
                      <td><?php echo $row->stock; ?></td>
                      <td style="display: none;"><?php echo $row->imagpath; ?></td>
                       <td style="display: none;"><?php echo $row->unitid; ?></td>
                        <td style="display: none;"><?php echo $row->unitname; ?></td>
                    </tr>
                  <?php $n++;
                  } ?>

                </tbody>


              </TABLE>
            </div>
            <button onclick="exportTableToExcel('table', 'productlist')">Export  To Excel File</button>
          </div>
        </div>

          
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
        <!-- <form id="userform" method="post"> -->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
						<div class="modal-body modal-body-sub_agile">
						<div class="col-md-8 modal_body_left modal_body_left1">
            <h2 style="margin:50px;">Add New<span>Size</span></h2>
							<div style="margin-left:100px;"  class="styled-input agile-styled-input-top">
								<label style="font-size:17px;">Size</label>
                <input type="text" name="sizename" id="sizename" class="validate form-control" required>
								<span></span>
							</div>
              <div class="modal-footer" style="">
							<!-- <input type="submit" name="action" class="btn btn-success" value="Add"> -->
							<input type="button" id="sizebtn" name="action" class="btn btn-success" value="Add">
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



<!-- Modal2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
        <!-- <form id="userform" method="post"> -->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
						<div class="modal-body modal-body-sub_agile">
						<div class="col-md-8 modal_body_left modal_body_left1">
            <h2 style="margin:50px;">Product<span> Barcode</span></h2>
							<div style="margin-left:100px;" class="styled-input agile-styled-input-top">
              <div class="row" style="margin-bottom:20px;">
                
                <input type="text" class="form-control" list="languages" autocomplete="off" id="barcd"
							name="barcd">
						      <datalist id="languages">
							        <?php foreach($product->result() as $gp){
                   		?>
							        <option label="<?php echo $gp->pdt_code;?>" value="<?php echo $gp->pdt_name;?>" data-mrp="<?php echo $gp->mrp;?>">
							        <?php  } ?>
						      </datalist>
                
              </div>
              <div class="row" style="margin-bottom:20px;">
              <select class="getsize" id="size" name="size" class="form-control">
                      <option value="">Select Size</option>
                      <?php foreach($size->result() as $row)
                      {?>
                      <option value="<?php echo $row->sizevalue;?>"><?php echo $row->sizevalue;?></option>   
                      <?php }   ?>
                </select>
                </div>
              <div class="row" style="margin-bottom:20px;">
                <input class="form-control" id="price" name="price" placeholder="MRP" type="text" >
              </div>
              
              <!-- <div class="row" style="margin-bottom:20px;">
                <input class="form-control" id="quantity" name="quantity" placeholder="Quantity" type="text" >
              </div> -->
              <div class="row" style="margin-bottom:20px;">
							<input type="button" id="barbtn" name="action" class="btn btn-success" value="Generate">

              </div>
                </div>

							</div>
              <div class="modal-footer" style="">
							<!-- <input type="submit" name="action" class="btn btn-success" value="Add"> -->
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


<script type="text/javascript">

  $(document).ready(function ()
  {
    $('#btnsave').on('click', function ()
    {

      var product = document.getElementById("product").value;
      var brand = document.getElementById("brand").value;
      var code = document.getElementById("code").value;
      var group = document.getElementById("group").value;
      var hsn = document.getElementById("hsn").value;
      var pur_rate = document.getElementById("pur_rate").value;
      var mrp = document.getElementById("mrp").value;
      var currentstock = document.getElementById("currentstock").value;
      var square = document.getElementById("square").value;
      var unitid = document.getElementById("unitid").value;
      var dis_price = document.getElementById("dis_price").value;
      var aed = document.getElementById("aed").value;
      var usd = document.getElementById("usd").value;
      var openingstock = document.getElementById("openingstock").value;
      var minimumstock = document.getElementById("minimumstock").value;
      var narration = document.getElementById("narration").value;
      var pos = document.getElementById("pos").value;
      var ecommerce = document.getElementById("ecommerce").value;
      var reseller = document.getElementById("reseller").value;
      var save = document.getElementById("btnsave").value;
      var img = document.getElementById("img").value;

        $.noConflict();

          $.ajax({
            type: "POST",
            // dataType:"json",
            url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_product",
            data: 
            {
              'product': product,
              'brand':brand,
              'code': code,
              'group':group,
              'hsn': hsn,
              'pur_rate':pur_rate,
              'mrp': mrp,
              'currentstock':currentstock,
              'square': square,
              'unitid':unitid,
              'dis_price': dis_price,
              'aed':aed,
              'usd': usd,
              'openingstock':openingstock,
              'minimumstock': minimumstock,
              'narration':narration,
              'pos': pos,
              'ecommerce':ecommerce,
              'reseller':reseller,
              'img':img,
              'save':save
            },
            success: function (data)
            {

              alert("success");
              location.reload();
            }
          });

      });
  });

</script>


<script type="text/javascript">


var table = document.getElementById('table');

  for (var i = 1; i < table.rows.length; i++)
  {
    table.rows[i].onclick = function() 
    {
      
      document.getElementById("productid").value = this.cells[0].innerHTML;
      document.getElementById("product").value = this.cells[2].innerHTML;
      document.getElementById("code").value = this.cells[3].innerHTML;
      var str=this.cells[3].innerHTML;
      var res = str.slice(2);
      document.getElementById("unk").value = res;
      document.getElementById("hsn").value = this.cells[4].innerHTML;
      document.getElementById("dis_price").value = this.cells[5].innerHTML;
      document.getElementById("group").value = this.cells[6].innerHTML;
      document.getElementById("brand").value = this.cells[7].innerHTML;
      document.getElementById("unitid").value ="1";
      // document.getElementById("tax").value = this.cells[9].innerHTML;
      document.getElementById("pur_rate").value = this.cells[8].innerHTML;
      document.getElementById("mrp").value = this.cells[9].innerHTML;
      document.getElementById("aed").value = this.cells[10].innerHTML;
      document.getElementById("usd").value = this.cells[11].innerHTML;
      document.getElementById("square").value = this.cells[12].innerHTML;
      document.getElementById("minimumstock").value = this.cells[13].innerHTML;
      document.getElementById("openingstock").value = this.cells[14].innerHTML;
      // document.getElementById("narration").value = this.cells[12].innerHTML;
      document.getElementById("currentstock").value = this.cells[15].innerHTML;
      document.getElementById("unitname").value = this.cells[18].innerHTML;  
      document.getElementById("bl").style.display = "block";
      // document.getElementById("divcurrentstock").style.display = "block";
      document.getElementById("viewstock").style.display = "inline";
      var img = this.cells[16].innerHTML;
      document.getElementById("im").src = "<?php echo base_url();?>images/" + img;
      document.getElementById("imagepath").value = img;
      document.getElementById("save").value = "Update";
      document.getElementById("stock").style.display = "none";
      viewstock.value="View Stock";
    }
  }


  var clear = document.getElementById('clear');
  clear.onclick = function() {
    document.getElementById("productid").value = "";
    document.getElementById("product").value = "";
    document.getElementById("code").value = "";
    document.getElementById("hsn").value = "";
    document.getElementById("group").value = "";
    document.getElementById("brand").value = "";
    document.getElementById("unk").value = "<?php foreach ($code->result() as $key) {
    echo $key->NO;                                                   }?>";
    document.getElementById("unit").value = "";
    // document.getElementById("tax").value = "";
    document.getElementById("pur_rate").value = "";
    document.getElementById("dis_price").value = "";
    document.getElementById("mrp").value = "";
    document.getElementById("aed").value = "";
    document.getElementById("usd").value = "";
    document.getElementById("minimumstock").value = "";
    document.getElementById("openingstock").value = "";
    document.getElementById("unitname").value = "";
    document.getElementById("im").src = null;
    document.getElementById("img").value = "";
    document.getElementById("pos").checked = false;
    document.getElementById("ecommerce").checked = false;
    document.getElementById("reseller").checked = false;
    document.getElementById("imagepath").value = "";
    document.getElementById("narration").value = "";
    document.getElementById("currentstock").value = "";
    document.getElementById("square").value = "";
    document.getElementById("save").value = "Save";
    document.getElementById("divcurrentstock").style.display = "none";
    document.getElementById("viewstock").style.display = "none";
  }




var unit = document.getElementById('unitname');
unit.onchange = function()
{
  document.getElementById("unitid").value = $("#unit option[value='" + $('#unitname').val() + "']").attr('label');
  
}
var mrp = document.getElementById('mrp');
mrp.onchange = function()
{
  document.getElementById("dis_price").value = mrp.value;
  
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


</script><script type="text/javascript">
          $('#viewstock').on('click', function (e)
          {
            var code =document.getElementById("code").value;
            if(document.getElementById("stock").style.display == "none")
            {
              document.getElementById("stock").style.display = "block";
              viewstock.value="Hide Stock";
            }
            else
            {
              document.getElementById("stock").style.display = "none";
              viewstock.value="View Stock";
            }
            try
            {
              $.ajax({
                type: "POST",
                // dataType:"json",
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/Loadstockbycode",
                data: 
                {
                  'code' : code
                },
                success: function (data) 
                {
                  var master=JSON.parse(data);
                  var i=0;
                  $('#stockdetails  tr').remove();
                  for(i=0;i<master['detailes'].length;i++)
                  {
                    var productname = master['detailes'][i]['pdt_name'];
                    var branch =master['detailes'][i]['branchname'];
                    var batch =master['detailes'][i]['batchname'];
                    var size = master['detailes'][i]['sizevalue'];
                    var currentstock =master['detailes'][i]['currentstock'];
                    var rowCount = document.getElementById('stockdetails').rows.length + 1;
                    var newTr = '<tr><td>' + rowCount +'</td><td>'+productname+'</td><td style="">'+branch+'</td><td style="display:none;">'+batch+'</td><td >'+size+'</td><td>'+currentstock+'</td> </tr>';
                    $('#stockdetails').append(newTr);
                  }
                },
                error: function (data) 
                {
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
            });
</script>
<!-- <script type="text/javascript">
          $(document).ready(function($)
          {
            $('#product').on('blur', function()
            {
              //   if(document.getElementById("save").value == "Save"){
              //   var app = $('#product').val();
              //   var first = app.charAt(0);
              //   var last = app[app.length - 1];
              //   var newc = first.concat(last);
              //   var unk = $('#unk').val();
              //   var l = unk.length;
              //   var n = "" + unk;
              //   var x = ("000000" + n).substring(n.length);
              //   var code = newc.concat(x);
              //   $('#c
            });
          });
</script> -->

<script type="text/javascript">
        $(document).ready(function($)
        {
          $('#print').on('click', function()
          {
            var excel_data=$('#table').html();
            var page = "excel.php?date="+excel_data;
            window.location=page;alert();
          });
        });
</script>

</script><script type="text/javascript">
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>

<script type="text/javascript">

  $(document).ready(function($) {
    $('#brand').on('change', function() {
      var app = $('#brand option:selected').text();
      var unk = $('#unk').val();
      var res = app.split(" ");
      var code1 = res[0]+unk;
      // var first = app.charAt(0);
      // var last = app[app.length - 1];
      // var newc = first.concat(last);
      // var l = unk.length;
      // var n = "" + unk;
      // var x = ("000000" + n).substring(n.length);
    //   var code1 = app + unk;

      $('#code').val(code1);
    });
  });
</script>




