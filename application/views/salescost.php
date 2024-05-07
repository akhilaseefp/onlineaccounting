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
        Sales Cost
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Sales Cost</li>
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
        <div class="table">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="shp_tab">
                  <thead>
                  <tr>
                    <th style="">SL No</th>
                    <th style="">From Date</th>
                    <th class="">Branch</th>
                    <th>Cost Of Sales</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>

                    <?php   if($this->session->userdata('role')=="Branch User")
                    { ?>
                      

                    <?php }else{ ?>

                      <th style="">Payment</th>
                      <th style=""></th>
                      

                    <?php } ?>


                  </tr>
                  </thead>
                    <tbody id="shp_tab1">
                    </tbody>
                 </table>
                 <b>Total Cost:<span id="totcost"></b></span>
                 <br>
                 <b>Total Paid Amount:<span id="totamount"></b></span>
                 <br>
                 <b>Total Return Stock Amount:<span id="totretamount"></b></span>
                 <br>
                 <b>Total Balance:<span id="totbal"></b></span>
                </div> 
                <button onclick="exportTableToExcel('shp_tab', 'Employee Register')">Export To  Excel File</button>
                  <script type="text/javascript">
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/salescost.ms-excel';
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
    </section>
    </div>

    <script type="text/javascript">
      var ctr = 1;
          $(document).ready(function () {

            

            $('#btngo').click(function () { 
              var table = document.getElementById("shp_tab1");

            var roll='<?php echo $this->session->userdata('role');?>';

for(var i = table.rows.length - 1; i > -1; i--)
{
    table.deleteRow(i);
}

			        ctr++;
              var branch = document.getElementById("branch").value;
						  var fdate = document.getElementById("fdate").value;
						  var tdate = document.getElementById("tdate").value;
              try{
                $.ajax({
                  type: "POST",
                  dataType: 'json',
                  url: "<?php echo base_url(); ?>index.php/Onlinecontrol/getsalescost",
                  data: {
                    'branch': branch,
                    'fdate': fdate,
                    'tdate': tdate
                  },
                  success: function (result) { 

                    var totalCostPaY1=0;
                    var totalPaidamount=0;
                    var totalBalance=0;
                    
                 
                    for (i=0;i<result['res1'].length;i++){
                               
                    var saleDate1 = result['res1'][i]['Dateonly'];                    
                    var branchName1 = result['res1'][i]['branchname'];                    
                    // var costPay1 = result['res1'][i]['stocksum']; 
                    var coststock = result['res1'][i]['stocksum']; 
                    var totretamount = result['res1'][i]['returnTotalCost'];
                    // alert(coststock);
                    // alert(totretamount);


                    var costPay1 =  coststock - totretamount; 

                    // alert(costPay1);

                    totalCostPaY1=totalCostPaY1+costPay1*1;
                    var paidamount = result['res1'][i]['paidamount']; 
                    totalPaidamount=totalPaidamount+paidamount*1;
                    
                    // totalReturnAmount=totalReturnAmount+totretamount*1;
                    totalBalance=totalCostPaY1-totalPaidamount-totretamount;
                     if(paidamount==null){
                      paidamount=0;
                     }            
                    var paid1 = 0;                   
                    var balance1 = costPay1-paidamount;

                    var tr = "tr" + ctr;
                    var saledate = "saledate" + ctr;
                    var branch = "branchname" + ctr;
                    var cost = "cost" + ctr;
                    var alpaid = "alpaid" + ctr;
                    var albalance = "albalance" + ctr;
                    var payment = "payment" + ctr;
                    var btnsub = "btnsub" + ctr;
                    var rowCount = document.getElementById('shp_tab1').rows.length + 1; 

                    if (roll == 'Branch User') {

                      var newTr = '<tr><td>' + (i*1+1) +'</td><td style="width:200px;"><input type="text" class="form-control clssaledate" disabled name="saledate" id="'+saledate+'"  value="'+saleDate1+'"/></td><td style="width:150px;"><input type="text" class="form-control" disabled name="branchname" id="'+branch+'"  value="'+branchName1+'"/></td><td style="width:150px;"><input type="text" class="form-control clscost" disabled name="cost" id="'+cost+'"  value="'+costPay1+'"/></td><td style="width:150px;"><input type="text" class="form-control" disabled name="alpaid" id="'+alpaid+'"  value="'+paidamount+'"/></td><td style="width:150px;"><input type="text" class="form-control" disabled name="albalance" id="'+albalance+'"  value="'+balance1+'"/></td> </tr>';


                    }else{

                      var newTr = '<tr><td>' + (i*1+1) +'</td><td style="width:200px;"><input type="text" class="form-control clssaledate" disabled name="saledate" id="'+saledate+'"  value="'+saleDate1+'"/></td><td style="width:150px;"><input type="text" class="form-control" disabled name="branchname" id="'+branch+'"  value="'+branchName1+'"/></td><td style="width:150px;"><input type="text" class="form-control clscost" disabled name="cost" id="'+cost+'"  value="'+costPay1+'"/></td><td style="width:150px;"><input type="text" class="form-control" disabled name="alpaid" id="'+alpaid+'"  value="'+paidamount+'"/></td><td style="width:150px;"><input type="text" class="form-control" disabled name="albalance" id="'+albalance+'"  value="'+balance1+'"/></td><td style="width:150px;"><input type="text" class="form-control clspayment" value="0" name="payment" id="'+payment+'"/></td><td style="width:50px;"><input type="submit" class="btn btn-success btnsub" value="Submit" name="btnsub" id="'+btnsub+'"/></td></tr>';

                    }


                    
                    $('#shp_tab').append(newTr);
                    ctr++;
                    }

                    totalCostPaY1=totalCostPaY1.toFixed(2);
                    document.getElementById("totcost").innerHTML = totalCostPaY1;
                    totalPaidamount=totalPaidamount.toFixed(2);
                    document.getElementById("totamount").innerHTML = totalPaidamount;
                    totalBalance=totalBalance.toFixed(2);
                    document.getElementById("totbal").innerHTML = totalBalance;
                    // totalReturnAmount=totalReturnAmount.toFixed(2);
                    document.getElementById("totretamount").innerHTML = totretamount;

                    

                  },
                  error: function () {

                    alert('Error occur...!!');

                    }
                  });
                } catch (err) {
                  alert(err.message);
                }
              });


          $('#shp_tab').on('click','.btnsub', function () {


            var payment=$(this).closest("tr").find ('.clspayment').val();
            var cost=$(this).closest("tr").find ('.clscost').val();
						var branch = document.getElementById("branch").value;
						var currentdate = document.getElementById("currentdate").value;
						var saledate = $(this).closest("tr").find ('.clssaledate').val();
            var balance=cost-payment;
            // $.noConflict();
            try {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Onlinecontrol/upd_salescost",
                  data: {
                    'branch': branch,
                    'currentdate': currentdate,
                    'saledate': saledate,
                    'cost': cost,
                    'payment': payment,
                    'balance': balance
                  },
                  success: function (data) 
                  {
                    alert("Paid Succesfully...!");
              			$('alpaid').val(payment);
              			$('albalance').val(balance);
              			$('payment').val();
                  },
                   error: function (request, status, error) {
        alert("error");

    }
             
            });

            }
              catch (err) {
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