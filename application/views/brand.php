


            <script src="<?php echo base_url();?>js/jquery1.js"></script>
          
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchbrand").on("keyup", function() {
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
       Brand
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Brand</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
         <div class="row">
           <div class="col-md-6">
                    <form class="seminor-login-form" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_brand">
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Brand Name</label>
                       <input type="text" class="form-control"  name="brandname" id="brandname" required autocomplete="off">
                       <input type="text" style="display: none;" class="form-control"  name="brandid" id="brandid" autocomplete="off">  
                     </div>
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-email">Narration</label>
                        <textarea class="form-control txtarea" name="narration" id="narration" style="line-height: 4.5"></textarea>
                     </div>
               <div class="offset-md-4">
              <input class="btn btn-success"type="submit" name="save" id="save" value="Save">
              <input class="btn btn-danger" type="submit" name="" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_brand">
              <input class="btn btn-info" type="submit" name=""  id="clear" value="Clear" formaction="javascript:void(0);">
              <input class="btn btn-warning" type="submit" name="" value="Close"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
          </div>
        </form>
          </div>
            <div class="col-md-6">
                
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Search</label>
                   <input type="text" class="form-control"  name="searchbrand" id="searchbrand" autocomplete="off">
                 </div>

                 <div class="table" style="position: relative;height: 200px;overflow: auto;">
              
                  <table width="100%" style="width: 100% !important ; " class="table table-striped table-hover" id="table">
                    <thead>
                       <tr>
                    <th class="col-md-2">Sl No</th>
                    <th class="col-md-4">Brand Name</th>
                    <th class="col-md-6">Narration</th>
                    <th  style="display: none;" class="col-md-4">brandid</th>
                  </tr>
                    </thead>
                    <tbody id="myTable">
                       <?php 
                      $n=1; 
                         foreach($query->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td><?php echo $row->brandname;
                                 ?></td>
                                  <td><?php echo $row->narration;
                                 ?></td>
                                  <td style="display: none;"><?php echo $row->brandid;
                                 ?></td>
                              </tr>
                              <?php  $n++;}?>
                    </tbody>
                 
                    
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
                         
                         document.getElementById("brandname").value = this.cells[1].innerHTML;
                         document.getElementById("narration").value = this.cells[2].innerHTML;
                         document.getElementById("brandid").value = this.cells[3].innerHTML;
                         document.getElementById("save").value = "Update";
                          
                         
                    };
                }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
                          document.getElementById("brandname").value = "";
                         document.getElementById("narration"). value = "";
                         document.getElementById("brandid").value = "";
                          document.getElementById("save").value = "Save";
                        
   }       
</script>

      


        
      



