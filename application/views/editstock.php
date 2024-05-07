<script src="<?php echo base_url();?>js/jquery1.js"></script>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
    Stock Transfer
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Forms</a></li> -->
      <li class="active">Stock Transfer</li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-default">
      <div class="box-body">
      
  <form>
    <?php 
foreach ($master->result() as $key ) {
  # code...

    ?>
    <div class="container-fluid">
      <div class="hed"><h1>Stock Transfer</h1></div>
      <hr>
      <div class="row">
        <div class="col-md-5">
          <p class="p1">Voucher no :</p>
          <input type="text" value="<?php echo $key->voucherno;?>" class="form-control" id="voucherno" required autocomplete="off">
        </div>
        <div class="col-md-5">
          <p class="p1">Date :</p>   
          <input type="date" class="form-control" value="<?php echo $key->date;?>" id="date" name="date">
        </div>
      </div>
      <div class="row">
        <div class="col-md-5">
      
          <p class="p1">From Branch :</p>   
          <select class="form-control"  name="" id="fbranch">

                <option value="<?php echo $key->fbranch;?>" selected="" ><?php echo $key->fbranch;?></option>
                 <?php  } ?>
                <?php foreach($branch->result() as $gp){
                  
                ?>
                <option value="<?php echo $gp->branchname;?>" ><?php echo $gp->branchname;?></option>
                 <?php  } ?>
              </select>
        </div>
        <div class="col-md-5">
          <p class="p1">To Branch:</p>   
       <select class="form-control"  name="" id="tbranch">
            <?php 
foreach ($master->result() as $key ) {?>

                <option value="<?php echo $key->tbranch;?>" selected="" ><?php echo $key->tbranch;}?></option>
    
                <?php foreach($branch->result() as $gp){
                  
                ?>
                <option value="<?php echo $gp->branchname;?>" ><?php echo $gp->branchname;?></option>
                 <?php  } ?>
              </select>
        </div>
      </div>
      <hr>
       <div class="row">
        <div class="col-md-3">
          <p class="p1">barcode</p>
          <input type="text" class="form-control" required id="code" autocomplete="off">
        </div>
        <div class="col-md-3">
          <p class="p1">Product name</p>   
          <input type="text" class="form-control" id="product" name="product">
        </div>
        <div class="col-md-3">
          <p class="p1">Purchase Rate</p>   
          <input type="text" class="form-control" id="mrp" name="">
        </div>
         <div class="col-md-3">
          <p class="p1">quantity</p>   
          <input type="number" class="form-control" id="qty" name="qty">
        </div>
      </div>
    
      
        <div class="row" style="margin-top: 2%;">
      <input class="offset-md-2 col-md-3" type="button" value="Add Row" id="bton" name="" onclick="addRow('dataTable')">
      <input class="col-md-3" type="button" value="Delete Row" id="bton" name="" onclick="deleteRow('dataTable')">
    </div>
      <hr>
        <div class="row" style="overflow-x: scroll;">
          <TABLE id="dataTable1" width="100%" border="1" class="table table-hover">
            <thead>
              <tr>
                <th></th>
                <th>SLNO</th>
                <th>Barcode</th>
                <th>Product Name</th>
                <th>Purchase Rate</th>
                <th>Qty</th>
                
              </tr>
            </thead>
            <tbody id="dataTable">

              <?php 
              $n=1;
              foreach ($details->result() as $key ) {

                ?>
                <tr>         
                 <td><input type="checkbox"></td>
              <td><?php echo $n;?></td>
              <td><?php echo $key->productid;?></td>
              <td><?php echo $key->product;?></td>
              <td><?php echo $key->mrp;?></td>
              <td><?php echo $key->qty;?></td>

</tr>
     
     <?php 
$n++;
   }
     ?>       </tbody>
             
          
          
          </TABLE>
        </div>
        <hr>
     <?php 
