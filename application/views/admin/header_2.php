<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MOA| Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/select2/dist/css/select2.min.css">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - te<?php echo base_url();?>xt editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>adim/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">


  <!--optional css -->


<!-- <link href="<?php echo base_url(); ?>css/sub/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" media="all" /> -->


  <!--optional css -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>MOA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url();?>adim/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url();?>adim/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                    INFOTICK Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url();?>adim/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url();?>adim/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url();?>adim/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>adim/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo  $this->session->userdata('name');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>adim/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                <?php echo  $this->session->userdata('name');?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url();?>index.php/Onlinecontrol/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>adim/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo  $this->session->userdata('name');?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
     
        <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Inventory Master</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Product"><i class="fa fa-circle-o"></i>Product</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/product_image"><i class="fa fa-circle-o"></i>Product Image</a></li>
            <li><a href="<?php echo base_url();?>ProductGroup"><i class="fa fa-circle-o"></i>Product Group</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/imagehandler"><i class="fa fa-circle-o"></i>Image Handler</a></li>
            <li><a href="<?php echo base_url();?>Unit"><i class="fa fa-circle-o"></i>Unit</a></li>
            <li><a href="<?php echo base_url();?>Brand"><i class="fa fa-circle-o"></i>Brand</a></li>
            <li><a href="<?php echo base_url();?>Batch"><i class="fa fa-circle-o"></i>Batch</a></li>
            <!-- <li><a href="<?php echo base_url();?>Batch"><i class="fa fa-circle-o"></i>Size</a></li> -->
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/multicurrency"><i class="fa fa-circle-o"></i>Multi Currency</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/shippingcharge"><i class="fa fa-circle-o"></i>Shipping Charge</a></li>
            
            
          </ul>
        </li>
  
         <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Account Master</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>AccountGroup"><i class="fa fa-circle-o"></i>Account Group</a></li>
            <li><a href="<?php echo base_url();?>AccountLedger"><i class="fa fa-circle-o"></i>Account Ledger</a></li>
            
          </ul>
        </li>
         <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Purchase</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>Purchase"><i class="fa fa-circle-o"></i>Purchase Invoice</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/editpur?fromdate=<?php echo date("Y/m/d H:i:s");?>&todate=<?php echo date("Y/m/d H:i:s");?>"><i class="fa fa-circle-o"></i>Edit Purchase</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/pur_return"><i class="fa fa-circle-o"></i>Purchase Return</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/purorder"><i class="fa fa-circle-o"></i>Purchase Order</a></li>
           
          </ul>
        </li>

         <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>User</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/Salesman"><i class="fa fa-circle-o"></i>Add Salesman</a></li>
          <li><a href="<?php echo base_url();?>Supplier"><i class="fa fa-circle-o"></i>Supplier</a></li>
            <li><a href="<?php echo base_url();?>Customer"><i class="fa fa-circle-o"></i>Customer</a></li>
            <li><a href="<?php echo base_url();?>Branch"><i class="fa fa-circle-o"></i>Branch</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/AddUser"><i class="fa fa-circle-o"></i>Add User</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/Changepassword"><i class="fa fa-circle-o"></i>Change Password</a></li>
          </ul>
        </li>
         </li>
         <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Transaction</span>
            <span class="pull-right-container">
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>JournelVoucher"><i class="fa fa-circle-o"></i>Journel Voucher</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/stocktransfer"><i class="fa fa-circle-o"></i>Stock Transfer</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/physicalstock"><i class="fa fa-circle-o"></i>Physical Stock</a></li>
             <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/contravoucher"><i class="fa fa-circle-o"></i>Contra Voucher</a></li>
            <li><a href="<?php echo base_url();?>index.php/Stockcontrol/damagestock"><i class="fa fa-circle-o"></i>Damage Stock</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/paymentvoucher"><i class="fa fa-circle-o"></i>Payment Voucher</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/chequepayment"><i class="fa fa-circle-o"></i>Cheque Payment</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/chequereceipt"><i class="fa fa-circle-o"></i>Cheque Receipt</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/receiptvoucher"><i class="fa fa-circle-o"></i>Receipt Voucher</a></li>
             <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/branchpaymentvoucher"><i class="fa fa-circle-o"></i>Branch Expense</a></li>
          </ul>
        </li>

        <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/PurchaseReport">
            <i class="fa fa-files-o"></i>
            <span>Purchase Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li>

        <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/PurchaseReturnReport">
            <i class="fa fa-files-o"></i>
            <span>Purchase Return Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li>

        <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/salesreport">
            <i class="fa fa-files-o"></i>
            <span>Sales Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li>

        <!-- <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/salesrtnreport_ogi">
            <i class="fa fa-files-o"></i>
            <span>Sales Return Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li> -->

        <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/stockreport">
            <i class="fa fa-files-o"></i>
            <span>Stock Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li>


        <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/branchreport">
            <i class="fa fa-files-o"></i>
            <span>Branch Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li>

        <li class="treevieww">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/walletreport">
            <i class="fa fa-files-o"></i>
            <span>Wallet</span>
            <span class="pull-right-container">
            
            </span>
          </a>
        </li>


          <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Others Reports</span>
            <span class="pull-right-container">
            </span>
          </a>

          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/salescost"><i class="fa fa-circle-o"></i>Sales Cost</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/ShopOrder"><i class="fa fa-circle-o"></i>Shop Order</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/salesrtnreport_ogi"><i class="fa fa-circle-o"></i>Sales Return Report</a></li>

             <li><a href="<?php echo base_url();?>index.php/Salescontrol/dailysalesreport"><i class="fa fa-circle-o"></i>Daily Sales</a></li>
            <!--<li><a href="<?php echo base_url();?>index.php/Onlinecontrol/daybook"><i class="fa fa-circle-o"></i>Day Book</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/profitnloss"><i class="fa fa-circle-o"></i>Profit & Loss A/C</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/balancesheet"><i class="fa fa-circle-o"></i>Balance Sheet</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/trialbalance"><i class="fa fa-circle-o"></i>Trial Balance</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/cash_bank_book"><i class="fa fa-circle-o"></i>Cash/Bank Book</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol/chequePage"><i class="fa fa-circle-o"></i> Cheque Register</a></li>
             <li><a href="<?php echo base_url(); ?>index.php/Onlinecontrol/cust_accview"><i class="fa fa-circle-o"></i> Ledger Register</a></li> -->
      
         
           
          </ul>
        </li>


        <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>eCommerce</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/esalesinvoice"><i class="fa fa-circle-o"></i>eCommerce Sales</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommerce"><i class="fa fa-circle-o"></i>Orders</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommercedetails"><i class="fa fa-circle-o"></i>Order Details</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbypaydate"><i class="fa fa-circle-o"></i>Order Details By Payment</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommercedetailsbyPaidNotDelivered"><i class="fa fa-circle-o"></i>Report Paid Not Delivered</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbynotpaid"><i class="fa fa-circle-o"></i>Report Not Paid</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbycancelled"><i class="fa fa-circle-o"></i>Report Cancelled</a></li>
            <li><a href="<?php echo base_url();?>index.php/Onlinecontrol/chat_room"><i class="fa fa-circle-o"></i>Chat Room</a></li>
          </ul>
    
        </li>
        <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>eCommerce UAE</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/esalesinvoiceaed"><i class="fa fa-circle-o"></i>eCommerce Sales UAE</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommerceaed"><i class="fa fa-circle-o"></i>Orders UAE</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommercedetailsaed"><i class="fa fa-circle-o"></i>Order Details UAE</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbypaydateaed"><i class="fa fa-circle-o"></i>Order Details By Payment UAE</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommercedetailsbyPaidNotDeliveredaed"><i class="fa fa-circle-o"></i>Report Paid Not Delivered UAE</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbynotpaidaed"><i class="fa fa-circle-o"></i>Report Not Paid UAE</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbycancelledaed"><i class="fa fa-circle-o"></i>Report Cancelled UAE</a></li>
          </ul>
    
        </li>
        <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>eCommerce USD</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/esalesinvoiceusd"><i class="fa fa-circle-o"></i>eCommerce Sales USD</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommerceusd"><i class="fa fa-circle-o"></i>Orders USD</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommercedetailsusd"><i class="fa fa-circle-o"></i>Order Details USD</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbypaydateusd"><i class="fa fa-circle-o"></i>Order Details By Payment USD</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/eCommercedetailsbyPaidNotDeliveredusd"><i class="fa fa-circle-o"></i>Report Paid Not Delivered USD</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbynotpaidusd"><i class="fa fa-circle-o"></i>Report Not Paid USD</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomreportbycancelledusd"><i class="fa fa-circle-o"></i>Report Cancelled USD</a></li>
          </ul>
    
        </li>
         <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Production</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomproductionreport"><i class="fa fa-circle-o"></i>INR orders</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomproductionreportusd"><i class="fa fa-circle-o"></i>USD orders</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomproductionreportaed"><i class="fa fa-circle-o"></i>AED orders</a></li>
           
          </ul>
    
        </li>
        <li class="treeview" style="display:none;">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Shipping</span>
            <span class="pull-right-container">
            
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomshipping"><i class="fa fa-circle-o"></i>INR orders</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomshippingusd"><i class="fa fa-circle-o"></i>USD orders</a></li>
            <li><a href="<?php echo base_url();?>index.php/Esalescontrol/ecomshippingaed"><i class="fa fa-circle-o"></i>AED orders</a></li>
           
          </ul>
    
        </li>

        <!-- <li class="trsdfeview">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/direct_stock">
            <i class="fa fa-files-o"></i>
            <span>Direct stock</span>
            <span class="pull-right-container">
            
            </span>
          </a>    
        </li> -->

        <li class="treasdfeview" style="display:none;">
          <a href="<?php echo base_url();?>index.php/Onlinecontrol/direct_stock_report">
            <i class="fa fa-files-o"></i>
            <span>Direct Stock Report</span>
            <span class="pull-right-container">
            
            </span>
          </a>    
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>