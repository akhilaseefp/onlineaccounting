
            <!--Export to pdf-->
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
            <!--Export to pdf-->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
           <script type="text/javascript">
  $(document).ready(function() {
    $("#searchby").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            
      });
      });
    });
 
</script>

<!-- <script type="text/javascript">
  $(document).ready(function() { 
    $("#branch").on("change", function() {
      var value = document.getElementById("branch").options[document.getElementById("branch").selectedIndex].text;
      alert(value)
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        
      });
    });
  });
</script> -->
           
            <div class="content-wrapper">
   <section class="content-header">
      <h1 style="">
        Stock Report By Group
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Stock Report By Group</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">

          <div class="row">
            <div class="container-fluid">

              <table border="1" class="table table-hover">
                <thead>
                 <tr>
                   <th>Price Range</th>
                   <th>Design Count</th>
                   <th>Stock Count</th>
                   <th>View</th>
                 </tr>
               </thead>

               <tbody id= "myTable">
                <tr>
                  <td>Below 2000</td>
                  <td><?php echo $n_cont;?></td>

                  <td><?php echo $cur_stock;?></td>
                  <!-- <td><?php echo $sz_cont;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_below2t?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>


                <tr>
                  <td>2000 - 2500</td>
                  <td><?php echo $n_cont2_5;?></td>
                  <td><?php echo $cur_stock2_5;?></td>
                  <!-- <td><?php echo $sz_cont2_5;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_2t2_5?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>


                <tr>
                  <td>2500 - 3000</td>
                  <td><?php echo $n_contt3;?></td>
                  <td><?php echo $cur_stockt3;?></td>
                  <!-- <td><?php echo $sz_contt3;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_2_5t3?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>


                <tr>
                  <td>3000-3500</td>
                  <td><?php echo $n3_5;?></td>
                  <td><?php echo $cur_stockt3_5;?></td>
                  <!-- <td><?php echo $sz_contt3_5;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_3t3_5?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>


                <tr>
                  <td>3500 - 4000</td>
                  <td><?php echo $n_contt4t;?></td>
                  <td><?php echo $cur_stockt4t;?></td>
                  <!-- <td><?php echo $sz_contt4t;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_3_5t4?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>

                <tr>
                  <td>4000 - 4500</td>
                  <td><?php echo $n_contt4_5;?></td>
                  <td><?php echo $cur_stockt4_5;?></td>
                  <!-- <td><?php echo $sz_contt4_5;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_4t4_5?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>

                <tr>
                  <td>4500 - 5000</td>
                  <td><?php echo $n_contt5t;?></td>
                  <td><?php echo $cur_stockt5t;?></td>
                  <!-- <td><?php echo $sz_contt5t;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_4_5t5?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>

                <tr>
                  <td>Above 5000</td>
                  <td><?php echo $n_contt5abv;?></td>
                  <td><?php echo $cur_stockt5abv;?></td>
                  <!-- <td><?php echo $sz_contt5abv;?></td> -->
                  <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/StockReport_group_all_above5t?groupid=<?php echo $groupid;?>&branch=<?php echo($branchid); ?>"><button class="btn-success">View</button></a></td>
                </tr>

                

               </tbody>
             </table>

         </div>
         </div>

         
          

  <form method="post">
    <div class="container-fluid">
      <div class="hed"><h1>Stock Report</h1></div>
      <hr>
    
      <div class="subdiv table-responsive" style="margin: 10px;" id="startprint">

        <table style="width: 100% !important;" border="1" class="table table-hover" id="StockReport_table">
          <thead>
           <tr>
            <th >Sl No</th>
            <th style="display: none;">Product id</th>
            <th >Product name</th>
            <th >Product code</th>
            <th>Product Group</th> 
            <th >Brand</th>
            <th >Unit</th>
            <th >Minimum Stock</th>
            <th>Current Stock</th>
            <th>Branch</th>
            <th>Size</th>
            <th>Batch</th>
            <th>purchase amnt</th>
            <th>Stock Cost Amount</th>
          </tr>
        </thead>
        <tbody id= "myTable">
          <?php 
          $n=1; 
          foreach($Stockdetails->result() as $row)
           { ?>
            <tr >
              <td><a><?php echo $n;?></a></td>
              <td style="display: none;"><?php echo $row->pdt_id;
              ?></td>
              <td><?php echo $row->pdt_name;
              ?></td>
              <td><?php echo $row->pdt_code;
              ?></td>
              <td><?php echo $row->groupname;
              ?></td>

              <td><?php echo $row->brandname;
              ?></td>

              <td><?php echo $row->unitname;
              ?></td>
              <td><?php echo $row->minimumstock;
              ?></td>
              <td><?php echo $row->currentstock;
              ?></td>
              <td class="class"><?php echo $row->branchname;
              ?></td>
              <td><?php echo $row->sizevalue;
              ?></td>
              <td><?php echo $row->batchname;
              ?></td>
              <td><?php echo $row->purchaserate;
              ?></td>
              <td><?php echo $row->purchaserate * $row->currentstock;
              ?></td>
            </tr>
            <?php  $n++;


          }?>  

        </tbody>
      </table>

    </div>


     <div id="editor"></div>

      <div class="row  form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);padding: 10px;">
                      
        <div class="" style="text-align: center;">

          <input class="btn btnormal2" type="submit" name="btnprint" value="Print" id="btnprint" style="margin-left: 27px;" onclick="printdiv('startprint')">

          <input class="btn btnormal2" type="submit" name="btnexport" value="Export to pdf" id="btnexport" style="margin-left: 27px;" onclick="Export()">

          <button onclick="exportTableToExcel('StockReport_table', 'Stock Report')">Export To Excel File</button>

        </div>
      </div> 
    </div>
  </form>  
   </div>


 <div class="container-fluid">
