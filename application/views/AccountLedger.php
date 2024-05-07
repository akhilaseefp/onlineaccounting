


<script src="<?php echo base_url();?>js/jquery1.js"></script>

   <script type="text/javascript">
    $(document).ready(function(){
   $("#Searchledger").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
  </script>

 
 <div class="content-wrapper">
        <section class="content-header">
         <h1> Account Ledger    </h1>
        <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Home"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Account Ledger</li>
        </ol>
        </section>
     <section class="content">
       <div class="box box-default">
          <div class="box-body">
             <div class="row">
                 <div class="col-md-6">    
                    <form class="seminor-login-form" method="post" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_accountledger">
                      <div class="form-group">
                       <label>Ledger Name</label>
                       <input type="text" class="form-control" required  name="ledgername" id="ledgerename">
                       <input type="text" style="display: none;"   class="form-control"  name="ledgerid" id="ledgerid" autocomplete="off">
                      </div>

                      <div class="form-group">
                       <label>Group</label>
                       <select  class="form-control" name="accountgroup" id="accountgroup">
                        <?php foreach($accountgroup->result() as $gp){
                            ?>
                               <option value="<?php echo $gp->accountgroupid;?>"><?php echo $gp->accountgroup;?></option>
                               
                       <?php  } ?>
                      </select>
                      </div>
                      <div class="form-group">
                       <label>Interest Calculation</label>
                      <input type="text" class="form-control"  name="interestcalculation" id="interestcalculation">
                     </div>
                     <div class="form-group">
                       <label>Branch</label>
                       <select  class="form-control"  required name="branch" id="branch">
                        <?php foreach($branch->result() as $ans){
                            ?>
                               <option value="<?php echo $ans->branchid;?>"><?php echo $ans->branchname;?></option>
                       <?php  } ?>
                      </select>
                      </div>
                   <div class="form-group">
                     <label>Opening balance</label>
                     <input type="text" class="form-control"  name="openingbalance" id="openingbalance">
                   </div>
                  <div class="form-group" >
                    <label></label>
                    <select  class="form-control" name="creditordebit" id="creditordebit">
                    <option value="Dr" selected="selected">Dr</option>
                    <option value="Cr">Cr</option>
                    </select>
                   </div>
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-email">Narration</label>
                    <textarea class="form-control" style="line-height: 5" name="narration" id="narration"></textarea>
                  </div>
                <div class="offset-md-4">
              <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
               <input class="btn btn-success"type="submit" name="btnsave" value="Save" id="btnsave">
              <input class="btn btn-danger" type="submit" name="btndelete" value="Delete" id="btndelete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_accountledger">
              <input class="btn btn-info" type="submit" name="btnclear" value="Clear" id="btnclear">
              <input class="btn btn-warning" type="submit" name="btnclose" value="Close" id="btnclose" formaction="<?php echo base_url(); ?>Home">
          </div>     
    </form>
  </div>
     
          

            <div class="col-md-6">


                 <div class="form-group">
                    <label name="searchbyledger" id="searchbyledger">Search By Ledger</label>
                    <input type="text" class="form-control"  name="Searchgroup" id="Searchledger">
                 </div>
                 <div class="table" style="position: relative;height: 431px;overflow: auto;">

                 
                  <table  class="table table-striped table-hover" id="ledgertable">
                    <thead style="align-items: left !important;">
                      <tr>
                      <th>Sl No</th>
                      <th>LedgerName</th>
                      <th>AccountGroup</th>
                      <th>currentbalance</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                      
                      <?php 
                      $n=1; 
                         foreach($FiilTableAccountledger->result() as $row)
                             {?>
                              <tr>
                                <td><a><?php echo $n;?></a></td>
                                <td><?php echo $row->ledgername;
                                 ?></td>
                                  <td><?php echo $row->accountgroup;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->accountgroupid;
                                 ?></td>
                                  <td style="display: none;s"><?php echo $row->ledgerid;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->interestcalculation;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->openingbalance;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->creditordebit;
                                 ?></td>
                                 <td style="display: none;"><?php echo $row->narration;
                                 ?></td>
                                 <td><?php echo $row->currentbalance;
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
        var table = document.getElementById('ledgertable');
                      
                      for(var i = 1; i < table.rows.length; i++)
                      {
                          table.rows[i].onclick = function()
                          {
                               
                               document.getElementById("ledgerename").value = this.cells[1].innerHTML;
                               document.getElementById("accountgroup").value = this.cells[3].innerHTML;
                               document.getElementById("interestcalculation").value = this.cells[5].innerHTML;
                               document.getElementById("openingbalance").value = this.cells[6].innerHTML;
                               document.getElementById("creditordebit").value = this.cells[7].innerHTML;
                               document.getElementById("narration").value = this.cells[8].innerHTML;
                               document.getElementById("ledgerid").value = this.cells[4].innerHTML;
                               document.getElementById("btnsave").value = "Update";
                                
                               
                          };
                      }
         var clear = document.getElementById('btnclear');   
        clear.onclick=function()
         {
                                document.getElementById("ledgerename").value = "";
                               document.getElementById("accountgroup").value = "";
                               document.getElementById("interestcalculation").value = "";
                               document.getElementById("openingbalance").value = "";
                               document.getElementById("narration").value = "";
                               document.getElementById("Searchledger").value = "";
                               document.getElementById("btnsave").value = "Save";
                              
         }       
      </script>

      


