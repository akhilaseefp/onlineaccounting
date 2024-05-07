<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>
<?php 
  
  ?>
<div class="content-wrapper">

   <section class="content-header">
      <h1>
        E Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">E Order</li>
      </ol>
    </section>

   <section class="content">
     <div class="box box-default">
     <div class="box-body">
      <div class="row">
        <div class="col-md-8">
               <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Order No :- <?php echo $order->result_array()[0]['no'];?></h4></div>
                <div class="panel-body">
                <table class="table borderless" id="order_table">
                <thead>
                     
                </thead>
                <tbody>
                   <?php $n=1; $totalstock=0;
                    foreach ($order->result() as $key) {
                    ?>
                  <!-- foreach ($order->lineItems as $line) or some such thing here -->
                  <tbody  style="background-color: #ddd;border: 10px solid #cfcbcb;padding: 50px;margin:30px;">
                  <tr>
                    <td class="col-md-3" rowspan="2">
                        <div class="media">
                          <div class="row" style="padding: 20px;">
                             <!-- <a class="thumbnail pull-left" target="_blank" href="<?php echo base_url();?>images/<?php echo $key->imagpath;?>" style="margin-bottom: 0px!important;"> <img class="media-object" src="<?php echo base_url();?>images/<?php echo $key->imagpath;?>" style="width: 82px; height: 82px;" > </a> -->
                             </div>
                             <input type="text" name="productname"  class="form-control"  autocomplete="off" id="productname<?php echo $n; ?>"
              value="<?php echo $key->productname;?>">

              <input type="text" name="referenceno"  class="form-control"  autocomplete="off" id="referenceno<?php echo $n; ?>"
              value="<?php echo $key->referenceno;?>"> 
                        </div>
                    </td>

         <!-- <td style=""><label for="male">Product</label></td> -->

            <td class="text-center" style="display: none;"><input type="text" name="detailsid" class="form-control detailsid"  autocomplete="off" id="detailsid<?php echo $n; ?>" value="<?php echo $key->eorderdetailsid;?>"></td>
             <td class="text-center" style="display: none;"><input type="text" name="detailsid" class="form-control detailsid"  autocomplete="off" id="hsn<?php echo $n; ?>" value="<?php echo $key->hsncode;?>"></td>


            <td class="text-center" colspan="3"> <label for="male">description</label><input type="text" name="description" class="form-control"  autocomplete="off" id="description<?php echo $n; ?>"
              value="<?php echo $key->description; ?>"></td>
            <td class="text-center" style=""><label for="male">Size</label><input type="text" name="size" class="form-control size"  autocomplete="off" id="size<?php echo $n; ?>" value="<?php echo $key->sizevalue;?>" readonly></td>
            <td class="text-center"><label for="male">Qty</label><input type="text" name="qty" readonly class="form-control"  autocomplete="off" id="qty<?php echo $n; ?>"
              value="<?php echo $key->qty;?>"></td>
              <td class="text-center"><label for="male">Mrp</label><input type="text" readonly name="amount" class="form-control"  autocomplete="off" id="mrp<?php echo $n; ?>"
              value="<?php echo $key->unitprice;?>"></td>
              <td class="text-center"><label for="male">COST</label><input type="text"  name="tax" class="form-control"  autocomplete="off" id="cost<?php echo $n; ?>"
              value="<?php echo $key->productcost;?>"></td></tr>
            <tr style="border-top-color: black!important;">  <td style="display: none;"><input type="text" name="productname" class="form-control"  autocomplete="off" id="product<?php echo $n; ?>"
              value="<?php echo $key->productname;?>"></td>
            <td class="text-center" style=""><label for="male">Net Amount</label><input type="text" name="detailsid" readonly class="form-control detailsid"  autocomplete="off" id="netamount<?php echo $n; ?>" value="<?php echo $key->netamount;?>"></td>
             <td class="text-center"> <label for="male">Tax Amount</label><input type="text" readonly name="description" class="form-control"  autocomplete="off" id="taxamount<?php echo $n; ?>"
              value="<?php echo $key->rowtaxamount;?>"><input type="hidden"  name="description" class="form-control"  autocomplete="off" id="tax<?php echo $n; ?>"
              value="<?php echo $key->tax;?>"></td>
              <td class="text-center"><label for="male">Grand total</label><input type="text" name="qty" readonly class="form-control"  autocomplete="off" id="totalamount<?php echo $n; ?>"
              value="<?php echo $key->amount;?>"></td>
              <td style="display:none"><input type="text" name="totalqty" readonly class="form-control"  autocomplete="off" id="totalqty"
              value="<?php echo $key->totalqty;?>"></td>
              <td style="display:none"><input type="text" name="oldbalance" readonly class="form-control"  autocomplete="off" id="oldbalance"
              value="<?php echo $key->oldbalance;?>"></td>
                   <!--  <td class="text-center"><label for="male">Paymnet</label><input type="text" name="amount" class="form-control"  autocomplete="off" id="amount<?php echo $n; ?>"
              value="<?php echo $key->amount;?>"></td> -->
                    <td style="display: none;" class="ctr"><?php echo $n;?></td> 
                     <td  colspan="2"> <label for="male">Item  Status </label> 
                      <input type="text" name="status" class="form-control"  autocomplete="off" value="<?php switch ($key->rowstatus) {
                        case 1:
                        echo 'Item Ready';
                        break;
                        case 2:
                        echo 'Shipped From DXB';
                        break;
                        case 3:
                        echo 'Reached PMNA';
                        break;
                        case 4:
                        echo 'Dispatch to Customer';
                        break;
                        case 5:
                        echo 'Delivered';
                        break;
                        case 6:
                        echo 'Returned';
                        break;

                        default:
                        echo 'Processing';
                      }?>">
              
                </td> 
                <!-- <td  colspan="2">
                <select class="form-control" name="status" id="status<?php echo $n;?>" required>
              <option selected="selected" value=""></option>
              <option  value="OrderReceived">Order Received</option>
               <option  value="Shipped">Shipped</option>
              <option  value="Cancelled">Cancelled</option>
              <option  value="Refunded">Refunded</option>
              <option value="Delivered">Delivered</option>
            </select>
            </td> -->
            <td class="text-center"><label for="male">Print Slip</label>
            <input type="checkbox" checked   autocomplete="off" id="print<?php echo $n; ?>"
             >
             </td>
                    <td  style="margin-top: 30px;"><input class="btn btn-success update"  type="button" name="btnupt" id="btnupt<?php echo $n; ?> " style="margin-top: 25px;" value="Update"><input class="btn btn-success return"  type="button" name="btnReturn" id="btnReturn<?php echo $n; ?> " style="margin-top: 25px;" value="Return"></td>
                   
                 

                  
                  </tr>
                  </tbody>

                    <?php
                    $n++;
                    $totalstock=$totalstock+$key->productcost;

                    }?>
                </tbody>
                </table> 
                <script type="text/javascript">
          $(document).ready(function () {

          $('#order_table').on('click','.update', function () 
          {
            
            var ctr=$(this).closest("tr").find ('.ctr').text();
            var description=$('#description'+ctr).val();
            var status=$('#status'+ctr).val();
            var productcost=$('#cost'+ctr).val();
            var detailsid=$('#detailsid'+ctr).val();
            var oldstock ="<?php echo $totalstock ;?>";
            var no=<?php echo $n;?>;
            var newstock=0;
            var orderno ="<?php echo $order->result_array()[0]['no'];?>";
            for (var i = 1; i < no; i++)
            { 
              var cost=$('#cost'+i).val();
              newstock=newstock+cost*1;
            }
            
            
            try{
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Esalescontrol/update_detailstatus",
                  data: {
                    'description': description,
                    'status': status,
                    'productcost' :productcost,
                    'detailsid': detailsid,
                    'orderno' :orderno,
                    'oldstock' :oldstock,
                    'newstock' :newstock
                   
                  },
                  success: function (data) 
                  {
                    alert("updation success");
                    location.reload();
                  },
                  error: function (request, status, error) {
        console.log(request.responseText);
    }
             
            });

            }
              catch (err) {
                alert(err.message);
              }
  
        });
            $('#order_table').on('click','.return', function () 
          {
            
            var ctr=$(this).closest("tr").find ('.ctr').text();
            
            var detailsid=$('#detailsid'+ctr).val();
           
          
           
            
            
            try{
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Esalescontrol/return_eorderitem",
                  data: {
                 
                    'status': 6,
                   
                    'detailsid': detailsid,
                   
                   
                  },
                  success: function (data) 
                  {
                    alert("return success");
                    location.reload();
                  },
                  error: function (request, status, error) {
        console.log(request.responseText);
    }
             
            });

            }
              catch (err) {
                alert(err.message);
              }
  
        });
      });
     </script>
                </div>

              <div style="display: none;" class="col-md-6">
                <?php foreach($order->result() as $key){ ?>
                <input  type="text" class="form-control" id="id" name="id" value="<?php echo $key->eordermasterid;?>" autocomplete="on">
                <input  type="text" class="form-control" id="ecom_no" name="ecom_no" value="<?php echo $key->eCommerce_no;?>" autocomplete="on">
                <input  type="text" class="form-control" id="branch" name="branch" value="<?php echo $key->branchid;?>" autocomplete="on">
                <input  type="text" class="form-control" id="customerid" name="customerid" value="<?php echo $key->customerid;?>" autocomplete="on">
                 <input  type="text" class="form-control" id="totalamount" name="totalamount" value="<?php echo $key->totalamount;?>" autocomplete="on">
                  <input  type="text" class="form-control" id="taxamount" name="taxamount" value="<?php echo $key->totaltax;?>" autocomplete="on">
                   <input  type="text" class="form-control" id="salesdate" name="salesdate" value="<?php echo $key->date_current;?>" autocomplete="on">
                    <input  type="text" class="form-control" id="billdiscount" name="billdiscount" value="<?php echo $key->billdiscount;?>" autocomplete="on">
                <?php  } ?>
              </div>

             
          </div>
          <script type="text/javascript">
          // var table = document.getElementById('order_table');
          
          // for(var i = 1; i < table.rows.length; i++)
          // {
                
          //       table.rows[i].onclick = function()
          //       {
          //           document.getElementById("name").value = this.cells[1].innerHTML;
          //           document.getElementById("descri").value = this.cells[3].innerHTML;
          //           document.getElementById("qty").value = this.cells[4].innerHTML;
          //           document.getElementById("amount").value = this.cells[5].innerHTML;
          //           document.getElementById("details_id").value = this.cells[2].innerHTML;

          //       }
          // }
              
          </script> 

          <div class="col-md-12"> 
          <div class="panel-heading text-center"><h4>Payment</h4></div>
          </div>

          
          
          <div style="background-color: #dddd;border: 10px solid #cfcbcb;padding: 50px;margin:30px;">
            <div class="row">

             <div class="col-md-3">
              <label>Grand Total :</label>
              <input class="form-control" readonly type="text" name="grandtotal" id="grandtotal" value="<?php echo $order->result_array()[0]['grandtotal'];?>">
            </div>
            <div class="col-md-3">
              <label>Discount :</label>
              <input class="form-control" readonly type="text" name="discount1" id="discount1" value="<?php echo $order->result_array()[0]['billdiscount'];?>">
            </div>
            <div class="col-md-3">
              <label>Paid cash :</label>
              <input class="form-control" readonly type="text" name="paidcash" id="paidcash" value="<?php echo $order->result_array()[0]['cash_payment'];?>">
            </div>
            <div class="col-md-3">
              <label>Paid Bank :</label>
              <input class="form-control" readonly type="text" name="paidbank" id="paidbank" value="<?php echo $order->result_array()[0]['bank_payment'];?>">
            </div>
            <div class="col-md-3">
              <label>Balance :</label>
              <input class="form-control" readonly type="text" name="balance" id="balance" value="<?php echo $order->result_array()[0]['balance']*1;?>">
            </div>


          </div>
          <?php 
                 // print_r($order->result()); die();
          ?>
          <div class="row" style="margin-top:25px;">
           <div style="display: none;" class="col-md-2">
            <?php foreach($order->result() as $key){ ?>
              <input type="text" class="form-control" id="id" name="id" value="<?php echo $key->eordermasterid;?>" autocomplete="on">
            <?php  } ?>
          </div>
          <div class="col-md-3">
            <label>Discount:</label>
            <input class="form-control" type="text" name="newdiscount" id="newdiscount" value="
            0.00">
          </div>
          <div class="col-md-3">
            <label>Cash Payment :</label>
            <input class="form-control" type="text" name="cashpayment" id="cashpayment" value="0.00">
          </div>
          <div class="col-md-3">
            <label>Bank Payment :</label>
            <input class="form-control" type="text" name="bankpayment" id="bankpayment" value="0.00">
          </div>
          <div class="col-md-3">
            <label>Status :</label>
            <select class="form-control" name="status" id="masterstatus" required>
              <?php

              foreach($paymentstatus->result() as $s){?>

                <?php if($s->status === $order->result_array()[0]['status']){ log_message('error', $s->status); ?>
                <option value="<?php echo $s->status;?>" selected><?php echo $s->status; ?></option>
              <?php }
              else { 
                ?>   
                <option value="<?php echo $s->status;?>" ><?php echo $s->status; ?></option>
              <?php }
            }?>
          </select>
        </div>

        <div class="row" style="">
          <div class="col-md-12" >
            <input  class="btn btn-success" type="submit" name="" value="Update & Pay" id="btnpayment" style="margin-top: 25px;margin-left:40%;">
          </div> 
        </div>

        <script type="text/javascript">
         $(document).ready(function () {
           $('#btnpayment').on('click', function () {this.disabled=true;
            var paidcash = document.getElementById("cashpayment").value;
            var paidbank = document.getElementById("bankpayment").value;
            var customerid = document.getElementById("customerid").value;
            var newdiscount = document.getElementById("newdiscount").value;
            var masterid = document.getElementById("id").value;
            var voucherno = document.getElementById("ecom_no").value;
            var branch = document.getElementById("branch").value;
            var status = document.getElementById("masterstatus").value;
            var balance = document.getElementById("balance").value;
            alert(balance);

            try {
              $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>index.php/Esalescontrol/upd_esalespay",
                data: {
                  'branch': branch,
                  'customerid': customerid,
                  'paidcash': paidcash,
                  'paidbank': paidbank,
                  'masterid': masterid,
                  'newdiscount': newdiscount,
                  'balance': balance,
                  'voucherno': voucherno,
                  'status' :status,
                },
                success: function (data) 
                {
                  alert(data);
                  alert("Paid Succesfully...!");
                  location.reload();
                },
                error: function (request, status, error) {
                  alert("error");

                }
              });

            }
            catch (err) {
              alert(err.message);
            }
          });
         });
       </script>
     </div>
   </div>



           <div class="row">
            <div class="col-md-12">
            <button id="pre_data"> Previous Data</button>
              
              <div class="table">

              <table style="width:100%;" border="1" class="table table-striped table-hover" id=""  style="visibility:hidden ;">
                  <thead>
                    <tr>
                      <th class="">Order Number</th>
                      <th class="">Ecom Number</th>
                      <th class="">Date</th>
                      <th style="">Product Name</th>
                      <th class="">Amount</th>
                    </tr>
                    <?php //print_r($prev_orders); die(); ?>
                    <?php
                    if($prev_orders){
                      foreach ($prev_orders as $row) { ?>

                        <tr>
                          <td><?php echo $row['eordermasterid'];  ?></td>
                          <td><?php echo $row['referenceno'];  ?></td>
                          <td><?php echo $row['orderdate'];  ?></td>
                          <td><?php echo $row['productname'];  ?></td>
                          <td><?php echo $row['amount'];  ?></td>
                          <td><?php echo $row['status']; ?></td>

                        </tr>
                      <?php }} ?>

                    </thead>

                    <tbody id="shp_tab1">
                    </tbody>
                  </table>
                  <div align="center"><input class="btn btn-warning" type="button" name="btnclose" value="Print Invoice" id="btnclose" ></div>
                  <br>
                  <div align="center"><input class="btn btn-warning" type="button" name="btnclose2" value="Print Delivery Slip" id="btnclose2" ></div>
                </div>     
              </div>
            </div>

            </div>
          <script type="text/javascript">
             function payment(){
              var table = document.getElementById("shp_tab1");
               $('#shp_tab1  tr').remove();

              ctr++;
              var branch = document.getElementById("branch").value;
              var id = document.getElementById("id").value;
              var customerid = document.getElementById("customerid").value;
              var orderno=document.getElementById("ecom_no").value;
              try{
                $.ajax({
                  type: "POST",
                  dataType: 'json',
                  url: "<?php echo base_url(); ?>index.php/Esalescontrol/getesalespay",
                  data: {
                    'branch': branch,
                    'customerid': customerid,
                    'id': id,
                    'orderno' :orderno
                  },
                  success: function (data) {
                  var master=JSON.parse(JSON.stringify(data)); 
                     for(i=0;i<master['branchledger'].length;i++){
                    var bankname = master['branchledger'][i]['ledgername'];
                    var type = master['branchledger'][i]['accountType'];
                    var date = master['branchledger'][i]['date'];
                     var balance = master['branchledger'][i]['balance'];
                     var paidamount = master['branchledger'][i]['paidamount'];
                   
                    var rowCount = document.getElementById('shp_tab1').rows.length + 1; 
                    var newTr = '<tr><td>'+(i*1+1)+'</td><td>'+type+'</td><td>'+date+'</td><td>'+bankname+'</td><td>'+paidamount+'</td><td>'+balance+'</td></tr>';
                    $('#shp_tab').append(newTr);
                    }
                    
                  },
                  error: function () {

                    alert('Error occur...!!');

                    }
                  });
                } catch (err) {
                  alert(err.message);
                }
              }

          
     </script>

            <div class="col-md-4">
                 <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <h4>Customer</h4>
                        </div>
                        <div class="panel-body">
                          <?php foreach($cust->result() as $c){ ?>
                                <div class="col-md-12">
                                  <strong>Name:</strong>
                                    <div class="pull-right"><b><?php echo $c->customername;?></b></div>
                                    
                                </div>
                                
                                <div class="col-md-12">
                                    <strong>Email</strong>
                                    <div class="pull-right"><span><?php echo $c->email;?></span></div>
                                </div>
                                <div class="col-md-12">
                                    <strong>Mobile</strong>
                                    <div class="pull-right"><span></span><span><?php echo $c->phonenumber;?></span></div>
                                </div>
                                  
                                <!-- <div class="col-md-12">
                                    <small>Account Registered</small>
                                    <div class="pull-right"><span>12/6/2020</span></div>
                                    <hr>
                                </div> -->
                                <div class="col-md-12">
                                  <div class="panel-heading text-center" style="background-color:#b1c7f2">
                                    <strong>Permenent Address</strong>
                                  </div>
                                  <div class="text-center" style="border:1px solid black; margin-bottom: 10px;">
                                    <strong>Name : </strong><b><?php echo $c->customername;?></b><br>
                                    <br><strong>Phone No : </strong><?php echo $c->phonenumber;?><br>
                                    <br><strong>Email : </strong><?php echo $c->email;?><br>
                                    <br><strong>Address : </strong><?php echo $c->address;?><br>
                                   <?php echo $c->state;?>
                                  </div>
                                </div>
                                <?php  } ?>

           <div class="row" style="padding-top:50px;">
            <div class="col-md-12">
              <div class="panel-heading text-center" style="background-color:#b1c7f2">
                    <strong>Shipping Address</strong>
             </div>
              <div class="table">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="shp_tab0">
                  <thead>
                  <tr>
