
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
<h1>Sales Return Report</h1>
<hr>
         
           
      
               <!-- Nav pills -->
              
               <div class="connected-line"></div>
                  <div id="organizer-details" class="container tab-pane active">
                    <form class="seminor-login-form" method="post">

                      <div class="row col-md-12">

                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">From  Date</label>
                           <input type="date" class="form-control" name="fromdate" id="fromdate"  required autocomplete="off">
                         </div>
                       </div>

                      <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">To  Date</label>
                           <input type="date" class="form-control" name="todate" id="todate"  required autocomplete="off">
                         </div>  
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-control-placeholder" for="contact-person">Branch Name</label>
                          <select  class="form-control" name="branchname" id="branchname">
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
      
      
      <div class="subdiv table-responsive" style="height:300px !important" id="startprint">
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
                     <th>TaxAmount</th> 
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                      <?php 
                      $n=1; 
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
                                 <td class="tax-amount"><?php echo $row->taxamount;
                                 ?></td>
                                 
                              </tr>
                              <?php  $n++;
                              
                                 
                            }?>    
                    </tbody>
                 </table>

                </div> 

                
                 <!--  <div class="offset-md-6">
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
                  </div> -->

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




