<script src="<?php echo base_url();?>js/jquery1.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
   $("#SearchSalesman").on("keyup", function() {
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
        Salesman    
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Salesman</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
           <div class="row">
                <div class="col-md-6">
                    <form class="" action="<?php echo base_url();?>index.php/Onlinecontrol/insert_salesman" method="post">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Name</label>
                        <input type="text" class="form-control" name="fullname" id="fullname"  required autocomplete="off">
                        <input type="text" class="form-control"  style="display: none;" name="salesmanid" id="salesmanid"  autocomplete="off" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Salesman Code</label>
                        <input type="number" class="form-control" name="salescode" id="salescode" required autocomplete="off">
                    </div>
                </div>
           </div>

           <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="contact-email">Address</label>
                        <textarea  name="address" id="address" class="form-control"></textarea> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="alternative-number">Branch</label>
                        <select  class="form-control"  required name="branch" id="branch">
                            <?php foreach ($branch->result() as $br)
                            {
                                ?>
                                <option name="getbranch" id="getbranch" value="<?php echo $br->branchid;?>"><?php echo $br->branchname;?></option>
                                <?php
                            }
                                ?>
                                </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="alternative-number">Phone Number</label>
                        <input type="text"  name="phonenumber" id="phonenumber" class="form-control" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="alternative-number">Incentive</label>
                        <input type="text"  name="incentive" id="incentive" class="form-control" >
                    </div>
                </div>
            </div>
    
      <div class="form-group offset-md-2 offset-lg-2 offset-sm-1" style="text-align: center;">
           <input  class="btn btn-success" type="submit" name="btnsave" value="Save" id="btnsave">
            <input  class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_salesman">
            <input  class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear" formaction="javascript:void(0);">
            <input  class="btn btn-warning" type="submit" name="btnclose" value="Close" id="btnclose" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
        </div> 
</form>
</div>
</div>

</section>

         <section class="content">
     <div class="box box-default">

        <div class="box-body">
      <div class="offset-md-4 offset-lg-4" style="width: 40%;">
        <div class="form-group" >
                    <label class="form-control-placeholder" style="align-self: center;" for="contact-person">Search</label>
                    <input type="text" class="form-control" name="SearchSalesman" id="SearchSalesman">
        </div>
      </div>
      
      <div class="table " style="" >
                  <table style="width: 100% !important;" border="1" class="table table-striped table-hover" id="salesman_table">
                    <thead>
                       <tr>
                    <th class="">Sl No</th>
                    <th  style="display: none;">Salesman Id</th>
                    <th>Salesman Code</th>
                    <th class="">Name</th>
                    <th  style="display: none;" >Branch</th>
                     <th>Phone Number</th> 
                     <th>Address</th> 
                     <th style="display: none;">Incentive</th>
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                      <?php 
                      $n=1; 
                         foreach($salesman->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td style="display: none;"><?php echo $row->salesmanid;?></td>
                                <td><?php echo $row->salesmancode;?></td>
                                <td><?php echo $row->salesmanname;?></td>
                                <td style="display: none;"><?php echo $row->branch;?></td>
                                <td><?php echo $row->phoneno;?></td>
                                <td><?php echo $row->address;?></td>
                                <td style="display: none;"><?php echo $row->incentive;?></td>
                              </tr>
                              <?php  $n++;}?>  
                    </tbody>
                 </table>

                </div> 

                </div>
              </div>
            </section>
          </div>

    <script type="text/javascript">
    var table = document.getElementById('salesman_table');
    
    for(var i = 1; i < table.rows.length; i++)
    {
        
        table.rows[i].onclick = function()
        {
            document.getElementById("salesmanid").value = this.cells[1].innerHTML;
            document.getElementById("fullname").value = this.cells[3].innerHTML;
            document.getElementById("phonenumber").value = this.cells[5].innerHTML;
            document.getElementById("address").value = this.cells[6].innerHTML;
            document.getElementById("salescode").value = this.cells[2].innerHTML;
            document.getElementById("getbranch").value = this.cells[4].innerHTML;
            document.getElementById("incentive").value = this.cells[7].innerHTML;
            document.getElementById("btnsave").value = "Update";   
        };
  }
  var clear = document.getElementById('btnclear');   
  clear.onclick=function()
   {
       document.getElementById("salescode").value = "";
       document.getElementById("fullname").value = "";
       document.getElementById("branch").value = "";
       document.getElementById("phonenumber").value = "";
       document.getElementById("address").value = "";
       document.getElementById("incentive").value = "";
       document.getElementById("btnsave").value = "Save";    
   }       
</script> 
    


