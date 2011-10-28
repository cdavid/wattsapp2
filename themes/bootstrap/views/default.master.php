<!DOCTYPE html>
<html lang="en">
<head>
<?php
$this->RenderAsset('Head');
echo '<script type="text/javascript" src="' . Gdn_Url::WebRoot(true) . "/themes/bootstrap/js/bootstrap-tabs.js" . '" /></script>' . "\n";
echo '<script type="text/javascript" src="' . Gdn_Url::WebRoot(true) . "/themes/bootstrap/js/bootstrap-dropdown.js" . '" /></script>' . "\n";
echo '<link src="' . Gdn_Url::WebRoot(TRUE) . '/themes/bootstrap/design/style.css" rel="stylesheet" type="text/css"></link>' . "\n";
?>
</head>
<body id="<?php echo $BodyIdentifier; ?>"
	class="<?php echo $this->CssClass; ?>">
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<a class="brand" href="<?php echo Url('/'); ?>"><span><?php echo Gdn_Theme::Logo(); ?>
				</span> </a>
            <?php
			      $Session = Gdn::Session();
					if ($this->Menu) {
						$this->Menu->AddLink('Dashboard', T('Dashboard'), '/dashboard/settings', array('Garden.Settings.Manage'));
						$this->Menu->AddLink('Collector', T('Collectors'), '/collector');
						$this->Menu->AddLink('Activity', T('Activity'), '/activity');			      
						if ($Session->IsValid()) {
							$Name = $Session->User->Name;
							$CountNotifications = $Session->User->CountNotifications;
							if (is_numeric($CountNotifications) && $CountNotifications > 0) {
								$Name .= ' <span>'.$CountNotifications.'</span>';
							}
              if (urlencode($Session->User->Name) == $Session->User->Name) {
                $ProfileSlug = $Session->User->Name;
              } else {
                $ProfileSlug = $Session->UserID.'/'.urlencode($Session->User->Name);
              }
							$this->Menu->AddLink('User', $Name, '/profile/'.$ProfileSlug, array('Garden.SignIn.Allow'), array('class' => 'UserNotifications'));
							$this->Menu->AddLink('SignOut', T('Sign Out'), Gdn::Authenticator()->SignOutUrl(), FALSE, array('class' => 'NonTab SignOut'));
						} else {
							$Attribs = array();
							if (SignInPopup() && strpos(Gdn::Request()->Url(), 'entry') === FALSE) {
								$Attribs['class'] = 'SignInPopup';
							}								
							$this->Menu->AddLink('Entry', T('Sign In'), Gdn::Authenticator()->SignInUrl(), FALSE, array('class' => 'NonTab'), $Attribs);
						}
						echo $this->Menu->ToString();
					}
				?>
        <?php
// 					$Form = Gdn::Factory('Form');
// 					$Form->InputPrefix = '';
// 					echo $Form->Open(array('action' => Url('/search'), 'method' => 'get', 'class' => 'pull-left'));
// 					echo '<input type="text" placeholder="Search"/>';
// 					echo $Form->Close();
 				?>
         </div>
		</div>
  </div>
		<div id="Body" class="container">
			<div id="Content">
			<?php $this->RenderAsset('Content'); ?></div>
			<div id="Panel">
			<?php $this->RenderAsset('Panel'); ?></div>
		</div>
		<div id="Foot">	
		        <p>
	        &copy; WattsApp,
	        <a target="_blank" href="http://cnds.eecs.jacobs-university.de/">
		 			  Computer Networks and Distributed Systems Group
		      </a>,
		      <a target="_blank" href="http://www.jacobs-university.de/">
  			    Jacobs University Bremen
		      </a>, 2011
		    </p> 
		    <?php
		    $this->RenderAsset('Foot');
		    echo Wrap(Anchor(T('Powered by Vanilla'), C('Garden.VanillaUrl')), 'div');
		    ?>
		</div>
	</div>
	<?php $this->FireEvent('AfterBody'); ?>
</body>
</html>
