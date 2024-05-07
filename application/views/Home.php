<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Infotick accounting</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style4.css">
<link href="https://fonts.googleapis.com/css?family=Audiowide|Bungee|Concert+One|Nunito|PT+Sans|Righteous|Text+Me+One" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="<?php echo base_url();?>js/jquery1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

</head>

<body>
    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <!-- <a class="navbar-brand" href="#">WebSiteName</a> -->
      <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span></span>
                    </button>
                
                <!-- <strong><img src="log2.png" width="40px" height="50px"></strong> -->
 

            
    </div>
    
    <form class="navbar-form navbar-left" action="/action_page.php">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="search">
        <div class="input-group-btn">
          <button class="btn btn-default" style="" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </div>
</nav>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
  

   <div class="w3-container w3-row" style="background-image: linear-gradient(to top right,black,#3c3c3c );">
    <div class="w3-col s4">
      <img src="<?php echo base_url(); ?>/assets/resources/man.svg" class="w3-circle w3-margin-right" style="width:46px height:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong>ADMIN</strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  


            <ul class="list-unstyled components">
                <li >
                    <a href="#">
                        <i><img src="<?php echo base_url(); ?>/assets/resources/house.svg" height="20px" width="20px"></i>
                        Home
                    </a>

                

                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i ><img src="<?php echo base_url(); ?>/assets/resources/shopping-bag.svg" height="20px" width="20px"> </i>
                        Sales
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Estimate</a>
                        </li>
                        <li>
                            <a href="#">Sales order</a>
                        </li>
                        <li>
                            <a href="#">Delivery challans</a>
                        </li>
                         <li>
                            <a href="#">Invoice</a>
                        </li>
                         <li>
                            <a href="#">Payment received</a>
                        </li>
                         <li>
                            <a href="#">Recurring invoice</a>
                        </li>
                         <li>
                            <a href="#">Credit notes</a>
                        </li>
                    </ul>
                </li>

               
                <li>
                    
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i><img src="<?php echo base_url(); ?>/assets/resources/basket.svg" width="20px" height="20px"></i>
                        Purchase
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Expense</a>
                        </li>
                        <li>
                            <a href="#">Recurring expense</a>
                        </li>
                        <li>
                            <a href="#">Purchase order</a>
                        </li>
                        <li>
                            <a href="#">Bills</a>
                        </li>
                        <li>
                            <a href="#">Payment made</a>
                        </li>
                        <li>
                            <a href="#">Recurring bills</a>
                        </li>
                        <li>
                            <a href="#">Vendor credit</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="supplier.html">
                      <i><img src="<?php echo base_url(); ?>/assets/resources/meeting.svg" width="20px" height="20px"></i>  
                       Supplier
                    </a>
                </li>

                 <li> 
                  <a href="#homeSubmenu5" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i ><img src="<?php echo base_url(); ?>/assets/resources/shopping-bag.svg" height="20px" width="20px"> </i>
                        Product
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu5">
                        <li>
                            <a href="productgroup.html">Add Product group</a>
                        </li>
                        
                    </ul>
                </li>



               


                 <li>
                    
                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i><img src="<?php echo base_url(); ?>/assets/resources/man.svg" width="20px" height="20px"></i>
                        user
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu2">
                        <li>
                            <a href="#">Add user</a>
                        </li>
                        <li>
                            <a href="#">Remove user</a>
                        </li>
                        
                    </ul>
                </li>



                    <li>
                    <a href="#">
                      <i><img src="<?php echo base_url(); ?>/assets/resources/diagram.svg" width="20px" height="20px"></i>  
                       Reports
                    </a>
                </li>

       

            </ul>

   
        </nav>
       

        <!-- Page Content  -->
     
       

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>

</html>