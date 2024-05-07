<script src="<?php echo base_url();?>js/jquery1.js"></script>
   <script src="<?php echo base_url(); ?>js/jquery.js"></script>
   <style type="text/css"> 
.never{
display:none;}</style>
<style>
a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #4CAF50;
  color: white;
}

.round {
  border-radius: 50%;
}
</style>
<script type="text/javascript">

	var inv_no =0;
  var ctr = 1;
    $(document).ready(function () {
    $('#dataTable1').on('change', '.ledgerclass', function () { 

      ctr++;
      try {

            var tr = "tr" + ctr;
            var ledger = "ledger" + ctr;
            var debit = "debit" + ctr;
            var credit = "credit" + ctr;
            var narration = "narration" + ctr;
            

            var rowCount = document.getElementById('dataTable').rows.length + 1;
            var newTr = '<tr><td>' + rowCount + '</td><td><input type="text" class="form-control ledgerclass" list="name" on autocomplete="off" name="ledger" id="' +  ledger +'"></td><td><input type="text" id="' + debit +'" class="form-control debitclass" name="" value="0.00"></td><td><input type="text" id="' + credit +'" class="form-control creditclass"  name="" value="0.00"></td><td><input type="text" id="' + narration +'" class="form-control"  name=""></td><td style="display:none">' + ctr +'</td><td><a href="" class="delete" >X</a></td></tr>';
            $('#dataTable1').append(newTr);
            calculation();

      } catch (err) {
        alert(err.message);
      }

    });


  });

  function calculation() {

    try {
      var table = document.getElementById('dataTable1');
     
      var debittotal = 0.00;
      var credittotal = 0.00;
      var rowdebit=0.00;
      var rowcredit =0.00;
    
      for (var n = 1; n < table.rows.length; n++) {
        var i = 0;
        try {
          i = document.getElementById('dataTable').rows[n - 1].cells[5].innerHTML;

        } catch (err) {

        }

        if (i == 0) {

        } else {
          

          rowdebit = document.getElementById('debit' + i).value * 1;
          rowcredit = document.getElementById('credit' + i).value * 1;
         
        }

       

        debittotal = debittotal + rowdebit;
        credittotal = credittotal + rowcredit;


      }

      $('#debittotal').val(debittotal);
      $('#credittotal').val(credittotal);
    
    } catch (err) {
      alert(err);
    }


  }
</script>






<div class="content-wrapper">
   <section class="content-header">
      
    <div class="hed"><h1>Journal Voucher</h1></div>
    <hr>
     <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Journal Voucher</li>
      </ol>
    </section>
  <section class="content">
    <div class="box box-default" style="padding-left: 10px;padding-top: 10px;padding-right: 10px;">
      <div class="box-body">
      <div id="invbutton">
				<a href="#" class="previous" id="previous">&laquo; Previous</a>
<a href="#" class="next" id="next">Next &raquo;</a></div>
        <div class="row">
          <div class="col-md-4">
            <label>Voucher no :</label>
            <?php foreach($voucherno->result() as $gp){
                    ?>
            <input type="text" name="voucherno" class="form-control" required autocomplete="off" id="voucherno"
              value="<?php echo $gp->NO;?>">
            <?php  } ?>
          </div>
          
         
       
          
          <div class="col-md-offset-2 col-md-4">
            <label>Journal date :</label>
            <input type="datetime" name="invoicedate" class="form-control" id="invoicedate"
              value="<?php $d=strtotime("now");echo date("Y-m-d H:i:s",$d);?>">
          </div>
         

        </div>
        <hr>

       

        <div class="table table-responsible">
          <TABLE id="dataTable1" border="1" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>SL.NO</th>
                <th>LEDGER NAME</th>
                <th class="d-none d-xl-block" style="">DEBIT</th>
                <th class="d-none d-xl-block" style="">CREDIT</th>
                <th class="d-none d-xl-block">NARRATION</th>
                <th class="never"></th>
                <th class="d-none d-xl-block"></th>
              </tr>
            </thead>
            <tbody id="dataTable" width="100%" border="1" class="table table-hover">
              <tr>
                <td>1</td>
                <td> <input type="text" class="form-control ledgerclass" list="name" autocomplete="off"
                    name="productname" id="ledger1"></td>
                <datalist id="name">
                  <?php foreach($accountledger->result() as $gp){
                   ?>
                  <option value="<?php echo $gp->ledgername;?>" 
                    data-id="<?php echo $gp->ledgerid;?>" data- ="<?php echo $gp->creditordebit;?>" label="<?php echo $gp->currentbalance;?>">
                    <?php  } ?>

                </datalist>
               
                
               
                <td><input type="text" id="debit1" class="form-control debitclass" name="" value="0.00"></td>

                <td><input type="text" id="credit1" class="form-control creditclass" name="" value="0.00"></td>
                <td><input type="text" id="narration1" class="form-control" name=""></td>
                <td  class="never">1</td>
                <td><a href="" class="delete">X</a></td>



              </tr>
            </tbody>
          </TABLE>
          <input class="btn btn-info" type="submit" name="btnclear" value="add row" id="addrow">
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <label>Narration :</label>
            <textarea class="form-control" id="narration" name="Narration"></textarea>
          </div>
         
        </div>
        <hr>
        <fieldset>
         

          <div class="row">
            <div class="col-md-6">
              <label>Debit Total :</label>
              <input type="text" class="form-control" name="debittotal" id="debittotal">
            </div>
            <div class="col-md-6">
              <label>Credit Total :</label>
              <input type="text" class="form-control" name="credittotal" id="credittotal">
            </div>
          </div>
          
        </fieldset>
        <hr>
        
       
        <div class="row margin" style="text-align: center">


          <div class="offset-md-4" style="display: inline-block">
            <input class="btn btn-success" type="button" name="btnsave" id="det" value="Save">
            <!-- <input class="btn btn-danger" type="submit" name="btndelete" id="btndelete" value="Delete"> -->
            <input class="btn btn-info" type="submit" name="btnclear" value="Clear">
            <input class="btn btn-warning" type="submit" name="btnclose" value="Close">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>




