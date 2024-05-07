

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
        Profit & Loss A/C
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Profit & Loss A/C</li>
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
     <h3>Income Accounts</h3>
       <div class="table-responsive">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="incometable">
                    <thead>
                  <tr>
                    <th style="">SL NO</th>
                    <th class="">Ledger Name</th>
                    <th style="">Amount</th>

                  </tr>

                  <?php
                    $n=0;
                    $i=1;
                    foreach ($day->result() as $key) {
                    ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $key->ledgername;?></td>
                    <td><?php echo $key->debit;?></td>
                    
                    
                  </tr>

                    <?php 
                      $i++;
                      $n = $n + $key->debit;
                    }?>

                 </table>

                </div> 

    </div>
    <div class="col-md-6">
    <h3>Expense Accounts</h3>
       <div class="table-responsive">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="expensetable">

                    <thead>
                  <tr>
                    <th style="">SL NO</th>
                    <th class="">Ledger Name</th>
                    <th style="">Amount</th>
                  </tr>

                  <?php
                    $m=0;
                    $i=1;
                    foreach ($day1->result() as $key) {
                    ?>
                    <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $key->ledgername;?></td>
                    <td><?php echo $key->credit;?></td>
                    
                    
                  </tr>

                    <?php 
                      $i++;
                      $m = $m + $key->credit;
                    }?>
                 </table>

                </div> 
            </div>
            </div>
            <div class="row" style="padding-top:20px;">
                    <div style="text-align: center;" class="col-md-6">
                        <label>Total Income : <?php echo $n; ?></label>
                     
                        
                    </div>
                    <div style="text-align: center;" class="col-md-6">
                        <label>Total Expense : <?php echo $m; ?></label>
                    </div>
            </div>   
             <div class="row" style="padding-top:20px;">
             
             <div style="text-align: center;" class="col-md-offset-3 col-md-6"> 
            <?php  
                  $a = $n - $m;
                  ?>
                  <label style="text-decoration:  underline  double blue;">Profit  : <?php echo $a?>  </label>
                   
            </div>
            </div> 
    </div>
  </div>
  </section>
  </div>
  </form>
              

  <!-- <script type="text/javascript">
	$(document).ready(function () {


				$('#btngo').on('click', function () {
          alert("Hi");
						var tdate = document.getElementById("tdate").value;
						var fdate = document.getElementById("fdate").value;
						$.noConflict();
						try {
							$.ajax({
									type: "POST",
									url: "<?php echo base_url() ?>index.php/Onlinecontrol/ltddaybook",
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