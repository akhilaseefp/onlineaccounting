<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>
<script type="text/javascript"> var inv_no =0;</script>
<style>
a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #4CAF50;
  color: white;
}

.round {
  border-radius: 50%;
}
</style>
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Payment Voucher
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Payment Voucher</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
           <div id="invbutton">
        <a href="#" class="previous" id="previous">&laquo; Previous</a>
<a href="#" class="next" id="next">Next &raquo;</a></div>
          
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
          <input type="datetime" class="form-control" id="receiptdate" name="receiptdate" value="<?php $d=strtotime("now"); echo date("Y-m-d H:i:s",$d);?>" required autocomplete="off">
        </div>
      </div>
        <div class="col-md-3">
         <div class="form-group">
           <label class="form-control-placeholder" for="contact-person">Cash/Bank :</label>
                  <input type="text" class="form-control" list="cashlist" required autocomplete="off"  name="cashorbank" id="cashorbank">
              <!-- <option value="0"  data-balance="0.00">Select Customer</option> -->
              <datalist id="cashlist" >
                <?php
                 foreach ($BankAndcashLedgers->result() as $ledgers) {
                ?>
                <option value="<?php echo $ledgers->ledgername; ?>"  label="<?php echo $ledgers->ledgerid;?>" ></option>
                <?php } ?>
              </datalist>
               </div>
      </div>
    </div>
    <div class="row">
                 <div class="col-md-4">
              <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Ledger</label>
                 <input type="text" class="form-control" list="ledgerlist" required autocomplete="off"  name="ledger" id="ledger">
              <!-- <option value="0"  data-balance="0.00">Select Customer</option> -->
              <datalist id="ledgerlist" >
                <?php
                  foreach ($ledger->result() as $led) {
                ?>
                <option value="<?php echo $led->ledgername; ?>"  label="<?php  echo $led->ledgerid;?>" data-balance="<?php echo $led->currentbalance;?>"></option>
                <?php } ?>
              </datalist>
        </div>
      </div>
                 <div class="col-md-4">
                <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Current Balance</label>
                    <input type="text" class="form-control" id="balance" name="balance" required autocomplete="off">
            <!--    <a href="<?php echo base_url();?>index.php/Onlinecontrol/supplier" class="pull-right">Add New Supplier</a> -->
                </div>
            </div>
          
                 <div class="col-md-4">

        <div class="form-group">
          <label class="form-control-placeholder" for="contact-person">Total Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" required autocomplete="off">
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
       
    </div>
    <div class="row margin col-md-12 form-group txn-bottom-form" style="text-align: center;">
       <form action="<?php echo base_url();?>index.php/Onlinecontrol/paymentvoucher">
          <div class="offset-md-4">
            <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
            <input class="btn btn-success" type="button" name="btnsave" value="Save" id="btnsave">
            <input class="btn btn-danger" type="button" name="btndelete" value="Delete" id="btndelete">
            <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
            
          </div></form>
    </div>
 
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
               <th class="">LedgerName</th>
              <th class="">Vendorinvoiceno</th>
              <th class="">CurrentBalance</th>
              <th class="">Date</th>
              <th class="">Narration</th>
              <th >Totalamount</th>
              <th >Cash/Bank</th>
                     <th style="display:none;">cashledger</th>
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
                <TD ><?php echo $row->currentbalance;?></TD>
                <TD><?php echo $row->date;?></TD>
                <TD ><?php echo $row->narration;?></TD>
                <TD ><?php echo $row->totalamount;?></TD>
                 <TD style="display:none;"><?php echo $row->ledger;?></TD>
                  <td ><?php echo $row->cash; ?></td>
                                  <td style="display: none;"><?php echo $row->cashorbank;
                                 ?></td>
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
     window.onload = function () {
  
    inv_no = document.getElementById("voucherno").value;
    
    document.getElementById("btndelete").disabled=true;
     var loadinvno="<?php echo $loadinvno ;?>";
   if(loadinvno!=0){
    $('#voucherno').val(loadinvno);
    loadinvoice(loadinvno);
    
  }
}
    var ledger = document.getElementById('ledger');   
    ledger.onchange=function()
   {
     document.getElementById("currentbalance").value = ledger.options[ledger.selectedIndex].getAttribute("data-balance");                                            
   }  

    var table = document.getElementById('dataTable');
                      
                      for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                               
                               document.getElementById("voucherno").value = this.cells[1].innerHTML;
                               document.getElementById("vendorinvoiceno").value = this.cells[3].innerHTML;
                               document.getElementById("ledger").value = this.cells[2].innerHTML;
                               document.getElementById("balance").value = this.cells[4].innerHTML;
                               document.getElementById("receiptdate").value = this.cells[5].innerHTML;
                               document.getElementById("narration").value = this.cells[6].innerHTML;
                               document.getElementById("amount").value = this.cells[7].innerHTML;
                               document.getElementById("btnsave").disabled=true;
                                 document.getElementById("cashorbank").value = this.cells[9].innerHTML;
                                 document.getElementById("btndelete").disabled = false; 
                                
                               
                          };
                      }
         var clear = document.getElementById('btnclear');   
        // clear.onclick=function()
        //  {
        //                        //  document.getElementById("branchid").value ="";
        //                        // document.getElementById("vendorinvoiceno").value = "";
        //                        // document.getElementById("ledger").value ="";
        //                        // document.getElementById("balance").value = "";
        //                        // document.getElementById("date").value = "";
        //                        // document.getElementById("narration").value = "";
        //                        // document.getElementById("amount").value = "";
        //                        // document.getElementById("btnsave").disabled=false;
                              
        //  }    
         $("#ledger").change(function ()
      {
        try
        {
          var val = $('#ledger').val();
          var balance = $('#ledgerlist option').filter(function ()
                                     {return this.value == val;}).data('balance');
          document.getElementById("balance").value = balance;
          

        }
        catch(err)
        {
          alert(err.message);
        }
      });    




