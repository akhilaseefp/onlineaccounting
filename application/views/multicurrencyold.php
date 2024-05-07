

   <div id="content">
            <script src="<?php echo base_url();?>js/jquery1.js"></script>
            
   <div id="content">          
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchbrand").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script type="text/javascript">
  // $.noConflict();
  var ctr = 1;
  var inv_no =0;
 

  var totalstockamount =0;
  $(document).ready(function () {


    $('#dataTable1').on('change', '.productcode2', function () {
      ctr++;
      // var a = $(this).closest("tr")[0].rowIndex;
           var a = $(this).closest("tr").find('.ctr').text();
      
      try {
        
                  
           
           
           newrow();

            
            

       
      } catch (err) {
        alert(err.message);
      }

    });


  });
</script>


    
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Multiple Currency
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active"> Multiple Currency</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">

      <div class="container-fluid">
        <div class="hed"><h1>Multiple Currency</h1></div>
        <hr>
         <div class="row">
           <div class="col-md-12">
             <div class="table table-responsible">
          <TABLE id="dataTable1" border="1" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>SL.NO</th>
                <th>PRODUCT NAME</th>
                
                <th>INR</th>
                
               <th>AED</th>
               <th>USD</th>
                
              </tr>
            </thead>
            <tbody id="dataTable" width="100%" class="table table-hover">
                <tr>
                <td>1</td>
                <td> <input type="text" class="form-control productcode2" list="name" autocomplete="off"
                    name="productname" id="productcode1"></td>
                <datalist id="name">
                  <?php foreach($product->result() as $gp){ ?>
                  <option label="<?php echo $gp->pdt_code;?>" data-purchaserate="<?php echo $gp->purchaserate;?>"
                    data-tax="<?php echo $gp->tax;?>" value="<?php echo $gp->pdt_name;?>">
                    <?php  } ?>
                </datalist>
                                
               
               
               
                
                  <td style=""> <input type="text" id="inr1" class="form-control salesrate inr" name="inr1" value="0.00"></td>
                   <td style=""> <input type="text" id="aed1" class="form-control salesrate aed" name="aed1" value="0.00"></td>
                    
               <td style=""><input type="text" id="usd1" class="form-control salesrate usd" name="usd1" value="0.00"></td>
               <td class="ctr" style="display: none">1</td>
                <td><a href="" class="delete">X</a></td>
                
              </tr>
            </tbody>
          </TABLE>
          <input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
        </div>
        <div class="row col-md-12 form-group margin txn-bottom-form" style="text-align: center;">
        <form action="<?php echo base_url();?>index.php/Onlinecontrol/multicurrency">
          <div class="offset-md-4">
            <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
            <input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave">
           
            <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
            
          </div>
        </div></form>
      </div>
              
