
    <!-- Sidebar -->
    <div class="sidebar sidebar-fixed">
        <div class="sidebar-dropdown"><a href="#">Navigation</a></div>

        <div class="sidebar-inner">
        
            <!--- Sidebar navigation -->
            <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
            <ul class="navi">

                <!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->

                <li><a href="<?php echo base_url()."admin";?>"><i class="icon-desktop"></i> Dashboard</a></li>

                <!-- Start: Admin Menu -->
                <li class="has_submenu">
                    <a href="#">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Users
                        <!-- Icon for dropdown -->
                    </a>
                    <ul>
                        <!--<li><a href="<?php echo base_url()."admin/sales";?>">Sales Reports</a></li>
                        <li><a href="<?php echo base_url()."admin/products";?>">Product Reports</a></li>
                        <li><a href="<?php echo base_url()."admin/usage";?>">Usage Reports</a></li>-->
                        <li><a href="<?php echo base_url()."all-users";?>">Admins</a></li>
                        <li><a href="<?php echo base_url()."all-customers";?>">Customers</a></li>
                    </ul>
                </li>
				<!-- End: Admin Menu -->
                
                <li><a href="<?php echo base_url()."administration/contacts";?>"><i class="icon-desktop"></i> Company profile</a></li>

                <!-- Start: Blog Menu -->
                <li class="has_submenu">
                    <a href="#">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Blog
                        <!-- Icon for dropdown -->
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url()."posts";?>">Posts</a></li>
                        <li><a href="<?php echo base_url()."blog-categories";?>">Categories</a></li>
                        <li><a href="<?php echo base_url()."comments";?>">All Comments</a></li>
                    </ul>
                </li>
				<!-- End: Blog Menu -->

                <!-- Start: Products Menu -->
                <li class="has_submenu">
                    <a href="#">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Spare Parts
                        <!-- Icon for dropdown -->
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url()."admin/all-brands";?>">Brands</a></li>
                        <li><a href="<?php echo base_url()."admin/all-categories";?>">Categories</a></li>
                        <li><a href="<?php echo base_url()."admin/all-models";?>">Models</a></li>
                        <li><a href="<?php echo base_url()."admin/all-products";?>">All Parts</a></li>
                    </ul>
                </li>
				<!-- End: Products Menu -->

            </ul>
        </div>
    </div>
    <!-- Sidebar ends -->
