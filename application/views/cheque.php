<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script> -->
 <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>

<!--  -->
<script src="<?php echo base_url(); ?>js/jquery1.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#searchproduct").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            
      });
      });
    });
 
</script>

<script type="text/javascript">
  $(document).ready(function() { 
    $("#statussearch").on("change", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
         $(this).toggle($(this).find('select[name="status"]').val().toLowerCase().indexOf(value) > -1)
        
      });
    });
  });
</script>



<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Cheque
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i> Home</a></li>
      <!-- <li><a href="#">Forms</a></li> -->
      <li class="active">Cheque</li>
    </ol>
  </section>
  <section class="content">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
         <form action="<?php echo base_url();?>index.php/Onlinecontrol/chequePage">

          <div class="col-md-4">
            <label>Date From :</label>
            <input type="date" name="fromdate" id="fdate"  class="form-control">
          </div>
          
          <div class="col-md-4">
            <label>Date To :</label>
            <input type="date" name="todate" id="tdate" class="form-control">
          </div>

          <div class="col-md-2" style="margin-top:25px;">
            <input class="btn btn-success" type="submit" name="btngo" id="btngo" value="Go">
          </div>
          </form>
        </div>

        <div class="row">
         <div class="col-md-6">
            <div class="form-group"> <label>Search Status :</label>
            <select class="form-control" name="field" id="statussearch">
              <option name="searchoption" selected="selected" value=""></option>
              <option name="searchoption" value="Pending"  >Pending</option>
               <option name="searchoption" value="Cleared">Cleared</option>
              <option name="searchoption" value="Canceled">Canceled</option>
              <option name="searchoption" value="Bounced">Bounced</option>
            </select>
            </div>
          </div>
          <div class="col-md-6" style="">
            <div class="form-group"> <label>Search Product :</label>
              <input type="text" id="searchproduct" name="searchproduct" class="form-control" autocomplete="off">
            </div>
          </div>
        </div>

            <div id="load"  class="table" style="position: relative;height:400px ;overflow: auto;">

              <TABLE id="table" width="100%" class="table table-striped table-hover">
                <thead>
                  <tr>
                    
                    <th>Sl No</th>
                    <th> Voucher No</th>
                    <th>Voucher Type</th>
                    <th style="display: none;">Ledger</th>
                    <th style="">Ledger Name</th>
                     
                    <th>Current balance</th>
                    <th style="">bank</th>
                    <th style="display: none;">bankid</th>
                    <th>amount</th>
                    <th>receipt date</th>
                    <th style="display: none;">clear date</th>
                    <th>cheque No</th>
                    <th  style="">status</th>
                    <th>cheque Date</th>
                    <th style="display: none;">Total Amount</th>
                    <th> Narration</th>
                    <th> Vendor Inv No</th>
                    
                    <th style="display: none;">Cheque Master Id</th>
                     <th> Action</th>
                     <th> Action</th>
                   
                    
                  </tr>
                </thead>
                <tbody id="myTable">
                  <?php
                  $n = 1;
                  foreach ($cheque->result() as $row) { ?>
                    <tr>
                      <td><a><?php echo $n; ?></a></td>
                      <td><?php echo $row->voucherno; ?></td>
                                            <td class="type"><?php echo $row->type; ?></td>
                      <td class="supplierid" style="display: none;"><?php echo $row->supplier; ?></td>
                       <td class="suppliername"><?php echo $row->suppliername; ?></td>
                      <td class="currentbalance"><?php echo $row->current_balance; ?></td>
                      <td style=""><?php echo $row->bankname; ?></td>
                      <td  class="cashorbank" style="display: none;"><?php echo $row->bank; ?></td>
                      <td class="totalamount"><?php echo $row->total_amount1; ?></td>
                      <td><?php echo $row->date; ?></td>
                      <td style="display: none;"><?php echo $row->cleardate; ?></td>
                      <td><?php echo $row->chqno; ?></td>
                     
                      <td><select class="form-control status" list="status" autocomplete="off" name="status" >
                        <?php switch ($row->status){
                          case "Pending" : ?>
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Bounced">Bounced</option>
                                         <option value="Cleared">Cleared</option>
                                         <option value="Cancelled">Cancelled</option>
                                            <?php  break;
                                        case "Bounced" : ?>
                                        <option value="Pending" >Pending</option>
                                        <option value="Bounced" selected>Bounced</option>
                                         <option value="Cleared">Cleared</option>
                                         <option value="Cancelled">Cancelled</option>
                                       <?php  break;
                                       case "Cleared" : ?>
                                        <option value="Pending" >Pending</option>
                                        <option value="Bounced" >Bounced</option>
                                         <option value="Cleared" selected>Cleared</option>
                                         <option value="Cancelled">Cancelled</option>
                                       <?php  break;
                                       case "Cancelled" : ?>
                                        <option value="Pending" >Pending</option>
                                        <option value="Bounced" >Bounced</option>
                                         <option value="Cleared" >Cleared</option>
                                         <option value="Cancelled" selected>Cancelled</option>
                                       <?php  break;
                                       }
                                       ?>

                </td>
                      <td><?php echo $row->date1; ?></td>
                      <td style="display: none;"><?php echo $row->total_amount; ?></td>
                      <td class="narration"><?php echo $row->narration; ?></td>
                      <td class="vendorinvoiceno"><?php echo $row->vendorinvoiceno; ?></td>
                      <td class="id" style="display: none;"><?php echo $row->id; ?></td>
                      <td ><input class="btn btn-success update" type="submit" name="btngo" id="btngo<?php echo $n; ?>" value="Submit"></td>
                      <td><input class="btn btn-success delete" type="submit" name="btngo" id="btndelete<?php echo $n; ?>" value="Delete"></td>
                                                               
                      
                      
                    </tr>
                  <?php $n++;
                  } ?>

                </tbody>



              </TABLE>
            </div>
          </div>
        </div>

          
      </div>
    </div>
  </section>
