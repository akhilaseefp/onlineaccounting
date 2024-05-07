<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<div class="content-wrapper">
   <section class="content-header">
      <h1>
        eCommerce Order USD
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">eCommerce Order USD</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">
      <form class="seminor-login-form" method="post">
     <div class="row">

          <div class="col-md-3">
            <div class="form-group">
             <label for="bdaymonth">Select Month :</label>
             <input type="month" class="form-control" name="month" id="month" value="" required autocomplete="off">
            </div>
          </div>

					<div class="col-md-4">
          <label>Date From :</label>
						<input type="date" name="fdate" id="fdate" class="form-control" value="<?php echo $fdate; ?>" required autocomplete="off">
          </div>
          
          <div class="col-md-4">
            <label>Date To :</label>
						<input type="date" name="tdate" id="tdate" class="form-control" value="<?php echo $tdate; ?>" required autocomplete="off">
          </div>

          <div class="col-md-1" style="margin-top:25px;">
            <input class="btn btn-success" type="submit" name="btngo" id="btngo" value="Go" formaction="<?php echo base_url(); ?>index.php/Esalescontrol/eCommerceusd">
          </div>
     </div>
     <div class="row">
          <div class="col-md-5">
          <div class="form-group"> <label>Search :</label>
              <input type="text" id="searchproduct" name="searchproduct" class="form-control" autocomplete="off">
          </div>
          <div class="col-md-7">

          </div>
     </div>
     
     </form>
     <div class="row" style="padding-top:50px;">
      <div class="col-md-12">
        <div class="table" style="overflow: auto;" >
          <button onclick="exportTableToExcel('shp_tab', 'Ecom Orders')">Export To Excel File</button>
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
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="shp_tab">
                    <thead>
                  <tr>
                    <!-- <th class="">Sl order/th> -->
                    <th style="">SL No</th>
                     <th style="">eCommerce No</th>
                     <th class="">Order No</th>
                     <th class="">Customer</th>             
                    <th class="">Sales Date</th>
                    <th >Delivery Date</th>                   
                    <th style="">Branch Name</th>
                    <th style="">qty</th>
                    <th style="">Image</th>
                     <th class="" style="">Narration</th>
                     <th style="">Amount</th>
                    <th class="">Cash Payment</th>
                    <th class="">bank Payment</th>
                    <th >Payment Mode</th>
                     <th></th>
                    
                    <!-- <th ></th> -->
                  </tr>
                  </thead>
                <tbody id="myTable">
                  <?php
                    $n=1;
                    foreach ($eorder->result() as $key) {
                    ?> 
                    <tr>
                    <td><?php echo $n;?></td>
                    <td style="display: none;"><?php echo $key->eCommerce_no;?></td>
                    <td><?php echo $key->eCommerce_no;?></td>
                    <td><?php echo $key->rzp_orderId;?></td>
                    <td><?php echo $key->customername;?></td>
                    <td style="display: none;"><?php echo $key->customerid;?></td>
                    <td><?php echo $key->date_current;?></td>
                    <td><?php echo $key->date_delivery;?></td>
                    <td><?php echo $key->branchname;?></td>
                    <td><?php echo $key->totalqty;?></td>
                    <td><a target="_blank" href="<?php echo base_url();?>shoporder/images/<?php echo $key->image_path;?>"><?php echo $key->image_path;?></a></td>
                    <td><?php echo $key->narration;?></td>
                    <td><?php echo $key->grandtotal;?></td>
                    <td><?php echo $key->cash_payment;?></td>
                    <td><?php echo $key->bank_payment;?></td>
                    <td>Bank</td>               
                     <td><a href="<?php echo base_url();?>index.php/Esalescontrol/eorder?masterid=<?php echo $key->eCommerce_id;?>&& custid=<?php echo $key->customerid;?>" target="_blank"><i class="fa fa-search"></i>&nbsp;&nbsp;View</a></td>
                  </tr>
                
                      <?php 
                      $n++;
                    }?>
                    </tbody>

                 </table>

                 
                </div>     
              </div>
            </div>
            </div>
    </section>
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
            document.getElementById("fdate").value=firstDay;
            document.getElementById("tdate").value=lastDay;

            });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#searchproduct").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

