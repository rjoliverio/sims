<nav class="sb-topnav navbar navbar-expand navbar-dark bg-light topnavcolor shadow-sm">
            <a class="navbar-brand" href="cashierdashboard.php"><img  src="../images/sims2.png" width="50" height="50"><span class="simstop ">SIMS</span></a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <!-- <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a> -->
                        <!-- <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="../index.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark navcolor" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-nav-userinfo p-3">
                                <div class="float-left">
                                    <img src="../images/<?php echo $res['Image']; ?>" width="50" height="50">
                                </div>
                                <div class="userdetails">
                                    <p><?php echo $res['Fname']." ".$res['Lname']; ?></p>
                                    <span><?php echo $res['Employee_id']; ?></span>
                                </div>
                            </div>
                            
                            <div class="user-divider w-100 bg-white"></div>

                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="cashierdashboard.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a>
                            <a class="nav-link" href="purchase.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                                Transaction
                            </a>
                            <a class="nav-link" href="reports.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                Reports
                            </a>
                            <a class="nav-link" href="contacts.php">
                                <div class="sb-nav-link-icon"><i class="far fa-address-book"></i></div>
                                Contacts
                            </a>
                            <?php if($res['Person_type']=="Manager"){ ?>
                                <a class="nav-link" href="employeeregistration.php">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                                    Registration
                                </a>
                            <?php } ?>
                            <a class="nav-link" href="products.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-gift"></i></div>
                                Products
                            </a>
                            <div class="sb-sidenav-menu-heading">SIMS Code</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                                ><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Membership
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                            ></a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="simscoderegister.php">Register</a></nav>
                            </div>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="simscodescan.php">QR Scan</a></nav>
                            </div>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                               
                            </div>
                            <!-- <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts</a
                            ><a class="nav-link" href="tables.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables</a
                            > -->
                        </div>
                    </div>
                    <div class="sb-sidenav-footer bg-success logged border border-white border-right-0 border-bottom-0 border-left-0">
                        <div class="small text-white">Logged in as:</div>
                        <span class="text-white active-name "><?php echo $res['Fname']." ".$res['Lname']." (".$res['Person_type'].")"; ?></span>
                    </div>
                </nav>
            </div>