</div>
<script type="text/javascript">
          $(document).ready(function () {

          $('#myTable').on('click','.update', function () {

            var vendorinvoiceno=$(this).closest("tr").find ('.vendorinvoiceno').html();
             var supplierid=$(this).closest("tr").find ('.supplierid').html();
              var currentbalance=$(this).closest("tr").find ('.currentbalance').html();
               var narration=$(this).closest("tr").find ('.narration').html();
                var totalamount=$(this).closest("tr").find ('.totalamount').html();
                 var cashorbank=$(this).closest("tr").find ('.cashorbank').html();
                 var status=$(this).closest("tr").find ('.status').val(); 
                 var id=$(this).closest("tr").find ('.id').html();
                 var type=$(this).closest("tr").find ('.type').html();
           if(type=='payment'){
            
            try {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Onlinecontrol/ChequetoPayment",
                  data: {
                    'vendorinvoiceno': vendorinvoiceno,
                    'ledger': supplierid,
                    'currentbalance': currentbalance,
                    'narration': narration,
                    'totalamount': totalamount,
                    'cashorbank': cashorbank,
                    'status': status,
                    'id' : id
                  },
                  success: function (data) 
                  {
                    alert("updation success");
                    
                  },
         error: function (request, status, error) {
        alert(request.responseText);
    }
             
            });

            }
              catch (err) {
                alert(err.message);
              }
            }
            else
            {
               try {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Onlinecontrol/ChequetoReceipt",
                  data: {
                    'vendorinvoiceno': vendorinvoiceno,
                    'ledger': supplierid,
                    'currentbalance': currentbalance,
                    'narration': narration,
                    'totalamount': totalamount,
                    'cashorbank': cashorbank,
                    'status': status,
                    'id' : id
                  },
                  success: function (data) 
                  {
                    alert("updation success");
                    
                  },
         error: function (request, status, error) {
        alert(request.responseText);
    }
             
            });

            }
              catch (err) {
                alert(err.message);
              }
            }
  
        });
      });
     </script>
      <script type="text/javascript">
          $(document).ready(function () {

          $('#myTable').on('click','.delete', function () {

           
                 var id=$(this).closest("tr").find ('.id').html();
                 var type=$(this).closest("tr").find ('.type').html();
         
            try {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Onlinecontrol/Chequedelete",
                  data: {
                   
                    'id' : id
                  },
                  success: function (data) 
                  {
                    alert("deletion success");
                    
                  },
         error: function (request, status, error) {
        alert(request.responseText);
    }
             
            });

            }
              catch (err) {
                alert(err.message);
              }
           
  
        });
      });
     </script>
     









