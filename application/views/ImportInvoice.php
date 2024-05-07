<script src="<?php echo base_url();?>js/jquery1.js"></script>            
<script type="text/javascript">
  $(document).ready(function(){
 $("#searchsuplier").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

  </script>
 <div class="content-wrapper">
   <section class="content-header">
      <h1>
        Farebase Invoice
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Forms</a></li> -->
        <li class="active">Farebase Invoice</li>
      </ol>
    </section>
   <section class="content">
     <div class="box box-default">
<div class="container">
        <div class="box-body" style="padding:134px;">
          
         <div class="row">
          
          <div class="col-sm-4">
            <h4><strong> Sales Excel</strong></h4>
            <form method="post" action="<?php echo site_url('Onlinecontrol/import_fbase'); ?>" enctype="multipart/form-data" >

              <div class="form-group">
                <input type="file" name="uploadFile" class="form-control-file" id="exampleFormControlFile1">
              </div>
              <button type ="submit" class="btn btn-primary"> Submit</button>
            </form>
          </div>  

          <div class="col-sm-4">
            <h4> <strong>Sales Return</strong> </h4>

            <form method="post" action="<?php echo site_url('Onlinecontrol/import_fbase_return'); ?>" enctype="multipart/form-data" >

              <div class="form-group">
                <input type="file" name="uploadFile" class="form-control-file" id="exampleFormControlFile1">
              </div>
              <button type ="submit" class="btn btn-primary"> Submit</button>
            </form>
          </div> 

          <div class="col-sm-4">

            <h4><strong>Customer</strong> </h4>

            <form method="post" action="<?php echo site_url('Onlinecontrol/import_fbase_customer'); ?>" enctype="multipart/form-data" >

              <div class="form-group">
                <input type="file" name="uploadFile" class="form-control-file" id="exampleFormControlFile1">
              </div>
              <button type ="submit" class="btn btn-primary"> Submit</button>
            </form>
          </div> 

 </div>
</div>

</div>
               </section>
               </div>
                
               
    </div>

