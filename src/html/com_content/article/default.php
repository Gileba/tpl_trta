<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));
JHtml::_('behavior.caption');

$currentDate       = JFactory::getDate()->format('Y-m-d H:i:s');
$isNotPublishedYet = $this->item->publish_up > $currentDate;
$isExpired         = $this->item->publish_down < $currentDate && $this->item->publish_down !== JFactory::getDbo()->getNullDate();

?>
<?php echo JLayoutHelper::render('joomla.content.full_image', $this->item); ?>
<div class="item-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
	<meta itemprop="inLanguage" 
		content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
	<?php endif;
	if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
	{
		echo $this->item->pagination;
	}
	?>

	<?php // Todo Not that elegant would be nice to group the params ?>
	<?php
		$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author')
		|| $assocParam);
		?>

	<?php if (!$useDefList && $this->print) : ?>
		<div id="pop-print" class="btn hidden-print">
			<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
		</div>
		<div class="clearfix"> </div>
	<?php endif; ?>
	<?php
	if (!$this->print) :
		if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) :
			echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false));
		endif;
	else :
		if ($useDefList) :
			?>
		<div id="pop-print" class="btn hidden-print">
			<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
		</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	if ($useDefList && ($info == 0 || $info == 2)) :
		// Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block
		echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above'));
	endif;
	?>

	<?php if ($params->get('show_title')) : ?>
	<div class="page-header">
		<h1 itemprop="headline">
			<?php echo $this->escape($this->item->title); ?>
		</h1>
		<?php if ($this->item->state == 0) : ?>
			<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
		<?php endif; ?>
		<?php if ($isNotPublishedYet) : ?>
			<span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
		<?php endif; ?>
		<?php
		if ($isExpired)
			&& $this->item->publish_down != JFactory::getDbo()->getNullDate()
		) :
			?>
			<span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>

	<?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
		<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>

		<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
	<?php endif; ?>

	<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
	<?php echo $this->item->event->beforeDisplayContent; ?>

	<?php if (isset($urls)
	&& ((!empty($urls->urls_position) && ($urls->urls_position == '0'))
	|| ($params->get('urls_position') == '0' && empty($urls->urls_position)))
	|| (empty($urls->urls_position) && (!$params->get('urls_position')))
) : ?>
	<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>
	<?php if ($params->get('access-view')) : ?>
		<?php
		if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
			echo $this->item->pagination;
		endif;
		?>
		<?php
		if (isset($this->item->toc)) :
			echo $this->item->toc;
		endif;
		?>
	<div itemprop="articleBody">
		<?php if ($params->get('show_intro')) : ?>
			<div class="introtext">
				<?php echo $this->item->introtext; ?>
			</div>
		<?php endif; ?>
		<div class="articletext">
			<?php echo str_replace($this->item->introtext, '', $this->item->text); ?>
		</div>
	</div>

		<?php
		if ($info == 1 || $info == 2) :
			if ($useDefList) :
				// Todo: for Joomla4 joomla.content.info_block.block can be changed to joomla.content.info_block
				echo JLayoutHelper::render('joomla.content.info_block.block',
					array('item' => $this->item, 'params' => $params, 'position' => 'below')
				);
			endif;
			if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
				$this->item->tagLayout = new JLayoutFile('joomla.content.tags');
				echo $this->item->tagLayout->render($this->item->tags->itemTags);
			endif;
		endif;
		?>

		<?php
		if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative) :
			echo $this->item->pagination;
		endif;
		?>
		<?php
		if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) :
			echo $this->loadTemplate('links');
		endif;
		?>
		<?php
		// Optional teaser intro text for guests
	elseif ($params->get('show_noauth') == true && $user->get('guest')) :
			echo JLayoutHelper::render('joomla.content.intro_image', $this->item);
			echo JHtml::_('content.prepare', $this->item->introtext);

			// Optional link to let them register to see the whole article.
		if ($params->get('show_readmore') && $this->item->fulltext != null) :
			$menu = JFactory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return',
				base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))
			);
			?>
	<p class="readmore">
		<a href="<?php echo $link; ?>" class="register">
			<?php if ($params->get('alternative_readmore', '') === '') : ?>
				<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
			<?php else : ?>
				<?php echo $params->get('alternative_readmore'); ?>
				<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
					<?php echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit')); ?>
				<?php endif; ?>
			<?php endif; ?>
		</a>
	</p>
		<?php endif; ?>
	<?php endif; ?>
	<?php
	if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
		echo $this->item->pagination;
		?>
	<?php endif; ?>
	<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
