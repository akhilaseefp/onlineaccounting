<script src="<?php echo base_url();?>js/jquery1.js"></script>         
<script type="text/javascript">
 $(document).ready(function(){
 $("#productcode").on("mouseleave", function() {
    var value = $(this).val().toLowerCase();
    $("#producttable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
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

      <div class="container-fluid">
        <div class="hed"><h1>Purchase Invoice</h1></div>
         <hr>
         <div class="row">
           <div class="col-md-4">
            <label>Voucher no :</label>
                <?php foreach($master->result() as $gp){  ?>
                    <input type="text" name="voucherno" class="form-control" required autocomplete="off" id="voucherno" value="<?php echo $gp->voucherno;?>">
                 <?php  } ?>
           </div>
           <div class="col-md-4">
              <label>Supplier :</label>
              <select class="form-control"  name="supplier" id="supplier">
                <?php foreach($supplier->result() as $gp){
                ?>
                <option value="<?php echo $gp->supplierid;?>"  data-supplierbalance ="<?php echo $gp->supplierbalance;?>"><?php echo $gp->suppliername;?></option>
                 <?php  } ?>
              </select>
           </div>
           <div class="col-md-4">
                 <label>Order no :</label>
                  <?php foreach($master->result() as $gp){    ?>
                      <input type="text" id="orderno" name="orderno" value="<?php echo $gp->orderno;?>" class="form-control"  autocomplete="off">
                    <?php }
                    ?>
           </div>
         </div>
         <div class="row">
             <div class="col-md-4">
                 <label>Vendor invoice no :</label>
                      <?php foreach($master->result() as $gp){  ?>
                      <input type="text" value="<?php echo $gp->vendorinvoiceno;?>" name="vendorinvoiceno" class="form-control" id="vendor"  autocomplete="off">
             </div>
             <div class="col-md-4">
                   <label>Invoice date :</label>   
                   <input type="date" name="invoicedate" class="form-control" id="invoicedate" value="<?php echo $gp->invoicedate;?>">    <?php }
                    ?>
             </div>
             <div class="col-md-4">
                  <label>Branch :</label>
                  <select class="form-control"  name="branch" id="branch">
                   <?php foreach($branch->result() as $gp){
                   ?>
                  <option value="<?php echo $gp->branchname;?>"><?php echo $gp->branchname;?></option>
                  <?php  } ?>
                  </select>
            </div>
      </div>
<hr>
      <div class="row">
           <div class="col-md-3">
               <label>Product Name :</label>   
               <input type="text" class="form-control" name="productname" id="productname">
           </div>
           <div class="col-md-3">
            <label>Product Code :</label>   
              <input type="text" class="form-control" id="productcode" name="productcode">
            
                 </div>
                  <div class="col-md-3">
            <label>Qty :</label>   
              <input type="text" class="form-control" id="Qty" name="Qty" value="1">
            
                 </div>
                      <div class="col-md-3">
              <label>Unit Price :</label>   
              <input type="text" class="form-control" name="unitprice" id="unitprice">
            
            </div>
           
         
</div>
<div class="row">
 <div class="col-md-3" style="display: none;">
              <label>Unit :</label>   
             <select class="form-control"   name="unit" id="unit">
                <?php foreach($unit->result() as $gp){
                  
                ?>
                <option value="<?php echo $gp->unitid;?>"><?php echo $gp->unitname;?></option>
                 <?php  } ?>
              </select>
            </div>
            
              <div class="col-md-3" style="display: none;">
                <label>Brand :</label>   
                                <select class="form-control"  name="brand" id="brand">
                <?php foreach($brand->result() as $gp){
 
                ?>
                <option value="<?php echo $gp->brandid;?>"><?php echo $gp->brandname;?></option>
                 <?php  } ?>
              </select>
            </div>
            <div class="col-md-3">
                <label>Batch Name :</label>   
                 <select class="form-control" name="batch" id="batch">
                 <?php foreach($batch->result() as $gp){
                 ?>
                 <option value="<?php echo $gp->batchid;?>"><?php echo $gp->batchname;?></option>
                 <?php  } ?>
                 </select>
               </div>
               <input type="text" id="pre" value="0" name="">
               <input type="text" id="mrp" value="0" name="">
               <input type="text" id="tax" value="0" name="">
</div>
  <div class="row margin" style="margin-top: 2%;text-align: center;">
               <input class="btn btn-success" type="button" value="Add Product" id="bton" onclick="addRow('dataTable')" name="">
               <input class="btn btn-danger" type="button" value="Delete Product" id="bton" onclick="deleteRow('dataTable')" name="">
        </div>

 <script src="<?php echo base_url(); ?>js/jquery.js"></script>
     <script type="text/javascript">
       $(document).ready(function(){
  
        
        $('#productcode').on('change',function(){

            var code = $('#productcode').val();
            alert(code);
          
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
             
                
                $('#productname').val(result[0]['pdt_name']);
               $('#productcode').val(result[0]['pdt_code']);
               // $('#Qty').val('');
               $('#unitprice').val(result[0]['purchaserate']);
               $('#unit').val(result[0]['unitid']);
               $('#group').val(result[0]['groupid']);
               $('#brand').val(result[0]['brandid']);
               $('#tax').val(result[0]['tax']);
               $('#mrp').val(result[0]['mrp']);
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
    $(document).ready(function(){


 
        //Save product
        $('#pro').on('click',function(){

            var productname  = $('#productname').val();
      
            var code = $('#productcode').val();
                  
            var qty = $('#Qty').val();
            var price =$('#unitprice').val();
            var unit = $('#unit').val();
            var group = $('#group').val();
            var brand = $('#brand').val();
            var tax= $('#tax').val();
            var mrp=$('#mrp').val();
                    
         $.noConflict();
      try{
            $.ajax({

                type : "POST",
                url  : "<?php echo base_url() ?>index.php/Onlinecontrol/insertprod",
                data : {'a':productname,'b':code,'c':group,'d':unit,'e':brand,'f':tax,'g':price,'h':qty,'i':mrp},
                success: function(data){
               alert("success");
               $('#productname').val('');
               $('#productcode').val('');
               // $('#Qty').val('');
               $('#unitprice').val('');

               // $('#unit').val()="";
               // $('#group').val()="";
               // $('#brand').val()="";
               $('#tax').val('');
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
<hr>
<div class="row" >
            <TABLE id="dataTable" width="100%" border="1" class="table table-hover" >
              <thead>
                  <tr>
                   <td> select</td>
                    <th >SL.NO</th>
                   <th>PRODUCT NAME</th> 
                   <th class="d-none d-xl-block" style=" " >PRODUCT CODE</th>
                   
                   <th>QTY</th>
                   <th class="d-none d-xl-block">UNIT PRICE</th>
                   <th>MRP </th> 
                   <th>NET AMOUNT</th>
                   <th class="d-none d-xl-block">TAX%</th>
                   <th >TAX AMOUNT</th>
                   <th class="d-none d-xl-block">AMOUNT</th>
                   <th class="d-none d-xl-block" style="">pre qty</th>

                  </tr>
              </thead>
              
             <tbody>
               <?php 
               $n=1;
               foreach ($detailes->result() as $key) {
                 ?>
                 <tr>
                 <td><input type="checkbox"></td>
                 <!-- <td style="display: none;"><?php echo $key->purchasedetailsid;?></td> -->
                 <td><?php echo $n;?></td>
                 <td><?php echo $key->productname; ?></td>
                 <td><?php echo $key->productcode; ?></td>
                 <td><?php echo $key->qty; ?></td>
                 <td><?php echo $key->unitprice; ?></td>
                 <td><?php echo $key->netamount; ?></td>
                 <td><?php echo $key->mrp;?></td>
                 <td><?php echo $key->tax; ?></td>
                 <td><?php echo $key->taxamount; ?></td>
                 <td><?php echo $key->amount; ?></td>
                 <td style=""><?php echo $key->qty; ?></td>
                 
                 </tr>
                 <?php
                 $n++;
               }
               ?>             </tbody>
            </TABLE>


  
</div>
<script type="text/javascript">
   var table = document.getElementById('dataTable');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         
                         document.getElementById("productname").value = this.cells[2].innerHTML;
                         document.getElementById("productcode").value = this.cells[3].innerHTML;
                         document.getElementById("Qty").value = this.cells[4].innerHTML;

                         document.getElementById("unitprice").value = this.cells[5].innerHTML;
                         document.getElementById("pre").value = this.cells[11].innerHTML;

                         document.getElementById('dataTable').deleteRow(i-1);
                          
                         
                    };
                }
</script>
<hr>

                <hr>
                 <div class="row">
 <div class="col-md-6">
            <label>Narration :</label>   
              <textarea class="form-control" id="narration"  name="Narration"></textarea> 
            
                 </div>
     <div class="col-md-6">
            <label>Transportation Company :</label>   
              <textarea id="company" class="form-control" name="transportationcompany"></textarea> 
            
                 </div>            
</div>

<hr>
<fieldset>
<div class="row">
  <div class="col-md-6">
   <label>Total Qty :</label>
    <input type="text" class="form-control" value="<?php foreach($master->result() as $gp){
         echo $gp->totalqty;
          }       ?>" name="totalqty" id="totalqty">

</div>

<div class="col-md-6">
   <label>Total Amount :</label>
    <input type="text" class="form-control" value="<?php foreach($master->result() as $gp){
         echo $gp->totalamount;
          }       ?>"  name="totalamount" id="totalamount">

</div>
</div>

<div class="row">
  <div class="col-md-6">
   <label>Additional Cost :</label>
    <input type="text" value="0" class="form-control" value="<?php foreach($master->result() as $gp){
         echo $gp->additionalcost;
          }       ?>"  name="additionalcost" id="additionalcost">

</div>

<div class="col-md-6">
   <label>Tax Amount :</label>
    <input type="text" class="form-control" name="taxamount" value="<?php foreach($master->result() as $gp){
         echo $gp->taxamount;
          }       ?>"   id="taxamount">

</div>
</div>

<div class="row">
  <div class="col-md-6">
   <label>Bill Discount :</label>
    <input type="text" value="<?php foreach($master->result() as $gp){
         echo $gp->billdiscount;
          }       ?>" class="form-control" name="billdiscount" id="billdiscount">

</div>

<div class="col-md-6">
   <label>Grand Total :</label>
    <input type="text" class="form-control" value="<?php foreach($master->result() as $gp){
         echo $gp->grandtotal;
          }       ?>"  name="grandtotal" id="grandtotal">

</div>
</div>
</fieldset>
<hr>
<fieldset style="font-size: 14px;background: #f0f0f0; font-style: bolder"  >Payment
  <div class="row">         
 
           <div class="col-md-3">
            <p class="p1" style="color: black">Old Balance :</label>
             <input type="text" name="oldbalance" value="<?php foreach($master->result() as $gp){
         echo $gp->oldbalance;
          }       ?>"  id="oldbalance" class="form-control"  autocomplete="off">
           </div>
             <div class="col-md-3">
            <p class="p1" style="color: black" >Bank/Cash :</label>
             <select class="form-control" id="cashorbank" name="cashorbank">
               <option>Cash</option>
               <option>Bank</option>
             </select>
           </div>
           <div class="col-md-3">
            <p class="p1" style="color: black" >Paid Amount :</label>
             <input type="text" value="0" value="<?php foreach($master->result() as $gp){
         echo $gp->paidamount;
          }       ?>"  name="paidamount" id="paidamount" class="form-control" required autocomplete="off">
           </div>
           <div class="col-md-3">
            <p class="p1" style="color: black" >Balance :</label>
             <input type="text" name="balance" value="<?php foreach($master->result() as $gp){
         echo $gp->balance;
          }       ?>"  id="balance" class="form-control"  autocomplete="off">
           </div>

               </div>
               </fieldset>

<hr>
<div class="row">


    <div class="offset-md-4">
                <input class="btn btnormal1" type="button"  name="btnsave" id="det" value="Update">
                <input class="btn btnormal2" type="submit" name="btndelete" value="Delete">
                <input class="btn btnormal2" type="submit" name="btnclear" value="Clear">
                <input class="btn btnormal1" type="submit" name="btnclose" value="Close">
    </div>
</form>
</div>
      


  <SCRIPT language="javascript">
    var a=0;
    var b=0.00;
    var c=0.00;
    var d=0.00;
    var e=0;
    var f=0;
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
                 var cell6 = row.insertCell(6);
                 var cell7 = row.insertCell(7);
                 var cell8 = row.insertCell(8);
                 var cell9 = row.insertCell(9);
                 var cell10 = row.insertCell(10);
                 var cell11 = row.insertCell(11);
                 var product = document.getElementById('productname');
                  cell0.checked=false;
                  cell1.innerHTML=rowCount;
                  cell2.innerHTML=document.getElementById('productname').value;
                  cell3.innerHTML=document.getElementById('productcode').value;
                  cell4.innerHTML=(document.getElementById('Qty').value);
                  cell5.innerHTML=document.getElementById('unitprice').value;
                  cell6.innerHTML=document.getElementById('mrp').value;
                  cell7.innerHTML=(document.getElementById('Qty').value*document.getElementById('unitprice').value);
                  cell8.innerHTML=document.getElementById('tax').value;
                  cell9.innerHTML=(document.getElementById('Qty').value*document.getElementById('unitprice').value)*(document.getElementById('tax').value)/100;
                  cell10.innerHTML=((document.getElementById('Qty').value*document.getElementById('unitprice').value)*(document.getElementById('tax').value)/100)+((document.getElementById('Qty').value*document.getElementById('unitprice').value));
                  // cell11.innerHTML=document.getElementById('pre').value;
                // alert(cell11.innerHTML);
              var table = document.getElementById("dataTable"), sumVal = 0;
            
            for(var i = 1; i < table.rows.length; i++)
            {
                sumVal = sumVal + parseInt(table.rows[i].cells[4].innerHTML);
            }
            
            // document.getElementById("val").innerHTML = "Sum Value = " + sumVal;
           
                  b=b+(document.getElementById('Qty').value*document.getElementById('unitprice').value)*(document.getElementById('tax').value)/100;
                  c=(c)+((document.getElementById('Qty')).value*1);
                  d=d+(document.getElementById('Qty').value*document.getElementById('unitprice').value);
                  e= (document.getElementById("billdiscount").value*1);
                  f= (document.getElementById("additionalcost").value*1);

                  document.getElementById("totalamount").value =d;
                  document.getElementById("totalqty").value =sumVal;
                  document.getElementById("taxamount").value =b;
                  document.getElementById('Qty').value="1";    
                  document.getElementById("grandtotal").value =d+b-e+f;
                  document.getElementById("balance").value =( document.getElementById("paidamount").value*1)-(document.getElementById("grandtotal").value*1);   

                   document.getElementById('productname').value="";
                   document.getElementById('productcode').value=""; 
                   document.getElementById('Qty').value=1;
                   document.getElementById('unitprice').value="";
                   document.getElementById('tax').value="";
                   document.getElementById('pre').value=0;
            }
        
    

      function deleteRow(tableID) 
       {
        // alert("sf");
               try 
               {
               var table = document.getElementById(tableID);
               var rowCount = table.rows.length;

                  for(var i=1; i<rowCount; i++)
                   {
                      var row = table.rows[i];         
                      row.cells[1].innerHTML=i;
                      var chkbox = row.cells[0].childNodes[0];
                          if(null != chkbox && true == chkbox.checked)
                           {
                              if(rowCount <= 1) 
                              {
                                  alert("Cannot delete all the rows.");
                                  break;
                              }
                             row.cells[1].innerHTML=i+1;
                             a=a-((row.cells[10].innerHTML)*1);
                             b=b-((row.cells[9].innerHTML)*1);
                             c=c-((row.cells[4].innerHTML)*1);
                             d=d-((row.cells[7].innerHTML)*1);
                             e= (document.getElementById("billdiscount").value*1);
                             f= (document.getElementById("additionalcost").value*1);          
                                 document.getElementById("totalamount").value =d;
                                 document.getElementById("totalqty").value =c;
                                 document.getElementById("taxamount").value =b;
                                 document.getElementById('Qty').value="1";    
                                 document.getElementById("grandtotal").value =d+b-e+f;
                                 document.getElementById("balance").value =( document.getElementById("paidamount").value*1)-(document.getElementById("grandtotal").value*1);
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


         

                 
                 </div>
              

</HEAD>

        </div>

</div>

</div>



</div>
<script type="text/javascript">
    $('#productname').click(function(){
                        var product = document.getElementById('productname');
                                      document.getElementById("unit").value = product.options[product.selectedIndex].getAttribute("data-unitid");
                                      document.getElementById("productcode").value = product.options[product.selectedIndex].getAttribute("data-productcode");
                                      document.getElementById("unitprice").value = product.options[product.selectedIndex].getAttribute("data-mrp");
                                      document.getElementById("tax").value = product.options[product.selectedIndex].getAttribute("data-tax");
                        
                          
   });
    
    var product1 = document.getElementById('supplier');   
  product1.onclick=function()
   {
                       
                                     document.getElementById("oldbalance").value = product1.options[product1.selectedIndex].getAttribute("data-supplierbalance");
                        
                                                 
   }   
   $('#billdiscount').change(function(){
    
             e= (document.getElementById("billdiscount").value*1);
             f= (document.getElementById("additionalcost").value*1);
                 document.getElementById("totalamount").value =d;
                 document.getElementById("totalqty").value =c;
                 document.getElementById("taxamount").value =b;
                 document.getElementById('Qty').value="1";    
                 document.getElementById("grandtotal").value =d+b-e+f;  
                 document.getElementById("balance").value =( document.getElementById("paidamount").value*1)-(document.getElementById("grandtotal").value*1);             
                          
   });
    $('#additionalcost').change(function(){
    
             e= (document.getElementById("billdiscount").value*1);
             f= (document.getElementById("additionalcost").value*1);
                document.getElementById("totalamount").value =d;
                document.getElementById("totalqty").value =c;
                document.getElementById("taxamount").value =b;
                document.getElementById('Qty').value="1";    
                document.getElementById("grandtotal").value =d+b-e+f;   
                document.getElementById("balance").value =( document.getElementById("paidamount").value*1)-(document.getElementById("grandtotal").  value*1);            
                          
   });
     $('#paidamount').change(function(){
    
            
            document.getElementById("balance").value =( document.getElementById("paidamount").value*1)-(document.getElementById("grandtotal").value*1);               
                          
   });
</script> 
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){


 $('#det').on('click',function(){
              
   var voucherno=document.getElementById("voucherno").value;
   var supplier=document.getElementById("supplier").value;
   var order=document.getElementById("orderno").value;
   var vendor=document.getElementById("vendor").value;
   var date=document.getElementById("invoicedate").value;
   var payment="cash";
   var narration=document.getElementById("narration").value;
   
   var company=document.getElementById("company").value;
   var totalqty=document.getElementById("totalqty").value;
   var totalamount=document.getElementById("totalamount").value;
   var additionalcost=document.getElementById("additionalcost").value;
   var tax=document.getElementById("taxamount").value;
   var discount=document.getElementById("billdiscount").value;
     var mrp = document.getElementById("mrp").value;


   var total=document.getElementById("grandtotal").value;
   var oldbalance=document.getElementById("oldbalance").value;
   var bank=document.getElementById("cashorbank").value;   
   
      var paidamount=document.getElementById("paidamount").value;
   var balance=document.getElementById("balance").value;
    $.noConflict();
   try{

            $.ajax({

                type : "POST",
                // dataType:"json",
                url  : "<?php echo base_url() ?>index.php/Onlinecontrol/editdetailes",
                data : {'voucherno':voucherno,
                'supplier':supplier,
                'order':order,
                'vendor':vendor,
                'date':date,
                'payment':payment,
                'narration':narration,
                'company':company,
                'totalqty':totalqty,
                'totalamount':totalamount,
                'additionalcost':additionalcost,
                'tax':tax,
                'discount':discount,
                'total':total,
                'oldbalance':oldbalance,
                'bank':bank,
                'paidamount':paidamount,
                
                'balance':balance},
                success: function(data){
              alert("master ok..!");
                                         alert("success1");           
                                              var table = document.getElementById('dataTable');
                                               for(var i = 1; i < table.rows.length; i++)
                                                      {
                                                         var productname = document.getElementById("dataTable").rows[i].cells[2].innerHTML;
                                                         var productcode = document.getElementById("dataTable").rows[i].cells[3].innerHTML;
                                                         var qty = document.getElementById("dataTable").rows[i].cells[4].innerHTML;
                                                         var unitprice = document.getElementById("dataTable").rows[i].cells[5].innerHTML;
                                                         var mrp = document.getElementById("dataTable").rows[i].cells[6].innerHTML;
                                                         var netamount = document.getElementById("dataTable").rows[i].cells[7].innerHTML;
                                                         var tax = document.getElementById("dataTable").rows[i].cells[8].innerHTML;
                                                         var taxamount = document.getElementById("dataTable").rows[i].cells[9].innerHTML;
                                                         var amount = document.getElementById("dataTable").rows[i].cells[10].innerHTML; 
                                                         var pre = document.getElementById("dataTable").rows[i].cells[11].innerHTML;
                                                                                           $.ajax({

                                                                                            type : "POST",
                                                                                            
                                                                                            url  : "<?php echo base_url() ?>index.php/Onlinecontrol/inserttable1",
                                                                                            data : {'voucherno':voucherno,
                                                                                            'invoicedate':date,
                                                                                            'productname':productname,
                                                                                            'productcode':productcode,
                                                                                            'qty':qty,
                                                                                            'unitprice':unitprice,
                                                                                            'mrp':mrp,
                                                                                            'pre':pre,
                                                                                            'netamount':netamount,
                                                                                            'tax':tax,
                                                                                            'taxamount':taxamount,
                                                                                            'amount':amount,
                
                                                                                            success: function(data){
                                                                                              alert("det");
                                                                                                var result1= JSON.stringify(data);
       alert(data);
                                                                                                    

        
  
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
   document.getElementById("dataTable").deleteRow(1);                                   



                                                                                                                      for(var i = 0; i < qty; i++)      
                                                                                                                      {var divToPrint1=document.getElementById("barcode");
                                                                                                                    var divToPrint2=document.getElementById("barcodemrp");
                                                                                                                    document.getElementById("barcodemrp").innerHTML = mrp;
                                                                                                                    
                                                                                                                       JsBarcode("#barcode", productcode,{
                                                                                                                                                            
                                                                                                                                                            lineColor: "#000",
                                                                                                                                                            
                                                                                                                                                            height: 40
                                                                                                                                                            
                                                                                                                                                          });
                                                                                                                      newWin= window.open("");
                                                                                                                      newWin.document.write("<center style='font-size=20'>MRP:"+unitprice+" </center>");
                                                                                                                       newWin.document.write(divToPrint1.outerHTML);
                                                                                                                      
                                                                                                                      
                                                                                                                      // newWin.print();
                                                                                                                      newWin.close();
                                                                                                                      }

                                                                                                                      
          
                                                                                                                     }
                                                                                                   

                                                                                                           
                                                                                                         }
                                                                                                 });   
                                                                                                    
                                                                         
  
                                                                                }
                                                                        
          
                                      },
                 error: function(data){
                   var result1= JSON.stringify(data);
       alert(result1);
                            // alert('Error occur...!!');
                        }
            });  

          }
          catch(err){
            alert(err.message);
          }
             });
   
        //Save product
        
              });  


</script>
<div id="barcodemrp" style="display: none;"></div>
<svg id='barcode' style="display: none;"></svg>
              </div>