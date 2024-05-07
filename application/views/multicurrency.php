

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
               
                <th style="display: none;">productcode</th>
                <th style="">ACTION</th>
               
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
                        
                        <td ><input type="text"  class="form-control inr"  value="<?php echo $mu->mrp;?>"></td>
                          <td class=""><input type="text"  class="form-control aed"  value="<?php echo $mu->aed;?>"> </td>
                           <td class=""><input type="text"  class="form-control usd"  value="<?php echo $mu->usd;?>"> </td>
                       
                         <td  class="productcode" style="display: none;"><?php echo $mu->pdt_code;?></td>
                          
                         
                       
                        
                       
                         
                         <td> <input class="btn btn-success update" type="button" name="btnupdate" value="Update" >
            </td>
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
        $(document).ready(function () {

          $('.update').on('click', function () {

 try {  
                     var product = $(this).closest("tr").find('.productcode').text(); 

                     
                    
                     var inr = $(this).closest("tr").find('.inr').val(); 
                      var aed = $(this).closest("tr").find('.aed').val(); 
                       var usd = $(this).closest("tr").find('.usd').val(); 
                    

                   
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url() ?>index.php/Onlinecontrol/update_multicurrency",
                      data: {
                        'product':product,
                        'inr' : inr,
                        'aed' :aed,
                        'usd' :usd,
                        
                        
                       
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
 

        
      </section>
    </div>
  


