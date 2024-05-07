<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

            <script src="<?php echo base_url();?>js/jquery1.js"></script>
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
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchgroup").on("keyup", function() {
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
        Product Group
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Product Group</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
           <div class="row">
              <div class="col-md-6">
                    <form class="seminor-login-form" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_productgroup" method="post">
     <div class="form-group">
        <label class="form-control-placeholder" for="contact-person">Product  Group:</label>
       <input type="text" class="form-control" id="groupname" name="groupname" autocomplete="on">
        <input style="display: none;" type="text" class="form-control" id="groupid" name="groupid" autocomplete="off">
     </div>

     <div class="form-group col-md-3">
          <label class="form-control-placeholder" for="contact-person">Tax Low:</label>
          <input type="text" class="form-control" id="taxlow" name="taxlow" autocomplete="on">
      </div>
      <div class="form-group col-md-3">
          <label class="form-control-placeholder" for="contact-person">Tax Slab:</label>
          <input type="text" class="form-control" id="taxslab" name="taxslab" autocomplete="on">
      </div>
     <div class="form-group col-md-3">
          <label class="form-control-placeholder" for="contact-person">Tax High:</label>
          <input type="text" class="form-control" id="taxhigh" name="taxhigh" autocomplete="on">
     </div>
     <div class="form-group col-md-3">
          <label class="form-control-placeholder" for="contact-person">HSN:</label>
          <input type="text" class="form-control" id="hsncode" name="hsncode" autocomplete="on">
     </div>
     <div class="form-group">
        <label class="form-control-placeholder" for="contact-person">Under:</label>
         <select  class="form-control" id ="groupunder"name="groupunder">
          <option >Primary</option>
          
                <?php    foreach($table->result() as $row)
                             {?>     
            <option value="<?php echo $row->groupid;?>"><?php echo $row->groupname;?></option>

      <?php }   ?>
        </select>
     </div> 
     <div class="form-group">
        <label class="form-control-placeholder" for="contact-email">Weight:</label>
       <input type="text" class="form-control" name="weight" id="weight">
     </div>
     <div class="form-group">
        <label class="form-control-placeholder" for="contact-email">Narration:</label>
       <textarea class="form-control txtarea" name="narration" id="narration"></textarea>
     </div>

      <div class="row col-md-12 form-group">
              <input class="btn btn-success"  type="submit" name="save" id ="save" value="Save">
              <input class="btn btn-danger" type="submit" name="delete" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_productgroup">
              <input class="btn btn-info" type="submit" name="close" value="Close" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
              <input class="btn btn-warning"  type="submit" name="clear" id="clear" value="Clear" formaction="javascript:void(0)" >

       </div>
 </form>
</div>
            
       <div class="col-md-6">
              <div class="row">
                   <div class="col-md-6">
                      <div class="form-group">
                      <label class="form-control-placeholder" for="contact-person">Search  Group:</label>
                      <input type="text" class="form-control" id="searchgroup" name="searchgroup" autocomplete="on">
                    </div>
                   </div>
                 <div class="col-md-6">
                     <div class="form-group">
                      <label class="form-control-placeholder" for="contact-person">Search:</label>
                      <select   id="myInput" class="form-control">
                      <option>Select Any Group</option>
                            <?php    foreach($table->result() as $row)
                             {?>
                      <option ><?php echo $row->groupname;?></option>
                            <?php }   ?></select>
                     </div>
                </div>
              </div>
                 <div class="table" style="position: relative;height: 200px;overflow: auto;">
                  <table class="table table-striped table-hover" id="table">
                    <THEAD>
                       <tr>
                        <th style="display:none;">ID</th>
                        <th>Sl No</th>
                        <th>Product Group</th>
                        <th>Tax Low</th>
                        <th>Slab</th>
                        <th>Tax High</th>
                        <th>HSN</th>
                        <th>Under</th>
                        <th>Weight</th>
                        <th>Narration</th>
                  </tr>
                    </THEAD>
                    <TBODY  id="myTable">
                       <?php  $i=1;   foreach($table->result() as $row)
                             {  ?> 
                              <tr>
                                 <th style="display: none;"><?php echo $row->groupid;?></th>
                                 <th><a><?php echo $i ;?></a></th>
                                 <th id="groupname1" ><?php echo $row->groupname;?></th>
                                 <th><?php echo $row->taxlow;?></th>
                                 <th><?php echo $row->slab;?></th>
                                 <th><?php echo $row->taxhigh;?></th>
                                 <th><?php echo $row->hsncode;?></th>
                                 <th><?php echo $row->groupunder;?></th>
                                 <th><?php echo $row->weight;?></th>
                                 <th><?php echo $row->narration;?></th>
                              </tr>
                            <?php $i++;}?>
                    </TBODY>
                 
                  
                 </table>
                </div>
      </div>
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
                         
                         document.getElementById("groupname").value = this.cells[2].innerHTML;
                         document.getElementById("taxlow").value = this.cells[3].innerHTML;
                         document.getElementById("taxslab").value = this.cells[4].innerHTML;
                         document.getElementById("taxhigh").value = this.cells[5].innerHTML;
                         document.getElementById("hsncode").value = this.cells[6].innerHTML;
                         document.getElementById("groupunder").value = this.cells[7].innerHTML;
                         document.getElementById("weight").value = this.cells[8].innerHTML;
                         document.getElementById("narration").value = this.cells[9].innerHTML;
                          document.getElementById("groupid").value = this.cells[0].innerHTML;
                           document.getElementById("save").value = "Update";
                         
                    };
                }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
                          document.getElementById("groupname").value = "";
                          document.getElementById("taxlow").value = "";
                          document.getElementById("taxslab").value = "";
                          document.getElementById("taxhigh").value = "";
                          document.getElementById("hsncode").value = "";
                         document.getElementById("groupunder"). value = "primary";
                         document.getElementById("weight").value = "";
                         document.getElementById("narration").value = "";
                         document.getElementById("groupid").value = "";
                          document.getElementById("save").value = "Save";

   }       
</script>
      



    </div>


      