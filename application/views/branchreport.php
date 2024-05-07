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
      BRANCH REPORT
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"> BRANCH REPORT</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">
     <div class="row">
     <div class="col-md-3">
     <label>Date From :</label>
     <input type="date" name="fdate" id="fdate" class="form-control" value="<?php echo $fromdate; ?>" >
     </div>
     <div class="col-md-3">
     <label>Date To :</label>
     <input type="date" name="tdate" id="tdate" class="form-control" value="<?php echo $todate; ?>" >
     </div>
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
    <div class="col-md-3">
						<div style="display: none;" class="form-group">
							<label class="form-control-placeholder" for="contact-person">Sales date</label>
							<input type="datetime" class="form-control" disabled id="currentdate" value="<?php $d=strtotime("now");$e=strtotime("-7 hours",$d); echo date("Y-m-d H:i:s",$e);?>" name="currentdate">
						</div>
					</div>
     </div>
     <div class="row" style="margin-top:25px;">
            <div class="col-md-12">
                <input class="btn btn-success btngo" type="submit" name="btngo" id="btngo" value="Go">
            </div>
        </div>
        <div class="row" style="padding-top:50px;">
      <div class="col-md-12">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">

        <div class="table tdtd">
                  <table style="width:70%;" border="1" class="table table-striped table-hover" id="expense">
                  <thead>
                  <tr>
                    <th colspan="3" style="text-align: center; background-color: #b5abab;"> MONTHLY REPORT</th>
                    
                  </tr>
                  </thead>
                    <tbody id="">
                    <tr style="background-color: #b5abab;">
                      <td style="width: 270px;"><strong>TOTAL COLLECTION</strong></td>
                      <td></td>
                      <td style="font-weight: 900;" id="totalAmount"></td>
                    </tr>

                    <tr style="background-color: #d5cabb;">
                      <td>Cash (+)</td>
                      <td id="totalCash"></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: #d5cabb;">
                      <td>Card (+)</td>
                      <td id="totalBank"></td>
                      <td ></td>
                    </tr>


                    <tr style="background-color: #d5cabb;">
                      <td>Paid Advance (+)</td>
                      <td id="totalAdvance"></td>
                      <td></td>
                    </tr>

                    <tr style="background-color: #d5cabb;">
                      <td>Refund (-)</td>
                      <td id="totalRefund"></td>
                      <td></td>
                    </tr>
                    
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: #b5abab;">
                      <td><strong>COST PAYABLE</strong></td>
                      <td id="totalCost"></td>
                      <td id="totalCost2"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: #b5abab;">
                      <td ><strong>GROSS PROFIT</strong></td>
                      <td></td>
                      <td id="grossProfit"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: #b5abab;">
                      <td ><strong>MONTHLY EXPENCE</strong></td>
                      <td id="monthlyExp"></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="background-color: #b5abab;">
                      <td ><strong>NET PROFIT</strong></td>
                      <td></td>
                      <td id="netProfit"></td>
                    </tr>
                  </tbody>
                </table>

                 <button class="btn btn-success" onclick="exportTableToExcel('expense', 'Profit and loss')">Export To  Excel File</button>
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
                <div class="col-md-2">
      </div> 




              </div>
            </div>
     <div class="row" style="padding-top:50px;">
      <div class="col-md-12">
        <div class="table">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="shp_tab">
                  <thead>
                  <tr>
                    <th style="">SL No</th>
                    <th style="">Date</th>
                    <!-- <th class="">Branch</th> -->
                    <th style="">Expense account</th>
                    <!-- <th style="">Against</th> -->
                    <th>Expense Debit</th>
                    <th>Expense Credit</th>
                    <th>Balance</th>
                    
                  </tr>
                  </thead>
                    <tbody id="shp_tab1">
                      
                    </tbody>
                 </table>
                 <button class="btn btn-success" onclick="exportTableToExcel('shp_tab', 'Expense Register')">Export To  Excel File</button>
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
						  var fdate = document.getElementById("fdate").value;
						  var tdate = document.getElementById("tdate").value;
              try{
                $.ajax({
                  type: "POST",
                  dataType: 'json',
                  url: "<?php echo base_url(); ?>index.php/Onlinecontrol/getbranchreport",
                  data: {
                    'branch': branch,
                    'fdate': fdate,
                    'tdate': tdate
                  },
                  success: function (result) { 
                    // alert(result['res2'][0]['totalCash']);

                    var paidAdvance=result['res2'][0]['totalAdvance'];
                    document.getElementById("totalAdvance").innerHTML = paidAdvance*-1;

                    var totalCash=result['res2'][0]['totalCash'];
                    document.getElementById("totalCash").innerHTML = totalCash;
                    var totalBank=result['res2'][0]['totalBank'];
                    document.getElementById("totalBank").innerHTML = totalBank;

                    var netReturn=result['res4'][0]['netReturn'];
                    document.getElementById("totalRefund").innerHTML = netReturn;

                    // var totalAmount=totalCash+totalBank;
                    var totalAmount = (totalCash*1) + (totalBank*1) - (paidAdvance) - (netReturn);
                    document.getElementById("totalAmount").innerHTML = totalAmount;
                    var totalCost=result['res2'][0]['totalCost']-result['res4'][0]['returnTotalCost'];
                    document.getElementById("totalCost").innerHTML = totalCost;
                    document.getElementById("totalCost2").innerHTML = totalCost;
                    var grossProfit=totalAmount-totalCost;
                    document.getElementById("grossProfit").innerHTML = grossProfit.toFixed(2);
                    var monthlyExp=result['res3'][0]['newBalance'];
                    document.getElementById("monthlyExp").innerHTML = monthlyExp;
                    var netProfit=grossProfit-monthlyExp;
                    document.getElementById("netProfit").innerHTML = netProfit.toFixed(2);
                 
                    for (i=0;i<result['res1'].length;i++)
                    { 
                      var date = result['res1'][i]['date'];                    
                        // var branchName1 = result['res1'][i]['branchname']; 
                        var ledgername = result['res1'][i]['ledgernames']; 
                        var opposite = result['res1'][i]['oppositename'];                    
                        var debit = result['res1'][i]['debit']; 
                        var credit = result['res1'][i]['credit']; 
                        var balance = result['res1'][i]['balance'];
                        var newTr = '<tr><td>' + (i*1+1) +'</td><td>'+date+'</td><td>'+ledgername+'</td><td>'+debit+'</td><td>'+credit+'</td><td>'+balance+'</td></tr>';
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
        document.getElementById("month").value ="<?php echo date('Y-m', strtotime(date('Y-m')." -1 month")); ?>";
        
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