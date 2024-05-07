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
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Trial Balance
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Trial Balance</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">
     <h1 style="color: blue; text-align: center;" >Trial Balance</h1>
     <h3 style="color:blue; text-align: center;"><?php if($fromdate==null){
       date_default_timezone_set('Asia/Kolkata');
     echo "AS OF ".date("Y-m-d H:i:s");
     }else{
      echo $fromdate." TO ".$todate;
     }



?></h3>
 <form method="post">
<div class="row">
       
        <div class="col-md-4">
          <p class="p1">From Date :</p>   
          <input type="date" class="form-control" name="fromdate" value="<?php echo $fromdate;?>">
        </div>
        <div class="col-md-4">
          <p class="p1">To Date :</p>
          <input type="date" class="form-control" name="todate" value="<?php echo $todate;?>">
        </div>
        <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                             <div class="form-group">
                               <input class="b1" class="" type="submit" name="btnsearch" value="Search" id="btnsearch" style="margin-top: 30px;margin-left: 0px !important;">
                             </div> 
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                               <input class="b1" class="" type="submit" name="btncancel" value="Clear" id="btncancel" style="margin-top: 30px;margin-left: 0px !important;">
                             </div> 
                          </div>
                        </div>
        </div>

      </div>
    </form>
     <div class="row" style="padding-top:50px;">
    
     <div class="col-md-12">
     
       <div class="table-responsive">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="incometable">
                    <thead>
                  <tr>
                    <th style="">SL NO</th>
                    <th class="">Ledger Name</th>
                    
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
                   <td><?php echo $pt->ledgername;?></td>
                   
                    <td><?php echo ($pt->debit); $totaldebit =$totaldebit+($pt->debit);?></td>
                     <td><?php echo ($pt->credit); $totalcredit =$totalcredit+($pt->credit);?></td>
                    
                     </tr>
              <?php
                $n++;
              }    
              ?>
            
          
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
            <div class="row" style="padding-top:20px;">
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
              

  