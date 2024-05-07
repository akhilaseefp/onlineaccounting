            <script src="<?php echo base_url();?>js/jquery1.js"></script>            
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchsuplier").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

  </script>
 <div class="content-wrapper">
   <section class="content-header">
      <h1>
        Supplier
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Supplier</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
               <form class="seminor-login-form" method="post" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_supplier ">

           <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                 <label class="form-control-placeholder" for="contact-person">Supplier name</label>
                 <input type="text" class="form-control" name="suppliername" id="suppliername"  required autocomplete="off">
                 <input type="text" class="form-control"  style="display: none;" name="supplierid" id="supplierid"  autocomplete="off">
                 <input type="text" class="form-control"  style="display: none;" name="supplierbalance" id="supplierbalance"  autocomplete="off"> 
                </div>
                <div class="form-group">
                     <label>Branch :</label>
                       <select class="form-control" name="branch" id="branch">
                      <?php foreach($branch->result() as $gp){
                          ?>
                     <option value="<?php echo $gp->branchid;?>"><?php echo $gp->branchname;?></option>
                      <?php  } ?>
                      </select>
                     </div>
                  
                
                <div class="form-group">
                 <label class="form-control-placeholder" for="alternative-number">E-mail</label>
                 <input type="email" class="form-control" name="email" id="email" autocomplete="off">
                </div>
                <div class="form-group">
                 <label class="form-control-placeholder" for="alternative-number">website</label>
                 <input type="text"  name="website" id="website" class="form-control">
                </div>
                <div class="form-group">
                 <label class="form-control-placeholder" for="contact-person">Phone no</label>
                 <input type="text" name="phone" id="mobile" class="form-control" required autocomplete="off">
                </div>
            </div>     
            <div class="col-sm-6">
                <div class="form-group">
                 <label class="form-control-placeholder" for="contact-person">Supplier Code</label>
                 <input type="text" class="form-control" name="code"  id="code" autocomplete="off">
                </div>
                <div class="form-group">
                 <label class="form-control-placeholder" for="contact-email">City</label>
                 <input type="text" class="form-control" name="city" id="city"  autocomplete="off">     
                </div>
                <div class="form-group" style="display:none;">
                 <label class="form-control-placeholder" for="alternative-number">Country</label>
                 <input type="text" class="form-control" name="country" id="country"  autocomplete="off">
                </div>
                <div class="form-group" style="display:none;">
                 <label class="form-control-placeholder" for="alternative-number">Supplier Account</label>
                 <input type="text" class="form-control" name="supplieraccount" id="supplieraccount"  autocomplete="off">
                </div>
                <div class="form-group">
                 <label class="form-control-placeholder" for="alternative-number">GST IN/VAT NO</label>
                 <input type="text" class="form-control" name="vatno" id="vatno" autocomplete="off">
                </div>
                <div class="form-group">
                 <label class="form-control-placeholder" for="alternative-number">Opening balance</label>
                 <input type="text" class="form-control" name="openingbalance"  id="openingbalance" autocomplete="off">
                </div>
                <div class="form-group">
                 <label class="form-control-placeholder" for="contact-email">Address</label>
                 <textarea  name="address" id="address" class="form-control"></textarea> 
                </div>
     </div>
      </div>
     

<div class="form-group offset-md-3 margin">
           <input class="btn btn-success"  type="submit" name="save" id="save" value="Save">
            <input class="btn btn-danger" type="submit" name="delete" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_supplier">
            <input class="btn btn-info" class="" type="submit" name="" id="clear" value="Clear" formaction="javascript:void(0);">
            <input class="btn btn-warning" class="" type="submit" name="" value="Close" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
            </div>    
     </form>
                  
  
       
 </div>
