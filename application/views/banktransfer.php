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
        Deposit
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Deposit</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">

          
      <div class="row">

        <div class="col-md-3">
          <div class="form-group" >
            <label class="form-control-placeholder" for="contact-person">Date</label>
            <input type="datetime" class="form-control" id="depositdate" value="<?php $d=strtotime("now");$e=strtotime("-7 hours",$d); echo date("Y-m-d H:i:s",$e);?>" name="depositdate">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label class="form-control-placeholder" for="contact-person">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" required autocomplete="off">
          </div>

        </div>

        <div class="col-md-3">
         <div class="form-group">

           <label class="form-control-placeholder" for="contact-person">Branch</label>
           <select class="form-control" name="branch" id="branch">
            <?php
            foreach ($branch->result() as $branch) { ?>
              <?php if($branch->branchid==$branchid){?>
                <option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>"  ><?php echo $branch->branchname; ?></option>
              <?php }
              else{?>
                <option value="<?php echo $branch->branchid;?>"  data-branchname="<?php echo $branch->branchname;?>" data-address="<?php echo $branch->address;?>" data-gstno="<?php echo $branch->gstno;?>" data-phonenumber="<?php echo $branch->phonenumber;?>" ><?php echo $branch->branchname; ?></option>
              <?php }
            }?>
          </select>
        </div>
      </div>  

      </div>


               




    <hr>
    <div class="row col-md-12 txn-bottom-form">
      <div class="col-md-6">
       
    </div>
    <div class="row margin col-md-12 form-group txn-bottom-form" style="text-align: center;">
       <form action="<?php echo base_url();?>index.php/Onlinecontrol/insert_banktransfer">
          <div class="offset-md-4">
            <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
            <input class="btn btn-success" type="button" name="btnsave" value="Deposit" id="btnsave">
            <!-- <input class="btn btn-danger" type="button" name="btndelete" value="Delete" id="btndelete">
            <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear"> -->
            
          </div>
        </form>
    </div>
 
</div>
</div>

</section>
</div>

<style type="text/css"> 
.never{
display:none;}</style>

<script type="text/javascript">
  var max=0;
     window.onload = function () {
  
    inv_no = document.getElementById("voucherno").value;
    max=inv_no;
    document.getElementById("btndelete").disabled=true;
     var loadinvno="<?php echo $loadinvno ;?>";
   if(loadinvno!=0){
    $('#voucherno').val(loadinvno);
    loadinvoice(loadinvno);
    
  }
   }
 </script>

<script type="text/javascript">
    var table = document.getElementById('dataTable');
                      
                      for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                               
                               document.getElementById("voucherno").value = this.cells[1].innerHTML;
                               document.getElementById("vendorinvoiceno").value = this.cells[6].innerHTML;
                               document.getElementById("ledger").value = this.cells[4].innerHTML;
                               document.getElementById("frombalance").value = this.cells[7].innerHTML;
                               document.getElementById("balance").value = this.cells[8].innerHTML;
                               
                               var aa=  new Date( this.cells[2].innerHTML); 
                      document.getElementById("receiptdate").value =  aa.toLocaleDateString('en-CA');
                               document.getElementById("narration").value = this.cells[9].innerHTML;
                               document.getElementById("amount").value = this.cells[5].innerHTML;
                               document.getElementById("btnsave").disabled=true;
                                 document.getElementById("cashorbank").value = this.cells[3].innerHTML;
                                 document.getElementById("btndelete").disabled = false; 
                                
                               
                          };
                      }
       

        
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
          $("#cashorbank").change(function ()
      {
        try
        {
          var val = $('#cashorbank').val();
          var balance = $('#cashlist option').filter(function ()
                                     {return this.value == val;}).data('balance');
          document.getElementById("frombalance").value = balance;
          

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
  if(inv_no>=max-1){
 $('#voucherno').val(max);
  inv_no=max;
  }
  else{
 inv_no=inv_no*1+1;
  $('#voucherno').val(inv_no);
  loadinvoice(inv_no);
 
  }
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
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/getcontravoucherbyvoucherno",
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
                                document.getElementById("frombalance").value = master[0]['frombalance'];
                           
                                  var aa=  new Date(master[0]['date']); 
                               
                      document.getElementById("receiptdate").value =  aa.toLocaleDateString('en-CA');
                              
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

            var amount = document.getElementById("amount").value;
            var depositdate = document.getElementById("depositdate").value;
            var branchid=document.getElementById("branch").value;
           // $.noConflict();
            try {
              $.ajax({
                type: "POST",
                // dataType:"json",
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_banktransfer",
                data: {
                  'amount': amount,
                  'depositdate': depositdate,
                  'branchid': branchid
                  
                },

                success: function (data) { alert('saved successfully');
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
            var vendorinvoiceno=document.getElementById("vendorinvoiceno").value;
            var narration=document.getElementById("narration").value;
             var frombalance = document.getElementById("frombalance").value;
           
          
            try {
              $.ajax({
                type: "POST",
                // dataType:"json",
                url: "<?php echo base_url() ?>index.php/Onlinecontrol/delete_contravoucher",
                data: {
                   'voucherno': voucherno,
                  'ledger': ledger,
                  'currentbalance': balance,
                  'frombalance' :frombalance,
                  'totalamount': amount,
                  'date': receiptdate,
                  'cashorbank': cashorbank,
                  'VendorInvoiceNo' :vendorinvoiceno,
                  'narration' :narration,
                  
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
