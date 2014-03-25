<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

		<?php echo $content; ?>


	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>

<?php $this->endContent(); ?>
<!-- Header -->
	<header class="navbar clearfix navbar-fixed-top read_page_navbar navbar_blue" id="header">
		<!-- Top Navigation Bar -->
		<div class="container">
		<div class="navbar-brand">
					
					<!-- TEAM STATUS FOR MOBILE -->
					<div class="visible-xs">
						<a href="#" class="team-status-toggle switcher btn dropdown-toggle">
							<i class="fa fa-users"></i>
						</a>
					</div>
					<!-- /TEAM STATUS FOR MOBILE -->
					<!-- SIDEBAR COLLAPSE -->
					<div id="sidebar-collapse" class="sidebar-collapse brand_hover_color_for_navbar_components">
						<i class="fa fa-bars" data-icon1="fa fa-bars" data-icon2="fa fa-bars" ></i>
					</div>
					<!-- /SIDEBAR COLLAPSE -->
                    <div class="expanding-searchbox">
						<div id="sb-search" class="sb-search">
							<form>
								<input class="sb-search-input" placeholder="Ne aramak istiyorsunuz?" type="text" value="" name="search" id="search">
								<input class="sb-search-submit" type="submit" value="">
								<span class="sb-icon-search brand_hover_color_for_navbar_components"></span>
							</form>
						</div>
					</div>
                    
				</div>

			<!-- Top Right Menu -->
			<ul class="nav navbar-nav navbar-right">
				<!-- User Login Dropdown -->
				<li class="dropdown user" id="header-user">
					<a href="#" class="dropdown-toggle read_page_user" data-toggle="dropdown">
						<img alt="" src="img/avatars/avatar3.jpg" />						
					</a>
					<ul class="dropdown-menu">
                    	<li><span class="username"><?php echo Yii::app()->user->name; ?></span></li>
						<li><a href="/user/profile"><i class="fa fa-user"></i> <?php _e('Profil') ?></a></li>
						<li><a href="/site/logout"><i class="fa fa-power-off"></i> <?php _e('Çıkış') ?></a></li>
					</ul>
				</li>
				<!-- /user login dropdown -->
			</ul>
			<!-- /Top Right Menu -->
            
            
            <div class="navbar_logo"></div>
            
            
		</div>
		<!-- /top navigation bar -->
	</header> <!-- /.header -->

	<div class="mybooks_page_container">
		<div id="sidebar" class="sidebar sidebar-fixed">
			<div class="sidebar-menu nav-collapse">
				<!--=== Navigation ===-->
				<ul>
					<li class="current">
						<a href="/site/dashboard">
							<i class="fa fa-gear fa-fw"></i>
							<span class="menu-text">Kontrol	Paneli</span>
							</a>
					</li>
					<li>
						<a href="/site/index">
							<i class="fa fa-book fa-fw"></i> <span class="menu-text">
							<?php _e('Kitaplarım'); ?>
						</span>
						</a>
					</li>
					<!--<li>
						<a href="users.html">
							<i class="icon-tasks"></i>
							Hosting
						</a>
					</li>
					-->
					<li>
						<a href="#">
							<i class="fa fa-medkit fa-fw"></i> <span class="menu-text">
							Destek
						</span>
						</a>
					</li>
					
					<li>
						<a href="#">
							<i class="fa fa-user fa-fw"></i> <span class="menu-text">
							Hesabım
						</span>
						</a>
					</li>
					
					<?php 
					function organisation()
						{
							$organisation = Yii::app()->db->createCommand()
						    ->select("*")
						    ->from("organisation_users")
						    ->where("user_id=:user_id", array(':user_id' => Yii::app()->user->id))
						    ->queryRow();
						    return  ($organisation) ? $organisation : null ;
						}
						$organisation = organisation();
					if($organisation)
					{
					?>
					<li class="has-sub">
						<a href="javascript:;" class="">
							<i class="fa fa-sitemap fa-fw"></i>
							<span class="menu-text"><?php echo __('Organizasyon');?></span>
							<span class="arrow"></span>
						</a>
						<ul class="sub">
							<li>
								<a href="/organisations/users?organisationId=<?php echo $organisation["organisation_id"]; ?>">
								<?php _e('Kullanıcılar'); ?>	
								</a>
							</li>
							<li>
								<a href="/organisations/workspaces?organizationId=<?php echo $organisation["organisation_id"]; ?>">
								<?php _e('Çalışma Alanı'); ?>
								</a>
							</li>
							<li>
								<a href="/organisationHostings/index?organisationId=<?php echo $organisation["organisation_id"]; ?>">
								<?php _e('Sunucu'); ?>
								</a>
							</li>
						</ul>
						
						
					</li>
					<?php } ?>
					
				</ul>
				<!-- /Navigation -->
				
			</div>
		</div>
		<!-- /Sidebar -->
	
	<div id="main-content">
		<div class="container">
			<div class="row">
					
		<?php echo $content; ?>

		</div>
	</div>
   </div>
<!-- END OF MYBOOKS PAGE CONTAINER -->


</body>
</html>