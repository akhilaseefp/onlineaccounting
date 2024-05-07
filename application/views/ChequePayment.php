<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Cheque Payment       
      </h1>
      <br>
      <a href="<?php echo base_url(); ?>index.php/Onlinecontrol/chequePage"> Cheque Register</i>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Cheque Payment</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
    <div class="row">
      <div class="col-md-3">
          <div class="form-group">
            <label class="form-control-placeholder" for="contact-person">Voucher No</label>
            <?php 
                 foreach ($chequeVoucherNo->result() as $key)  {
                 
                 
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
            <label class="form-control-placeholder" for="contact-person">Payment Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo date("Y-m-d") ?>" required autocomplete="off">
          </div>
        </div>
</div>
          <div class="row">
               <div class="col-md-4">
            <div class="form-group">
                <label class="form-control-placeholder" for="contact-person">Supplier </label>
                
                <input type="text" class="form-control" list="supplier1" required autocomplete="off"  name="supplier" id="supplier">
                <datalist id="supplier1">
                  <option disabled selected>Select Supplier </option>
                  <?php foreach($supp->result() as $sup){
                    ?>
                    <option value="<?php echo $sup->ledgerid;?>" data-balance="<?php echo $sup->currentbalance;?>" label="<?php echo $sup->suppliername;?>"></option>
                    <?php
                  } ?>
                  </datalist>
                
            </div>
        </div>
            <div class="col-md-4">
            <div class="form-group">
                  <label class="form-control-placeholder" for="contact-person">Current Balance</label>
                  <input type="text" class="form-control" id="currentbalance" name="currentbalance" value="" autocomplete="off">
          <!--    <a href="<?php echo base_url();?>index.php/Onlinecontrol/supplier" class="pull-right">Add New Supplier</a> -->
              </div>
          </div>
      </div>
        

        <div class="table table-responsible">
          <TABLE id="dataTable1" border="1" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>SL.NO</th>
                <th>Cheque No</th>
                <th>Bank</th>
                <th>Status</th>
                <th style="" class="d-none d-xl-block">Cheque Date</th>
                <th class="d-none d-xl-block">Amount</th>
                <th style="display: none;"></th>
                <th class="d-none d-xl-block"></th>
              </tr>
            </thead>
            <tbody id="dataTable" width="100%" class="table table-hover">
                <tr>
                <td>1</td>
                <td style="">
                  <input type="text" class="form-control chqno" autocomplete="off" id="chqno1" name="chqno">
                </td>
                <td> <input type="text" class="form-control bank" list="name" autocomplete="off"
                    name="bank" id="bank1"></td>
                <datalist id="name">
                  <?php foreach($BankLedgers->result() as $ledgers){ ?>
                  <option value="<?php echo $ledgers->ledgerid;?>" label="<?php echo $ledgers->ledgername; ?>">
                    <?php  } ?>
                </datalist>

              <td>
                <select class="form-control status" list="status" autocomplete="off" name="status" id="status1">
                <option value="Pending">Pending</option>
                <option value="Bounced">Bounced</option>
                <option value="Cleared">Cleared</option>
                <option value="Cancelled">Cancelled</option>
                
              </td>
                <td style=""><input type="date" class="form-control" id="date1" name="date" value="<?php echo date("Y-m-d") ?>" required autocomplete="off"></td>
                <td><input type="text" id="totalamount1" class="form-control mrp" name=""></td>
                <td class="ctr" style="display: none">1</td>
                <td><a href="" class="delete">X</a></td>
              </tr>
            </tbody>
          </TABLE>
          <input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
        </div>
        <hr>

    <div class="row col-md-12 txn-bottom-form">
      <div class="col-md-6">
        <div class="form-group">
          <label class="form-control-placeholder" for="contact-person">Narration</label>
          <textarea class="form-control" id="narration" name="narration" style="line-height:2.5"></textarea>
     
      </div>
    </div>
      <div class="col-md-4">
            <div class="form-group">
              <label class="form-control-placeholder" for="contact-person">Total Amount</label>
              <input type="text" class="form-control" id="totalamount" name="totalamount" required autocomplete="off">
            </div>                  
      </div>

    <div class="row margin col-md-12 form-group txn-bottom-form" style="text-align: center;">
      <div class="offset-md-4">
        <input class="btn btn-success" type="submit" id="btnsave" name="btnsave" value="Save">
        <input class="btn btn-danger" type="submit" id="delete" name="delete"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_paymentvoucher" value="Delete">
        <input class="btn btn-info" type="submit" id="btnclear" name="btnclear" value="Clear">
        <input class="btn btn-warning" type="submit" id="close" name="close" value="Close">
      </div>
    </div>

</div>
</div>
</div>
</section>
</div>
<script type="text/javascript">

  
  $("#supplier").change(function () {
    try {
      var val = $('#supplier').val();
      var balance = $('#supplier1 option').filter(function () {
      return this.value == val;
      }).data('balance');
      document.getElementById("currentbalance").value = balance;
    } catch (err) {
      alert(err.message);
    }
  });
</script>
<script type="text/javascript">
  var ctr = 1;
  $('#addrow').on('click', function () { 
    ctr++;

    var tr = "tr" + ctr;
    var chqno = "chqno" + ctr;
    var bank = "bank" + ctr;
     var status = "status" + ctr;
    var date = "date" + ctr;
    var totalamount = "totalamount" + ctr;

    var rowCount = document.getElementById('dataTable').rows.length + 1;
    var newTr = '<tr><td>'+ rowCount +'</td><td><input type="text" class="form-control chqno" autocomplete="off" id="' +chqno + '" name="chqno"></td><td><input type="text" class="form-control bank" list="name" on autocomplete="off" name="bank" id="' +
              bank +'"></td><td><select list="status" class="form-control status" name="status" autocomplete="off" id="' + status + '"><option value="Pending">Pending</option><option value="bounced">bounced</option><option value="Cleared">Cleared</option><option value="Cancelled">Cancelled</option></td><td> <input type="date" value="<?php echo date("Y-m-d") ?>" class="form-control date" autocomplete="off" id="' +date + '" name="date"></td><td><input type="text" id="' + totalamount +'" class="form-control mrp"  name=""></td><td class="ctr" style="display:none">' + ctr +'</td> <td><a href="" class="delete" >X</a></td> </tr>';
    $('#dataTable1').append(newTr);
    calculation();
  });

  
</script>

<script type="text/javascript">
    $('#dataTable1').on('keyup', '.mrp', function () {


   
   
    calculation();

  });
 </script>
<script type="text/javascript"> 
  $('#dataTable1').on('click', '.delete', function (e) {
    e.preventDefault();
  
    $(this).closest('tr').remove();
  
    var table = document.getElementById('dataTable1');
    var ab = table.rows.length;
    for (var i = 1; i < table.rows.length + 1; i++) {
      table.rows[i].cells[0].innerHTML = i;
    }
    calculation();
  });

   

  function calculation() {

    try {
      var table = document.getElementById('dataTable1'); 
   
       var totalamount=0; 
      for (var n = 1; n < table.rows.length; n++) {
           var i = 0;          
          i = document.getElementById('dataTable').rows[n - 1].cells[6].innerHTML; 
          
          totalamount=totalamount+($('#totalamount'+i).val()*1);
       
        
       
        }
        $('#totalamount').val(totalamount);

      
       
      

      
     
    } catch (err) {
      alert(err);
    }


  }



</script>

<script type="text/javascript">
  $(document).ready(function () {

    $('#btnsave').on('click', function () {
                    var voucherno = document.getElementById("voucherno").value;
                    var vendorinvoiceno = document.getElementById("vendorinvoiceno").value;
                    var date = document.getElementById("date").value;
                    var supplier = document.getElementById("supplier").value;
                    var currentbalance = document.getElementById("currentbalance").value;
                    var narration = document.getElementById("narration").value;
                    var totalamount = document.getElementById("totalamount").value;
                    var table = document.getElementById('dataTable1');
                    // $.noConflict();
                    try {
                     for (var n = 1; n < table.rows.length; n++) { 
                                                                  var i = 0;          
                                                               i = document.getElementById('dataTable').rows[n - 1].cells[6].innerHTML; 
                                      var chqno1 = document.getElementById("chqno"+i).value;
                    var bank1 = document.getElementById("bank"+i).value;
                    var status1 = document.getElementById("status"+i).value;
                    var date1 = document.getElementById("date"+i).value;
                    var totalamount1 = document.getElementById("totalamount"+i).value;                        
                        var type ="payment";                                     
                      $.ajax({
                        type: "POST",
                        // dataType:"json",
                        url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_chequepayment",
                        data: {
                          'voucherno': voucherno,
                          'vendorinvoiceno': vendorinvoiceno,
                          'date':date,
                          'supplier': supplier,
                          'currentbalance': currentbalance,
                          'chqno1': chqno1,
                          'bank1': bank1,
                          'status1':status1,
                          'date1': date1,
                          'totalamount1': totalamount1,
                          'narration': narration,
                          'totalamount': totalamount,
                          'type' :type
                        },
                        success: function (data) {

                      
                        var myJSON = JSON.stringify(data);
                        
                      },
                      error: function (data) {
                        var myJSON = JSON.stringify(data);
                        alert("in details");
                  alert(myJSON);
                      }

                    });
                    }
                    location.reload();
                    }
                    catch (err) {
        alert(err.message);
      }

              });
  


    });
  
  </script>

<style type="text/css"> 
.never{
display:none;}</style>

<script type="text/javascript">
    
    
    

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
</script>