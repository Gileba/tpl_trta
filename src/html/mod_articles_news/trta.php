<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="modtitle">
	<?php echo $module->title; ?>
</div>
<div class="newsflash<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $item) : ?>
		<div class="newsitem">
			<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>
		</div>
	<?php endforeach; ?>
</div>
