
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
						<?php
							$avatarSrc=Yii::app()->request->baseUrl."/css/ui/img/avatars/profile.png";
							$userProfileMeta=UserMeta::model()->find('user_id=:user_id AND meta_key=:meta_key',array('user_id'=>Yii::app()->user->id,'meta_key'=>'profilePicture'));
							if ($userProfileMeta->meta_value) {
								$avatarSrc=$userProfileMeta->meta_value;
							}
						?>
						<img alt="" src="<?php echo $avatarSrc; ?>" />					
					</a>
					<ul class="dropdown-menu">
                    	<li><span class="username"><?php echo Yii::app()->user->name; ?></span></li>
						<li><a href="/user/profile"><i class="fa fa-user"></i> <?php _e('Profil') ?></a></li>
						<li><a href="/faq/index" onClick='tripStart();'><i class="fa fa-question"></i> <?php _e('Yardım') ?></a></li>
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

	<div class="mybooks_page_container clearfix">
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
						<a href="/faq">
							<i class="fa fa-medkit fa-fw"></i> <span class="menu-text">
							Destek
						</span>
						</a>
					</li>
					
					<li>
						<a href="/user/profile">
							<i class="fa fa-user fa-fw"></i> <span class="menu-text">
							Profil
						</span>
						</a>
					</li>
					<?php 
						$templates=array();

						$allTemplates=Yii::app()->db->createCommand()
						    ->select("*")
						    ->from("organisations_meta")
						    ->where("meta=:meta", array('meta'=>'template'))
						    ->queryAll();

						 $userWorkspaces=Yii::app()->db->createCommand()
						    ->select("*")
						    ->from("workspaces_users")
						    ->where("userid=:userid", array('userid'=>Yii::app()->user->id))
						    ->queryAll();

					    foreach ($allTemplates as $key => $template) {
					    	foreach ($userWorkspaces as $key2 => $workspace) {
					    		if ($workspace['workspace_id']===$template['value']) {
					    			$templates[]=$workspace['workspace_id'];
					    		}
					    	}
					    }
					?>
					<?php if(!empty($templates)) { 
							if (count($templates)==1) {
								?>
								<li>
									<a href="/organisations/templates/<?php echo $templates[0]; ?>">
										<i class="fa fa-clipboard fa-fw"></i> <span class="menu-text">
										<?php _e('Templates'); ?>
									</span>
									</a>
								</li>
								<?php
							}
							else
							{
								?>
							<li class="has-sub">
								<a href="javascript:;" class="">
									<i class="fa fa-clipboard fa-fw"></i>
									<span class="menu-text"><?php echo __('Şablonlar');?></span>
									<span class="arrow"></span>
								</a>
								<ul class="sub">
									<?php 
										foreach ($templates as $a => $tem) {
									?>
									<li>
										<a href="/organisations/templates/<?php echo $tem ?>">
										<?php 
										$organisation=Yii::app()->db->createCommand()
												    ->select("o.organisation_name")
												    ->from("organisations o")
												    ->join("organisation_workspaces w",'o.organisation_id=w.organisation_id')
												    ->where("workspace_id=:id", array(':id' => $tem ) )->queryRow();
										echo $organisation['organisation_name'];
										?>	
										</a>
									</li>
									<?php } ?>
								</ul>
								
								
							</li>

								<?php
							}
						?>
							<?php }
							
							
							function organisation()
								{
									$organisation = Yii::app()->db->createCommand()
								    ->select("*")
								    ->from("organisation_users")
								    ->where("user_id=:user_id", array(':user_id' => Yii::app()->user->id))
								    ->queryAll();
								    return  ($organisation) ? $organisation : null ;
								}
								$organisations = organisation();
							if($organisations)
							{
								foreach ($organisations as $key => $organisation) {
							?>
							
							<li class="has-sub">
								<a href="javascript:;" class="">
									<i class="fa fa-briefcase fa-fw"></i>
									<span class="menu-text"><?php 
									$organisation_name=Yii::app()->db->createCommand()
								    ->select("*")
								    ->from("organisations")
								    ->where("organisation_id=:organisation_id", array(':organisation_id' => $organisation["organisation_id"]))
								    ->queryRow();

									echo $organisation_name["organisation_name"]; 
									?></span>
									<span class="arrow"></span>
								</a>
								<ul class="sub">
									<?php if ($organisation['role']=='owner' || $organisation['role']=='manager') { ?>
									<li>
										<a href="/organisations/account/<?php echo $organisation["organisation_id"]; ?>">
											Kontrol Paneli
										</a>
									</li>
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
									<li>
										<a href="/organisations/bookCategories/<?php echo $organisation["organisation_id"]; ?>">
										<?php _e('Yayın Kategorileri'); ?>
										</a>
									</li>
									<li>
										<a href="/organisations/aCL/<?php echo $organisation["organisation_id"]; ?>">
										<?php _e('ACL'); ?>
										</a>
									</li>
									<?php }; ?>
									<li>
										<a href="/organisations/publishedBooks/<?php echo $organisation["organisation_id"]; ?>">
										<?php _e('Yayınlanan Eserler'); ?>
										</a>
									</li>
								</ul>
								
								
							</li>
							<?php } ;
						};
						?>
							
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