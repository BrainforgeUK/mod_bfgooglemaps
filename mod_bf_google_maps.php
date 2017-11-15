<?php
/**
 * @version   0.0.1
 * @package		Joomla.Site
 * @subpackage	mod_bf_google_maps
 * @copyright	Copyright (C) 2017 Jonathan Brain. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');// no direct access

$php_condition = trim($params->get('php_condition'), " ;\t\n\r\0\x0B");
if (!empty($php_condition)) {
  if (!eval('return ' . $php_condition . ';')) {
    return;
  }
}

$layout = $params->get('layout', 'default');

$wrapper_options	= trim( $params->get( 'wrapper_options' ) );
require JModuleHelper::getLayoutPath('mod_bf_google_maps', $layout);
?>