<script type="text/javascript" href="js/bootstrap.js"></script>
<script type="text/javascript" href="js/bootstrap.min.js"></script>
<script type="text/javascript" href="js/jquery-3.1.1.js"></script>
<script type="text/javascript" href="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
$('#invbutton').on('click', '.previous', function (e) {
  inv_no=inv_no-1;
  $('#voucherno').val(inv_no);
  loadinvoice(inv_no);
  });

</script>

<script type="text/javascript">


$('#invbutton').on('click', '.next', function (e) {
  
  inv_no=inv_no*1+1;
  $('#voucherno').val(inv_no);
  loadinvoice(inv_no);
  });


$('#voucherno').on('change', '', function (e) {
  
  inv_no=$('#voucherno').val();
  loadinvoice(inv_no);
  });
  
  function loadinvoice(a){
	  	
      // $.noConflict();
try {
  $.ajax({
    type: "POST",
    // dataType:"json",
    url: "<?php echo base_url()?>index.php/Onlinecontrol/loadvoucher",
    data: {
      'voucherno' : a
    },
          success: function (data) {document.getElementById("det").disabled = true;
          // document.getElementById("btnupdate").disabled = false;
          // document.getElementById("btndelete").disabled = false;
          
              
            var master=JSON.parse(data);
            if (master['master'].length==0)
            {
              alert("no such invoice exists ");
            }
            else
            {
              var myJSON = JSON.stringify(master['master'][0]['voucherno']);
              document.getElementById("invoicedate").value=master['master'][0]['journaldate'];
              document.getElementById("debittotal").value =master['master'][0]['totalamount'];
              document.getElementById("credittotal").value =master['master'][0]['totalamount'];
              document.getElementById("narration").value =master['master'][0]['narration'];
              $('#dataTable  tr').remove();
              ctr=1;
              var i=0;

for(i=0;i<master['detailes'].length;i++)
{
            var tr = "tr" + ctr;
            var ledger = "ledger" + ctr;
            var debit = "debit" + ctr;
            var credit = "credit" + ctr;
            var narration = "narration" + ctr;
            var ledgeridv =master['detailes'][i]['ledgerid'];
            var debitv =master['detailes'][i]['debit'];
            var creditv =master['detailes'][i]['credit'];
            var narrationv =master['detailes'][i]['narration'];

            var rowCount = document.getElementById('dataTable').rows.length + 1;
            var newTr = '<tr><td>' + rowCount + '</td><td><input type="text" class="form-control ledgerclass" list="name" on autocomplete="off" name="ledger" id="' +  ledger +'" value="' +ledgeridv + '"></td><td><input type="text" id="' + debit +'" class="form-control debitclass" name="" value="'+ debitv +'"></td><td><input type="text" id="' + credit +'" class="form-control creditclass"  name="" value="'+ creditv +'"></td><td><input type="text" id="' + narration +'" class="form-control" value="'+ narrationv +'"  name=""></td><td style="display:none">' + ctr +'</td><td><a href="" class="delete" >X</a></td></tr>';
            $('#dataTable1').append(newTr);
            ctr=ctr+1;
            }
            }
            
            
            

          },
          error: function (data) {
            var myJSON = JSON.stringify(data);
            alert("in details");
      alert(myJSON);
          }

        });

       }
catch(err)
{
alert(err.message);
}


}
  
</script>