</div>
                  <div class="box box-default">

        <div class="box-body"> 

      <div class="table">
                  <table width="100%" border="1" class="table table-striped table-hover" id="table">
                    <thead>
                       <tr>
                    <th class="col-md-2">Sl No</th>
                    <th class="col-md-3" >Supplier</th>
                    <th style="display: none;" >Supplier code</th>
                     <th class="col-md-3">Current Balance</th>
                     

                    <th  style="display: none;" >supplierid</th>
                     <th  style="display: none;" >address</th> 
                     <th  style="display: none;" >city</th>
                      <th  style="display: none;" >country</th> 
                      <th  style="display: none;" >date</th> 
                      <th  style="display: none;" >email</th>
                       <th  style="display: none;" >mobile</th> 
                       <th  style="display: none;" >openingbalance</th> 
                       <th  style="display: none;" >place</th>
                        <th  style="display: none;" >vatno</th>
                         <th  style="display: none;" >website</th>
                         <th class="col-md-4">Branch</th>
                         <th  style="display: none;" >account</th>
                          <th  style="display: none;" >branchid</th>
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                      <?php 
                      $n=1; 
                         foreach($query->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td><?php echo $row->suppliername;?></td>
                                <td style="display: none;"><?php echo $row->code;?></td>
                                <td><?php echo $row->currentbalance;?></td>
                                
                               <td style="display: none;"><?php echo $row->supplierid;?></td>
                               <td style="display: none;"><?php echo $row->supaddress;?></td>
                               <td style="display: none;"><?php echo $row->city;?></td>
                               <td style="display: none;"><?php echo $row->country;?></td>
                               <td style="display: none;"><?php echo $row->date;?></td>
                               <td style="display: none;"><?php echo $row->email;?></td>
                               <td style="display: none;"><?php echo $row->mobile;?></td>
                               <td style="display: none;"><?php echo $row->openingbalance;?></td>
                               <td style="display: none;"><?php echo $row->place;?></td>
                               <td style="display: none;"><?php echo $row->vatno;?></td>
                               <td style="display: none;"><?php echo $row->website;?></td>
                               <td><?php echo $row->branchname;?></td>
                               <td style="display: none;"><?php echo $row->supplieraccount;?></td>
                               <td style="display: none;"><?php echo $row->branch;?></td>
                               
                              </tr>
                              <?php $n++;}?>
                    </tbody>
                    
                 
                    
                 </table>
                </div>   
               </div>
               </div>
               </section>
               </div>
                
                <script type="text/javascript">
  var table = document.getElementById('table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         
                        
                         document.getElementById("suppliername").value = this.cells[1].innerHTML;
                         document.getElementById("code").value = this.cells[2].innerHTML;
                          document.getElementById("supplierbalance").value = this.cells[3].innerHTML;
                           document.getElementById("supplierid").value = this.cells[4].innerHTML;
                            document.getElementById("address").value = this.cells[5].innerHTML;
                             document.getElementById("city").value = this.cells[6].innerHTML;
                              document.getElementById("country").value = this.cells[7].innerHTML;
                                document.getElementById("email").value = this.cells[9].innerHTML;
                                 document.getElementById("mobile").value = this.cells[10].innerHTML;
                                  document.getElementById("openingbalance").value = this.cells[11].innerHTML;
                                  document.getElementById("branch").value = this.cells[17].innerHTML;
                                    document.getElementById("vatno").value = this.cells[13].innerHTML;
                                     document.getElementById("website").value = this.cells[14].innerHTML;
                                     document.getElementById("supplieraccount").value = this.cells[16].innerHTML;                                     
                         document.getElementById("save").value = "Update";
                          
                         
                    };
                }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
                          document.getElementById("suppliername").value = "";
                         document.getElementById("code").value = "";
                          document.getElementById("supplierbalance").value = "";
                           document.getElementById("supplierid").value = "";
                            document.getElementById("address").value = "";
                             document.getElementById("city").value = "";
                              document.getElementById("country").value = "";
                              document.getElementById("branch").value = "";
                              
                                document.getElementById("email").value = "";
                                 document.getElementById("mobile").value = "";
                                  document.getElementById("openingbalance").value = "";
                                  
                                    document.getElementById("vatno").value = "";
                                     document.getElementById("website").value = "";
                         document.getElementById("save").value = "Save";
                          
                        
   }       
</script> 
    </div>


