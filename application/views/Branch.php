<script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>



   <script src="<?php echo base_url();?>js/jquery1.js"></script>
    
   <script type="text/javascript">
    $(document).ready(function(){
   $("#Searchbranch").on("keyup", function() {
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
  Branch
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Branch</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">




     <script>
      window.onload = function () {
        try{

          var branchid="<?php echo $branchid ?>";


          if (branchid === "") {

            alert();

          }else{

            // Initialize Cloud Firestore through Firebase
            firebase.initializeApp({
              apiKey: "AIzaSyDpk13JNZ_b1VtBGbM2Dfs_14nzesm-mFc",
              authDomain: "posmoa-732ea.firebaseapp.com",
              databaseURL: "https://posmoa-732ea-default-rtdb.firebaseio.com",
              projectId: "posmoa-732ea",
              storageBucket: "posmoa-732ea.appspot.com",
              messagingSenderId: "777170253446",
              appId: "1:777170253446:web:5fe97c0b0614814af2c307",
              measurementId: "G-SV2KJZJB8Z"
            });

            var db = firebase.firestore();

            var newCityRef = db.collection("invoicenos").doc(branchid);

            console.log(newCityRef);
            console.log(branchid);


            var docData = {
              invoiceNo: 1

              // orderId : newCityRef.id  
            }

              newCityRef.set(docData);

          }


        }
        catch(err){
          alert(err.message);
        }

      }
    </script> 


        <div class="box-body">

         <div class="row">
           <div class="col-md-6">               
          <form class="seminor-login-form" method="post" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_branch">
              <div class="form-group">
               <label class="form-control-placeholder" for="contact-person">Branch Name</label>
               <input type="text" class="form-control" required autocomplete="off" name="branchname" id="branchname">
               <input type="text" style="display: none;"  class="form-control"  name="branchid" id="branchid" autocomplete="off">
              </div>

<input type="hidden" style=""  class="form-control"  name="oldbrname" id="oldbrname" autocomplete="off">


<div class="form-group">
  <label class="form-control-placeholder" for="contact-person">Country</label>
  <select class="form-control" name="country" id="country">
    <option value="0">INDIA</option>
    <option value="1">UAE</option>
    <option value="2">USA</option>
  </select>
</div>
             <div class="form-group">
              <label class="form-control-placeholder" for="contact-person">Branch In Charge</label>
              <input type="text" class="form-control" required autocomplete="off" name="branchincharge" id="branchincharge"> 
            </div>
            <div class="form-group">
             <label class="form-control-placeholder" for="contact-person">GST NO</label>
             <input type="text" class="form-control" required autocomplete="off" name="gstno" id="gstno">  
             </div>
            <div class="form-group">
             <label class="form-control-placeholder" for="contact-person">Phone Number</label>
             <input type="text" class="form-control" required autocomplete="off" name="phonenumber" id="phonenumber">  
             </div>
            <div class="form-group">
             <label class="form-control-placeholder" for="contact-email">Address</label>
             <textarea class="form-control txtarea" style="line-height: 4.5" name="address" id="address"></textarea>
            </div>

          <div class="offset-md-4 offset-lg-4 offset-sm-2">
              <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
              <input class="btn btn-success"type="submit" name="btnsave" value="Save" id="btnsave">
              <input class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_branch">
              <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
              <input class="btn btn-warning" type="submit" name="btnclose" value="Close" id="btnclose" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
          </div>
                
    </form>  
               </div>
          

            <div class="col-md-6">
                
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Search</label>
                    <input type="text" class="form-control" name="Searchbranch" id="Searchbranch">
                   
                 </div>

                 <div class="table" style="position: relative;height: 200px;overflow: auto;">
                  <table border="1" style="width: 100% !important ; " class="table table-striped table-hover" id="branch_table">
               <thead>
                      <tr>
                      <th>Sl No</th>
                      <th>Branch Name</th>
                      <th>Branch in charge</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                      <?php 
                      $n=1; 
                         foreach($branch->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td style="display: none;"><?php echo $row->branchid; ?></td>
                                <td><?php echo $row->branchname; ?></td>
                                <td><?php echo $row->branchincharge; ?></td>
                                <td style="display: none;"><?php echo $row->gstno; ?></td>
                                <td style="display: none;"><?php echo $row->phonenumber; ?></td>
                                <td style="display: none;"><?php echo $row->address; ?></td>
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
        var table = document.getElementById('branch_table');
                      
                      for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                               
                               document.getElementById("branchid").value = this.cells[1].innerHTML;
                               document.getElementById("branchname").value = this.cells[2].innerHTML;
                               document.getElementById("branchincharge").value = this.cells[3].innerHTML;
                               document.getElementById("gstno").value = this.cells[4].innerHTML;
                               document.getElementById("phonenumber").value = this.cells[5].innerHTML;
                               document.getElementById("address").value = this.cells[6].innerHTML;
                               document.getElementById("oldbrname").value = this.cells[2].innerHTML;
                               document.getElementById("btnsave").value = "Update";
                                
                               
                          };
                      }
         var clear = document.getElementById('btnclear');   
        clear.onclick=function()
         {
                                document.getElementById("branchid").value ="";
                               document.getElementById("branchname").value = "";
                               document.getElementById("branchincharge").value ="";
                               document.getElementById("phonenumber").value = "";
                               document.getElementById("btnsave").value = "Save";
                              
         }       
      </script>
      


