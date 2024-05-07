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
        Daily Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Daily Sales Report</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
           <form class="seminor-login-form" method="post">
          <div class="row col-md-12">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">From  Date</label>
                           <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" required autocomplete="off">
                         </div>
                       </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">To  Date</label>
                           <input type="date" class="form-control" name="todate" id="todate" value="<?php echo $todate; ?>"   required autocomplete="off">
                         </div>  
                      </div>
                      <div class="col-md-3" style="">
            <div class="form-group">
              <label class="form-control-placeholder" for="contact-person">Branch</label>
              <select class="form-control" name="branchid" id="branchid">
                <?php
              foreach ($branch->result() as $branch) { ?>
                <?php if($branch->branchid==$branchid){?>
                <option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>" selected ><?php echo $branch->branchname; ?></option>
                <?php }
                else{?>
                <option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>" ><?php echo $branch->branchname; ?></option>
                <?php }
                }?>
              </select>
            </div>
          </div>
                      <div class="col-md-2">
                        <div class="form-group">
                         <label for="bdaymonth">Select Month :</label>
                         <input type="month" class="form-control" name="month" id="month" value=""   required autocomplete="off">
                        </div>
                      </div>
                      <input class="btn btn-success" type="submit" style="margin-top: 25px;" name="" id="search" value="Search" formaction="<?php echo base_url(); ?>index.php/Salescontrol/dailysalesreport">
                         </div>        
<input type="text" class="form-control" id="myInput" value="" name="" placeholder="Search by invoiceno">

<div class="row margin" style="text-align: right;">
 <b> Advance in Hand :<?php echo $advanceinhand->result_array()[0]['advanceinhand']; ?> </b>
<button style="margin-left: 60px;" onclick="exportTableToExcel('salestable', 'Daily Sales ')">Export To  Excel File</button>
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
                    <th class="">SL No</th>
                    <th >Date</th>
                    <th style="">Bills</th>
                    <th style="">Gross Sales</th>
                    <th style="">Discount</th>
                     <th style="">Refund</th>
                    <th>Net Sales</th>
                    <th>Total Cash</th>
                    <th>Total Bank</th>
                    <th>Total Paid Advance</th>
                    <th>Cost Of Sales</th>
                    <th>Total Profit</th>
                    <th>Total Qty</th>
                    <th>Branch</th>
                  </tr>
                  <tbody id="new">
                  <?php $i =1;
                  foreach ($master->result() as $key) {
                    ?>
                    <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $key->Dateonly;?></td>
                    <td><?php echo $key->no;?></td>
                     <td><?php echo $key->total;?></td>
                    <td><?php echo $key->discount;?></td>
                     <td><?php echo $key->netReturn;?></td>
                    <td><?php echo $key->netsales - $key->netReturn;?></td>
                    <td><?php echo $key->cash;?></td>
                    <td><?php echo $key->bank;?></td>
                    <td><?php echo $key->paidadvance;?></td>
                    <td><?php echo $key->cost - $key->stockReturn;?></td>
                    <td><?php echo $key->profit - ($key->netReturn - $key->stockReturn);?></td>
                    <td><?php echo $key->qty;?></td>
                    <td><?php echo $key->branchname;?></td>
                  </tr>
                      <?php $i++;}?>
                      </tbody>

                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><?php echo($sum_total); ?></th>
                        <th><?php echo($sum_discount); ?></th>
                        <th><?php echo($sum_netReturn); ?></th>
                        <th><?php echo($sum_netSales); ?></th>
                        <th><?php echo($sum_cash); ?></th>
                        <th><?php echo($sum_bank); ?></th>
                        <th><?php echo($sum_paidAdvance); ?></th>
                        <th><?php echo($sum_cost); ?></th>
                        <th><?php echo($sum_profit); ?></th>
                        <th></th>
                        <th></th>
                        
                      </tr>
                 </table>
                </div>     
          </div>
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
  document.getElementById("fromdate").value=firstDay;
  document.getElementById("todate").value=lastDay;

  });
  </script>
