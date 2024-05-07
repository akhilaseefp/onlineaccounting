      <div class="content-wrapper">

    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Select2</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           <div class="row">
           <div class="col-md-6">
             <div class="pos-rel">
               <!-- Nav pills -->
              
               <div class="connected-line"></div>
               <!-- Tab panes -->
               <!-- <div class="tab-content"> -->
                  <!-- <div id="organizer-details" class="container tab-pane active"> -->
                    <form  action="<?php echo base_url(); ?>index.php/Onlinecontrol/insert_brand">
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-person">Brand Name</label>
                       <input type="text" class="form-control"  name="brandname" id="brandname" required autocomplete="off">
                       <input type="text" style="display: none;" class="form-control"  name="brandid" id="brandid" autocomplete="off">
                       
                     </div>
                     <div class="form-group">
                        <label class="form-control-placeholder" for="contact-email">Narration</label>
                       <textarea class="form-control" name="narration" id="narration" style="line-height: 7.5"></textarea>
                       
                     </div>
                     <div class="row col-md-12 form-group txn-bottom-form" style=" box-shadow: 0 0 11px rgba(33,33,33,.2);">
          <div class="offset-md-2">
              <!--<input class="b2 btnstyle btnown" style="background: #56a7d6" type="submit" name="" value="Save">-->
              <input class="btn btnormal1"type="submit" name="save" id="save" value="Save">
            
              <input class="btn btnormal2" type="submit" name="" value="Delete" formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/delete_brand">
              <input class="btn btnormal2" type="submit" name=""  id="clear" value="Clear" formaction="javascript:void(0);">
              <input class="btn btnormal1" type="submit" name="" value="Close"  formaction="<?php echo base_url(); ?>index.php/Onlinecontrol/home">
               </form>
          <!-- </div> -->
      <!-- </div>  -->
                     
                  </div>
                 
                  
               </div>
            </div>
            </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </form>   
      </div>
      
      </section>
    
