<div class="content-wrapper">
   <section class="content-header">
      <h1>
     StockTransfer
           </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Account Group</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">

        <div class="box-body">
   <div class="row margin">
       <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%" border="1" class="table table-hover" id="salestable">
                    <thead>
                  <tr>
                   
                    <!-- <th class="">Sl order/th> -->

                     <th style="">stockmasterid</th>
                    <th class="">Voucher No</th>
                    <th >Date</th>
                    <th style="">From Branch</th>
                    <th style="">To Branch</th>
                     <th class="" style="">Total Cost</th>
                     <th>Action</th>
                     
                     
                    <!-- <th ></th> -->
                  </tr>
                  <?php
                  foreach ($stock->result() as $key) {
                    ?>
                    <tr>
                    <td><?php echo $key->stockmasterid;?></td>
                    <td><?php echo $key->voucherno;?></td>
                    <td><?php echo $key->date;?></td>
                    <td><?php echo $key->fbranch;?></td>
                    <td><?php echo $key->tbranch;?></td>
                    <td><?php echo $key->totalcost;?></td>
                    <td><a href="<?php echo base_url();?>index.php/Stockcontrol/deletestocktransfer?a=<?php echo $key->voucherno;?>"><button class="btn btn-danger">delete</button></a><a href="<?php echo base_url();?>index.php/Stockcontrol/editstocktransfer?a=<?php echo $key->voucherno;?>"><button class="btn btn-success">Edit</button></a></td>
                  </tr>
                      <?php }?>
                 </table>

                </div>     
    </div>
                <div class="row margin" style="text-align: right;">
                  <a href="<?php echo base_url();?>index.php/Onlinecontrol/stocktransfer"><button class="btn btn-success">NEW</button></a>
                </div> 
