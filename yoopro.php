<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.yoopro
 *
 * @copyright   Copyright (C) 2005 - 2017 Mariella Colombo, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.utilities.utility');

/**
 * Yoo Pro plugin
 *
 * <b>Usage:</b>
 * <code><hr class="yoopro-content-readmore" /></code>
 *
 * @since  1.6
 */
class PlgContentYoopro extends JPlugin
{
	/**
	 * Plugin that adds a pagebreak into the text and truncates text at that point
	 *
	 * @param   string   $context  The context of the content being passed to the plugin.
	 * @param   object   &$row     The article object.  Note $article->text is also available
	 * @param   mixed    &$params  The article params
	 * @param   integer  $page     The 'page' number
	 *
	 * @return  mixed  Always returns void or true
	 *
	 * @since   1.6
	 */
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		if ($context == 'com_content.article')
		{
			JFactory::getApplication()->getDocument()->addStyleSheet(JUri::base(true) . '/media/plg_content_yoopro/css/yoopro.css');
			JFactory::getApplication()->getDocument()->addScript(JUri::base(true) . '/media/plg_content_yoopro/js/yoopro.js');

			return;
		}

		if ($context !== 'com_content.category')
		{
			return;
		}

		// Expression to search for.
		$regex = '#<hr(.*)class="yoopro-content-readmore"(.*)\/>#iU';

		// Simple performance check to determine whether bot should process further.
		if (JString::strpos($row->text, 'class="yoopro-content-readmore') === false)
		{
			return true;
		}

		list ($introtext, $fulltext) = preg_split($regex, $row->text, 2);
		$row->text = $introtext;

		return true;
	}
}