<script type="text/javascript">
 
  window.onload = function () { inv_no = document.getElementById("voucherno").value;
    document.getElementById("debittotal").value = "0.00";
     document.getElementById("credittotal").value = "0.00";
      var loadinvno="<?php echo $loadinvno ?>";
   if(loadinvno!=0){
     $('#voucherno').val(loadinvno);
     loadinvoice(loadinvno);

   }
  }
  $('#dataTable1').on('focus', '.debitclass', function () {
if ($(this).val()==0) {
                       $(this).val("");
                      }

   
  });
   $('#dataTable1').on('focus', '.creditclass', function () {


   if ($(this).val()==0) {
                       $(this).val("");
                      }
  });
    $('#dataTable1').on('focusout', '.debitclass', function () {
if ($(this).val()=="") {
                       $(this).val("0.00");
                      }

   
  });
   $('#dataTable1').on('focusout', '.creditclass', function () {


   if ($(this).val()=="") {
                       $(this).val("0.00");
                      }
  });

  $('#dataTable1').on('change', '.debitclass', function () {


    var a = $(this).closest("tr")[0].rowIndex;

   
    calculation();
  });
  $('#dataTable1').on('change', '.creditclass', function () {


    var a = $(this).closest("tr")[0].rowIndex;
    
    calculation();


  });
  $('#dataTable1').on('click', '.delete', function (e) {
    e.preventDefault();



    $(this).closest('tr').remove();
    var table = document.getElementById('dataTable1');
    var ab = table.rows.length;
    for (var i = 1; i < table.rows.length + 1; i++) {
      table.rows[i].cells[0].innerHTML = i;
    }



    calculation();
  });

  
</script>
<script type="text/javascript">
  $('#addrow').on('click', function () { 
    ctr++;

     var tr = "tr" + ctr;
            var ledger = "ledger" + ctr;
            var debit = "debit" + ctr;
            var credit = "credit" + ctr;
            var narration = "narration" + ctr;
            

            var rowCount = document.getElementById('dataTable').rows.length + 1;

            var newTr = '<tr><td>' + rowCount + '</td><td><input type="text" class="form-control ledgerclass" list="name" on autocomplete="off" name="ledger" id="' +  ledger +'"></td><td><input type="text" id="' + debit +'" class="form-control debitclass" name="" value="0.00"></td><td><input type="text" id="' + credit +'" class="form-control creditclass"  name="" value="0.00"></td><td><input type="text" id="' + narration +'" class="form-control"  name=""></td><td style="display:none">' + ctr +'</td><td><a href="" class="delete" >X</a></td></tr>';
                        $('#dataTable1').append(newTr);
            calculation();



  });
</script>
<script type="text/javascript">
  $(document).ready(function () {


        $('#det').on('click', function () { 

            // var Finaltaxamount=0.00;

            var voucherno = document.getElementById("voucherno").value;
           
            var date = document.getElementById("invoicedate").value;

            // alert (payment);
            var narration = document.getElementById("narration").value;

           

            var debittotal = document.getElementById("debittotal").value; 
             var credittotal = document.getElementById("credittotal").value;
          
           if (debittotal==credittotal && debittotal !=0) {

            //$.noConflict();


            try {

              $.ajax({

                  type: "POST",
                  // dataType:"json",
                  url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_journalmaster",
                  data: {
                    'voucherno': voucherno,
                    
                    'date': date,
                    
                    'narration': narration,
                    'totalamount':debittotal
                    
                    
                   

                    
                  }, success: function (data) {
                     var ctr = 1;
                    var table = document.getElementById('dataTable1');

                    for (var i = 1; i < table.rows.length ; i++) {
                      var ledger = $('#ledger' + i).val();

                      
                      var debit = $('#debit' + i).val();
                       var credit = $('#credit' + i).val();
                      
                        var narration = $('#narration' + i).val();
                        var voucherno = $('#voucherno').val();
                        var val = $('#ledger'+i).val();

                          var ledgerid = $('#name option').filter(function () {
                                                                               return this.value == val;
                                                                                                        }).data('id');
                           var type = $('#name option').filter(function () {
                                                                               return this.value == val;
                                                                                                        }).data('type');
                      if (debit==0 && credit==0) {

                      } else {

                        jQuery.ajax({

                            type: "POST",
                            url: "<?php echo base_url() ?>index.php/Onlinecontrol/insert_journaldetails",
                            data: {
                              'debit':debit,
                              'credit':credit,
                              'narration':narration,
                              'voucherno':voucherno,
                              'ledgerid':ledgerid,
                                'type':type,
                                'date':date
                            },
                             success: function (data) {},
                           
                                //end of second success

                                error: function (data) {
                                  var result1 = JSON.stringify(data);
                                  alert(result1);
                                  // alert('Error occur...!! adding');
                                }


                            });

                          //end of second ajax  
                        } //end of else



                      } //end of for loop

                                       },

                  complete: function (data) { alert("Journal Inserted Successfully");
                  location.reload();
                  

                   
                         
                      
             


                    }, //end of first success
                    error: function (data) {
                      var result1 = JSON.stringify(data);
                      alert(result1);
                      // alert('last');
                    }
                  }); //end of first ajax


              }
              catch (err) {
                alert(err.message);
              }
            }
            else{
              alert("Total Debit not equal to Total Credit or Zero debit and Zero credit");
            }
            });

          //Save product

        });
</script>

</div>