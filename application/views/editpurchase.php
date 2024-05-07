<script src="<?php echo base_url();?>js/jquery1.js"></script>
 <script>
$(document).ready(function(){
  $("#myInput").on("change", function() {
    var value = $(this).val().toLowerCase();
     $("#new tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>


<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Edit Purchase
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Edit Purchase</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">  <form class="seminor-login-form" method="post">
          <div class="row col-md-12">
                   <div class="col-md-3">
            <div class="form-group">
             <label for="bdaymonth">Select Month :</label>
             <input type="month" class="form-control" name="month" id="month" value="" required autocomplete="off">
            </div>
          </div>
<script type="text/javascript">

     window.onload=function(){
      document.getElementById("month").value ="<?php echo date('Y-m'); ?>";
      var date =new Date(document.getElementById("month").value+"-01"), y = date.getFullYear(), m = date.getMonth();
          var firstDay = new Date(y, m, 2).toISOString().slice(0,10);
          var lastDay = new Date(y, m + 1, 1).toISOString().slice(0,10);
            document.getElementById("fromdate").value=firstDay;
            document.getElementById("todate").value=lastDay;
      
       }

</script>   

                  
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">From  Date</label>
                           <input type="date" class="form-control" name="fromdate" id="fromdate" value="" required autocomplete="off">
                         </div>
                       </div>

                      <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">To  Date</label>
                           <input type="date" class="form-control" name="todate" id="todate" value=""   required autocomplete="off">
                         </div>  
                      </div>
                      <div class="col-md-2">
                      <input class="btn btn-success" type="submit" style="margin-top: 25px;" name="" id="search" value="Search" formaction="<?php echo base_url(); ?>index.php/Purchasecontrol/editpur">
                         </div> 

                      </div>
                      <script type="text/javascript">

            $('#month').on('keyup change', function () {
               var date =new Date(document.getElementById("month").value+"-01"), y = date.getFullYear(), m = date.getMonth();
          var firstDay = new Date(y, m, 2).toISOString().slice(0,10);
          var lastDay = new Date(y, m + 1, 1).toISOString().slice(0,10);
            document.getElementById("fromdate").value=firstDay;
            document.getElementById("todate").value=lastDay;

            });
</script>
                   
          
<input type="text" class="form-control" id="myInput" value="" name="" placeholder="Search by invoiceno">

 <div class="row margin" style="text-align: right;">
                 <button formaction="<?php echo base_url();?>index.php/Onlinecontrol/pur_invoice" class="btn btn-success">NEW</button>

                
                 <button class="btn btn-success" onclick="exportTableToExcel('salestable', 'Purchase Register')">Export To  Excel File</button>
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
                 </form>
   <div class="row margin">
       <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%" border="1" class="table table-hover" id="salestable">
                    <thead>
                  <tr>
                   
                    <!-- <th class="">Sl order/th> -->

                     <!-- <th style="">stockmasterid</th> -->
                    <th class="">Voucher No</th>
                    <th >Date</th>
                    <th style="">Quantity</th>
                    <th style="">Total amount</th>
                    <th style="">Branch</th>
                     <!-- <th class="" style="">Total Cost</th> -->
                     <th>Action</th>
                     
                     
                                   </tr></thead>
                                    <tbody id="new">
                  <?php
                  foreach ($voch->result() as $key) {
                    ?>
                    <tr>
                    <!-- <td><?php echo $key->stockmasterid;?></td> -->
                    <td><?php echo $key->voucherno;?></td>
                    <td><?php echo $key->invoicedate;?></td>
                     <td><?php echo $key->totalqty;?></td>
                    <!-- <td><?php echo $key->tbranch;?></td> -->
                    <td><?php echo $key->grandtotal;?></td>
                    <td><?php echo $key->branchname;?></td>
                    <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/pur_invoice?a=<?php echo $key->voucherno;?>"><button class="btn btn-success">Edit</button></a></td>
                  </tr>
                      <?php }?>
                      </tbody>
                 </table>

                </div>     
    </div>
                <div class="row margin" style="text-align: right;">
                  <!-- <a href="<?php echo base_url();?>index.php/Onlinecontrol/pur_invoice"><button class="btn btn-success">NEW</button></a> -->
                </div>