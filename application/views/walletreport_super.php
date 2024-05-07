            <script src="<?php echo base_url();?>js/jquery1.js"></script>

<script>
$(document).ready(function(){
  $("#myInput").on("click", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script type="text/javascript">
 window.onload=function(){
  document.getElementById("month").value ="<?php echo date('Y-m'); ?>";

}
</script> 




<div class="content-wrapper">
   <section class="content-header">
      <h1>
        WALLET BALANCE
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">WALLET BALANCE</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">

       <form class="seminor-login-form" method="post">

                        <div class="row col-md-12">

                          <div class="col-md-3">
                            <label>Branch</label>
                            <select  class="form-control"  required name="branch" id="branch">
                              <?php
                              foreach ($branch->result() as $branch) { ?>

                                <?php if($branch->branchid==$branchid){?>

                                 <option value="<?php echo $branch->branchid;?>" selected readonly><?php echo $branch->branchname; ?></option>

                               <?php }
                               else{?>

                                <option value="<?php echo $branch->branchid;?>"><?php echo $branch->branchname; ?></option>

                              <?php }
                            }?>
                          </select>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                             <label for="bdaymonth">Select Month :</label>
                             <input type="month" class="form-control" name="month" id="month" value=""   required autocomplete="off">
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

                         <div class="col-md-3">
                           <label>Date From :</label>
                           <input type="date" name="fromdate" id="fromdate" class="form-control" value="<?php echo $fromdate; ?>" >
                         </div>
                         <div class="col-md-3">
                           <label>Date To :</label>
                           <input type="date" name="todate" id="todate" class="form-control" value="<?php echo $todate; ?>" >
                         </div>

                         <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                             <div class="form-group">
                               <input class="b1" class="" type="submit" name="btnsearch" value="Search" id="btnsearch" style="margin-top: 17px;">
                             </div> 
                          </div>


                     </div>
                   </form>


     <h1 style="color: blue; text-align: center;" >WALLET BALANCE</h1>


     <?php foreach ($supplier->result() as $br)
     { ?>

       <h4 style="color: grey; text-align: center;" > BALANCE IS: <b> <?php echo $br->currentbalance*-1;?> </b></h4>

       <?php
     } ?>

   <!--   <?php

      $ttl_debit = 0;
      $ttl_credit = 0;
     foreach ($ledger->result() as $pt) {
      ?>
                      <?php $ttl_debit+=$pt->debitt; ?>
                      <?php  $ttl_credit +=$pt->creditt; ?>


      <?php }  ?>

                      <?php echo $ttl_debit; ?>
                      <?php echo $ttl_credit; ?> -->





     <div class="row" style="padding-top:50px;">
    
     <div class="col-md-12">
     
       <div class="table-responsive">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="incometable">
                    <thead>
                  <tr>
                    <th style="">SL NO</th>
                    <th style="">Date</th>
                    <th class="">Ledger Name</th>
                    <th class="">Refference No</th>
                    <th style="">Debit</th>
                    <th >Credit</th>


                  </tr>

                  </thead>
                  <tbody>


                   <?php
                   $n = 1;
                   $totaldebit=0;
                   $totalcredit=0; 
                   foreach ($ledger->result() as $pt) {
                    ?>
                    <tr>
                      <td><?php echo $n;?></td>
                      <td><?php echo $pt->date;?></td>
                      <td><?php echo $pt->type;?></td>
                      <td><?php echo $pt->reference;?></td>
                      <td><?php echo $pt->debit;  $totaldebit =$totaldebit+($pt->debit); ?></td>
                      <td><?php echo $pt->credit;  $totalcredit =$totalcredit+($pt->credit); ?></td>

                    </tr>
                    <?php
                    $n++;
                  }    
                  ?>

                  <tr style="background-color: #a0d4d9;">
                    <td></td>
                    <td>TOTAL</td>
                    <td></td>
                    <td></td>
                    <td><strong><?php echo $totaldebit ; ?></strong></td>
                    <td><strong><?php echo $totalcredit ; ?></strong></td>
                  </tr>
            
          
                  </tbody>

                 </table>

                </div>  <button onclick="exportTableToExcel('incometable', 'Trial Balance ')">Export To  Excel File</button>
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
            <div class="row" style="padding-top:20px; display: none;">
                    <div class="col-md-6">
                        <label>Total Debit :  <?php echo $totaldebit;?> </label>
                        <br/>
                        <label>Total Credit :  <?php echo $totalcredit;?> </label>
                    </div>
                    
            </div>    
    </div>
  </div>
  </section>
  </div>
              


             

  