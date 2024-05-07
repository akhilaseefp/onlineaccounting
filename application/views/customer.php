<script src="<?php echo base_url();?>js/jquery1.js"></script>           
<script type="text/javascript">
  $(document).ready(function(){
  $("#Searchcustomer").on("keyup", function() {
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
Customer       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Customer</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
                    <form class="seminor-login-form" method="post" action="<?php echo base_url();?>index.php/Onlinecontrol/insert_customer" enctype="multipart/form-data">

         <div class="row">

           <div class="col-sm-6">
                      <div class="form-group">
                      <label class="form-control-placeholder" for="contact-person">Customer name</label>
                      <input type="text" class="form-control" name="customername" id="customername"  required autocomplete="off">
                      <input type="text" class="form-control"  style="display: none;" name="customerid" id="customerid"  autocomplete="off">
                      <input type="text" class="form-control"  style="display: none;" name="customerbalance" id="customerbalance"  autocomplete="off">
                      </div>

                    <div class="form-group">
                     <!-- <label class="form-control-placeholder" for="contact-person">Customer Code</label> -->
                     <input type="hidden" class="form-control" name="customercode"  id="customercode" autocomplete="off" value="0">
                    </div>
                    <div class="form-group">
                     <label class="form-control-placeholder" for="contact-email">Address</label>
                     <textarea  name="address" id="address" class="form-control"></textarea> 
                    </div>
                    <div class="form-group">
                     <label class="form-control-placeholder" for="alternative-number">E-mail</label>
                     <input type="email" class="form-control" name="email" id="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                     <label class="form-control-placeholder" for="contact-person">Phone no</label>
                     <input name="phonenumber" id="phonenumber" class="form-control" required autocomplete="off" type="text">
                    </div>
                      <div class="form-group">
                     <!-- <label class="form-control-placeholder" for="contact-person">Credit limit</label> -->
                     <input type="hidden" name="limit" id="limit" value="0" class="form-control" required autocomplete="off" value="0">
                    </div>

          </div>
          
          <div class="col-sm-6">
                    <div class="form-group">
                    <label class="form-control-placeholder" for="alternative-number">website</label>
                    <input type="text"  name="website" id="website" class="form-control">
                    </div>        
                    <div class="form-group">
                     <label class="form-control-placeholder" for="contact-person">State</label>
                     <input type="text" name="state" id="state" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                     <label class="form-control-placeholder" for="contact-person">Country</label>
                     <input type="text" name="country" id="country" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                     <label class="form-control-placeholder" for="alternative-number">GST IN/VAT NO</label>
                     <input type="text" class="form-control" name="vatno" id="vatno" autocomplete="off">
                    </div>
                    <div class="form-group">
                     <!-- <label class="form-control-placeholder" for="alternative-number">Opening balance</label> -->
                     <input type="hidden" class="form-control" name="openingbalance"  id="openingbalance" autocomplete="off" value="0">
                    </div>
          </div>
        </div>
        
     <div class="row">
                    <div class="offset-md-4 margin">
           <input  class="btn btn-success" type="submit" name="btnsave" id="btnsave" value="Save">
            <input  class="btn btn-danger" type="submit" name="btndelete" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_customer">
            <input  class="btn btn-info" type="submit" name="btnclear" id="btnclear" value="Clear" formaction="javascript:void(0);">
            <input  class="btn btn-warning" type="submit" name="" value="Close" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
            </div>
      </div>    
     </form>       
            </div>
          </div>
           <div class="box box-default">
          <div class="box-body">
      <div class="offset-md-4 offset-lg-4" >
        <div class="form-group" >
                    <label class="form-control-placeholder" style="align-self: center;" for="contact-person">Search</label>
                    <input type="text" class="form-control" name="Searchcustomer" id="Searchcustomer">
        </div>
      </div>

      
                <div class="table"  style="position: relative;height: 200px;overflow: auto;"  >
                  <table style="width: 100%!important;" border="1"  class="table table-striped table-hover" id="customer_table">
                    <thead>
                       <tr>
                    <th class="">Sl No</th>
                    <th style="display: none;">customerid</th>
                    <th >customer Name</th>
                    <th class="">customer Code</th>
                    <th style="display: none;">Address</th>
                     <th class="">Email</th>
                     <th >Phone Number</th> 
                     <th  style="display: none;" >Website</th>
                      <th  style="display: none;" >State</th> 
                      <th   style="display: none;" >Country</th> 
                      <th  style="display: none;">VatNo</th>
                      <th  >Opening balance</th>
                      <th  >Credit Limit</th>
                      <th  >Balance</th>
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                       <?php 
                      $n=1; 
                         foreach($customer->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td style="display: none;"><?php echo $row->customerid;
                                 ?></td>
                                <td><?php echo $row->customername;
                                 ?></td>
                                  <td ><?php echo $row->customercode;
                                 ?></td>
                                  
                                 <td style="display: none;"><?php echo $row->address;
                                 ?></td>
                                 <td ><?php echo $row->email;
                                 ?></td>
                                 <td ><?php echo $row->phonenumber;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->website;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->state;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->country;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->vatno;
                                 ?></td>
                                  <td ><?php echo $row->openingbalance;
                                 ?></td><td ><?php echo $row->crlimit;
                                 ?></td>
                                 <td ><?php echo $row->currentbalance;
                                 ?></td>
                              </tr>
                              <?php  $n++;}?>  
                   </tbody>
                      
                 </table>

                </div> 
              </div>
            </div>

        <button onclick="exportTableToExcel('customer_table', 'Customers')">Export To Excel File</button>

          </section>
        </div>



        <script type="text/javascript">
          function exportTableToExcel(tableID, filename = ''){
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
        type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
      }
    }
  </script>



        

    <script type="text/javascript">
  var table = document.getElementById('customer_table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         
                         document.getElementById("customerid").value = this.cells[1].innerHTML;
                         document.getElementById("customername").value = this.cells[2].innerHTML;
                         document.getElementById("customercode").value = this.cells[3].innerHTML;
                          document.getElementById("address").value = this.cells[4].innerHTML;
                           document.getElementById("email").value = this.cells[5].innerHTML;
                            document.getElementById("phonenumber").value = this.cells[6].innerHTML;
                             document.getElementById("website").value = this.cells[7].innerHTML;
                              document.getElementById("state").value = this.cells[8].innerHTML;
                              
                                document.getElementById("country").value = this.cells[9].innerHTML;
                                 document.getElementById("vatno").value = this.cells[10].innerHTML;
                                  document.getElementById("openingbalance").value = this.cells[11].innerHTML;
                                  document.getElementById("limit").value = this.cells[12].innerHTML;
                         document.getElementById("btnsave").value = "Update";
                          
                         
                    };
                }
   var clear = document.getElementById('btnclear');   
  clear.onclick=function()
   {
                          document.getElementById("customerid").value = "";
                         document.getElementById("customername").value = "";
                         document.getElementById("customercode").value = "";
                          document.getElementById("address").value = "";
                           document.getElementById("email").value = "";
                            document.getElementById("phonenumber").value = "";
                             document.getElementById("website").value = "";
                              document.getElementById("state").value = "";
                              
                                document.getElementById("country").value = "";
                                 document.getElementById("vatno").value = "";
                                  document.getElementById("openingbalance").value = "";
                                  document.getElementById("limit").value = "";
                         document.getElementById("btnsave").value = "Save";
                          
                        
   }       
</script> 
    </div>