</div>
          
           
</div>
<div class ="row">

            <div class="col-md-12">
                
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Search</label>
                   <input type="text" class="form-control"  name="searchbrand" id="searchbrand" autocomplete="off">
                 </div>

                 <div class="subdiv table-responsive">
                  <table width="100%" border="1" class="table table-hover" id="table">
                    <thead >
                       <tr >
                <th style="text-align: center;">SL.NO</th>
                <th style="text-align: center;">PRODUCT NAME</th>
                
                
                <th style="text-align: center;">INR</th>
                
                <th class="" style="text-align: center;">AED</th>
                <th class="" style="text-align: center;">USD</th>
                <th style="display: none;"></th>
                <th style="display: none;;">productcode</th>
               
                     </tr>
                    </thead>
                   <tbody id="myTable">
                    <?php
                      $n=1;
                     foreach($multicurrency->result() as $mu)
                    {
                      ?>
                      <tr>
                        <td class=""><?php echo $n;?></td>
                         <td class=""><?php echo $mu->pdt_name;?></td>
                        
                        <td ><input type="text"  class="form-control inr"  value="<?php echo $mu->inr;?>"></td>
                          <td class=""><input type="text"  class="form-control aed"  value="<?php echo $mu->aed;?>"> </td>
                           <td class=""><input type="text"  class="form-control usd"  value="<?php echo $mu->usd;?>"> </td>
                        <td class="multiid" style="display: none;"><?php echo $mu->multicurrency_id;?></td>
                         <td  class="productcode" style="display: none;"><?php echo $mu->productcode;?></td>
                          
                         
                       
                        
                       
                         
                         <td> <input class="btn btn-success update" type="button" name="btnupdate" value="Update" >
            <input class="btn btn-danger delete" type="button" name="btndelete" value="Delete" ></td>
                      </tr>
                 <?php  $n++;
                   } ?>
                 </tbody>
                  </table>
                </div>
                <button onclick="exportTableToExcel('table', 'Multi Unit Register')">Export To  Excel File</button>
                  <script type="text/javascript">
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
            </div>
         </div>
           </div>

     

      </div>
    </div>
 <script type="text/javascript">
   $('#dataTable1').on('keyup change', '.conversion', function () {
          
 no =$(this).closest("tr").find('.ctr').text();
 

  });
     $('#dataTable1').on('focus', '.salesrate', function () {


   if ($(this).val()==0) {
                       $(this).val("");
                      }
  });
      $('#dataTable1').on('focus', '.salesrate', function () {


   if ($(this).val()==0) {
                       $(this).val("");
                      }
  });
   $('#dataTable1').on('click', '.delete', function (e) {
    e.preventDefault();
  
    $(this).closest('tr').remove();
  
    var table = document.getElementById('dataTable1');
    var ab = table.rows.length;
    for (var i = 1; i < table.rows.length + 1; i++) {
      table.rows[i].cells[0].innerHTML = i;
    }
    
  });
  // var table = document.getElementById('table');
                
  //               for(var i = 1; i < table.rows.length; i++)
  //               {
  //                   table.rows[i].onclick = function()
  //                   {
                         
  //                        document.getElementById("product").value = this.cells[7].innerHTML;
  //                        document.getElementById("unit").value = this.cells[1].innerHTML;
  //                        document.getElementById("nounit").value = this.cells[3].innerHTML;
  //                        document.getElementById("bunit").value = this.cells[8].innerHTML;
  //                        document.getElementById("rate").value = this.cells[5].innerHTML;
  //                        document.getElementById("unitid").value = this.cells[6].innerHTML;
  //                        document.getElementById("save").value = "Update";
                          
                         
  //                   };
  //               }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
    // alert("sdhfk");
                          
                          document.getElementById("save").value = "Save";
                        
   }     
   var product = document.getElementById('product');   
  product.onclick=function()
   {
                       
                                    
                        
                          
                        
   }       
</script>
<script type="text/javascript">
  $('#addrow').on('click', function () { 
   newrow();

  });
  function newrow(){ 
     ctr++;

    var tr = "tr" + ctr;
            var productcode = "productcode" + ctr;
            // var unitprice = "unitprice" + ctr;
            var conversion = "conversion" + ctr;
                            var inr = "inr" + ctr;
                         var aed = "aed" + ctr;
                          var usd = "usd" + ctr;
                       
            
            var rowCount = document.getElementById('dataTable').rows.length + 1;
            var newTr = '<tr><td>'+ rowCount +'</td><td><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="'+productcode+'"></td><td style=""><input type="text" id="' + inr +'" class="form-control salesrate inr"  name="inr" ></td><td style=""><input type="text" id="' + aed +'" class="form-control salesrate aed"  name="aed" ></td><td style=""><input type="text" id="' + usd +'" class="form-control salesrate usd"  name="usd" ></td><td class="ctr" style="display:none">' + ctr +'</td> <td><a href="" class="delete" >X</a></td>< </tr>';
              
            $('#dataTable1').append(newTr);
  }
   
  
