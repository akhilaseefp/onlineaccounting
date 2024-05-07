<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
 <script src="<?php echo base_url();?>js/jquery1.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchunit").on("keyup", function() {
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
Unit
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Unit</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
         <div class="row">
                    <form class="seminor-login-form" method="post" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_unit">
           <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-placeholder" for="contact-person">Unit Name</label>
                 <input type="text" class="form-control" name="uname" id="uname" required autocomplete="off">
       
              </div>
              <div class="form-group">
        
              <input type="text" style="display: none;" id="unitId" class="form-control" name="unitId"  autocomplete="off">
       
              </div>
              <div class="form-group">
              <label class="form-control-placeholder" for="contact-email">Narration</label>
              <textarea class="form-control txtarea" name="narration" id="narration" style="line-height: 7.5"></textarea>
       
              </div>
  
              <div class="offset-md-4 margin">
              <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
              <input class="btn btn-success"type="submit"  id="save" name="save" id="save" value="Save">
              <input class="btn btn-danger" type="submit" id="Delete" name="" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_unit">
              <input class="btn btn-info" type="submit" id="clear" name="" value="Clear" formaction="javascript:void(0);" >
              <input class="btn btn-warning" type="submit" id="close" name="" value="close" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
            </div>
             </div>
      </form>
     
           
            <div class="col-md-6">
                
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Search</label>
                     <input type="text" class="form-control" name="searchunit" id ="searchunit"  autocomplete="off">
                   
                 </div>

                 <div class="table">
                  <table width="100%" border="1" class="table table-striped table-hover" id ="table">
                    <thead>
                       <tr>
                    <th class="col-md-2">Sl No</th>
                    <th class="col-md-4">Unit Name</th>
                    <th class="col-md-6">Narration</th>
                    <th style="display: none;">unitid</th>
                  </tr>
                    </thead>
                    <tbody id="myTable">
                       <?php 
                      $n=1; 
                         foreach($query->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td><?php echo $row->unitname;?></td>
                                <td><?php echo $row->narration;?></td>
                               <td style="display: none;"><?php echo $row->unitid;?></td>
                              </tr>
                              <?php $n++;}?>
                    </tbody>
                 
                     
                                  
                    </table>
                </div>
         </div>
       </div>
     </div>
   </div>
 </section>
</div>
      

      </div>
      <script type="text/javascript">
  var table = document.getElementById('table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         
                         document.getElementById("uname").value = this.cells[1].innerHTML;
                         document.getElementById("narration").value = this.cells[2].innerHTML;
                         document.getElementById("unitId").value = this.cells[3].innerHTML;
                          document.getElementById("save").value = "Update";
                          
                         
                    };
                }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
                          document.getElementById("uname").value = "";
                         document.getElementById("narration"). value = "";
                         document.getElementById("unitId").value = "";
                         document.getElementById("save").value = "Save";
   }       
</script>
      



      


        
      
    </div>

 