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
	<header class="navbar clearfix" id="header">
		<!-- Top Navigation Bar -->
		<div class="container">
		<div class="navbar-brand">
					<!-- COMPANY LOGO -->
					<a href="<?php echo $this->createUrl('site/index');  ?>">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/logo.png" alt="Linden" class="img-responsive" height="30" width="120">
					</a>
					<!-- /COMPANY LOGO -->
					<!-- TEAM STATUS FOR MOBILE -->
					<div class="visible-xs">
						<a href="#" class="team-status-toggle switcher btn dropdown-toggle">
							<i class="fa fa-users"></i>
						</a>
					</div>
					<!-- /TEAM STATUS FOR MOBILE -->
					<!-- SIDEBAR COLLAPSE -->
					<div id="sidebar-collapse" class="sidebar-collapse btn">
						<i class="fa fa-bars" 
							data-icon1="fa fa-bars" 
							data-icon2="fa fa-bars" ></i>
					</div>
					<!-- /SIDEBAR COLLAPSE -->
				</div>

			<!-- Top Right Menu -->
			<ul class="nav navbar-nav navbar-right">
				<!-- User Login Dropdown -->
				<li class="dropdown user" id="header-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="img/avatars/avatar3.jpg" />
						<span class="username"><?php echo Yii::app()->user->name; ?></span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="/user/profile"><i class="fa fa-user"></i> <?php _e('Profil') ?></a></li>
						<li><a href="/site/logout"><i class="fa fa-power-off"></i> <?php _e('Çıkış') ?></a></li>
					</ul>
				</li>
				<!-- /user login dropdown -->
			</ul>
			<!-- /Top Right Menu -->
		</div>
		<!-- /top navigation bar -->
	</header> <!-- /.header -->

	<section id="page">
		<div id="sidebar" class="sidebar">
			<div class="sidebar-menu nav-collapse">
				<!--=== Navigation ===-->
				<ul>
					<li class="current">
						<a href="index.html">
							<i class="fa fa-tachometer fa-fw"></i>
							<span class="menu-text">Kontrol	Paneli</span>
							</a>
					</li>
					<?php function getUserWorkspaces()
					{
						$userid=Yii::app()->user->id;

						$workspacesOfUser= Yii::app()->db->createCommand()
					    ->select("*")
					    ->from("workspaces_users x")
					    ->join("workspaces w",'w.workspace_id=x.workspace_id')
					    ->join("user u","x.userid=u.id")
					    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
					    
					    return $workspacesOfUser;	
					}
					$workspacesOfUser= getUserWorkspaces();
					if (isset($workspacesOfUser) && !empty($workspacesOfUser)):
					?>
					
					<li class="has-sub">
						<a href="javascript:;" class="">
							<i class="fa fa-book fa-fw"></i>
							<span class="menu-text">Kitaplarım</span>
								<span class="arrow"></span>
						</a>
						<ul class="sub">
						<?php foreach ($workspacesOfUser as $key => $workspace): 
						$workspace=(object)$workspace; ?>
							<li>
								<a href="/site/index?id=<?php echo $workspace->workspace_id; ?>">
								<span class="sub-menu-text">
								<?php echo $workspace->workspace_name; ?>
								</span>
								</a>
							</li>
						<?php endforeach; ?>
						</ul>
						
					</li>
					<?php endif; ?>
					
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
							<i class="fa fa-money fa-fw"></i> <span class="menu-text">
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
							<i class="fa fa-briefcase fa-fw"></i>
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
</section>



</body>
</html>