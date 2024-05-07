<script>
$(document).ready(function(){
  $("#myInput").on("click", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>


<form method="post">
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Cash/Bank Book
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Cash/Bank Book</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">
     <div class="row">
					<div class="col-md-4">
          <label>Date From :</label>
						<input type="date" name="fdate" id="fdate" class="form-control">
          </div>
          
          <div class="col-md-4">
            <label>Date To :</label>
						<input type="date" name="tdate" id="tdate" class="form-control">
          </div>

          <div class="col-md-4" style="margin-top:25px;">
            <input class="btn btn-success" type="submit" name="btngo" id="btngo" value="Go">
          </div>
     </div>
     <div class="row" style="padding-top:50px;">
     <div class="col-md-6">
       <label>Cash ledger</label>
       <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="salestable">
                    <thead>
                  <tr>
                   
                    <!-- <th class="">Sl order/th> -->

                     <th style="">SL NO</th>
                    <th class="">Ledger Name</th>
                    <th class="">Date</th>
          
                     <th>Current Balance</th>
                 
                     <th>Account Type</th>
                     
                     
                     
                    <!-- <th ></th> -->
                  </tr>
                  <?php
                    $n=1;
                    foreach ($daay->result() as $key) {
                    ?>
                    <tr>
                    <td><?php echo $n;?></td>
                    <td><?php echo $key->ledgername;?></td>
                    <td><?php echo $key->date;?></td>
           
                    <td><?php echo $key->currentbalance;?></td>
                  
                    <td><?php echo $key->accountType;?></td>
                  </tr>
                      <?php 
                      $n++;
                    }?>
                 </table>

                </div>     
    </div>

         <div class="col-md-6">
          <label>Bank ledger</label>
       <div class="table-responsive" style="overflow-x: scroll;">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="salestable">
                    <thead>
                  <tr>
                   
                    <!-- <th class="">Sl order/th> -->

                     <th style="">SL NO</th>
                    <th class="">Ledger Name</th>
                    <th class="">Date</th>
                     <th>Current Balance</th>
                     <th>Account Type</th>
                     
                     
                     
                    <!-- <th ></th> -->
                  </tr>
                  <?php
                    $n=1;
                    foreach ($daay1->result() as $key) {
                    ?>
                    <tr>
                    <td><?php echo $n;?></td>
                    <td><?php echo $key->ledgername;?></td>
                    <td><?php echo $key->date;?></td>
                    <td><?php echo $key->currentbalance;?></td>
                    <td><?php echo $key->accountType;?></td>
                  </tr>
                      <?php 
                      $n++;
                    }?>
                 </table>

                </div>     
    </div>
  </div>

  </form>
              

 <!--  <script type="text/javascript">
	$(document).ready(function () {


				$('#btngo').on('click', function () {
          alert("Hi");
						var tdate = document.getElementById("tdate").value;
						var fdate = document.getElementById("fdate").value;
						$.noConflict();
						try {
							$.ajax({
									type: "POST",
									url: "<?php echo base_url() ?>index.php/Onlinecontrol/CBdaybook",
									data: {
										'tdate': tdate,
										'fdate': fdate
									},
									success: function (data) 
									{
										alert("master");
										
									}
							catch (err) {
								alert(err.message);
							}
						});

					//Save product
						}

				});
      });
</script> -->