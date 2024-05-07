
   <div id="content">
            <script src="<?php echo base_url();?>js/jquery1.js"></script>

            <!--Export to pdf-->
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
            <!--Export to pdf-->

<script type="text/javascript">
    $(document).ready(function(){
   $("#SearchUser").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>




      <div class="content-wrapper">
  <section class="content-header">
<h1>Sales Report</h1>

<hr>
         
           
      
               <!-- Nav pills -->
              
               <div class="connected-line"></div>
                  <div id="organizer-details" class="container tab-pane active">
                    <form class="seminor-login-form" method="post">

                      <div class="row col-md-12">

                        <div class="col-md-4">
                          <div class="form-group">
                           <label for="bdaymonth">Select Month :</label>
                           <input type="month" class="form-control" name="month" id="month" value=""   required autocomplete="off">
                         </div>
                       </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">From  Date</label>
                           <input type="date" class="form-control" name="fromdate" id="fromdate"  value="<?php echo $fromdate; ?>" required autocomplete="off">
                         </div>
                       </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">To  Date</label>
                           <input type="date" class="form-control" name="todate" id="todate"  value="<?php echo $todate; ?>" required autocomplete="off">
                         </div>  
                      </div>
                          
                      </div>

                      <?php if ($this->session->userdata('role')=="Branch User") { ?>

                     <?php }else{ ?>


                     


                      <div class="row col-md-12">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Search By</label>
                            <select  class="form-control"  name="searchby" id="searchby">
                              <option>All</option>
                              <option>Supplier-wise</option>
                              <option>Product-wise</option>
                              <option>Brand-wise</option>
                            </select>
                         </div>
                       </div>

                       <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Supplier Name</label>
                            <select  class="form-control" name="supplier" id="supplier">
                               <?php foreach ($supplier->result() as $br)
                              {
                                 ?>
                                 <option value="<?php echo $br->suppliername;?>"><?php echo $br->suppliername;?></option>

                                <?php
                               }
                               ?>
                            </select>
                         </div>
                       </div>

                      <!-- <div class="offset-md-6">
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
                      </div> -->

                      </div>

                      <div class="row col-md-12">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Product Name</label>
                            <select  class="form-control" name="productname" id="productname">
                               <?php foreach ($productname->result() as $br)
                              {
                                 ?>
                                 <option value="<?php echo $br->pdt_name;?>"><?php echo $br->pdt_name;?></option>

                                <?php
                               }
                               ?>
                            </select>
                         </div>
                       </div>

                       <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Brand Name</label>
                            <select  class="form-control" name="brandname" id="brandname">
                               <?php foreach ($brand->result() as $br)
                              {
                                 ?>
                                 <option value="<?php echo $br->brandid;?>"><?php echo $br->brandname;?></option>

                                <?php
                               }
                               ?>
                            </select>
                         </div>
                       </div>

                      </div>
     
     <?php  } ?>
                  
                  <div class="row col-md-12">
                    <div class="offset-md-6">
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
      <hr>
      
      
      <div class="subdiv table-responsive" style="" id="startprint">
                  <table style="width: 100% !important;" border="1" class="table table-hover" id="PurchaseReport_table">
                    <thead>
                  <tr>
                    <th >Sl No</th>
                    <th style="display: none;">Details id</th>
                    <th >Invoice No</th>
                     <th>Sales Date</th> 
                    <th >Product Name</th>
                     <th >Unit Price</th>
                    <th>Qty</th>
                     <th>Amount</th> 
                     <?php 
                     if($this->session->userdata('role')=="Branch User")
                      {}else{?>
                     <th>TaxAmount</th> <?php } ?>
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                      <?php 
                      $n=1; 

                      $unitttl = 0;
                      $qtyttl= 0;
                      $amntttl= 0;

                         foreach($SalesDetails->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td style="display: none;"><?php echo $row->purchasedetailsid;
                                 ?></td>
                                <td><?php echo $row->invoiceno;
                                 ?></td>
                                 <td><?php echo $row->salesdate;
                                 ?></td>
                                  <td><?php echo $row->productname;
                                 ?></td>
                                  
                                 <td><?php echo $row->unitprice;
                                 ?></td>
                                 <td><?php echo $row->qty;
                                 ?></td>
                                 <td class="net-amount"><?php echo $row->netamount;
                                 ?></td>
                                 <?php 
                                 if($this->session->userdata('role')=="Branch User")
                                  {}else{?>
                                   <td class="tax-amount"><?php echo $row->taxamount;
                                   ?></td>
                                 <?php } ?>
                                 
                              </tr>

                              <?php $unitttl += $row->unitprice; ?>
                              <?php $qtyttl += $row->qty; ?>
                              <?php $amntttl += $row->netamount; ?>

                              <?php  $n++;
                              
                                 
                            }?>   

                            <tr style="background-color: black;
    font-weight: 800;
    color: white;">
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><?php echo $unitttl; ?></td>
                              <td><?php echo $qtyttl; ?></td>
                              <td><?php echo $amntttl; ?></td>
                            </tr> 
                    </tbody>
                 </table>

                </div> 

                              
                              
                              


                <?php 
                if($this->session->userdata('role')=="Branch User")
                  {}else{?>
                
                  <div class="offset-md-6">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Taxable amount</label>
                           <input type="text" class="form-control" name="taxableamount" id="taxableamount"  autocomplete="off">
                         </div>
                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Total VAT paid</label>
                           <input type="text" class="form-control" name="totalvatpaid" id="totalvatpaid"  autocomplete="off">
                         </div> 
                         <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Total purchase amount</label>
                           <input type="text" class="form-control" name="totalpurchaseamount" id="totalpurchaseamount"  autocomplete="off">
                         </div> 
                  </div>

                <?php }?>

                   <div class="row col-md-12 form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);">
                      <div class="offset-md-4 offset-lg-4 offset-sm-4 offset-xs-4">
                          <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
                          
                          <input class="btn btnormal2" type="submit" name="btnprint" value="Print" id="btnprint" style="margin-left: 27px;" onclick="printdiv('startprint')">
                          <input class="btn btnormal2" type="submit" name="btnexport" value="Export to pdf" id="btnexport" style="margin-left: 27px;" onclick="Export()">
                          
                      </div>
                    </div> 

                 </form>  
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

              <!--calculation From grid-->
              <script language="javascript" type="text/javascript">
                var tds = document.getElementById('PurchaseReport_table').getElementsByTagName('td');
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
              {
                var printcontents=document.getElementById(divname).innerHTML;
                document.body.innerHTML = printcontents;
                window.print();
                document.body.innerHTML = originalContents;
              }
            </script>

            <!--Export to pdf-->
            <script type="text/javascript">
              function Export() {
                  html2canvas(document.getElementById('PurchaseReport_table'), {
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
   document.getElementById("fromdate").value=firstDay;
   document.getElementById("todate").value=lastDay;

 });
</script>