foreach ($master->result() as $key ) {
  ?>
        <div class="row col-md-12 txn-bottom-form">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-placeholder"  for="contact-person">Narration</label>
              <textarea class="form-control"  id="narration" style="line-height:2.5"><?php echo $key->narration;?></textarea>
            </div>
            
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label class="form-control-placeholder"  for="contact-person">Total cost</label>
              <input type="text" class="form-control" value="<?php echo $key->totalcost;}?>" id="totalcost" required autocomplete="off">
            </div>

          </div>
        </div>
        <hr>
        <div class="row col-md-12 form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);">
          <div class="offset-md-4">
          <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
            <input class="btn btnormal1"type="button" id="save" name="" value="Save">
            <input class="btn btnormal2" type="submit" name="" value="Delete">
            <input class="btn btnormal2" type="submit" name="" value="Clear">
            <input class="btn btnormal1" type="submit" name="" value="Close">
          </div>
        </div>
  </form>    
</div>


 <TABLE id="dataTable2" width="100%" border="1" style="display: none;" class="table table-hover">
            <thead>
              <tr>
                <th></th>
                <th>SLNO</th>
                <th>Barcode</th>
                <th>Product Name</th>
                <th>Purchase Rate</th>
                <th>Qty</th>
                
              </tr>
            </thead>
            <tbody id="dataTable">

              <?php 
              $n=1;
              foreach ($details->result() as $key ) {

                ?>
                <tr>         
                 <td><input type="checkbox"></td>
              <td><?php echo $n;?></td>
              <td><?php echo $key->productid;?></td>
              <td><?php echo $key->product;?></td>
              <td><?php echo $key->mrp;?></td>
              <td><?php echo $key->qty;?></td>

</tr>
     
     <?php 
$n++;
   }
     ?>       </tbody>
             
          
          
          </TABLE>
  <SCRIPT language="javascript">
   
     var d=0.00;
          function addRow(tableID)
              {

                 var table = document.getElementById(tableID);
                 var rowCount = table.rows.length;
                 var row = table.insertRow(rowCount);        
                 var cell0 = row.insertCell(0);
                 var x = document.createElement("INPUT");
                 x.setAttribute("type", "checkbox");
                 cell0.appendChild(x);
                 var cell1 = row.insertCell(1);
                 var cell2 = row.insertCell(2);
                 var cell3 = row.insertCell(3);
                 var cell4 = row.insertCell(4);
                 var cell5 = row.insertCell(5);
                 
                 var product = document.getElementById('productname');
                  cell0.checked=false;
                  cell1.innerHTML=rowCount;
                  cell2.innerHTML=document.getElementById('code').value;
                  cell3.innerHTML=document.getElementById('product').value;
                  cell4.innerHTML=document.getElementById('mrp').value;
                  cell5.innerHTML=(document.getElementById('qty').value);
                

                  d=d+(document.getElementById('qty').value*document.getElementById('mrp').value);
                  // alert(d);
                  document.getElementById("totalcost").value =d;
               
                   document.getElementById('product').value="";
                   document.getElementById('code').value=""; 
                   document.getElementById('mrp').value="";
                   document.getElementById('qty').value="";
                  
                   
            }
        
    
   function deleteRow(tableID) 
       {
        // alert("sf");
               try 
               {
               var table = document.getElementById(tableID);
               var rowCount = table.rows.length;
               // var d=0.00;
                  for(var i=0; i<rowCount; i++)
                   {
                      var row = table.rows[i];         
                      row.cells[1].innerHTML=i;
                      var chkbox = row.cells[0].childNodes[0];
                          if(null != chkbox && true == chkbox.checked)
                           {
                              if(rowCount <= 0) 
                              {
                                  alert("Cannot delete all the rows.");
                                  break;
                              }
                             row.cells[1].innerHTML=i+1;
                           
                             d=d-((row.cells[4].innerHTML)*1);
                              
                                 document.getElementById("totalcost").value =d;
                               
                            
                             table.deleteRow(i);
                             rowCount--;
                              i--;
           
                          }


                    }
              } 
              catch(e)
                  {
                  alert(e);
                  }
      }



    </SCRIPT>


    <script type="text/javascript">
         $.noConflict();

    $(document).ready(function($){
        
        $('#code').on('change',function(){

            var code = $('#code').val();
            // alert(code);
          
      try{
            $.ajax({

                type : "POST",
                 dataType: 'json',
                url  : "<?php echo base_url(); ?>index.php/Onlinecontrol/Autofill_New",
                data : {'b':code},
                success: function(result){
       // alert("success autofill");
       var result1= JSON.stringify(result);
       // alert(result1);
             
                
                $('#product').val(result[0]['pdt_name']);
               // $('#productcode').val(result[0]['pdt_code']);
               // $('#Qty').val('');
               // $('#unitprice').val(result[0]['purchaserate']);
               // $('#unit').val(result[0]['unitid']);
               // $('#group').val(result[0]['groupid']);
               // $('#brand').val(result[0]['brandid']);
               // $('#tax').val(result[0]['tax']);
               $('#mrp').val(result[0]['purchaserate']);
                },
                 error: function(){
                            alert('Error occur...!!');
                        }
            });
          }
          catch(err){
            alert(err.message);
          }
        });
    });
 
</script>
<script type="text/javascript">
   $(document).ready(function(){


 $('#save').on('click',function(){
alert("hi");
var voucherno=document.getElementById("voucherno").value;

// var =document.getElementById("date").value;
var fbranch=document.getElementById("fbranch").value;
var tbranch=document.getElementById("tbranch").value;
var date=document.getElementById("date").value;
var totalcost=document.getElementById("totalcost").value;
var narration=document.getElementById("narration").value;

 $.noConflict();
 try{
         
            $.ajax({ 

                type : "POST",
                // dataType:"json",
                url  : "<?php echo base_url() ?>index.php/Onlinecontrol/editstockmaster",
                data : {'voucherno':voucherno,
                'date':date,
                'fbranch':fbranch,
                'tbranch':tbranch,
                'totalcost':totalcost,
                'narration':narration
                },
                success: function(data){
                  var myJSON = JSON.stringify(data);
                  alert("master");


                     var table = document.getElementById('dataTable');
                     for(var i = 0; i < table.rows.length; i++)
                        {
                         var code= document.getElementById("dataTable").rows[i].cells[2].innerHTML;
                         var product= document.getElementById("dataTable").rows[i].cells[3].innerHTML;
                         var mrp= document.getElementById("dataTable").rows[i].cells[4].innerHTML;
                         var qty = document.getElementById("dataTable").rows[i].cells[5].innerHTML;
                         // alert(product);
                                            $.ajax({
                                                      type : "POST",                                       
                                                      url  : "<?php echo base_url() ?>index.php/Onlinecontrol/editstock",
                                                      data : {
                                                               'productid':code,
                                                               'product':product,
                                                               'mrp':mrp,
                                                               'tbranch':fbranch,
                                                               'fbranch':tbranch,
                                                               'qty':qty
                                                             },
                                            success: function(data)
                                                   {
                                                                                // alert
                                                     var myJSON = JSON.stringify(data);
                                                     alert("update success");
                                                   },
                                            error: function(data)
                                                  {
                                                     alert("delete error");
                                                     var myJSON = JSON.stringify(data);
                                                     // alert(myJSON);
                                                  }
                                                 });
                                                  
                                                  $.ajax({                                             
                                                  type: "POST",
                                                  dataType:"json",
                                                  url:"<?php echo base_url() ?>index.php/Onlinecontrol/Autogenerate_StockVoucherNo",
                                                  data:{
                                                    
                                                     },

                                                    success: function(data)
                                                    { 

                                                      $("#voucherno").val(data[0].NO);
                                                    } ,
                                                    error: function(){
                                                        alert('Error occur...!!');
                                                    }

                                                });



                
                                                       }


                  var table = document.getElementById('dataTable');
                     for(var i = 0; i < table.rows.length; i++)
                        {
                         var code= document.getElementById("dataTable").rows[i].cells[2].innerHTML;
                         var product= document.getElementById("dataTable").rows[i].cells[3].innerHTML;
                         var mrp= document.getElementById("dataTable").rows[i].cells[4].innerHTML;
                         var qty = document.getElementById("dataTable").rows[i].cells[5].innerHTML;
                         // alert(product);
                                            $.ajax({
                                                      type : "POST",                                       
                                                      url  : "<?php echo base_url() ?>index.php/Onlinecontrol/editstockdetails",
                                                      data : { 'voucherno':voucherno,
                                                               'productid':code,
                                                               'product':product,
                                                               'mrp':mrp,
                                                               'tbranch':tbranch,
                                                               'fbranch':fbranch,
                                                               'qty':qty
                                                             },
                                            success: function(data)
                                                   {
                                                                                // alert
                                                     var myJSON = JSON.stringify(data);
                                                     alert("deatils success");
                                                   },
                                            error: function(data)
                                                  {
                                                     alert("detaileserror");
                                                     var myJSON = JSON.stringify(data);
                                                     // alert(myJSON);
                                                  }
                                                 });
                                                  
                                                  $.ajax({                                             
                                                  type: "POST",
                                                  dataType:"json",
                                                  url:"<?php echo base_url() ?>index.php/Onlinecontrol/Autogenerate_StockVoucherNo",
                                                  data:{
                                                    
                                                     },

                                                    success: function(data)
                                                    { 

                                                      $("#voucherno").val(data[0].NO);
                                                    } ,
                                                    error: function(){
                                                        alert('Error occur...!!');
                                                    }

                                                });



                
                                                       }
                                                          


                                                          }, //stockmastersuccess
                                                          error: function(data){
                            var myJSON = JSON.stringify(data);
                                                            alert(myJSON);
                        }
                          }); //ajax
                      }
                      catch(err){
            alert(err.message);
          }
  });
 });
</script>