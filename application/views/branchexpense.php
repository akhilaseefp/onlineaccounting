<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Branch Expense
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Branch Expense</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
          <form method="post" action="<?php echo base_url();?>index.php/Onlinecontrol/insert_branchexpense">
    <div class="row">
      <div class="col-md-3">
                <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Voucher No</label>
                  <?php 
                       foreach ($voucherno->result() as $key)  {
                  ?>
                  <input type="text" class="form-control" id="voucherno" value="<?php echo $key->NO;}?>" name="voucherno" required autocomplete="off">
                </div>
              </div>
               <div class="col-md-3">
                <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Vendor Invoice Number</label>
                  <input type="text" class="form-control" id="vendorinvoiceno" name="VendorInvoiceNo"  autocomplete="off">
                </div>
              </div>
               <div class="col-md-3">
                <div class="form-group" >
          <label class="form-control-placeholder" for="contact-person">Date</label>
          <input type="date" class="form-control" id="date" name="date" value="<?php echo date("Y-m-d") ?>" required autocomplete="off">
        </div>
      </div>
        <div class="col-md-3">
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
                 <div class="col-md-4">
              <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Supplier </label>
                  <select class="form-control" id="supplier" name="supplier">
                    <option disabled="true" selected="">Select Ledger </option>
                    <?php foreach($supp->result() as $sup){
                      ?>
                      <option value="<?php echo $sup->ledgerid;?>" data-balance="<?php echo $sup->currentbalance;?>"><?php echo $sup->ledgername;?></option>
                      <?php
                    } 
                    ?>
                  </select>
        </div>
      </div>
                 <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Current Balance</label>
                    <input type="text" class="form-control" id="currentbalance" name="currentbalance" required autocomplete="off">
            <!--    <a href="<?php echo base_url();?>index.php/Onlinecontrol/supplier" class="pull-right">Add New Supplier</a> -->
                </div>
            </div>
          
                 <div class="col-md-4">

        <div class="form-group">
          <label class="form-control-placeholder" for="contact-person">Total Amount</label>
          <input type="text" class="form-control" id="totalamount" name="totalamount" required autocomplete="off">
        </div>
                
            </div>
</div>

    <hr>
    <div class="row col-md-12 txn-bottom-form">
      <div class="col-md-6">
        <div class="form-group">
          <label class="form-control-placeholder" for="contact-person">Narration</label>
          <textarea class="form-control" id="narration" name="narration" style="line-height:2.5"></textarea>
     
      </div>
    </div>
      <div class="col-md-6">
        <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Next payment</label>
                    <input type="date" class="form-control" id="currentbalanc" name="currentbalanc" autocomplete="off">
            <!--    <a href="<?php echo base_url();?>index.php/Onlinecontrol/supplier" class="pull-right">Add New Supplier</a> -->
       
      </div>
    </div>
    <div class="row margin col-md-12 form-group txn-bottom-form" style="text-align: center;">
      <div class="offset-md-4">
        <input class="btn btn-success" type="submit" id="btnsave" name="btnsave" value="Save">
        <!-- <input class="btn btn-danger" type="submit" id="delete" name="delete"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_paymentvoucher" value="Delete"> -->
        <input class="btn btn-info" type="submit" id="btnclear" name="btnclear" value="Clear">
        <input class="btn btn-warning" type="submit" id="close" name="close" value="Close">
      </div>
    </div>
 </form>
</div>
</div>

 <div class="box box-default">
        <div class="box-body">
      <div class="row col-md-12 table">
      
        <hr>
        <TABLE id="dataTable" width="100%" border="1"  class="table table-striped table-hover">
          <thead>
            <tr>
             
              <th class="">SLNO</th>
              <th class="">Voucherno</th>
               <th class="">SupplierName</th>
              <th class="">Vendorinvoiceno</th>
              <th class="never">CurrentBalance</th>
              <th class="">Date</th>
              <th class="never">Narration</th>
              <th >Totalamount</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <?php
            $n=1;
            foreach($pay->result() as $row)
            {
              ?>
              <TR>
               
                <TD><a><?php echo $n;?></a></TD>
                <TD><?php echo $row->voucherno;?></TD>
                 <TD><?php echo $row->ledgername;?></TD>
                 <TD><?php echo $row->vendorinvoiceno;?></TD>
                <TD class="never"><?php echo $row->currentbalance;?></TD>
                <TD><?php echo $row->date;?></TD>
                <TD class="never"><?php echo $row->narration;?></TD>
                <TD ><?php echo $row->totalamount;?></TD>
                 <TD class="never"><?php echo $row->supplier;?></TD>
              </TR>
              <?php 
              $n++;
            }
            ?>
          </tbody>
        </TABLE>
      </div>
</div>
</div>
</section>
</div>

<style type="text/css"> 
.never{
display:none;}</style>

<script type="text/javascript">
    
    var supplier = document.getElementById('supplier');   
  supplier.onchange=function()
   {
     document.getElementById("currentbalance").value = supplier.options[supplier.selectedIndex].getAttribute("data-balance");                                            
   }  

    var table = document.getElementById('dataTable');
                      
                      for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                               
                               document.getElementById("voucherno").value = this.cells[1].innerHTML;
                               document.getElementById("vendorinvoiceno").value = this.cells[3].innerHTML;
                               document.getElementById("supplier").value = this.cells[8].innerHTML;
                               document.getElementById("currentbalance").value = this.cells[4].innerHTML;
                               document.getElementById("date").value = this.cells[5].innerHTML;
                               document.getElementById("narration").value = this.cells[6].innerHTML;
                               document.getElementById("totalamount").value = this.cells[7].innerHTML;
                               document.getElementById("btnsave").disabled=true;
                                
                               
                          };
                      }
         var clear = document.getElementById('btnclear');   
        clear.onclick=function()
         {
                                document.getElementById("branchid").value ="";
                               document.getElementById("vendorinvoiceno").value = "";
                               document.getElementById("supplier").value ="";
                               document.getElementById("currentbalance").value = "";
                               document.getElementById("date").value = "";
                               document.getElementById("narration").value = "";
                               document.getElementById("totalamount").value = "";
                               document.getElementById("btnsave").disabled=false;
                              
         }       




</script>