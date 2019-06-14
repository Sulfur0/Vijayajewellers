<?php session_start(); 
if($_SESSION["usuario"]==null){
    header("Location: index.php?fail=1&not-authorized=1");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vijaya Jewellers Automation</title>

    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/metisMenu.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!--
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    -->
    

</head>

<body>

    <div id="wrapper">

        
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="admin.php">Vijaya Jewellers Automation</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo $_SESSION["usuario"];?><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                    <!--
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>

                        <li class="divider"></li>
                        -->
                        <li><a href="backend/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <?php 
                        if($_SESSION["privileges"]=='2'){
                        ?>
                        <li>
                        <!-- mostrar esto si el usuario es administrador -->
                            <a href="/#"><i class="fa fa-users fa-fw"></i> Administration<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="users/create-user.php"><i class='fa fa-plus fa-fw'></i> Add new User</a>
                                </li>
                                <li>
                                    <a href="users/list-users.php"><i class='fa fa-list-ol fa-fw'></i> User list</a>
                                </li>
                            </ul>
                        </li>
                        <!-- hasta aqui -->
                        <?php   
                        }
                        ?>

                        <li>
                            <a href="/#"><i class="fa fa-users fa-fw"></i> Customers<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="customers/create-customer.php"><i class='fa fa-plus fa-fw'></i> Add new customer</a>
                                </li>
                                <?php if($_SESSION["privileges"]=='2'){ ?>
                                <li>
                                    <a href="customers/list-customers.php"><i class='fa fa-list-ol fa-fw'></i> customers List</a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-handshake-o fa-fw"></i> Sales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="sales/create-sale.php"><i class='fa fa-plus fa-fw'></i> New Sale</a>
                                </li>  
                                <?php if($_SESSION["privileges"]=='2'){ ?>                              
                                <li>
                                    <a href="sales/bill-sales.php"><i class='fa fa-folder-open fa-fw'></i> Bill archive</a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-diamond fa-fw"></i> Pawning<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="pawnings/create-pawning.php"><i class='fa fa-plus fa-fw'></i> New Pawning</a>
                                </li> 
                                <?php if($_SESSION["privileges"]=='2'){ ?> 
                                <li>
                                    <a href="pawnings/list-pawnings.php"><i class='fa fa-list-ol fa-fw'></i> Pawning list</a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="pawnings/input-bill.php?repawn=1"><i class='fa fa-plus fa-fw'></i> Re Pawn</a>
                                </li> 
                                <li>
                                    <a href="pawnings/input-bill.php?redeem=1"><i class='fa fa-gift fa-fw'></i> Redeem </a>
                                </li>
                                <li>
                                    <a href="pawnings/input-bill.php?warning-letter=1"><i class='fa fa-bell fa-fw'></i> Warning Letter </a>
                                </li>
                                <li>
                                    <a href="pawnings/input-bill.php?terminate-pawn=1"><i class='fa fa-close fa-fw'></i>Terminate Pawn</a>
                                </li>
                                <li>
                                    <a href="pawnings/list-pawnings-won.php"><i class='fa fa-trophy fa-fw'></i> Pawn Won inventory</a>
                                </li>                                
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-book fa-fw"></i> Orders<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($_SESSION["privileges"]=='2'){ ?>
                                <li>
                                    <a href="orders/list-orders.php"><i class='fa fa-list-ol fa-fw'></i> All Orders</a>
                                </li>
                                <?php } ?>
                                <li>
                                    <a href="orders/create-order.php"><i class='fa fa-plus fa-fw'></i> Add new Order</a>
                                </li>                                
                                <li>
                                    <a href="orders/input-bill.php?deliver-order=1"><i class='fa fa-check fa-fw'></i> Deliver Order</a>
                                </li>
                                <li>
                                    <a href="orders/pending-orders.php"><i class='fa fa-list-ol fa-fw'></i> Pending Orders</a>
                                </li>
                            </ul>
                        </li>
                        
                        
                        <li>
                            <a href="#"><i class="fa fa-cubes fa-fw"></i> Articles<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="articles/create-article.php"><i class='fa fa-plus fa-fw'></i> Add new Article</a>
                                </li>
                                <li>
                                    <a href="articles/create-article.php"><i class='fa fa-list-ol fa-fw'></i> Article List</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-map-marker fa-fw"></i> Areas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="areas/create-area.php"><i class='fa fa-plus fa-fw'></i> Add new Area</a>
                                </li>
                                <li>
                                    <a href="areas/list-areas.php"><i class='fa fa-list-ol fa-fw'></i> Areas List</a>
                                </li>
                            </ul>
                        </li>
                        <?php if($_SESSION["privileges"]=='2'){ ?>
                        <li>
                            <a href="#"><i class="fa fa-file-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="reports/input-date.php?target=sales"><i class='fa fa-calendar fa-fw'></i> Sales Report</a>
                                    <!--
                                    <span class="fa arrow"></span>//poner esto detras de bton para hacer efecto de flecha de lista desplegable
                                    <ul class="nav nav-third-level">
                                        
                                        <li>
                                            <a href="reports/sales-report.php?m=1"><i class="fa fa-calendar fa-fw"></i> Monthly</a>
                                        </li>
                                        <li>
                                            <a href="reports/sales-report.php?a=1"><i class="fa fa-calendar fa-fw"></i> Anual</a>
                                        </li>
                                        
                                        <li>
                                            <a href="reports/input-date.php?target=sales"><i class="fa fa-calendar fa-fw"></i> Monthly</a>
                                        </li>
                                        <li>
                                            <a href="reports/input-date.php?target=sales"><i class="fa fa-calendar fa-fw"></i> Anual</a>
                                        </li>
                                    </ul>
                                    -->
                                </li>
                                <li>
                                    <a href="reports/input-date.php?target=pawnings"><i class='fa fa-calendar fa-fw'></i> Pawns Report</a>
                                    <!--
                                    <span class="fa arrow"></span>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="reports/input-date.php?target=pawnings"><i class="fa fa-calendar fa-fw"></i> Monthly</a>
                                        </li>
                                        <li>
                                            <a href="reports/input-date.php?target=pawnings"><i class="fa fa-calendar fa-fw"></i> Anual</a>
                                        </li>
                                    </ul>
                                    -->
                                </li>
                                <li>
                                    <a href="reports/pawn-stock.php"><i class="fa fa-cubes fa-fw"></i>Pawning Gold in Stock</a>
                                </li>
                                <li>
                                    <a href="reports/sales-stock.php"><i class="fa fa-cubes fa-fw"></i>Gold Stock</a>
                                </li>
                                <li>
                                    <a href="reports/orders-stock.php"><i class="fa fa-cubes fa-fw"></i>Orders in Stock</a>
                                </li>
                                <li>
                                    <a href="reports/orders-ontime.php"><i class="fa fa-check fa-fw"></i>Orders Completed</a>
                                </li>
                                <li>
                                    <a href="reports/upcoming-pawn.php"><i class="fa fa-clock-o fa-fw"></i> Upcoming Pawns</a>
                                </li>
                                <li>
                                    <a href="reports/warnings-sent.php"><i class="fa fa-warning fa-fw"></i> Warnings Sent</a>
                                </li>
                                <li>
                                    <a href="reports/pawnings-won.php"><i class="fa fa-trophy fa-fw"></i> Pawnings Won</a>
                                </li>
                                <li>
                                    <a href="reports/area-pawns-sales.php"><i class="fa fa-map-marker fa-fw"></i> Area Wise</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Inventory<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">    
                                <li>
                                    <a href="inventory/new-gold.php"><i class='fa fa-list-ol fa-fw'></i> New Gold</a>
                                </li>
                                <li>
                                    <a href="inventory/old-gold.php"><i class='fa fa-list-ol fa-fw'></i> Old Gold</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-gear fa-fw"></i> Site Configuration<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">    
                                <li>
                                    <a href="config/index.php"><i class='fa fa-gears fa-fw'></i> Setup</a>
                                </li>                                
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

     </nav>

        <div id="page-wrapper">