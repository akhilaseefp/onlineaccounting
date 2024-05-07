   <script src="<?php echo base_url();?>js/jquery1.js"></script>
   <script>
$(document).ready(function(){
  $("#myInput").on("change", function() {
    var value = $(this).val().toLowerCase();
     $("#new tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Edit Sales
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Edit Sales</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
           <form class="seminor-login-form" method="post">
          <div class="row col-md-12">

                  
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">From  Date</label>
                           <input type="date" class="form-control" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" required autocomplete="off">
                         </div>
                       </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-placeholder" for="contact-person">To  Date</label>
                           <input type="date" class="form-control" name="todate" id="todate" value="<?php echo $todate; ?>"   required autocomplete="off">
                         </div>  
                      </div>
                      <div class="col-md-2">
                      <input class="btn btn-success" type="submit" style="margin-top: 25px;" name="" id="search" value="Search" formaction="<?php echo base_url(); ?>index.php/Salescontrol/editsales">
                         </div> 

                      </div>
                   
          
<input type="text" class="form-control" id="myInput" value="" name="" placeholder="Search by invoiceno">

 <div class="row margin" style="text-align: right;">
                 <button formaction="<?php echo base_url();?>index.php/Onlinecontrol/salesinvoice" class="btn btn-success">NEW</button>

                
                <button formaction="<?php echo base_url();?>index.php/Salescontrol/excel" class="btn btn-success" id="btnexport">Export To Excel</button>
                  
                </div>
                 </form>
   <div class="row margin">
       <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%" border="1" class="table table-hover" id="salestable">
                    <thead>
                  <tr>
                    <th class="">Invoice No</th>
                    <th >Date</th>
                    <th style="">Quantity</th>
                    <th style="">Branch</th>
                    <th style="">Total Amount</th>
                    
                    <!-- <th class="" style="">Total Cost</th> -->
                    <th>Action</th>
                    <!-- <th ></th> -->
                  </tr>
                  <tbody id="new">
                  <?php
                  foreach ($master->result() as $key) {
                    ?>
                    <tr>
                    <!-- <td><?php echo $key->stockmasterid;?></td> -->
                    <td><?php echo $key->invoiceno;?></td>
                    <td><?php echo $key->salesdate;?></td>
                     <td><?php echo $key->totalqty;?></td>
                    <td><?php echo $key->branchname;?></td>
                    <td><?php echo $key->grandtotal;?></td>
                    <td><?php echo $key->grandtotal;?></td>
       <?php               if($this->session->userdata('role')=="Super Admin")
      { ?>
                    <td><a href="<?php echo base_url();?>index.php/Salescontrol/viewsales?masterid=<?php echo $key->salesmasterid;?>"><button class="btn btn-success">Edit</button></a></td>
                  <?php } ?>
                  </tr>
                      <?php }?>
                      </tbody>
                 </table>

                </div>     
    </div>
    
            <script type="text/javascript">

            </script>   