<!--                     <th>Name</th>
                    <th>Name</th>
                    <th>Name</th>
                    <th>Name</th>
                    <th>Name</th>
                    <th>Name</th> -->

                  </tr>
                  </thead>
                    <tbody id="shp_tab12">
                      <tr>
                      <?php 
                      //print_r($ship->result()); die();
                        //if($ship->result()) {
                      foreach($ship->result() as $sp){ ?>
                        <tr><td style="display: none;"><input type="text" class="form-control" name="" id="Shippingid"  value="<?php echo $sp->id;?>"/></td></tr>

                      <tr><td style="width:200px;"><b>Name</b><input  type="text" class="form-control" name="" id="nm"  value="<?php echo $sp->fullname;?>"/></td></tr>

                      <tr><td style=""><b>Address</b><textarea maxlength="60" type="textarea" class="form-control clscost" name="" id="addrs" style="text-transform: uppercase;"><?php echo $sp->street;?></textarea></td></tr>

                      <tr><td style=""><b>Address 2</b><textarea maxlength="60"type="textarea" class="form-control clscost" name="" id="addrs2" style="text-transform:uppercase;"><?php echo $sp->street2;?></textarea></td></tr>

                      <tr><td style="width:150px;"><b>Phone Number</b><input  type="text" minlength="10" class="form-control clscost" name="" id="pho"  value="<?php echo $sp->mobileNo;?>"/></td></tr>

                      <tr><td style="width:150px;"><b>Phone Number 2</b><input  type="text" minlength="10" class="form-control clscost" name="" id="pho2"  value="<?php echo $sp->mobileNo2;?>"/></td></tr>

                      <tr><td style="width:150px;"><b>Pin Code</b><input  type="text" class="form-control clscost" name="" id="pin"  value="<?php echo $sp->postalCode;?>"/></td></tr>

                      <tr><td style="width:150px;"><b>land Mark</b><input  type="text" class="form-control clscost" name="" id="land"  value="<?php echo $sp->landmark;?>"/></td></tr>

                      <tr><td style="width:150px;"><b>City</b><input  type="text" class="form-control clscost" name="" id="city"  value="<?php echo $sp->city;?>"/></td></tr>

                      <tr><td style="width:150px;"><b>State</b><input style=" text-transform: uppercase;" type="text" list="statelist" autocomplete="off" class="form-control clscost" name="" id="state"  value="<?php echo $sp->state;?>"/></td></tr>

                       <tr><td style="width:150px;"><b>Country</b><input style=" text-transform: uppercase;" type="text" class="form-control clscost" list="countrylist" required autocomplete="off"  name="country" id="country" label="<?php echo $sp->country_id;?>" value="<?php echo $sp->country_name;?>"></td></tr>


                      <td style="width:50px;"><input type="submit" style="width: 100%;" class="btn btn-success btnsub" value="Submit" name="btnsub" id="btnsub"/></td>
                      <?php } //} ?>
                      </tr>
                    </tbody>
                 </table>
                </div>     
              </div>
            </div> 
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"> </script>
             <script>
        $(document).ready(function() {
            $('input').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
        });
    </script> 
                  
            <script type="text/javascript">
                  var ctr = 1;
                  $(document).ready(function () {

                  $('#shp_tab0').on('click','.btnsub', function () {

                    var name= document.getElementById("nm").value;
                    var address= document.getElementById("addrs").value;
                    var address2= document.getElementById("addrs2").value;
                    var phone_number= document.getElementById("pho").value;
                    var phone_number2= document.getElementById("pho2").value;

                    var pin_code= document.getElementById("pin").value;
                    var land_mark= document.getElementById("land").value;
                     var city= document.getElementById("city").value;
                     var state= document.getElementById("state").value;
                     var country = $("#countrylist option[value='" + $('#country').val() + "']").attr('label');
                      // var country= document.getElementById("country").value;
                    var detailsid = document.getElementById("Shippingid").value;
                    var customerid = document.getElementById("customerid").value;
                    
                   
                    // $.noConflict();
                    try {
                      $.ajax({
                          type: "POST",
                          url: "<?php echo base_url() ?>index.php/Esalescontrol/upd_ecustmer",
                          data: {
                            'name': name,
                            'address': address,
                            'address2': address2,
                            'phone_number': phone_number,
                            'phone_number2': phone_number2,
                            'pin_code': pin_code,
                            'land_mark': land_mark,
                            'detailsid': detailsid,
                            'customerid': customerid,
                            'city' :city,
                            'state' :state,
                            'country' : country
                          },
                          success: function (data) 
                          {
                            alert("Update Succesfully...!");
                            $('alpaid').val(payment);
                            $('albalance').val(balance);
                            $('payment').val();
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
             <script type="text/javascript">
               window.onload = function () {try{
                payment();
}
   catch(err){
     alert(err.message);
   }
 }
             </script>
                  </div>
              </div>
            </div>
          </div>
      </section>
        <datalist  id="statelist" >
<option value="Andhra Pradesh">Andhra Pradesh</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option value="Arunachal Pradesh">Arunachal Pradesh</option>
<option value="Assam">Assam</option>
<option value="Bihar">Bihar</option>
<option value="Chandigarh">Chandigarh</option>
<option value="Chhattisgarh">Chhattisgarh</option>
<option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
<option value="Daman and Diu">Daman and Diu</option>
<option value="Delhi">Delhi</option>
<option value="Lakshadweep">Lakshadweep</option>
<option value="Puducherry">Puducherry</option>
<option value="Goa">Goa</option>
<option value="Gujarat">Gujarat</option>
<option value="Haryana">Haryana</option>
<option value="Himachal Pradesh">Himachal Pradesh</option>
<option value="Jammu and Kashmir">Jammu and Kashmir</option>
<option value="Jharkhand">Jharkhand</option>
<option value="Karnataka">Karnataka</option>
<option value="Kerala" >Kerala</option>
<option value="Madhya Pradesh">Madhya Pradesh</option>
<option value="Maharashtra">Maharashtra</option>
<option value="Manipur">Manipur</option>
<option value="Meghalaya">Meghalaya</option>
<option value="Mizoram">Mizoram</option>
<option value="Nagaland">Nagaland</option>
<option value="Odisha">Odisha</option>
<option value="Punjab">Punjab</option>
<option value="Rajasthan">Rajasthan</option>
<option value="Sikkim">Sikkim</option>
<option value="Tamil Nadu">Tamil Nadu</option>
<option value="Telangana">Telangana</option>
<option value="Tripura">Tripura</option>
<option value="Uttar Pradesh">Uttar Pradesh</option>
<option value="Uttarakhand">Uttarakhand</option>
<option value="West Bengal">West Bengal</option>
</datalist>
<datalist id="countrylist">
								<?php
								foreach ($country->result() as $cust)
								{
								?>
								<option value="<?php echo $cust->country_name; ?>" label="<?php echo $cust->country_id;?>"></option>
								<?php } ?>
							</datalist>
      </div>


      <script type="text/javascript">
       function prints(){  var no=<?php echo $n;?>;
         // var bicus= $("#customer").val();
                     var customername = $('#nm').val();
                                      
                     var grandtotal = (document.getElementById("grandtotal").value)*1;
                      var taxamount = (document.getElementById("taxamount").value)*1;
                     try{
                     var inwords = toWords(grandtotal);
                  }catch(err){
                    alert(err.message);
                  }
                     var totalamount = (document.getElementById("totalamount").value)*1;
                     // var points = grandtotal*1/100;
                     // var redpointbalance = (document.getElementById("pointbalance").value)*1;
                     //var pointbalance = redpointbalance+points;
                     // var pointredeem = (document.getElementById("pointredeem").value)*1;
                     // var pointbalance = (redpointbalance+points-pointredeem).toFixed(2);
                     var billdiscount = document.getElementById("billdiscount").value;
                     var paidcash = (document.getElementById("paidcash").value)*1;
                     var paidbank = (document.getElementById("paidbank").value)*1;
                     var totalqty = (document.getElementById("totalqty").value)*1;
                     var balance = (document.getElementById("balance").value*1).toFixed(2);
                     var oldbalance = (document.getElementById("oldbalance").value*1).toFixed(2);
                     var salesdate = document.getElementById("salesdate").value;
                     var invoiceno = document.getElementById("ecom_no").value;
                     // var branchid = document.getElementById("branch").value;
                     var  state = $('#state').val();
                      var cgst=0;
                      var sgst=0;
                       var igst=0;
                     if(state=="Karnataka"){
                      cgst=(taxamount/2).toFixed(2);
                      sgst=(taxamount/2).toFixed(2);
                      igst=0;

                     }else{
                      cgst=0;
                      sgst=0;
                      igst=taxamount.toFixed(2);

                     }
        
                     var paidamount = paidcash + paidbank;
                    
                       var ship_address=$('#addrs').val();
                       var ship_address2=$('#addrs2').val();
                       var  number1 = $('#pho').val();
                       var  number2 = $('#pho2').val();
                       var  countryname = $('#country').val();
                      //  var country = $("#countrylist option[value='" + $('#country').val() + "']").attr('label');
                       var pin =$('#pin').val();
        
                       

                    
                       var mywindow = window.open('', '', 'height=600,width=1000');
    mywindow.document.write('<html><head><title>Print</title><style>*{font-family: "Lucida Console", Monaco, monospace;}.imgg{float:left; padding:20px;}.moahead{font-size:40px;letter-spacing:9px;font-family: "Lucida Console";}center{padding:20px;}.invoice{color:white; font-size:25px; background-color:black;}hr{border-top: 1px dashed black;}  table{border-collapse: collapse; border-width:3px!important;border-style:double!important;border-color:black; margin-top: 10px; } th {   border:1px solid;	background-color: #CCE7E7;    }</style>');
    mywindow.document.write('</head><body>');
    // mywindow.document.write(content);
    mywindow.document.write('<center><span class="invoice"></span><br><span class="moahead">MALL OF ABAYAS</span><br><span>First floor,No.88,Room No.F04,5th Block,</span><br><span>Koramangala Industrial Layout, Bengaluru, Karnataka, PIN 560095<br> info@mallofabayas.com | GSTIN: 29ABIFM2960L1ZQ </span></center>');
	mywindow.document.write('<table>');
	mywindow.document.write('<tr><td style="padding:5px;text-align:center;border:3px double;" colspan="14"><b>Invoice</td></tr>');

	mywindow.document.write('<tr style=""><td style="padding:5px;text-align:center;border:3px double;" colspan="7"><b>Invoice Details : </b></td><td style="padding:5px;text-align:center;border:3px double;" colspan="7"><b>Details Of Receiver |Billed to : </b></td></tr>');

	mywindow.document.write('<tr VALIGN="TOP"><td style="padding:5px;border-left:1px solid;border-bottom:1px solid;" colspan="3"> Invoice NO <br>Invoice Date<br>State </td><td style="padding:5px;border-bottom:1px solid;" colspan="4">: '+invoiceno+'<br>: '+salesdate+'<br>: Kerala</td><td style="padding-top:5px!important;border-left:1px solid;border-bottom:1px solid;" colspan="3">Address :</td><td style="padding:5px;border-bottom:1px solid;border-right:1px solid;" colspan="4">'+customername+'<pre style="margin:0;padding:0;">'+ship_address+'</pre>'+state+'<br>'+number1+'</td></tr>');

    mywindow.document.write('<thead><tr><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th><th style="display:none;"></th></tr></thead><tbody>');
    mywindow.document.write('<tr><td colspan="14" style="color:white">|</td></tr>');


    mywindow.document.write('<thead><tr><th style="padding:10px;" rowspan="2">SL NO</th><th style="padding:10px;" rowspan="2">Product Name</th><th style="padding: 10px;" rowspan="2">HSN / SAC Code</th><th style="padding: 10px;" rowspan="2">Qty</th><th style="padding: 10px;" rowspan="2">Size</th><th style="padding: 10px;" rowspan="2">Unit Rate</th><th style="padding: 10px;" rowspan="2">Amount</th><th style="padding: 10px;" colspan="2">CGST</th><th style="padding: 10px;" colspan="2">SGST</th><th style="padding: 10px;" colspan="2">IGST</th><th style="padding: 10px;" rowspan="2">Total</th></tr><tr><th style="padding: 10px;" >Rate</th><th style="padding: 10px;">Amount</th><th style="padding: 10px;">Rate</th><th style="padding: 10px;" >Amount</th><th style="padding: 10px;">Rate</th><th style="padding: 10px;">Amount</th></tr></thead><tbody>');

  
    for (var i = 1; i < no; i++)
  {  
   
    // var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").data('label');
      var hsn= 0;
      // var sqft = 0;
      var mrp = 0;
      var sizename = 0;
      var qty = 0;
      var batch=0;
      var descr ="";
      var productname = $('#productname'+i).val();
        
        descri = $('#description'+i).val();
       
        mrp = $('#mrp' + i).val();
        hsn = $('#hsn' + i).val();        
        sizename =$('#size'+i).val();
        qty = $('#qty' + i).val();      
      var netamount = $('#netamount' + i).val();
      var tax=$('#tax' + i).val();   
      var taxamount=$('#taxamount' + i).val();  
      var rowtotalamount = ($('#totalamount' + i).val()*1).toFixed(2); 
      var cgstt=0;
      var sgstt=0;
      var igstt=0;
      var cgsttamount=0;
      var sgsttamount=0;
      var igsttamount=0;
      if(state=="Karnataka"){

       
        sgstt=(tax/2);
        igstt =0.00;
       
        sgsttamount=(taxamount/2);
        igsttamount =0.00;


      }
      else{
       
        sgstt=0.00;
        igstt=tax;
       
        sgsttamount=0.00;
        igsttamount=taxamount;

      }
     
      
     
      if(productname!=null && productname!="")
		{
			mywindow.document.write('<tr><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+i+'</td><td style="padding:3px;text-align:left;border-bottom:none;border-top:none;border-right:1px solid;">'+productname+'</td><td style="padding:3px;text-align:left;border-bottom:none;border-top:none;border-right:1px solid;">'+hsn+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+qty+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+sizename+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+mrp+'</td><th style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+netamount+'</th><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+sgstt+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+sgsttamount+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+sgstt+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+sgsttamount+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+igstt+'</td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+igsttamount+'</td><th style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;">'+(rowtotalamount)+'</th></tr>');
		}
    
  }
  var extra =25-no;
	
	if(extra>0){
		for(var no=1;no<extra;no++) 
	{
mywindow.document.write('<tr><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid black;color:white">|</td><td style="padding:3px;text-align:left;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:left;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><th style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></th><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><td style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></td><th style="padding:3px;text-align:center;border-bottom:none;border-top:none;border-right:1px solid;"></th></tr>');




	}
	}
  
  mywindow.document.write('<tr><th colspan="3""><b>Total</b></th><th><b>'+totalqty+'</b></th><th></th><th></th><th><b>'+totalamount+'</b></th><th colspan="2">'+sgst+'</th><th colspan="2">'+sgst+'</th><th colspan="2">'+igst+'</th><th>'+(grandtotal.toFixed(2))+'</th></tr>');
	 mywindow.document.write('<tr><td colspan="14" style="color:white">|</td></tr>');
	  mywindow.document.write('<tr><td colspan="7" rowspan="1" style="text-align:left;border-right:1px solid;border-top:1px solid;"><b>Total Invoice Amount in Words </b></td><th colspan="5" style="border-right:1px solid;">Total Amount Before Tax </th><th colspan="2">'+totalamount+'</th></tr><tr><td colspan="7" rowspan="5" style="text-align:center;border-right:1px solid;"><br>Rupees '+inwords+' Only<br><br></td><td colspan="5" style="border-right:1px solid;border-bottom:1px solid;">Total CGST</td><td colspan="2" style="border-bottom:1px solid;">'+sgst+'</td></tr><tr><td colspan="5" style="border-right:1px solid;border-bottom:1px solid;"">Total SGST</td><td colspan="2" style="border-bottom:1px solid;">'+sgst+'</td></tr><tr><td colspan="5" style="border-right:1px solid;">Total IGST</td><td colspan="2">'+igst+'</td></tr><tr><th colspan="5" style="border-right:1px solid;">Total GST</th><th colspan="2">'+(igst*1+sgst*2)+'</th></tr><tr><th colspan="5" style="border-right:1px solid;">Total Amount After Tax</th><th colspan="2">'+grandtotal+'</th></tr>');
	
	
	mywindow.document.write('<tr><td colspan="14" style="color:white;border-top:1px solid black;">|</td></tr><tr style="padding:30px;"><th colspan="7"> Bank Details</th><th colspan="7">Signature & Seal</th></tr><tr><td colspan="3" style="color:white;">|</td><td colspan="4"></td><td colspan="7" rowspan="10" style="border-left:1px solid;border-bottom:1px solid;"></tr><tr><td colspan="3">Account Name </td><td colspan="4"> : Mall Of Abayas</td></tr><tr><td colspan="3" style="color:white;">|></td><td colspan="4"></td></tr><tr><td colspan="3">Account Number</td><td colspan="4">: 50200031021499</td></tr><tr><td colspan="3" style="color:white;">|></td><td colspan="4"></td></tr><tr><td colspan="3" style=""> Branch IFSC</td><td colspan="4" style="">: HDFC0000053</td></tr><tr><td colspan="3" style="color:white;">|</td><td colspan="4"></td></tr><tr><td colspan="3" style="color:white;">|</td><td colspan="4"></td></tr><tr><td colspan="3" style="color:white;">|</td><td colspan="4"></td></tr><tr><td colspan="3" style="color:white;border-bottom:1px solid black;">|</td><td colspan="4" style="border-bottom:1px solid;"></td></tr><tr><td colspan="14" style="color:white;border-top:1px solid;">|</td></tr></tbody></table>');
	
    mywindow.document.write('</body></html>');

// mywindow.document.write('<td style="padding: 20px;" colspan="6">----------------------------------------------------------------------------------------------------</td>');

mywindow.document.close();
    mywindow.focus();
    mywindow.print();

       }

function printslip()
{
  var no=<?php echo $n;?>;
  // var bicus= $("#customer").val();
  var customername = $('#nm').val();
  var grandtotal = (document.getElementById("grandtotal").value)*1;
  var taxamount = (document.getElementById("taxamount").value)*1;
                     try{
                     var inwords = toWords(grandtotal);
                  }catch(err){
                    alert(err.message);
                  }
                     var totalamount = (document.getElementById("totalamount").value)*1;
                     // var points = grandtotal*1/100;
                     // var redpointbalance = (document.getElementById("pointbalance").value)*1;
                     //var pointbalance = redpointbalance+points;
                     // var pointredeem = (document.getElementById("pointredeem").value)*1;
                     // var pointbalance = (redpointbalance+points-pointredeem).toFixed(2);
                     var billdiscount = document.getElementById("billdiscount").value;
                     var paidcash = (document.getElementById("paidcash").value)*1;
                     var paidbank = (document.getElementById("paidbank").value)*1;
                     var balance = (document.getElementById("balance").value*1).toFixed(2);
                     var salesdate = document.getElementById("salesdate").value;
                     var invoiceno = document.getElementById("ecom_no").value;
                     // var branchid = document.getElementById("branch").value;
                     var  state = $('#state').val();
                      var cgst=0;
                      var sgst=0;
                       var igst=0;
                     if(state=="Karnataka"){
                      cgst=(taxamount/2).toFixed(2);
                      sgst=(taxamount/2).toFixed(2);
                      igst=0;

                     }else{
                      cgst=0;
                      sgst=0;
                      igst=taxamount.toFixed(2);

                     }
        
                     var paidamount = paidcash + paidbank;
                    
                       var ship_address=$('#addrs').val();
                       var ship_address2=$('#addrs2').val();
                       var  number1 = $('#pho').val();
                       var  number2 = $('#pho2').val();
                       var  landmark = $('#land').val();
                       var  countryname = $('#country').val();
                       var countryname = countryname.toUpperCase();
                      //  var country = $("#countrylist option[value='" + $('#country').val() + "']").attr('label');
                       var pin =$('#pin').val();
                       var mywindow = window.open('', 'Print', 'height=600,width=1000');
    


mywindow.document.write('<html><head><title>Print</title><style>*{font-family: "Times New Roman", Sans-serif;}.moahead{font-size:30px;letter-spacing:9px;font-family: "Lucida Console";}.mainclass{border-top: 0.5px solid black;border-left: 0.5px solid black;border-right: 0.5px solid black;text-align:right;}.clearfix::after{clear:both;content:"";display:table;align-items:bottom;}.invoice{color:white;font-size:20px; background-color:black;}hr{border-top: 1px dashed black;}.headerspan{font-size:14px;margin-left:30%;margin-top:50px;}</style>');
mywindow.document.write('</head><body>');
mywindow.document.write('<div class="mainclass clearfix"><img style="width:120px;height:80px;float:left;" src="<?php echo base_url();?>images/MOALOGO.png"><span class="headerspan"><br>First floor,No.88,Room No.F04,5th Block <br> Koramangala, Industrial Layout Bengaluru, Karnataka <br>  PIN 560095 info@mallofabayas.com GSTIN: 29ABIFM2960L1ZQ <br> Whatsapp:+971 56 809 6288 Contact:+91 9778328120</span></div>');
mywindow.document.write('<table cellspacing=0 style="width: 100%;height:37vh; border:1px solid black;" >');
// mywindow.document.write('<tr><td style="padding:5px;" colspan="6"></td></tr>');
 mywindow.document.write('<tr><td colspan="6">Delivery Address :</td><td style="width:10%;text-align:center;border-bottom:1px solid black;border-left:1px solid black;">EcomNo</td><td style="text-align:center;border-bottom:1px solid black;border-left:1px solid black;">Particulars</td></tr><tr valign=top><td style="padding:20px 70px;"  colspan="6" rowspan="'+(no-1)+'"><span style="font-size: 110%;">'+customername+'</span><pre style="margin:0;padding:0;font-size:110%;">'+ship_address+'<br></pre><pre style="margin:0;padding:0;font-size:110%;">'+ship_address2+'<br></pre><span style="font-size: 110%;">'+landmark+'</span><br><span style="font-size: 110%;">'+state+'</span><br><span style="font-size: 110%;">'+countryname+'</span> , <span style="font-size: 110%;">'+pin+'</span><br><span style="font-size: 110%;">CONTACT NO: '+number1+'</span><br><span style="font-size: 110%;">'+number2+'</span></td>');
    // mywindow.document.write('<thead><tr><th style="display:none;"></th><th style="display:none;"></th></tr></thead><tbody>');
    // mywindow.document.write('<thead><tr><td style="padding:10px 0px;width:10%;">Sl No</td><td style="padding:10px 0px;width:10%;">EcommerceNo</td><th style="padding:10px 0px;">Particulars</th></tr></thead><tbody>');
     var n=1;
   for (var i = 1; i < no; i++)
  {  
   
    // var productname = $("#name option[value='" + $('#productcode'+i).val() + "']").data('label');
      var hsn= 0;
      // var sqft = 0;
      var mrp = 0;
      var sizename = 0;
      var qty = 0;
      var batch=0;
      var descr ="";
      var productname = $('#productname'+i).val();
      var referenceno = $('#referenceno'+i).val();
      descri = $('#description'+i).val();
      mrp = $('#mrp' + i).val();
      hsn = $('#hsn' + i).val();        
      sizename =$('#size'+i).val();
      qty = $('#qty' + i).val();      
      var netamount = $('#netamount' + i).val();
      if($('#print'+i).prop('checked')==true)
      {
        if(n==1){
          mywindow.document.write('<td style="text-align:center;border-left:1px solid black;padding:0;">'+referenceno+'</td><td style="text-align:center;border-left:1px solid black;padding:0;">'+productname+'</td></tr>');
        }else{
          mywindow.document.write('<tr style="border:0px;" valign=top><td style="text-align:center;border-left:1px solid black;padding:0!important;">'+referenceno+'</td><td style="text-align:center;border-left:1px solid black;padding:0!important;">'+productname+'</td></tr>');
        }
        n++;
      }
      
  }
  mywindow.document.write('<tr><td colspan="9" style="border-top:1px solid black;font-size:13px;text-align:center;">For Mall of abayas - Digitally Verified:Signature Not Required</td></tr>');
  mywindow.document.write('</tbody> </table>');
  mywindow.document.write('<br><span style="float:right;margin-right:50px;">Team MOA</span>');

  mywindow.document.write('</body></html>');
  // mywindow.document.write(not);
  // mywindow.document.write(foot);
  var delayInMilliseconds = 3000; //3 second

setTimeout(function() {
  mywindow.document.close();
  mywindow.focus();
  mywindow.print();
}, delayInMilliseconds);
  

}

</script>
<script>
$(document).ready(function () {


        $('#btnclose').on('click', function () {
           try{
            prints();
          }catch(err){
            alert(err.message);
          }
                          
            });

          

        });
      </script>
      <script>
$(document).ready(function () {


        $('#btnclose2').on('click', function () {
           try{
            var phone_number= document.getElementById("pho").value;
                    var phone_number2= document.getElementById("pho2").value;
                    if (phone_number.length < 9) {
                      alert("check phone number");
                    }
                    else{
            printslip();
                                          
                    }

          }catch(err){
            alert(err.message);
          }
                          
            });

          

        });
      </script>



<script>

$("#cashpayment").change(function(){

  var cashpayment = document.getElementById("cashpayment").value*1;
  var bankpayment = document.getElementById("bankpayment").value*1;
  var paidcash = document.getElementById("paidcash").value*1;
  var paidbank = document.getElementById("paidbank").value*1;
  var paidamount = paidcash + paidbank;
  var bankpayment = document.getElementById("bankpayment").value*1;
  var newdiscount = document.getElementById("newdiscount").value*1;
  var grandtotal = document.getElementById("grandtotal").value*1;
  var balance = document.getElementById("balance").value;
  var discount11 = document.getElementById("discount1").value*1;
  
  var newtotal= (grandtotal-paidamount-discount11).toFixed(2);
  
  
if(cashpayment==null||cashpayment=="")
{
  cashpayment=0;
    var newbalance=(newtotal-(cashpayment+bankpayment+newdiscount))*1;
    $('#balance').val(newbalance);
  }
  else
  {
    var newbalance=(newtotal-(cashpayment+bankpayment+newdiscount))*1;
    $('#balance').val(newbalance);
  }

});

$("#bankpayment").change(function(){

  var cashpayment = document.getElementById("cashpayment").value*1;
  var bankpayment = document.getElementById("bankpayment").value*1;
  var paidcash = document.getElementById("paidcash").value*1;
  var paidbank = document.getElementById("paidbank").value*1;
  var paidamount = paidcash + paidbank;
  var bankpayment = document.getElementById("bankpayment").value*1;
  var newdiscount = document.getElementById("newdiscount").value*1;
  var grandtotal = document.getElementById("grandtotal").value*1;
  var balance = document.getElementById("balance").value;
  var discount11 = document.getElementById("discount1").value*1;
  
  var newtotal= (grandtotal-paidamount-discount11).toFixed(2);
  
if(bankpayment==null||bankpayment=="")
{
  bankpayment=0;
    var newbalance=(newtotal-(cashpayment+bankpayment+newdiscount))*1;
    $('#balance').val(newbalance);
  }
  else
  {
    var newbalance=(newtotal-(cashpayment+bankpayment+newdiscount))*1;
    $('#balance').val(newbalance);
  }
});

$("#newdiscount").change(function(){

  var cashpayment = document.getElementById("cashpayment").value*1;
  var bankpayment = document.getElementById("bankpayment").value*1;
  var paidcash = document.getElementById("paidcash").value*1;
  var paidbank = document.getElementById("paidbank").value*1;
  var paidamount = paidcash + paidbank;
  var bankpayment = document.getElementById("bankpayment").value*1;
  var newdiscount = document.getElementById("newdiscount").value*1;
  var grandtotal = document.getElementById("grandtotal").value*1;
  var balance = document.getElementById("balance").value;
  var discount11 = document.getElementById("discount1").value*1;
  
  var newtotal= (grandtotal-paidamount-discount11).toFixed(2);
  
if(newdiscount==null||newdiscount=="")
{
    newdiscount=0;
    var newbalance=(newtotal-(cashpayment+bankpayment+newdiscount))*1;
    $('#balance').val(newbalance);
  }
  else
  {
    var newbalance=(newtotal-(cashpayment+bankpayment+newdiscount))*1;
    $('#balance').val(newbalance);
  }

});

</script>



<script>



//--->number to word > start

    var root = typeof self == 'object' && self.self === self && self ||
        typeof global == 'object' && global.global === global && global ||
        this;
 

  // Simplified https://gist.github.com/marlun78/885eb0021e980c6ce0fb
  function isFinite(value) {
      return !(typeof value !== 'number' || value !== value || value === Infinity || value === -Infinity);
  }

 
  var ENDS_WITH_DOUBLE_ZERO_PATTERN = /(hundred|thousand|(m|b|tr|quadr)illion)$/;
  var ENDS_WITH_TEEN_PATTERN = /teen$/;
  var ENDS_WITH_Y_PATTERN = /y$/;
  var ENDS_WITH_ZERO_THROUGH_TWELVE_PATTERN = /(zero|one|two|three|four|five|six|seven|eight|nine|ten|eleven|twelve)$/;
  var ordinalLessThanThirteen = {
      zero: 'zeroth',
      one: 'first',
      two: 'second',
      three: 'third',
      four: 'fourth',
      five: 'fifth',
      six: 'sixth',
      seven: 'seventh',
      eight: 'eighth',
      nine: 'ninth',
      ten: 'tenth',
      eleven: 'eleventh',
      twelve: 'twelfth'
  };

  /**
   * Converts a number-word into an ordinal number-word.
   * @example makeOrdinal('one') => 'first'
   * @param {string} words
   * @returns {string}
   */
  function makeOrdinal(words) {
      // Ends with *00 (100, 1000, etc.) or *teen (13, 14, 15, 16, 17, 18, 19)
      if (ENDS_WITH_DOUBLE_ZERO_PATTERN.test(words) || ENDS_WITH_TEEN_PATTERN.test(words)) {
          return words + 'th';
      }
      // Ends with *y (20, 30, 40, 50, 60, 70, 80, 90)
      else if (ENDS_WITH_Y_PATTERN.test(words)) {
          return words.replace(ENDS_WITH_Y_PATTERN, 'ieth');
      }
      // Ends with one through twelve
      else if (ENDS_WITH_ZERO_THROUGH_TWELVE_PATTERN.test(words)) {
          return words.replace(ENDS_WITH_ZERO_THROUGH_TWELVE_PATTERN, replaceWithOrdinalVariant);
      }
      return words;
  }

  function replaceWithOrdinalVariant(match, numberWord) {
      return ordinalLessThanThirteen[numberWord];
  }

 
  /**
   * Converts an integer into a string with an ordinal postfix.
   * If number is decimal, the decimals will be removed.
   * @example toOrdinal(12) => '12th'
   * @param {number|string} number
   * @returns {string}
   */
  function toOrdinal(number) {
      var num = parseInt(number, 10);
      if (!isFinite(num)) throw new TypeError('Not a finite number: ' + number + ' (' + typeof number + ')');
      var str = String(num);
      var lastTwoDigits = num % 100;
      var betweenElevenAndThirteen = lastTwoDigits >= 11 && lastTwoDigits <= 13;
      var lastChar = str.charAt(str.length - 1);
      return str + (betweenElevenAndThirteen ? 'th'
              : lastChar === '1' ? 'st'
              : lastChar === '2' ? 'nd'
              : lastChar === '3' ? 'rd'
              : 'th');
  }

 
  var TEN = 10;
  var ONE_HUNDRED = 100;
  var ONE_THOUSAND = 1000;
  var ONE_MILLION = 1000000;
  var ONE_BILLION = 1000000000;           //         1.000.000.000 (9)
  var ONE_TRILLION = 1000000000000;       //     1.000.000.000.000 (12)
  var ONE_QUADRILLION = 1000000000000000; // 1.000.000.000.000.000 (15)
  var MAX = 9007199254740992;             // 9.007.199.254.740.992 (15)

  var LESS_THAN_TWENTY = [
      'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
      'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
  ];

  var TENTHS_LESS_THAN_HUNDRED = [
      'zero', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
  ];

  /**
   * Converts an integer into words.
   * If number is decimal, the decimals will be removed.
   * @example toWords(12) => 'twelve'
   * @param {number|string} number
   * @param {boolean} [asOrdinal] - Deprecated, use toWordsOrdinal() instead!
   * @returns {string}
   */
  function toWords(number, asOrdinal) {
      var words;
      var num = parseInt(number, 10);
      if (!isFinite(num)) throw new TypeError('Not a finite number: ' + number + ' (' + typeof number + ')');
      words = generateWords(num);
      return asOrdinal ? makeOrdinal(words) : words;
  }

  function generateWords(number) {
      var remainder, word,
          words = arguments[1];

      // We’re done
      if (number === 0) {
          return !words ? 'zero' : words.join(' ').replace(/,$/, '');
      }
      // First run
      if (!words) {
          words = [];
      }
      // If negative, prepend “minus”
      if (number < 0) {
          words.push('minus');
          number = Math.abs(number);
      }

      if (number < 20) {
          remainder = 0;
          word = LESS_THAN_TWENTY[number];

      } else if (number < ONE_HUNDRED) {
          remainder = number % TEN;
          word = TENTHS_LESS_THAN_HUNDRED[Math.floor(number / TEN)];
          // In case of remainder, we need to handle it here to be able to add the “-”
          if (remainder) {
              word += '-' + LESS_THAN_TWENTY[remainder];
              remainder = 0;
          }

      } else if (number < ONE_THOUSAND) {
          remainder = number % ONE_HUNDRED;
          word = generateWords(Math.floor(number / ONE_HUNDRED)) + ' hundred';

      } else if (number < ONE_MILLION) {
          remainder = number % ONE_THOUSAND;
          word = generateWords(Math.floor(number / ONE_THOUSAND)) + ' thousand,';

      } else if (number < ONE_BILLION) {
          remainder = number % ONE_MILLION;
          word = generateWords(Math.floor(number / ONE_MILLION)) + ' million,';

      } else if (number < ONE_TRILLION) {
          remainder = number % ONE_BILLION;
          word = generateWords(Math.floor(number / ONE_BILLION)) + ' billion,';

      } else if (number < ONE_QUADRILLION) {
          remainder = number % ONE_TRILLION;
          word = generateWords(Math.floor(number / ONE_TRILLION)) + ' trillion,';

      } else if (number <= MAX) {
          remainder = number % ONE_QUADRILLION;
          word = generateWords(Math.floor(number / ONE_QUADRILLION)) +
          ' quadrillion,';
      }

      words.push(word);
      return generateWords(remainder, words);
  }

  /**
   * Converts a number into ordinal words.
   * @example toWordsOrdinal(12) => 'twelfth'
   * @param {number|string} number
   * @returns {string}
   */
  function toWordsOrdinal(number) {
      var words = toWords(number);
      return makeOrdinal(words);
  }



    var numberToWords = {
        toOrdinal: toOrdinal,
        toWords: toWords,
        toWordsOrdinal: toWordsOrdinal
    };

    if (typeof exports != 'undefined') {
        if (typeof module != 'undefined' && module.exports) {
            exports = module.exports = numberToWords;
        }
        exports.numberToWords = numberToWords;
    } else {
        root.numberToWords = numberToWords;
    }

//--->number to word > end
</script>