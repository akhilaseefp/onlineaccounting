<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<script type="text/javascript">
$(document).ready(function(){ 
  $("#myInput").on("click", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<!-- <form method="post" action="<?php echo base_url(); ?>index.php/Onlinecontrol/salescost"> -->
<div class="content-wrapper">
   <section class="content-header">
      <h1>
      STOCK PRODUCT REGISTER REPORT
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">STOCK PRODUCT REGISTER REPORT</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">
     <div class="row">


      <div class="col-md-3">
        <div class="form-group">
         <label for="bdaymonth">Product</label>
         <input type="text" class="form-control productcode2" list="name" autocomplete="off" name="productname" id="productcode1">

         <datalist id="name">
          <?php foreach($product->result() as $gp){
            ?>
            <option value="<?php echo $gp->pdt_code;?>" data-qty="<?php echo $gp->purchaserate;?>"
              data-tax="<?php echo $gp->tax;?>" label="<?php echo $gp->pdt_name;?>">
            <?php  } ?>
          </datalist>
       </div>
     </div>


   <div class="col-md-3">
    <label>Branch</label>
    <select  class="form-control"  required name="branch" id="branch">
      <?php
      foreach ($branch->result() as $branch) { ?>
        <?php if($branch->branchid==$branchid){?>
          <option value="<?php echo $branch->branchid;?>"  ><?php echo $branch->branchname; ?></option>
        <?php }
        else{?>
          <option value="<?php echo $branch->branchid;?>"><?php echo $branch->branchname; ?></option>
        <?php }
      }?>
    </select>
  </div>

  <div class="col-md-3">
    <label>.</label><br>
    <input class="btn btn-success btngo" type="submit" name="btngo" id="btngo" value="Go">
  </div>


     <div class="row" style="padding-top:50px;">
      <div class="col-md-12">
        <div class="table">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="shp_tab">
                  <thead>
                  <tr>
                    <th style="">SL No</th>
                    <th style="">Date</th>
                    <th style="">Type</th>
                    <th>Qty</th>
                    
                  </tr>
                  </thead>
                    <tbody id="shp_tab1">
                      
                    </tbody>
                 </table>
                 <button class="btn btn-success" onclick="exportTableToExcel('shp_tab', 'Stock Register')">Export To  Excel File</button>
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
    </section>
    </div>

    <script type="text/javascript">
      var ctr = 1;
          $(document).ready(function () {

            

            $('#btngo').click(function () { 

              var table = document.getElementById("shp_tab1");
              $('#shp_tab1 tr').remove();
              var branch = document.getElementById("branch").value;
						  var pdt_id = document.getElementById("productcode1").value;

              try{
                $.ajax({
                  type: "POST",
                  dataType: 'json',
                  url: "<?php echo base_url(); ?>index.php/Onlinecontrol/getStockRegPDTReport",
                  data: {
                    'branch': branch,
                    'pdt_id': pdt_id
                  },
                  success: function (result) { 

                    // alert(result.length);
                 
                    for (i=0;i<result.length;i++)
                    { 
                        var date = result[i]['date'];                    
                        var opposite = result[i]['transactiontype'];                    
                        var balance = result[i]['qty'];
                        var newTr = '<tr><td>' + (i*1+1) +'</td><td>'+date+'</td><td>'+opposite+'</td><td>'+balance+'</td></tr>';
                        $('#shp_tab').append(newTr);
                        ctr++;
                    }
                      
                      },
                      error: function(xhr, status, error) {
                          alert(xhr.responseText);
                      }
                        });
                } catch (err) {
                  alert(err.message);
                }
              });
      });
     </script>
     <script type="text/javascript">
       window.onload=function(){
        document.getElementById("month").value ="<?php echo date('Y-m'); ?>";

      }
    </script> 
            
            <script type="text/javascript">
              $('#month').on('keyup change', function () {
               var date =new Date(document.getElementById("month").value+"-01"), y = date.getFullYear(), m = date.getMonth();
               var firstDay = new Date(y, m, 2).toISOString().slice(0,10);
               var lastDay = new Date(y, m + 1, 1).toISOString().slice(0,10);
               document.getElementById("fdate").value=firstDay;
               document.getElementById("tdate").value=lastDay;


             });
           </script>
                         
  <!-- </form> -->