
   <script src="<?php echo base_url();?>js/jquery1.js"></script>
    
   <script type="text/javascript">
    $(document).ready(function(){
   $("#Searchgroup").on("keyup", function() {
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
        Account Group
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Account Group</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
           <div class="row">
              <div class="col-md-6">

   <!-- <div class="hed"><h1>Account Group</h1></div> -->
         <form class="seminor-login-form" method="post" action="<?php echo base_url(); ?>Add_Accountgroup">
                <div class="form-group">
                 <label>Account  Group</label>
                 <input type="text" class="form-control" required autocomplete="off" name="accountgroup" id="accountgroup">
                 <input type="text" style="display: none;"  class="form-control"  name="accountgroupid" id="accountgroupid" autocomplete="off">
               </div>
              <div class="form-group">
                 <label>Under</label>
                 <select  class="form-control"  required name="under" id="under">
                 <?php foreach($accountgroup->result() as $gp){
                  ?>
                 <option value="<?php echo $gp->accountgroupid;?>" data-rootid="<?php echo $gp->rootid;?>"><?php echo $gp->accountgroup;?></option>
                 <?php  } ?>
                 </select>
                 <input type="text" hidden="" name="root" id="root">
               </div>
               <div class="form-group">
                  <label class="form-control-placeholder" for="contact-email">Narration</label>
                  <textarea class="form-control txtarea" style="line-height:5" name="narration" id="narration"></textarea>
       
                  </div>

               <div class="offset-md-4">
                    <input class="btn btn-success"type="submit" name="btnsave" value="Save" id="btnsave">
                   <input class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete" formaction="<?php echo base_url(); ?>Delete_Accountgroup">
                   <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
                   <input class="btn btn-warning" type="submit" name="btnclose" value="Close" id="btnclose" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
               </div>
         </form>
     
                 </div> 
                 <!-- col6 -->
                  
               
            <div class="col-md-6">
                
                  <div class="form-group">
                    <label class="" for="contact-person">Search</label>
                    <input type="text" class="form-control"  name="Searchgroup" id="Searchgroup">
                   
                 </div>

                 <div class="table" style="position: relative;height: 200px;overflow: auto;">
                  <table border="1" style="width: 100% !important ; " class="table table-striped table-hover" id="account_table">
                    <thead>
                      <tr>
                      <th>Sl No</th>
                      <th>Account Group</th>
                      <th>Under</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                       <?php 
                      $n=1; 
                         foreach($FiilTableAccountgroup->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td><?php echo $row->accountgroup;
                                 ?></td>
                                  <td><?php echo $row->undername;
                                 ?></td>
                                  <td style="display: none;"><?php echo $row->accountgroupid;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->narration;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->underid;?></td>
                                 <td style="display: none;"><?php echo $row->rootid;?></td>

                              </tr>
                              <?php  $n++;}?>
                    </tbody>

                 </table>
                 </div>  <!--table!> -->
            </div><!-- col6-->
         </div><!--raw -->
       </div>

      
</div>
</section>
</div>
      <script type="text/javascript">
        var table = document.getElementById('account_table');
                      
                      for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                               
                               document.getElementById("accountgroup").value = this.cells[1].innerHTML;
                               document.getElementById("under").value = this.cells[5].innerHTML;
                               document.getElementById("narration").value = this.cells[4].innerHTML;
                               document.getElementById("accountgroupid").value = this.cells[3].innerHTML;
                               document.getElementById("root").value=this.cells[6].innerHTML;
                               document.getElementById("btnsave").value = "Update";
                                
                               
                          };
                      }
         var clear = document.getElementById('btnclear');   
        clear.onclick=function()
         {
                                document.getElementById("accountgroup").value = "";
                               document.getElementById("under").value = "";
                               document.getElementById("narration").value ="";
                               document.getElementById("accountgroupid").value ="";
                               document.getElementById("btnsave").value = "Save";
                              
         }       
          var product1 = document.getElementById('under');   
  product1.onchange=function()
   {
                       
                                     document.getElementById("root").value = product1.options[product1.selectedIndex].getAttribute("data-rootid");
                        
                                                 
   }  
   window.onload=function()
   {
    document.getElementById("root").value = product1.options[product1.selectedIndex].getAttribute("data-rootid");
   } 
      </script>