</script>

      <script type="text/javascript">
        $(document).ready(function () {

          $('#btnsave').on('click', function () {

 try {  
                     var table = document.getElementById('dataTable1');
                       var success="Success";
                    for (var i = 1; i < table.rows.length; i++) {
                   
                     
                    var productname = $('#productcode' + i).val();
                      var product = $("#name option[value='" + $('#productcode'+i).val() + "']").attr('label');
                     
                      var inr = $('#inr' + i).val();
                        var aed = $('#aed' + i).val();
                          var usd = $('#usd' + i).val();
                     
                     
                     
                                            
                     
                      if (product == null || product =="") {

                      } else {   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_multicurrency",
                      data: {
                        'product':product,
                        'inr' : inr,
                        'aed' :aed,
                        'usd' :usd,                        
                        'save' :'Save'
                      },
                      success: function (data) {
                       success="multiple currencies successfully Inserted.please click clear to see the effect.";
                        var myJSON = JSON.stringify(data);
                      },
                      error: function (data) {
                        success=0;
                        var myJSON = JSON.stringify(data);
                       success=myJSON;
                      }

                    }); //product insert ajax  
                    
                  } //end of else
                    

                  }
                   alert(success);
                    $('#dataTable  tr').remove();
                    ctr=1;
                    newrow();
                  
} //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
          // location.reload();
        }
            });
          });

      </script>
       <script type="text/javascript">
        $(document).ready(function () {

          $('.update').on('click', function () {

 try {  
                     var product = $(this).closest("tr").find('.productcode').text(); 

                     
                    
                     var inr = $(this).closest("tr").find('.inr').val(); 
                      var aed = $(this).closest("tr").find('.aed').val(); 
                       var usd = $(this).closest("tr").find('.usd').val(); 
                     var multicurrencyid = $(this).closest("tr").find('.multiid').text(); 

                   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/update_multicurrency",
                      data: {
                        'product':product,
                        'inr' : inr,
                        'aed' :aed,
                        'usd' :usd,
                        
                        
                        'multicurrencyid' :multicurrencyid
                      },
                      success: function (data) {
                     alert("multiple currency successfully Updated.");
                     location.reload();
                        // var myJSON = JSON.stringify(data);
                      },
                      error: function (data) {
                        var myJSON = JSON.stringify(data);
                        alert("in details");
                  alert(myJSON);
                      }

                    }); //product insert ajax  
                    
                 
} //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
          
        }
            });
          });

      </script>
 <script type="text/javascript">
        $(document).ready(function () {

          $('.delete').on('click', function () {

 try {  
                    
                     var multiid = $(this).closest("tr").find('.multiid').text(); 
                     
                   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/delete_multicurrency",
                      data: {
                       
                        'multiid' :multiid
                      },
                      success: function (data) {
                     alert("multiple currency deleted successfully");
                     location.reload();
                    
                        // var myJSON = JSON.stringify(data);
                      },
                      error: function (data) {
                        var myJSON = JSON.stringify(data);
                        alert("in details");
                  alert(myJSON);
                      }

                    }); //product insert ajax  
                    
                 
} //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
           location.reload();
        }
            });
          });

      </script>


        
      </section>
    </div>
  




   <div id="content">
            <script src="<?php echo base_url();?>js/jquery1.js"></script>
            
   <div id="content">          
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchbrand").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<script type="text/javascript">
  // $.noConflict();
  var ctr = 1;
  var inv_no =0;
 

  var totalstockamount =0;
  $(document).ready(function () {


    $('#dataTable1').on('change', '.productcode2', function () {
      ctr++;
      // var a = $(this).closest("tr")[0].rowIndex;
           var a = $(this).closest("tr").find('.ctr').text();
      
      try {
        
                  
           
           
           newrow();

            
            

       
      } catch (err) {
        alert(err.message);
      }

    });


  });
</script>


    
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Multiple Currency
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active"> Multiple Currency</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">

      <div class="container-fluid">
        <div class="hed"><h1>Multiple Currency</h1></div>
        <hr>
         <div class="row">
           <div class="col-md-12">
             <div class="table table-responsible">
          <TABLE id="dataTable1" border="1" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>SL.NO</th>
                <th>PRODUCT NAME</th>
                
                <th>INR</th>
                
               <th>AED</th>
               <th>USD</th>
                
              </tr>
            </thead>
            <tbody id="dataTable" width="100%" class="table table-hover">
                <tr>
                <td>1</td>
                <td> <input type="text" class="form-control productcode2" list="name" autocomplete="off"
                    name="productname" id="productcode1"></td>
                <datalist id="name">
                  <?php foreach($product->result() as $gp){ ?>
                  <option label="<?php echo $gp->pdt_code;?>" data-purchaserate="<?php echo $gp->purchaserate;?>"
                    data-tax="<?php echo $gp->tax;?>" value="<?php echo $gp->pdt_name;?>">
                    <?php  } ?>
                </datalist>
                                
               
               
               
                
                  <td style=""> <input type="text" id="inr1" class="form-control salesrate inr" name="inr1" value="0.00"></td>
                   <td style=""> <input type="text" id="aed1" class="form-control salesrate aed" name="aed1" value="0.00"></td>
                    
               <td style=""><input type="text" id="usd1" class="form-control salesrate usd" name="usd1" value="0.00"></td>
               <td class="ctr" style="display: none">1</td>
                <td><a href="" class="delete">X</a></td>
                
              </tr>
            </tbody>
          </TABLE>
          <input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
        </div>
        <div class="row col-md-12 form-group margin txn-bottom-form" style="text-align: center;">
        <form action="<?php echo base_url();?>index.php/Onlinecontrol/multicurrency">
          <div class="offset-md-4">
            <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
            <input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave">
           
            <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
            
          </div>
        </div></form>
      </div>
              
