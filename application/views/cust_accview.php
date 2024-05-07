<script>
$(document).ready(function(){
  $("#myInput").on("click", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<div class="content-wrapper">
   <section class="content-header">
      <h1>
       Ledger Register
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Ledger Register</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">
      <form method="post" >
     <div class="row">
     	<div class="col-md-2">
			    <label>Account ledger :</label>
           <?php if($customerledger!=null){ ?>
          <input type="text" class="form-control" required list="name" autocomplete="off" name="customerledger" id="customerledger" value="<?php echo $customerledger; ?>"></td>
           <?php  } else{?>
             <input type="text" class="form-control" required list="name" autocomplete="off" name="customerledger" id="customerledger"></td>
             <?php  } ?>
			     <datalist id="name">
			      <?php foreach ($accountledger->result() as $gp) {
			        ?>
			        <option value="<?php echo $gp->ledgerid; ?>"><?php echo $gp->ledgername; ?></option>
			        <?php  } ?>
			        </datalist>    
			  </div>
					<div class="col-md-4">
          <label>Date From :</label>
						<input type="date" name="fdate" id="fdate"  class="form-control" value="<?php echo $fdate; ?>">
          </div>
          
          <div class="col-md-4">
            <label>Date To :</label>
						<input type="date" name="tdate" id="tdate" class="form-control" value="<?php echo $tdate; ?>">
          </div>

          <div class="col-md-4" style="margin-top:25px;">
            <input class="btn btn-success" type="submit" name="btngo" id="btngo" value="Go">
          </div>
     </div>
     </form>
     <div class="row" style="padding-top:50px;">
      <div class="col-md-12">
        <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="salestable">
                    <thead>
                  <tr>
                     <!-- <th class="">Sl order/th> -->
                     <th style="">SL NO</th>
                     <th class="">Voucher No</th>
                     <th >Date</th>
                      <th class="" style="">Particulars</th>
                     <th style="">Account type</th>
                     <th style="">Debit</th>
                     <th style="">Credit</th>
                    
                      <th class="" style="">Balance</th>
                       <th>Action</th>
                     <!-- <th ></th> -->
                  </tr>
                  <?php
                    $n=1;
                    foreach ($day->result() as $key) {
                    ?>
                    <tr>
                    <td><?php echo $n;?></td>
                    <td><?php echo $key->invoiceno;?></td>
                    <td><?php echo $key->date;?></td>
                     <td><?php echo $key->Particulars;?></td>
                    <td><?php echo $key->accountType;?></td>
                    <td><?php echo $key->debit;?></td>
                    <td><?php echo $key->credit;?></td>
                   
                     <td><?php echo $key->balance;?></td>
                     <?php if($key->accountType=="Sales Invoice" or $key->accountType=="Sales Update"){?>
                                     <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/salesinvoice?a=<?php echo $key->invoiceno;?>"  target="_blank"><button class="btn btn-success">View</button></a></td>
                    <?php }else if($key->accountType=="Purchase Invoice" or $key->accountType=="Purchase Update"){?>  
                                 <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/pur_invoice?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td> 
                    <?php }else if($key->accountType=="Receipt Voucher" or $key->accountType=="Receipt Voucher_Delete"){?> 
                                     <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/receiptvoucher?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td> 
                   <?php }else if($key->accountType=="Payment Voucher" or $key->accountType=="Payment Voucher delete"){?> 
                                     <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/paymentvoucher?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td> 
                     <?php }else if($key->accountType=="Journal Voucher_save" or $key->accountType=="Journal Voucher_save"){?> 
                                     <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/journelvoucher?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td> 
                                      <?php }else if($key->accountType=="Damage Stock" or $key->accountType=="Damage Stock Delete"){?> 
                     <td><a href="<?php echo base_url();?>index.php/Stockcontrol/damagestock?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td> 
                     <?php }else if($key->accountType=="Purchase Return" or $key->accountType=="Purchase Return"){?> 
                     <td><a href="<?php echo base_url();?>index.php/Onlinecontrol/pur_return?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td>
                     <?php }else if($key->accountType=="Sales Return" or $key->accountType=="Sales Return"){?> 
                     <td><a href="<?php echo base_url();?>index.php/Salescontrol/viewsalesreturn?a=<?php echo $key->invoiceno;?>" target="_blank"><button class="btn btn-success">View</button></a></td> 
                   <?php }else{?> <td></td> <?php }?>       
                  </tr>
                      <?php 
                      $n++;
                    }?>
                 </table>
                </div>     
              </div>
            </div>
            </div>
    </section>
    </div>
  
              

 