<!-- <div id="chartContainer" style="height: 370px; width: 100%;"></div>
<button class="btn invisible" id="backButton">&lt; Back</button> -->
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
 </div>        
</section>
</div>

<script type="text/javascript">


 var clear = document.getElementById('btncancel');   
 clear.onclick=function()
 {
  document.getElementById("fromdate").value = "";
  document.getElementById("todate").value = "";
  document.getElementById("searchby").value = "";


} 


</script>

  <!--Print-->
            <script type="text/javascript">
              function printdiv(divname)
              { var originalContents=document.body.innerHTML;
                var printcontents=" <h1 style='text-align: center;'>Stock Report</h1>"+ document.getElementById(divname).innerHTML;
                document.body.innerHTML = printcontents;
                window.print();
                document.body.innerHTML = originalContents;
              }

              function printdivv(divname)
              { var originalContents=document.body.innerHTML;
                var printcontents=" <h1 style='text-align: center;'>All Stock Report</h1>"+ document.getElementById(divname).innerHTML;
                document.body.innerHTML = printcontents;
                window.print();
                document.body.innerHTML = originalContents;
              }
            </script>

            <!--Export to pdf-->
             <!-- <script type="text/javascript">
              function Export() {
                  html2canvas(document.getElementById('StockReport_table'), {
                      onrendered: function (canvas) {
                          var data = canvas.toDataURL();
                          var docDefinition = {
                              content: [{
                                  image: data,
                                  width: 500
                              }]
                          };
                          pdfMake.createPdf(docDefinition).download("PurchaseReport.pdf");
                      }
                  });
              }
          </script> -->

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

        function exportTableToExcell(tableID, filename = ''){
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
            <script type="text/javascript">
             
             
             function Export() {



                  var cache_width = $('#renderPDF').width(); //Criado um cache do CSS
    var a4 = [595.28, 841.89]; // Widht e Height de uma folha a4
    $("#StockReport_table").width((a4[0] * 1.33333) - 80).css('max-width', 'none');

        // Aqui ele cria a imagem e cria o pdf
        html2canvas($('#StockReport_table'), {
          onrendered: function (canvas) {
            var img = canvas.toDataURL("image/jpeg", 1.0);
                var doc = new jsPDF({ unit: 'px', format: 'a4' });//this line error
                var doc = new jsPDF('landscape'); alert();// default is portrait
                doc.setFontSize(22);
                doc.setFillColor(255, 255, 255);
                doc.setDrawColor(0,0, 0);
                doc.text(100, 20, 'Stock Report');
                doc.addImage(img, 'JPEG', 30, 40);

                doc.save('Stock Report.pdf');
                //Retorna ao CSS normal
                $('#StockReport_table').width(cache_width);
              }
            });
      }
                    
          </script>

         

     
     <?php
 
$totalVisitors = 883000;
 
$newVsReturningVisitorsDataPoints = array(
  array("y"=> 519960, "name"=> "New Visitors", "color"=> "#E7823A"),
  array("y"=> 363040, "name"=> "Returning Visitors", "color"=> "#546BC1")
);
 
$newVisitorsDataPoints = array(
  array("x"=> 1420050600000 , "y"=> 33000),
  array("x"=> 1422729000000 , "y"=> 35960),
  array("x"=> 1425148200000 , "y"=> 42160),
  array("x"=> 1427826600000 , "y"=> 42240),
  array("x"=> 1430418600000 , "y"=> 43200),
  array("x"=> 1433097000000 , "y"=> 40600),
  array("x"=> 1435689000000 , "y"=> 42560),
  array("x"=> 1438367400000 , "y"=> 44280),
  array("x"=> 1441045800000 , "y"=> 44800),
  array("x"=> 1443637800000 , "y"=> 48720),
  array("x"=> 1446316200000 , "y"=> 50840),
  array("x"=> 1448908200000 , "y"=> 51600)
);
 
$returningVisitorsDataPoints = array(
  array("x"=> 1420050600000 , "y"=> 22000),
  array("x"=> 1422729000000 , "y"=> 26040),
  array("x"=> 1425148200000 , "y"=> 25840),
  array("x"=> 1427826600000 , "y"=> 23760),
  array("x"=> 1430418600000 , "y"=> 28800),
  array("x"=> 1433097000000 , "y"=> 29400),
  array("x"=> 1435689000000 , "y"=> 33440),
  array("x"=> 1438367400000 , "y"=> 37720),
  array("x"=> 1441045800000 , "y"=> 35200),
  array("x"=> 1443637800000 , "y"=> 35280),
  array("x"=> 1446316200000 , "y"=> 31160),
  array("x"=> 1448908200000 , "y"=> 34400)
);
 
?>

<script>
window.onload = function () {
 
var totalVisitors = <?php echo $totalVisitors ?>;
var visitorsData = {
  "New vs Returning Visitors": [{
    click: visitorsChartDrilldownHandler,
    cursor: "pointer",
    explodeOnClick: false,
    innerRadius: "75%",
    legendMarkerType: "square",
    name: "New vs Returning Visitors",
    radius: "100%",
    showInLegend: true,
    startAngle: 90,
    type: "doughnut",
    dataPoints: <?php echo json_encode($newVsReturningVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
  }],
  "New Visitors": [{
    color: "#E7823A",
    name: "New Visitors",
    type: "column",
    xValueType: "dateTime",
    dataPoints: <?php echo json_encode($newVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
  }],
  "Returning Visitors": [{
    color: "#546BC1",
    name: "Returning Visitors",
    type: "column",
    xValueType: "dateTime",
    dataPoints: <?php echo json_encode($returningVisitorsDataPoints, JSON_NUMERIC_CHECK); ?>
  }]
};
 
var newVSReturningVisitorsOptions = {
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "New VS Returning Visitors"
  },
  subtitles: [{
    text: "Click on Any Segment to Drilldown",
    backgroundColor: "#2eacd1",
    fontSize: 16,
    fontColor: "white",
    padding: 5
  }],
  legend: {
    fontFamily: "calibri",
    fontSize: 14,
    itemTextFormatter: function (e) {
      return e.dataPoint.name + ": " + Math.round(e.dataPoint.y / totalVisitors * 100) + "%";  
    }
  },
  data: []
};
 
var visitorsDrilldownedChartOptions = {
  animationEnabled: true,
  theme: "light2",
  axisX: {
    labelFontColor: "#717171",
    lineColor: "#a2a2a2",
    tickColor: "#a2a2a2"
  },
  axisY: {
    gridThickness: 0,
    includeZero: false,
    labelFontColor: "#717171",
    lineColor: "#a2a2a2",
    tickColor: "#a2a2a2",
    lineThickness: 1
  },
  data: []
};
 
var chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
chart.options.data = visitorsData["New vs Returning Visitors"];
chart.render();
 
function visitorsChartDrilldownHandler(e) {
  chart = new CanvasJS.Chart("chartContainer", visitorsDrilldownedChartOptions);
  chart.options.data = visitorsData[e.dataPoint.name];
  chart.options.title = { text: e.dataPoint.name }
  chart.render();
  $("#backButton").toggleClass("invisible");
}
 
$("#backButton").click(function() { 
  $(this).toggleClass("invisible");
  chart = new CanvasJS.Chart("chartContainer", newVSReturningVisitorsOptions);
  chart.options.data = visitorsData["New vs Returning Visitors"];
  chart.render();
});
 
}
</script>


  

</div>