</div>
          
           
</div>
<div class ="row">

            <div class="col-md-12">
                
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Search</label>
                   <input type="text" class="form-control"  name="searchbrand" id="searchbrand" autocomplete="off">
                 </div>

                 <div class="subdiv table-responsive">
                  <table width="100%" border="1" class="table table-hover" id="table">
                    <thead >
                       <tr >
                <th style="text-align: center;">SL.NO</th>
                <th style="text-align: center;">PRODUCT NAME</th>
                
                
                <th style="text-align: center;">INR</th>
                
                <th class="" style="text-align: center;">AED</th>
                <th class="" style="text-align: center;">USD</th>
                <th style="display: none;"></th>
                <th style="display: none;;">productcode</th>
               
                     </tr>
                    </thead>
                   <tbody id="myTable">
                    <?php
                      $n=1;
                     foreach($multicurrency->result() as $mu)
                    {
                      ?>
                      <tr>
                        <td class=""><?php echo $n;?></td>
                         <td class=""><?php echo $mu->pdt_name;?></td>
                        
                        <td ><input type="text"  class="form-control inr"  value="<?php echo $mu->inr;?>"></td>
                          <td class=""><input type="text"  class="form-control aed"  value="<?php echo $mu->aed;?>"> </td>
                           <td class=""><input type="text"  class="form-control usd"  value="<?php echo $mu->usd;?>"> </td>
                        <td class="multiid" style="display: none;"><?php echo $mu->multicurrency_id;?></td>
                         <td  class="productcode" style="display: none;"><?php echo $mu->productcode;?></td>
                          
                         
                       
                        
                       
                         
                         <td> <input class="btn btn-success update" type="button" name="btnupdate" value="Update" >
            <input class="btn btn-danger delete" type="button" name="btndelete" value="Delete" ></td>
                      </tr>
                 <?php  $n++;
                   } ?>
                 </tbody>
                  </table>
                </div>
                <button onclick="exportTableToExcel('table', 'Multi Unit Register')">Export To  Excel File</button>
                  <script type="text/javascript">
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
            </div>
         </div>
           </div>

     

      </div>
    </div>
 <script type="text/javascript">
   $('#dataTable1').on('keyup change', '.conversion', function () {
          
 no =$(this).closest("tr").find('.ctr').text();
 

  });
     $('#dataTable1').on('focus', '.salesrate', function () {


   if ($(this).val()==0) {
                       $(this).val("");
                      }
  });
      $('#dataTable1').on('focus', '.salesrate', function () {


   if ($(this).val()==0) {
                       $(this).val("");
                      }
  });
   $('#dataTable1').on('click', '.delete', function (e) {
    e.preventDefault();
  
    $(this).closest('tr').remove();
  
    var table = document.getElementById('dataTable1');
    var ab = table.rows.length;
    for (var i = 1; i < table.rows.length + 1; i++) {
      table.rows[i].cells[0].innerHTML = i;
    }
    
  });
  // var table = document.getElementById('table');
                
  //               for(var i = 1; i < table.rows.length; i++)
  //               {
  //                   table.rows[i].onclick = function()
  //                   {
                         
  //                        document.getElementById("product").value = this.cells[7].innerHTML;
  //                        document.getElementById("unit").value = this.cells[1].innerHTML;
  //                        document.getElementById("nounit").value = this.cells[3].innerHTML;
  //                        document.getElementById("bunit").value = this.cells[8].innerHTML;
  //                        document.getElementById("rate").value = this.cells[5].innerHTML;
  //                        document.getElementById("unitid").value = this.cells[6].innerHTML;
  //                        document.getElementById("save").value = "Update";
                          
                         
  //                   };
  //               }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
    // alert("sdhfk");
                          
                          document.getElementById("save").value = "Save";
                        
   }     
   var product = document.getElementById('product');   
  product.onclick=function()
   {
                       
                                    
                        
                          
                        
   }       
