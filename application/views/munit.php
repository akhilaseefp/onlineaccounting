

   <div id="content">
            <script src="<?php echo base_url();?>js/jquery1.js"></script>
            
   <div id="content">          
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

    


      <div class="container-fluid">
        <div class="hed"><h1>Multiple Unit</h1></div>
        <hr>
         <div class="row">
           <div class="col-md-6">
             <div class="pos-rel">
               <!-- Nav pills -->
              
               <div class="connected-line"></div>
               <!-- Tab panes -->
               <div class="tab-content">
                  <div id="organizer-details" class="container tab-pane active">
                    <form class="seminor-login-form" action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_munit">
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Product</label>
                   <select class="form-control" id="product" name="product">
                    <?php foreach($product->result() as $p)
                    {
?>
                  <option value="<?php echo $p->pdt_id;?>" data-unitid ="<?php echo $p->unitid;?>" ><?php echo $p->pdt_name;?></option>
                <?php }?>
                 
              
              </select>
                       
                     </div>
                     <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">New Unit</label>
                       <input type="text" class="form-control"  name="unit" id="unit" required autocomplete="off">
                       
                     </div>
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">No.of basic unit</label>
                                <input type="text" class="form-control"  name="nounit" id="nounit" required autocomplete="off">
                       <input type="hidden" name="unitid" id="unitid">
                     </div>
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Basic Unit</label>
               <select class="form-control" id="bunit" name="bunit">
                        <?php foreach($unit->result() as $u)
                    {
?>
                  <option value="<?php echo $u->unitid;?>"><?php echo $u->unitname;?></option>
                <?php }?>
              
              </select>
                       
                     </div>
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">Sales rate</label>     
                                <input type="text" class="form-control"  name="rate" id="rate" required autocomplete="off"> 
                          </div>
                     <div class="row col-md-12 form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);">
          <div class="offset-md-2">
              <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
              <input class="btn btnormal1"type="submit" name="save" id="save" value="Save">
            
              <input class="btn btnormal2" type="submit" name="" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_multiunit">
              <input class="btn btnormal2" type="submit" name=""  id="clear" value="Clear" formaction="javascript:void(0);">
              <input class="btn btnormal1" type="submit" name="" value="Close"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
               </form>
          </div>
      </div> 
                     
                  </div>
                 
                  
               </div>
            </div>
            </div>

            <div class="col-md-6">
                
                  <div class="form-group">
                    <label class="form-control-placeholder" for="contact-person">Search</label>
                   <input type="text" class="form-control"  name="searchbrand" id="searchbrand" autocomplete="off">
                 </div>

                 <div class="subdiv table-responsive">
                  <table width="100%" border="1" class="table table-hover" id="table">
                    <thead>
                       <tr>
                    <th >Sl No</th>
                    <th >unit</th>
                    <th >product</th>
                    <th >No.of basic unit</th>
                    <th >Basic unit</th>
                    <th >Sales rate</th>
                    <th  style="display: none;" class="col-md-4">unitid</th>
                     <th  style="display: none;" class="col-md-4">baseunitid</th>
                      <th  style="display: none;" class="col-md-4">productid</th>
                  </tr>
                    </thead>
                   <tbody id="myTable">
                    <?php
$n=1;
                     foreach($munit->result() as $mu)
                    {
                      ?>
                      <tr>
                        <td><?php echo $n;?></td>
                         <td><?php echo $mu->unit;?></td>
                        <td><?php echo $mu->pdt_name;?></td>
                        
                        <td><?php echo $mu->count;?></td>
                        <td><?php echo $mu->unitname;?></td>
                        <td><?php echo $mu->rate;?></td>
                         <td style="display: none;"><?php echo $mu->multi_id;?></td>
                         <td style="display: none;"><?php echo $mu->product_id;?></td>
                         <td style="display: none;"><?php echo $mu->unitid;?></td>
                      </tr>
                 <?php  $n++;
                   } ?>
                 </tbody>
                  </table>
                </div>
            </div>
         </div>

     

      </div>
 <script type="text/javascript">
  var table = document.getElementById('table');
                
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         
                         document.getElementById("product").value = this.cells[7].innerHTML;
                         document.getElementById("unit").value = this.cells[1].innerHTML;
                         document.getElementById("nounit").value = this.cells[3].innerHTML;
                         document.getElementById("bunit").value = this.cells[8].innerHTML;
                         document.getElementById("rate").value = this.cells[5].innerHTML;
                         document.getElementById("unitid").value = this.cells[6].innerHTML;
                         document.getElementById("save").value = "Update";
                          
                         
                    };
                }
   var clear = document.getElementById('clear');   
  clear.onclick=function()
   {
    // alert("sdhfk");
                          document.getElementById("unitid").value = "";
                         document.getElementById("nounit"). value = "";
                         document.getElementById("rate").value = "";
                          document.getElementById("save").value = "Save";
                        
   }     
   var product = document.getElementById('product');   
  product.onclick=function()
   {
                       
                                     document.getElementById("bunit").value = product.options[product.selectedIndex].getAttribute("data-unitid");
                        
                          
                        
   }       
</script>

      


        
      
    </div>


