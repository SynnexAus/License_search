	<aside class="left-side sidebar-offcanvas">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<?php /*?><div class="pull-left image">
				 <?php
				$img=$mfp->mf_getValue("admin","image_path","id",$_SESSION['Admin_UserID']);
				if(is_file("../uploads/profile/".$img))
				{ ?>
					<img src="../uploads/profile/<?=$img;?>" class="img-circle" alt="User Image"/>                            
				<?php }else{ ?>
					<img src="../uploads/profile/no_avatar.jpg" class="img-circle" alt="User Image"/>
				<?php	} ?>
				</div><?php */?>
				<div class="pull-left info">
					<p>Hello, <?=ucfirst($mfp->mf_getvalue("admin","username","id",$_SESSION['Admin_UserID']));?></p>

					
				</div>
			</div>
		  
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				
				<li class="active">
					<a <?=($currentMenu=="Dashboard")?"class='active'":"";?> href="dashboard.php">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					</a>
				</li>
				<li class="treeview <?=($currentMenu=="Customers")?"active":"";?>">
					<a href="#">
					<i class="fa fa-smile-o"></i>
						<span>Manage Customers</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <?=($currentPage=="Manage Customers")?"class='active'":"";?>><a href="manage-customers.php"><i class="fa fa-angle-double-right"></i>Manage Customers</a></li>                                 
					</ul>
				</li>
				<li class="treeview <?=($currentMenu=="Users")?"active":"";?>">
					<a href="#">
					<i class="fa fa-smile-o"></i>
						<span>Manage Users</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <?=($currentPage=="Manage Users")?"class='active'":"";?>><a href="manage-users.php"><i class="fa fa-angle-double-right"></i>Manage Users</a></li>                                 
					</ul>
				</li>
                
				<li class="treeview <?=($currentMenu=="Email Templates")?"active":"";?>">
					<a href="#" >
						<span class="fa fa-envelope"></span>                               
						<span>Email Templates</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <?=($currentPage=="Manage Email Templates")?"class='active'":"";?>><a href="manage-email-template.php"><i class="fa fa-angle-double-right"></i>Manage Email Templates</a></li> 
										  
					</ul>
				</li>
                <li class="treeview <?=($currentMenu=="Static Pages")?"active":"";?>">
					<a href="#" >
						<span class="fa fa-edit"></span>                               
						<span>Static Pages</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li <?=($currentPage=="Manage Pages")?"class='active'":"";?>><a href="manage-pages.php"><i class="fa fa-angle-double-right"></i> Manage Pages</a></li>                             
					</ul>
				</li>
                <li class="treeview <?=($currentMenu=="Settings")?"active":"";?>">
                    <a href="#">
                        <span class="fa fa-cogs"></span>
                        <span>Settings</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                <ul class="treeview-menu">
                    <?php /*?><li <?=($currentPage=="Manage Settings")?"class='active'":"";?>><a href="manage-settings.php"><i class="fa fa-angle-double-right"></i> Manage Settings</a></li>
                    <li <?=($currentPage=="Profile")?"class='active'":"";?>><a href="profile.php"><i class="fa fa-angle-double-right"></i> Profile</a></li><?php */?>
                    <li <?=($currentPage=="Change Password")?"class='active'":"";?>><a href="change-password.php"><i class="fa fa-angle-double-right"></i> Change Password</a></li>
                    <li><a href="logout.php"><i class="fa fa-angle-double-right"></i> Sign Out</a></li>
                </ul>
                </li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>