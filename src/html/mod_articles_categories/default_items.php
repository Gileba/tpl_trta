<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$input  = JFactory::getApplication()->input;
$option = $input->getCmd('option');
$view   = $input->getCmd('view');
$id     = $input->getInt('id');

foreach ($list as $item) : ?>
	<li
		<?php if ($id == $item->id && in_array($view, array('category', 'categories')) && ($option == 'com_content')) :
			echo ' class="active"';
		endif; ?>
	>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<?php if ($item->getParams()->get('image')) : ?>
			<img src="<?php echo $item->getParams()->get('image'); ?>"
				alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
		<?php endif; ?>
		</a>

		<?php if ($params->get('show_description', 0)) : ?>
			<?php echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content'); ?>
		<?php endif; ?>
		<?php
		if ($params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0) || ($params->get('maxlevel') >= ($item->level - $startLevel)))
			&& count($item->getChildren())) :
			echo '<ul>';
			$temp = $list;
			$list = $item->getChildren();
			require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default') . '_items');
			$list = $temp;
			echo '</ul>';
		endif;
		?>
	</li>
<?php endforeach;
