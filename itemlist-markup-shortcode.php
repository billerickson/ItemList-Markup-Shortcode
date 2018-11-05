<?php
/**
 * Plugin Name: ItemList Markup Shortcode
 * Plugin URI: https://github.com/billerickson/ItemList-Markup-Shortcode/
 * Description: Generate the ItemList schema markup for a list of posts you specify
 * Version: 2.0.0
 * Author: Bill Erickson
 * Author URI: https://www.billerickson.net
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package ItemList-Markup-Shortcode
 * @version 1.0.0
 * @author Bill Erickson <bill@billerickson.net>
 * @copyright Copyright (c) 2018, Bill Erickson
 * @link https://github.com/billerickson/ItemList-Markup-Shortcode/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the primary.
 */
require_once plugin_dir_path( __FILE__ ) . 'class-be-itemlist-markup.php';

/**
 * The function provides access to the ItemList markup methods.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @since 1.0.0
 *
 * @return object
 */
function be_itemlist_markup() {

	return BE_ItemList_Markup::instance();
}
be_itemlist_markup();
