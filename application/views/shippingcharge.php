

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



    
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Shipping Charge
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Shipping Charge</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">

      <div class="container-fluid">
        <div class="hed"><h1>Shipping Charge</h1></div>
        
<div class ="row">
                  <datalist id ="currency">
                      
                      <?php
                          foreach ($currency->result() as $row)
                          {
                                ?>
                    <option value="<?php echo $row->currencyname; ?>" label="<?php echo $row->currencyid; ?>">
                    <?php } ?>
                    </datalist> 
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
                <th style="text-align: center;">COUNTRY</th>
                
                
                <th style="text-align: center;">CURRENCY</th>
                
                <th class="" style="text-align: center;">SHIPPING CHARGE</th>
                <th class="" style="text-align: center;">Action</th>
                <th style="display: none;"></th>
                <th style="display: none;;">COUNTRYID</th>
               
                     </tr>
                    </thead>
                   <tbody id="myTable">
                    <?php
                      $n=1;
                     foreach($shippingcharge->result() as $mu)
                    { 
                      ?>
                      <tr>
                        <td class=""><?php echo $n;?></td>
                         <td class=""><?php echo $mu->country_name;?></td>
                        
                        <td ><input type="text" class="form-control unit " list="currency" autocomplete="off"  value="<?php echo $mu->currencyname;?>" ></td>
                          <td class=""><input type="text"  class="form-control rate"  value="<?php echo $mu->charge;?>"> </td>
                        <td class="multiid" style="display: none;"><?php echo $mu->shippingid;?></td>
                         <td  class="productcode" style="display: none;"><?php echo $mu->country;?></td>
                          <td  class="" style="display: none;"><?php echo $mu->currencyname;?></td>
                         
                       
                        
                       
                         
                         <td> <input class="btn btn-success update" type="button" name="btnupdate" value="Update" >
           
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
       
</script>


      
       <script type="text/javascript">
        $(document).ready(function () {

          $('.update').on('click', function () {

 try {  
                     var country = $(this).closest("tr").find('.productcode').text(); 

                    
                     var currencyname = $(this).closest("tr").find('.unit').val(); 
                      var currency = $("#currency option[value='" + currencyname + "']").attr('label');
                    
                     var charge = $(this).closest("tr").find('.rate').val(); 
                     var shippingid = $(this).closest("tr").find('.multiid').text(); 

                  
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/update_shippingcharge",
                      data: {
                        'country':country,
                        'currency': currency,
                        'charge': charge,
                        
                        'shippingid' :shippingid
                      },
                      success: function (data) {
                     alert("Shipping charge successfully Updated.");
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
 

        
      </section>
    </div>
  


