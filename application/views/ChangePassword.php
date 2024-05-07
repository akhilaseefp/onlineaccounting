<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/logincss.css">
  <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet">
  <title></title>

  <script type="text/javascript">
      function CheckNewConfirmPW() 
      {
        var _txt1 = $('#newpassword').val();
        var _txt2 = $('#confirmpassword').val();
        
        if(_txt1 != _txt2)
        {
          alert('Confirm Password doesn\'t match with New Password!');
          return false;
        }
      }
   </script>

</head>

 <div class="content-wrapper">

  <div class ="box" style="padding: 22px !important;">
    <img src="<?php echo base_url(); ?>/assets/resources/team.png" alt="Trulli" width="120" height="120" align="centre">
    <h1>Change Password</h1>
    <form action="<?php echo base_url(); ?>index.php/Onlinecontrol/update_Changepassword" method="post">
      <div class="inputBox">
        <input type="text" name="username" id="username" value="<?php echo  $this->session->userdata('username');?>">
        <label>Username</label>
      </div>

      <div class="inputBox">
        <input type="Password" name="oldpassword" id="oldpassword">
        <label >Old Password</label>
      </div>

      <div class="inputBox">
        <input type="Password" name="newpassword" id="newpassword">
        <label>New Password</label>
      </div>

      <div class="inputBox">
        <input type="Password" name="confirmpassword" id="confirmpassword" onfocusout="CheckNewConfirmPW()">
        <label>Confirm Password</label>
      </div>
      <div>
        <input class="a1" style="margin-left: 100px !important;" type="submit" name="btnChange" value="Change">
        <input class="a2" type="submit" name="btncancel" value="Cancel">
      </div>
      
    </form>
  </div>
</div>


  </div>
  <script type="text/javascript">
    var clear = document.getElementById('btncancel');
    clear.onclick=function()
    {
      document.getElementById("username").value ="";
      document.getElementById("oldpassword").value = "";
      document.getElementById("newpassword").value ="";
      document.getElementById("confirmpassword").value = "";
      
    } 
  </script>

</body>
</html>
