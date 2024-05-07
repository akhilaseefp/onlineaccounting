<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Receipt Voucher
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Receipt Voucher</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
              <form class="seminor-login-form" action="<?php echo base_url();?>index.php/Onlinecontrol/insert_receiptvoucher">
       <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Voucher No :</label>
                  <?php foreach ($voucherno->result() as $vno) {
                   
                  }
                  ?>
                  <input type="text" class="form-control" required autocomplete="off" value="<?php echo $vno->NO;?>" name="voucherno" id="voucherno">
                    <input type="text" class="form-control"  style="display: none;" name="receiptvoucherid" id="receiptvoucherid"  autocomplete="off">
                     <input type="text" class="form-control"  style="display: none;" name="customeraccount" id="customeraccount"  autocomplete="off">
                </div>
              </div>
               <div class="col-md-4">
                 <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Receipt Date :</label>
                  <input type="date" class="form-control"  name="receiptdate" id="receiptdate" value="<?php echo date("Y-m-d") ?>">
                 </div>
               </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Cash/Bank :</label>
                  <select  class="form-control" name="cashorbank" id="cashorbank">
                    <?php
                      foreach ($BankAndcashLedgers->result() as $ledgers) {
                      
                     ?>
                     <option value="<?php echo $ledgers->ledgerid; ?>"><?php echo $ledgers->ledgername; ?></option>
                   <?php } ?>
                  </select>
               </div>
       </div>
     </div>
     <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Customer Name :</label>
                  <select  class="form-control" name="customer" id="customer">
                    <?php
                      foreach ($customer->result() as $cust) {
                      
                     ?>
                     <option value="<?php echo $cust->customerid; ?>" data-customerbalance ="<?php echo $cust->currentbalance;?>"  ><?php echo $cust->ledgername; ?></option>
                   <?php } ?>
                  </select>
                </div>
           </div>
      <div class="col-md-3"> 
                <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Amount :</label>
                  <input type="text" class="form-control" required autocomplete="off" name="amount" id="amount">
                </div>   
              </div>
      <div class="col-md-3"> 
        <div class="form-group">
          <label class="form-control-placeholder" for="contact-person">Costomer Balance :</label><br>
          <input type="text" class="form-control" required autocomplete="off" name="customerbalance" id="customerbalance">
         <!--  <label class="form-control-placeholder" for="contact-person" name="customerbalance" id="customerbalance">0.00</label> -->
        </div>
      </div>
      <div class="col-md-3"> 
          <div class="form-group">
          <label class="form-control-placeholder" for="contact-person">Next Collection</label><br>
          <input type="text" class="form-control" required autocomplete="off" name="customerbalanc" id="customerbalan">
         <!--  <label class="form-control-placeholder" for="contact-person" name="customerbalance" id="customerbalance">0.00</label> -->
        </div>
      </div>
    </div>
    <div class="row margin" style="text-align: center;">
       <div class="form-group offset-md-3">
          <input class="btn btn-success" class="" type="submit" name="btnsave" value="Save" id="btnsave">
            <input class="btn btn-danger" class="" type="submit" name="btndelete" value="Delete" id="btndelete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_receiptvoucher">
            <input class="btn btn-info" class="" type="submit" name="btnclear" value="Clear" id="btnclear" formaction="javascript:void(0);">
        </div>
    </div>
</form>
</div>
</div>
 <div class="box box-default">
        <div class="box-body">
    <div class="row col-md-12">
       <div class="subdiv table-responsive" style="height:300px !important" >
                  <table style="width: 100% !important;" border="1" class="table table-striped table-hover" id="receiptvoucher_table">
                    <thead>
                  <tr>
                   
                    <th class="">Sl No</th>
                     <th style="display: none;">Receiptid</th>
                    <th class="">Voucher No</th>
                    <th >customer Name</th>
                    <th style="display:none;">customer Id</th>
                     <th class="">Amount</th>
                     <th >Customer Balance</th>
                    <th >Date</th>
                    <th >Customer A/C</th>
                    <th >cashorbank</th>
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                       <?php 
                      $n=1; 
                         foreach($getreceiptvoucher->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td style="display: none;"><?php echo $row->receiptvoucherid;
                                 ?></td>
                                <td><?php echo $row->voucherno;
                                 ?></td>
                                  <td ><?php echo $row->customername;
                                 ?></td>
                                  <td style="display: none;"><?php echo $row->customerid;
                                 ?></td>
                                 <td ><?php echo $row->amount;
                                 ?></td>
                                 <td ><?php echo $row->currentbalance;
                                 ?></td>
                                 <td ><?php echo $row->receiptdate;
                                 ?></td>
                                 <td ><?php echo $row->customeraccount;
                                 ?></td>
                                 <td ><?php echo $row->cashorbank;
                                 ?></td>
                              </tr>
                              <?php  $n++;}?>  
                         
                   </tbody>
                      
                 </table>

                </div>      
    </div>
</div>
</div>
</section>
</div>

  <script type="text/javascript">
  var table = document.getElementById('receiptvoucher_table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         
                         document.getElementById("receiptvoucherid").value = this.cells[1].innerHTML;
                         document.getElementById("voucherno").value = this.cells[2].innerHTML;
                         document.getElementById("customer").value = this.cells[4].innerHTML;
                       
                          document.getElementById("amount").value = this.cells[5].innerHTML;
                           document.getElementById("customerbalance").value = this.cells[6].innerHTML;
                            document.getElementById("receiptdate").value = this.cells[7].innerHTML;
                             document.getElementById("customeraccount").value = this.cells[8].innerHTML;
                             document.getElementById("cashorbank").value = this.cells[9].innerHTML;
                         document.getElementById("btnsave").disabled=true;
                          
                         
                    };
                }
   var clear = document.getElementById('btnclear');   
  clear.onclick=function()
   {
                           document.getElementById("receiptvoucherid").value = "";
                          document.getElementById("amount").value = "";
                           document.getElementById("customerbalance").value = "";
                             document.getElementById("customeraccount").value = "";
                         document.getElementById("btnsave").value = "Save";
                          
                        
   }     

   var customer = document.getElementById('customer');   
  customer.onclick=function()
   {
                       
                                     document.getElementById("customerbalance").value = customer.options[customer.selectedIndex].getAttribute("data-customerbalance");
                        
                                                 
   }     
</script> 

<!-- <script type="text/javascript">//To load customer balance
    $(document).ready(function(){
        
        $('#customer').on('change',function(){

          
            var $sel = $("#customer");
            var ledgername = $("option:selected",$sel).text()+"&nbspA/C"; 
            alert(ledgername);
            
         $.noConflict();
      try{
            $.ajax({

                type : "POST",
                 dataType: 'json',
                url  : "<?php echo base_url(); ?>index.php/Onlinecontrol/Autofill_customerbalance",
                data : {'b':ledgername},
                success: function(result)
                {
                  alert(b);
                  $('#customerbalance').val(result[0]['currentbalance']);
                },
                 error: function(){
                            alert('Error occur...!!');
                        }
            });
          }
          catch(err){
            alert(err.message);
          }
        });
    });
 
</script> -->

</div>