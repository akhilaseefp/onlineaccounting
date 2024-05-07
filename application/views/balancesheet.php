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
<div class="content-wrapper">
   <section class="content-header">
      <h1>
        Balance Sheet
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Balance Sheet</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
     <div class="box-body">     <h1 style="color: blue; text-align: center;" >MOA Balance Sheet</h1>
     <h3 style="color:blue; text-align: center;"><?php

$d=strtotime("+3 hours 30 minutes");
echo date("Y-m-d h:i:sa", $d) ;

?></h3>
     <div class="row" style="padding-top:50px;">
     <div class="col-md-6">
       <div class="table-responsive">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="incometable">
                    <thead>
                  <tr>
                    <th style="text-align: center;">Asset</th>
                    <th style="width:100px; text-align: center;">Amount</th>
                  </tr>

                  <?php 
                      $m = 0;
                      foreach($asset->result() as $row)
                  {?>
                  <tr>

                    <td style="text-align: center;"><?php echo $row->ledgername?></td>
                    <td style="text-align: center;"><?php echo $row->currentbalance?></td>                    
                  </tr>

                  <?php  
                  $m = $m + $row->currentbalance;
                  }?>

                 </table>

                </div>     
    </div>
    <div class="col-md-6">
       <div class="table-responsive">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="expensetable">

                    <thead>
                  <tr>
                    <th style="text-align: center;">Liabilities</th>
                    <th style="width:100px; text-align: center;">Amount</th>

                  </tr>

                  <?php 
                      $n=0; 
                      foreach($liabil->result() as $row)
                  {?>
                  <tr>

                    <td style="text-align: center;"><?php echo $row->ledgername?></td>
                    <td style="text-align: center;"><?php echo $row->currentbalance?></td>                    
                  </tr>
                  <?php  
                  $n = $n + $row->currentbalance;
                  }?>

                 </table>

                </div> 
            </div>
            </div>
            <div class="row" style="padding-top:20px;">
                    <div style="text-align: center;" class="col-md-6">
                        <label style="text-align: center;">Total Assets : <?php echo $m; ?></label>
                        
                    </div>
                    <div style="text-align: center;" class="col-md-6">
                        <label style="text-align: center;">Total Liabilities : <?php echo $n; ?></label>
                    </div>
            </div>
            <div class="row" style="padding-top:20px;">
             
             <div style="text-align: center;" class="col-md-offset-3 col-md-6"> 
            <?php  
                  $a = $m - $n;
                  ?>
                  <label style="text-decoration:  underline  double blue;">Owner Equity : <?php echo $a?>  </label>
                   
            </div>
            </div>
    </div>
  </div>
  </section>
  </div>
              

  <script type="text/javascript">
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
</script>