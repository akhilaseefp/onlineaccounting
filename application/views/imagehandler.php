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
       Image Handler
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Image Handler</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
        <div class="box-body">
         <div class="row">
           <div class="col-md-6">
             <?php echo form_open_multipart('Onlinecontrol/insertimagehandler') ?>
                        <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Image name</label>
                        <select name="code" id="code" class="form-control">
                        <option  disabled="true">Select Product code</option>
                         <?php 
                         foreach($img->result() as $row)
                         {?>

                        <option value="<?php echo $row->productcode;?>"><?php echo $row->productcode;?></option>
                        
                        <?php }
                        ?>
                       </select>
                        </div>
            </div>
            <div class="col-md-6">
                        <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Type</label>
                        <select name="type" id="type" class="form-control">
                        <option  disabled="true">Select Type</option>
                         <?php 
                         foreach($typeselect->result() as $type)
                         {?>
                        <option value="<?php echo $type->type;?>"><?php echo $type->type;?></option>
                        <?php }
                        ?>
                        </select>
                        </div>
            </div>
        </div>
        
        <div class="row">
        <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-control-placeholder" for="contact-email">Images</label>
                       <input type="file" class="form-control" onchange="readURL(this);"  name="img" id="img">
                       <img src="#" id="blah" name="blah" style="display: none;" alt="your image" >
                       <div id="new"> </div>
                     </div>
        </div>
        <div class="col-md-3">
          <input style="border:none;margin-top:25px;" disabled type="text" class="form-control" value="<?php echo $row->name;?>" name="imagename" id="imagename">
        </div>
        </div>
               <div class="offset-md-4">
              <input class="btn btn-success"type="submit" name="save" id="save" value="Save">
              <input class="btn btn-danger" type="submit" name="" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/deleteimagehandler">
              <input class="btn btn-info" type="submit" name=""  id="clear" value="Clear" formaction="javascript:void(0);">
              <input class="btn btn-warning" type="submit" name="" value="Close"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
              </div>
        </form>
          
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
                    .width(500)
                    .height(300);
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
document.getElementById("imagename").value = img;
document.getElementById("new").innerHTML  ="" ;
document.getElementById("save").value = "Update";
  

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
              pt='<img src="<?php echo base_url();?>images/'+ im + '" class="img" style="margin-top:20px;" width="500px" height="300px" >';
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