</script>
<script type="text/javascript">
   $('#invbutton').on('click', '.previous', function (e) {
   
    inv_no=inv_no-1;
    $('#voucherno').val(inv_no);
   loadinvoice(inv_no);
  });
</script>
<script type="text/javascript">
   $('#invbutton').on('click', '.next', function (e) {
    
    inv_no=inv_no*1+1;
    $('#voucherno').val(inv_no);
    loadinvoice(inv_no);
  });
    $('#voucherno').on('change', '', function (e) {
   
    inv_no=$('#voucherno').val();
    loadinvoice(inv_no);
  });
    function loadinvoice(a){
      
                  // $.noConflict();
            try {
              $.ajax({
                type: "POST",
                // dataType:"json",
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/getpaymentvoucherbyvoucherno",
                data: {
                  'voucherno' : a
                },
                      success: function (data) { 
                        var master=JSON.parse(data);
                        document.getElementById("btnsave").disabled = true;
                     
                      document.getElementById("btndelete").disabled = false;
                      
                          
                       
                        if (master.length==0) {alert("no such voucher exists ");}
                        else{ 
                          document.getElementById("voucherno").value = master[0]['voucherno'];
                               document.getElementById("vendorinvoiceno").value = master[0]['vendorinvoiceno'];
                               document.getElementById("ledger").value = master[0]['ledgername'];
                               document.getElementById("balance").value = master[0]['currentbalance'];
                               document.getElementById("receiptdate").value = master[0]['date'];
                               document.getElementById("narration").value = master[0]['narration'];
                               document.getElementById("amount").value = master[0]['totalamount'];
                               document.getElementById("btnsave").disabled=true;
                                 document.getElementById("cashorbank").value = master[0]['cash'];
                                 document.getElementById("btndelete").disabled = false; 
                                
                      
                       
                        }
                        
                        
                        

                      },
                      error: function (data) {
                        var myJSON = JSON.stringify(data);
                        alert("in details");
                  alert(myJSON);
                      }

                    });

                   }
        catch(err)
        {
          alert(err.message);
        }

      
    }
</script><script type="text/javascript">
        $(document).ready(function () {

          $('#btnsave').on('click', function () {

            var voucherno = document.getElementById("voucherno").value;
            var cashid = document.getElementById("cashorbank").value;
            var cashorbank=$("#cashlist option[value='" +cashid +"']").attr('label');
             var ledgername = document.getElementById("ledger").value;
            var ledger=$("#ledgerlist option[value='" +ledgername +"']").attr('label');
            var balance = document.getElementById("balance").value;
            var amount = document.getElementById("amount").value;
            var receiptdate = document.getElementById("receiptdate").value;
            var vendorinvoiceno=document.getElementById("vendorinvoiceno").value
            var narration=document.getElementById("narration").value
           
           
           // $.noConflict();
            try {
              $.ajax({
                type: "POST",
                // dataType:"json",
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_paymentvoucher",
                data: {
                  'voucherno': voucherno,
                  'ledger': ledger,
                  'currentbalance': balance,
                  'totalamount': amount,
                  'date': receiptdate,
                  'cashorbank': cashorbank,
                  'VendorInvoiceNo' :vendorinvoiceno,
                  'narration' :narration
                  
                  
                },

                success: function (data) { 
                    if(data=="0"){
                     alert('saved successfully');
location.reload();
                    
                }
                else{ 
                    alert("Increment Voucher Number to avoid duplication");
                }
                   
                }, //master success
          error: function (data) {
            var myJSON = JSON.stringify(data);
            alert(myJSON);
          },
          complete: function (){ 
          }
        });
              } //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
          
        }
        
      });

      //Save product

    });
  </script>
  <script type="text/javascript">
        $(document).ready(function () {
          $('#btndelete').on('click', function () {
           
             var voucherno = document.getElementById("voucherno").value;
            var cashid = document.getElementById("cashorbank").value;
            var cashorbank=$("#cashlist option[value='" +cashid +"']").attr('label');
             var ledgername = document.getElementById("ledger").value;
            var ledger=$("#ledgerlist option[value='" +ledgername +"']").attr('label');
            var balance = document.getElementById("balance").value;
            var amount = document.getElementById("amount").value;
            var receiptdate = document.getElementById("receiptdate").value;
            var vendorinvoiceno=document.getElementById("vendorinvoiceno").value
            var narration=document.getElementById("narration").value
            
            $.noConflict();
            try {
              $.ajax({
                type: "POST",
                // dataType:"json",
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/delete_paymentvoucher",
                data: {
                   'voucherno': voucherno,
                  'ledger': ledger,
                  'currentbalance': balance,
                  'totalamount': amount,
                  'date': receiptdate,
                  'cashorbank': cashorbank,
                  'VendorInvoiceNo' :vendorinvoiceno,
                  'narration' :narration
                  
                },
                success: function (data) { alert('Deleted successfully');
location.reload();
              }, //master success
          error: function (data) {
            var myJSON = JSON.stringify(data);
            alert(myJSON);
          },
          complete: function (){ 
          }
        });
              } //try
        catch (err) {
          alert(err.message);
        }
        finally{ 
          
        }
        
      });

      //Save product

    });
  </script>