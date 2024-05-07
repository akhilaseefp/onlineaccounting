
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<script src="<?php echo base_url();?>js/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>


<!--Export to pdf-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<!--Export to pdf-->



<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Purchase Return Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Purchase Return Report</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
         <div class="row">
           
      
               <!-- Nav pills -->
              
               <div class="connected-line"></div>
                  <div id="organizer-details" class="container tab-pane active">
                    <form class="seminor-login-form" method="post">

                      <div class="row col-md-12">

                        <div class="col-md-3">
                        <div class="form-group">
                         <label for="bdaymonth">Select Month :</label>
                         <input type="month" class="form-control" name="month" id="month" value=""   required autocomplete="off">
                        </div>
                      </div>

                        <div class="col-md-3">
                         <label>Date From :</label>
                         <input type="date" name="fromdate" id="fromdate" class="form-control" value="<?php echo $fromdate; ?>" >
                       </div>
                       <div class="col-md-3">
                         <label>Date To :</label>
                         <input type="date" name="todate" id="todate" class="form-control" value="<?php echo $todate; ?>" >
                       </div>

                       <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Branch Name</label>
                            <select  class="form-control" name="branch" id="branch">
                               <?php foreach ($branch->result() as $br)
                              {
                                 ?>
                                 <option value="<?php echo $br->branchid;?>"><?php echo $br->branchname;?></option>

                                <?php
                               }
                               ?>
                            </select>
                         </div>
                       </div>


                          
                      </div>

                      <div class="row col-md-12">

                       


                      <div class="row col-md-12">

                       <div class="col-md-6">
                          <div class="row col-md-12 col-lg-12 col-sm-12 col-xs-12">
                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                             <div class="form-group">
                               <input class="b1" class="" type="submit" name="btnsearch" value="Search" id="btnsearch" style="margin-top: 17px;">
                             </div> 
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                               <input class="b1" class="" type="submit" name="btncancel" value="Cancel" id="btncancel" style="margin-top: 17px;">
                             </div> 
                          </div>
                        </div>
                       </div>

                          
                      </div>
     
     
                  </div>
                 </form>  
                  
         </div>
      </div>  
      <hr>
      
      
      <div class="subdiv table-responsive" style="overflow-x: none;" id="startprint">
        <table style="width: 100% !important;" border="1" class="table table-hover" id="Purchasetable">
                    <thead>
                      <tr>
                        <th >Sl No</th>
                        <th>Voucher No</th>
                        <th>Reference No</th>
                        <th>Invoice Date</th> 
                        <th>Qty</th>
                        <th>Amount</th> 
                        <th>View</th> 
                      </tr>
                    </thead>
                    <tbody id="myTable">

                       <?php 
                      $n=1; 
                         foreach($PurchaseReturnDetailsAll->result() as $row)
                             { ?>
                              <tr>
                                <td><?php echo $n;?></td>
                                <td><?php echo $row->voucherno; ?></td>
                                 <td><?php echo $row->vendorinvoiceno; ?></td>
                                 <td><?php echo $row->invoicedate; ?></td>
                                 <td><?php echo $row->totalqty; ?></td>
                                 <td class="net-amount"><?php echo $row->grandtotal;?></td>
                                <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/pur_return_branch?a=<?php echo $row->voucherno;?>"><button class="btn btn-success">View</button></a></td>
                                 
                              </tr>
                              <?php  $n++; }?> 
                    </tbody>
                 </table>

                </div> 
                <button class="btn btn-success" onclick="exportTableToExcel('Purchasetable', 'Purchase Report')">Export To  Excel File</button>


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

                
                  <div class="offset-md-6">

                    <?php

                    if($this->session->userdata('role')=="Branch User")
                    { 
                    }else{ ?>

                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Taxable amount</label>
                           <input type="text" class="form-control" name="taxableamount" id="taxableamount"  autocomplete="off">
                         </div>


                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Total VAT paid</label>
                           <input type="text" class="form-control" name="totalvatpaid" id="totalvatpaid"  autocomplete="off">
                         </div> 

                       
                         <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Total Purchase Amount</label>
                           <input type="text" class="form-control" name="totalpurchaseamount" id="totalpurchaseamount"  autocomplete="off">
                         </div> 
                         <?php } ?>
                         
                  </div>

                   <div class="row col-md-12 form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);">
                      <div class="offset-md-4 offset-lg-4 offset-sm-4 offset-xs-4">
                          <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
                          
                          <input class="btn btnormal2" type="submit" name="btnprint" value="Print" id="btnprint" style="margin-left: 27px;" onclick="printdiv('startprint')">
                          <!-- <input class="btn btnormal2" type="submit" name="btnexport" value="Export to pdf" id="btnexport" style="margin-left: 27px;" onclick="Export()"> -->





                          
                      </div>
                    </div> 

                <script type="text/javascript">
                
                 var clear = document.getElementById('btncancel');   
                 clear.onclick=function()
                 {
                  document.getElementById("fromdate").value = "";
                  document.getElementById("todate").value = "";
                  document.getElementById("supplier").value = "";
                  document.getElementById("taxableamount").value="0";
                  document.getElementById("totalvatpaid").value="0";
                  document.getElementById("totalpurchaseamount").value="0";

                } 
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
                 document.getElementById("fromdate").value=firstDay;
                 document.getElementById("todate").value=lastDay;

               });
             </script>




              <!--calculation From grid-->
              <script language="javascript" type="text/javascript">
                var tds = document.getElementById('Purchasetable').getElementsByTagName('td');
                var sum = 0;
                var tax=0;
                for(var i = 0; i < tds.length; i ++)
                {
                    if(tds[i].className == 'net-amount')
                    {
                        sum += isNaN(tds[i].innerHTML) ? 0 : parseInt(tds[i].innerHTML);
                    }
                    if(tds[i].className == 'tax-amount' && tds[i].innerHTML != '') 
                    {
                        tax += isNaN(tds[i].innerHTML) ? 0 : parseInt(tds[i].innerHTML);
                    }
                }
                
                document.getElementById('taxableamount').value += sum;
                document.getElementById('totalvatpaid').value += tax;
                document.getElementById('totalpurchaseamount').value += sum+ tax;
            </script>

            <!--Print-->
            <script type="text/javascript">
              function printdiv(divname)
              {  var originalContents=document.body.innerHTML;
                var printcontents=" <h1 style='text-align: center;'>Purchase Report</h1>"+document.getElementById(divname).innerHTML;
                document.body.innerHTML = printcontents;
                window.print();
                document.body.innerHTML = originalContents;
              }
            </script>

            <!--Export to pdf-->
            <script type="text/javascript">
              function Export() {
                  html2canvas(document.getElementById('Purchasetable'), {
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
          </script>
    </div>