</script>
<script type="text/javascript">
  $('#addrow').on('click', function () { 
   newrow();

  });
  function newrow(){ 
     ctr++;

    var tr = "tr" + ctr;
            var productcode = "productcode" + ctr;
            // var unitprice = "unitprice" + ctr;
            var conversion = "conversion" + ctr;
                            var inr = "inr" + ctr;
                         var aed = "aed" + ctr;
                          var usd = "usd" + ctr;
                       
            
            var rowCount = document.getElementById('dataTable').rows.length + 1;
            var newTr = '<tr><td>'+ rowCount +'</td><td><input type="text" class="form-control productcode2" list="name" on autocomplete="off" name="productname" id="'+productcode+'"></td><td style=""><input type="text" id="' + inr +'" class="form-control salesrate inr"  name="inr" ></td><td style=""><input type="text" id="' + aed +'" class="form-control salesrate aed"  name="aed" ></td><td style=""><input type="text" id="' + usd +'" class="form-control salesrate usd"  name="usd" ></td><td class="ctr" style="display:none">' + ctr +'</td> <td><a href="" class="delete" >X</a></td>< </tr>';
              
            $('#dataTable1').append(newTr);
  }
   
  
</script>

      <script type="text/javascript">
        $(document).ready(function () {

          $('#btnsave').on('click', function () {

 try {  
                     var table = document.getElementById('dataTable1');
                       var success="Success";
                    for (var i = 1; i < table.rows.length; i++) {
                   
                     
                    var productname = $('#productcode' + i).val();
                      var product = $("#name option[value='" + $('#productcode'+i).val() + "']").attr('label');
                     
                      var inr = $('#inr' + i).val();
                        var aed = $('#aed' + i).val();
                          var usd = $('#usd' + i).val();
                     
                     
                     
                                            
                     
                      if (product == null || product =="") {

                      } else {   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_multicurrency",
                      data: {
                        'product':product,
                        'inr' : inr,
                        'aed' :aed,
                        'usd' :usd,                        
                        'save' :'Save'
                      },
                      success: function (data) {
                       success="multiple currencies successfully Inserted.please click clear to see the effect.";
                        var myJSON = JSON.stringify(data);
                      },
                      error: function (data) {
                        success=0;
                        var myJSON = JSON.stringify(data);
                       success=myJSON;
                      }

                    }); //product insert ajax  
                    
                  } //end of else
                    

                  }
                   alert(success);
                    $('#dataTable  tr').remove();
                    ctr=1;
                    newrow();
                  
} //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
          // location.reload();
        }
            });
          });

      </script>
       <script type="text/javascript">
        $(document).ready(function () {

          $('.update').on('click', function () {

 try {  
                     var product = $(this).closest("tr").find('.productcode').text(); 

                     
                    
                     var inr = $(this).closest("tr").find('.inr').val(); 
                      var aed = $(this).closest("tr").find('.aed').val(); 
                       var usd = $(this).closest("tr").find('.usd').val(); 
                     var multicurrencyid = $(this).closest("tr").find('.multiid').text(); 

                   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/update_multicurrency",
                      data: {
                        'product':product,
                        'inr' : inr,
                        'aed' :aed,
                        'usd' :usd,
                        
                        
                        'multicurrencyid' :multicurrencyid
                      },
                      success: function (data) {
                     alert("multiple currency successfully Updated.");
                     location.reload();
                        // var myJSON = JSON.stringify(data);
                      },
                      error: function (data) {
                        var myJSON = JSON.stringify(data);
                        alert("in details");
                  alert(myJSON);
                      }

                    }); //product insert ajax  
                    
                 
} //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
          
        }
            });
          });

      </script>
 <script type="text/javascript">
        $(document).ready(function () {

          $('.delete').on('click', function () {

 try {  
                    
                     var multiid = $(this).closest("tr").find('.multiid').text(); 
                     
                   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/delete_multicurrency",
                      data: {
                       
                        'multiid' :multiid
                      },
                      success: function (data) {
                     alert("multiple currency deleted successfully");
                     location.reload();
                    
                        // var myJSON = JSON.stringify(data);
                      },
                      error: function (data) {
                        var myJSON = JSON.stringify(data);
                        alert("in details");
                  alert(myJSON);
                      }

                    }); //product insert ajax  
                    
                 
} //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
           location.reload();
        }
            });
          });

      </script>


        
      </section>
    </div>
  


