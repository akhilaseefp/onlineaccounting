<script src="<?php echo base_url();?>js/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/JsBarcode.all.min.js"></script>
<script src="<?php echo base_url();?>js/angular.min.js"></script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<script type="text/javascript">
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
        Shop Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i>Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Shop Order</li>
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
           <div class="col-md-2">
                        <div class="form-group">
                         <label for="bdaymonth">Select Month :</label>
                         <input type="month" class="form-control" name="month" id="month" value=""   required autocomplete="off">
                        </div>
                      </div>
<script type="text/javascript">
               window.onload=function(){
                document.getElementById("month").value ="<?php echo date('Y-m'); ?>";
                var date =new Date(document.getElementById("month").value+"-01"), y = date.getFullYear(), m = date.getMonth();
var firstDay = new Date(y, m, 2).toISOString().slice(0,10);
var lastDay = new Date(y, m + 1, 1).toISOString().slice(0,10);
  document.getElementById("fdate").value=firstDay;
  document.getElementById("tdate").value=lastDay;

               }
            </script> 
 <script type="text/javascript">
  $('#month').on('keyup change', function () {
     var date =new Date(document.getElementById("month").value+"-01"), y = date.getFullYear(), m = date.getMonth();
var firstDay = new Date(y, m, 2).toISOString().slice(0,10);
var lastDay = new Date(y, m + 1, 1).toISOString().slice(0,10);
  document.getElementById("fdate").value=firstDay;
  document.getElementById("tdate").value=lastDay;

     
   


  });
  </script>


          <div class="col-md-2" style="margin-top:25px;">
            <input class="btn btn-success" type="submit" name="btngo" id="btngo" value="Go">
          </div>
     </div>
     <div class="row" style="padding-top:50px;">
      <div class="col-md-12">
        <div class="table">
                  <table style="width:100%;" border="1" class="table table-striped table-hover" id="shp_tab">
                    <thead>
                  <tr>
                    <!-- <th class="">Sl order/th> -->
                    <th style="">SL No</th>
                     <th style="">Order NO</th>
                    <th class="">Order Date</th>
                    <th >Delivery Date</th>
                    <th style="">Description</th>
                    <th style="">Image</th>
                     <th class="" style="">Narration</th>
                     <th style="">Amount</th>
                    <th class="">Advance</th>
                    <th >Balance</th>
                    <th >Stock Amount</th>
                    <th style="">Stitch</th>
                    <th style="">Dispatch</th>
                    <th style="">Received</th>
                    <th style="">Delivery</th>
                     <th></th>
                    
                    <!-- <th ></th> -->
                  </tr>
                  <?php
                    $n=1;
                    foreach ($shop->result() as $key) {
                    ?> 
                    <tr>
                    <td><?php echo $n;?></td>
                    <td><?php echo $key->shoporderno;?></td>
                    <input type="hidden" class="clshoporderno" value="<?php echo $key->shoporderno; ?>" id="shoporderno<?php echo $n; ?>" name="">
                    <td><?php echo $key->date_current;?></td>
                    <td><?php echo $key->date_delivery;?></td>
                    <td><?php echo $key->pdt_desc;?></td>
                    <td><a target="_blank" href="<?php echo base_url();?>shoporder/images/<?php echo $key->imagepath;?>"><?php echo $key->imagepath;?></a></td>
                    <td><?php echo $key->narration;?></td>
                    <td><?php echo $key->amount;?></td>
                    <td><?php echo ($key->paid_cash +$key->paid_bank);?></td>
                    <td><?php echo $key->balance;?></td>
                    <?php
                    foreach ($users->result() as $us) 
                    {
                      $role=$us->role;
                       if($role=="Super Admin")
                       {
                         ?>
                         <td><input type="text" class="clstckamt" name="stckamt" id="stckamt"  value="<?php echo $key->stck_amnt;?>"/></td>
                         <?php
                       }
                       else if($role=="Branch User")
                       {
                         ?>
                         <td><input type="text" disabled class="clstckamt" name="stckamt" id="stckamt"  value="<?php echo $key->stck_amnt;?>"/></td>
                         <?php
                       }
                    }
                    ?>
                    <td><?php if ($key->stitch==1) { ?> 
                    <input type="checkbox" class="clstitch" name="stitch" onkeypress="myFunction(this,event)"  id="stitch<?php echo $n; ?>" value="1" checked>
                    <?php  } 
                    else{
                    ?>
                    <input type="checkbox" class="clstitch" name="stitch" onkeypress="myFunction(this,event)" id="stitch<?php echo $n; ?>" value="0">
                    <?php } ?>
                    </td>

                    <td>  <?php if ($key->dispatch==1) { ?> 
                    <input type="checkbox" class="cldispatch" onkeypress="myFunction(this,event)" name="dispatch" id="dispatch<?php echo $n; ?>" value="1" checked>
                    <?php  } 
                    else{
                    ?>
                    <input type="checkbox" class="cldispatch" onkeypress="myFunction(this,event)" name="dispatch" id="dispatch<?php echo $n; ?>" value="0">
                    <?php } ?>
                    </td>
                    <td>  <?php if ($key->received==1) { ?> 
                    <input type="checkbox" class="clreceived" onkeypress="myFunction(this,event)" name="received" id="received<?php echo $n; ?>" value="1" checked>
                    <?php  } 
                    else{
                    ?>
                    <input type="checkbox" class="clreceived" onkeypress="myFunction(this,event)" name="received" id="received<?php echo $n; ?>" value="0">
                    <?php } ?>
                    </td>
                    <td>  <?php if ($key->delivery==1) { ?> 
                    <input type="checkbox" class="cldelivery" onkeypress="myFunction(this,event)" name="delivery" id="delivery<?php echo $n; ?>" value="1" checked>
                    <?php  } 
                    else{
                    ?>
                    <input type="checkbox" class="cldelivery" onkeypress="myFunction(this,event)" name="delivery" id="delivery<?php echo $n; ?>" value="0">
                    <?php } ?>
                    </td>

                     <td><input class="btn btn-success"  type="button" name="btnupt" id="btnupt<?php echo $n; ?>" value="SUBMIT"></td>
                  </tr>
                
                      <?php 
                      $n++;
                    }?>

                 </table>
                 <button class="btn btn-success" onclick="exportTableToExcel('shp_tab', 'Shop Order')">Export To  Excel File</button>
                 
                </div>     
              </div>
            </div>
            </div>
    </section>
    </div>
    <script type="text/javascript">
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>  
    <script type="text/javascript">
      function myFunction(box,event) {
  var x = event.which || event.keyCode;
  
  if (x==13) {
    var $box = $(box);
    if ($box.attr('checked')) {
       $box.attr('checked',false);
    }
    else{
       $box.attr('checked',true);
      }
  }
}
 
        
    </script>

          <script type="text/javascript">
          $(document).ready(function () {

          $('#shp_tab').on('click','.btn-success', function () 
          {
            
            var stckamt=$(this).closest("tr").find ('.clstckamt').val();
            var stitch =0;
            var dispatch =0;
            var received =0;
            var delivery=0;
            if($(this).closest("tr").find('.clstitch').prop("checked")==true)
            {
              stitch=1;
            }
            if($(this).closest("tr").find('.cldispatch').prop("checked")==true)
            {
              dispatch=1;
            }
            if($(this).closest("tr").find('.clreceived').prop("checked")==true)
            {
              received=1;
            }
            if($(this).closest("tr").find('.cldelivery').prop("checked")==true)
            {
              delivery=1;
            }
            var shoporderno=$(this).closest("tr").find ('.clshoporderno').val();
        
            try {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() ?>index.php/Onlinecontrol/upd_shporder",
                  data: {
                    'shoporderno': shoporderno,
                    'stckamt': stckamt,
                    'stitch': stitch,
                    'dispatch': dispatch,
                    'received': received,
                    'delivery': delivery
                  },
                  success: function (data) 
                  {
                    alert("updation success");
                  }
             
            });

            }
              catch (err) {
                alert(err.message);
              }
  
        });
      });
     </script>
                         
  </form>