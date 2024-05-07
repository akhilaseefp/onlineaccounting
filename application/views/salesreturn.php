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
        Sales Return
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Sales Return</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
           <div class="row margin" style="text-align: right;">
                  <a href="<?php echo base_url();?>index.php/Onlinecontrol/salesinvoice"><button class="btn btn-success">NEW</button></a>
                </div> 
<input type="text" class="form-control" id="myInput" name="">

   <div class="row margin">
       <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%" border="1" class="table table-hover" id="salestable">
                    <thead>
                  <tr>
                   
                  
                    <th class="">Voucher No</th>
                    <th >Date</th>
                    <th style="">Quantity</th>
                    <th style="">Total amount</th>
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
                    <!-- <td><?php echo $key->tbranch;?></td> -->
                    <td><?php echo $key->grandtotal;?></td>
                    <td><a href="<?php echo base_url();?>index.php/Salescontrol/viewsalesreturn?voucher=<?php echo $key->invoiceno;?>"><button class="btn btn-success">Edit</button></a></td>
                  </tr>
                      <?php }?>
                      </tbody>
                 </table>

                </div>     
    </div>
               
