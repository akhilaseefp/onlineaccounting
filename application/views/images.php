<script src="<?php echo base_url();?>js/jquery1.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchbatch").on("keyup", function() {
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
       Images
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Images</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
         <div class="row">
           <div class="col-md-6">
             <?php echo form_open_multipart('Onlinecontrol/insert_image') ?>
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Product name</label>
                        <select name="code" id="code"   class="form-control" required="true">
                        <option  disabled="true">Select Product code</option>
                         <?php 
                         foreach($pdt->result() as $row)
                             {?>
                        <option value="<?php echo $row->pdt_code;?>"><?php echo $row->pdt_name." => ".$row->pdt_code;?></option>
                       <?php }
                       ?>
                       </select>
                       <input type="text" style="display: none;" class="form-control"  name="batchid" id="batchid" autocomplete="off">  
                     </div>
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-email">Images</label>
                       <input type="file" class="form-control" onchange="readURL(this);" required="true"  name="img">
                       <img src="#" id="blah" style="display: none;" alt="your image" >
                       <div id="new"> </div>
                     </div>
               <div class="offset-md-4">
              <input class="btn btn-success"type="submit" name="save" id="save" value="Save">
              <input class="btn btn-danger" type="submit" name="" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_batch">
              <input class="btn btn-info" type="submit" name=""  id="clear" value="Clear" formaction="javascript:void(0);">
              <input class="btn btn-warning" type="submit" name="" value="Close"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
          </div>
        </form>
          </div>
         </div>
        </div>
      </div>
    </section>
  </div>

<script type="text/javascript">
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
         document.getElementById("blah").style.display ="block";
    }
</script>
<script src="<?php echo base_url();?>js/jquery1.js"></script>

<script type="text/javascript">
  // $.noConflict();
  var ctr = 1;
  $(document).ready(function () {


    $('#code').on('change', function () {
  var code = $('#code').val();
      // alert(code);
document.getElementById("new").innerHTML  ="" ;
  

      try {
        $.ajax({

          type: "POST",
          dataType: 'json',
          url: "<?php echo base_url(); ?>index.php/Onlinecontrol/getimg",
          data: {
            'b': code
          },
          success: function (result) {
            var s = result.length;
            if(s>0)
            {
              for (var i = 0; i < s; i++) {
                var im =result[i]['name'];
              // alert(result[i]['name']);
              var pt="";
              pt='<img src="<?php echo base_url();?>images/'+ im + '" class="img" width="100px" height="100px" >';
              document.getElementById("new").innerHTML += pt;
            }
            }
         // var result1 = JSON.stringify(result);
         //                          alert(s);
            // var Qty = $('#qty' + a).val();
          },
          error: function (data) {
           var result1 = JSON.stringify(data);
                                  alert(result1);
            // alert('Error occur...!!');
          }
        });
      } catch (err) {
        alert(err.message);
      }

    });


  });
</script>