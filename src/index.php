<?php
	defined('_JEXEC') or die('Restricted access');

	use Joomla\CMS\Factory;


	/** @var JDocumentHtml $this */
	$app      	= Factory::getApplication();
	$doc      	= Factory::getDocument();
	$lang 		= $app->getLanguage();
	$page 		= $app->getRouter()->getVars();

	/** Output as HTML5 */
	$this->setHtml5(true);

	$menu 		= $app->getMenu();
	$params		= $app->getTemplate(true)->params;
	$config 	= Factory::getConfig();
	$pageclass 	= $menu->getActive()->getParams(true)->get('pageclass_sfx');

	// Logo file or site title param
	$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

	$wa = $this->getWebAssetManager();
	$wa->useStyle('template.trta.base');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
   <head>
		<jdoc:include type="head" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/fontawesome.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/solid.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/brands.min.css" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body class="<?php echo $pageclass ? htmlspecialchars($pageclass) : 'default'; ?>">
		<div class="offcanvas"><jdoc:include type="modules" name="offcanvas" style="html5" /></div>
		<div class="container">
			<div class="top">
				<div class="logo"><a href="/"><img src="templates/tpl_trta/images/logo.png" alt="<?php echo $sitename ?>" /></a></div>
				<jdoc:include type="modules" name="top" style="html5" />
			</div>
			<div class="content">
				<jdoc:include type="message" />
				<div class="header"><jdoc:include type="modules" name="header" style="html5" /></div>
				<div class="component">
					<jdoc:include type="component" />
					<div class="bottomimage"></div>
				</div>
				<div class="bottom">
					<div class="bottom-content"><jdoc:include type="modules" name="bottom" style="html5" /></div>
				</div>
			</div>
			<div class="footer">
				<div class="logo"><img src="templates/tpl_trta/images/logo.png" alt="<?php echo $sitename ?>" /></div>
				<jdoc:include type="modules" name="footer" style="html5" /></div>
		</div>
		<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/hamburger.js"></script>
<?php	if ($this->params->get('analytics')) {	?>
		<!-- Google Analytics -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })
			  (window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			  ga('create', '<?php	echo $this->params->get('analytics'); ?>', 'auto');
			  ga('send', 'pageview');
		  </script>
<?php	}	?>
	</body>
</html>
