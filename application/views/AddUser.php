            <script src="<?php echo base_url();?>js/jquery1.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
   $("#SearchUser").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
<script type="text/javascript">
    function CheckConfirmPW() 
    {
      var _txt1 = $('#password').val();
      var _txt2 = $('#confirmpassword').val();
      
      if(_txt1 != _txt2)
      {
        alert('Confirm Password doesn\'t match with Password!');
        return false;
      }
    }
</script>
     <div class="content-wrapper">
   <section class="content-header">
      <h1>
        User      
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">User </li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
           <div class="row">
              <div class="col-md-6">
                    <form class="" action="<?php echo base_url();?>index.php/Onlinecontrol/insert_adduser" method="post">
            <div class="form-group">
                <label class="form-control-placeholder" for="contact-person">Full Name</label>
                <input type="text" class="form-control" name="firstname" id="firstname"  required autocomplete="off">
                <input type="text" class="form-control"  style="display: none;" name="userid" id="userid"  autocomplete="off" >
            </div>
            <div class="form-group">
                <label class="form-control-placeholder" for="contact-person">Nickname</label>
                <input type="text" class="form-control" name="lastname" id="lastname">
            </div>
            <div class="form-group">
                <label class="form-control-placeholder" for="contact-email">Role</label>
                <select  class="form-control"  required name="role" id="role">
                   <option>Super Admin</option>
                   <option>Admin</option>
                   <option>Branch User</option>
                   <option>Chat Executive</option>
                   <option>Chat Manager</option>
                    <option>Production Admin</option>
                    <option>Shipping Admin</option>
                    <option>Ecommerce Admin</option>
                </select>
          </div>
          <div class="form-group">
            <label class="form-control-placeholder" for="alternative-number">Branch</label>
            <select  class="form-control"  required name="branch" id="branch">
               <?php foreach ($branch->result() as $br)
              {
                 ?>
                 <option value="<?php echo $br->branchid;?>"><?php echo $br->branchname;?></option>
      
               <?php
               }
               ?>
            </select>
          </div>
          <div class="form-group">
              <label class="form-control-placeholder" for="alternative-number">Phone Number</label>
              <input type="text"  name="phonenumber" id="phonenumber" class="form-control" >
          </div>
          </div>
         <div class="col-md-6">
           <div class="form-group">
             <label class="form-control-placeholder" for="alternative-number">Id Number</label>
             <input type="text" name="idnumber" id="idnumber" class="form-control"   autocomplete="off">
           </div>
           <div class="form-group">
             <label class="form-control-placeholder" for="contact-person">Email</label>
             <input type="email" name="email" id="email" class="form-control" autocomplete="off">
           </div>
           <div class="form-group">
             <label class="form-control-placeholder" for="alternative-email">User name</label>
             <input type="text" class="form-control" name="username" id="username" required autocomplete="off">
           </div>
           <div class="form-group">
             <label class="form-control-placeholder" for="alternative-number">Password</label>
             <input type="Password" class="form-control" name="password" id="password" required autocomplete="off">
           </div>
           <div class="form-group">
             <label class="form-control-placeholder" for="alternative-number">Confirm Password</label>
             <input type="Password" class="form-control" name="confirmpassword" id="confirmpassword" required autocomplete="off" onfocusout="CheckConfirmPW()">
           </div>
</div>
</div>
      <div class="form-group offset-md-2 offset-lg-2 offset-sm-1" style="text-align: center;">
           <input  class="btn btn-success" type="submit" name="btnsave" value="Save" id="btnsave" onclick="CheckConfirmPW()">
            <input  class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_adduser">
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
          <input type="text" class="form-control" name="SearchUser" id="SearchUser">
        </div>
      </div>
      
      <div class="table " style="" >
                  <table style="width: 100% !important;" border="1" class="table table-striped table-hover" id="user_table">
                    <thead>
                       <tr>
                    <th class="">Sl No</th>
                    <th style="display:none;">Userid</th>
                    <th class="">First Name</th>
                    <th style="display: none;">Last Name</th>
                     <th class="">Role</th>
                    <th style="display: none;">Branch</th>
                     <th style="display: none;">Phone Number</th> 
                     <th style="display: none;">Id Number</th>
                      <th style="display: none;">Email</th> 
                      <th>Username</th> 
                      <th  style="display: none;">Password</th>
                  </tr>
                    </thead>
                    <tbody id= "myTable">
                      <?php 
                      $n=1; 
                         foreach($adduser->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td style="display: none;"><?php echo $row->userid;
                                 ?></td>
                                <td><?php echo $row->firstname;
                                 ?></td>
                                  <td style="display: none;"><?php echo $row->nickname;
                                 ?></td>
                                  
                                 <td style=""><?php echo $row->role;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->branch;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->phonenumber;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->idnumber;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->email;
                                 ?></td>
                                 <td style=""><?php echo $row->username;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->password;
                                 ?></td>
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
  var table = document.getElementById('user_table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                        document.getElementById("userid").value = this.cells[1].innerHTML;
                         document.getElementById("firstname").value = this.cells[2].innerHTML;
                         document.getElementById("lastname").value = this.cells[3].innerHTML;
                          document.getElementById("role").value = this.cells[4].innerHTML;
                           document.getElementById("branch").value = this.cells[5].innerHTML;
                            document.getElementById("phonenumber").value = this.cells[6].innerHTML;
                             document.getElementById("idnumber").value = this.cells[7].innerHTML;
                              document.getElementById("email").value = this.cells[8].innerHTML;
                               document.getElementById("username").value = this.cells[9].innerHTML;
                                document.getElementById("password").value = this.cells[10].innerHTML;
                                 document.getElementById("confirmpassword").value = this.cells[10].innerHTML;
                                     
                         document.getElementById("btnsave").value = "Update";
                          
                         
                    };
                }
   var clear = document.getElementById('btnclear');   
  clear.onclick=function()
   {
                        document.getElementById("firstname").value = "";
                         document.getElementById("lastname").value = "";
                            document.getElementById("phonenumber").value = "";
                             document.getElementById("idnumber").value = "";
                              document.getElementById("email").value = "";
                               document.getElementById("username").value = "";
                                document.getElementById("password").value = "";
                                 document.getElementById("confirmpassword").value = "";
                                 document.getElementById("SearchUser").value = "";

                         document.getElementById("btnsave").value = "Save";
                          
                        
   }       
</script> 
    


