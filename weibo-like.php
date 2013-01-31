<?php
/*
Plugin Name: Sina Weibo Like Button 新浪微博赞按钮
Plugin URI: http://sparanoid.com/work/weibo-like/
Description: Adds Sina Weibo Like button on your site
Version: 1.0.3
Author: Tunghsiao Liu
Author URI: http://sparanoid.com/
Author Email: info@sparanoid.com
License: GPLv2 or later

  Copyright 2012 Tunghsiao Liu, aka. Sparanoid (info@sparanoid.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Apply XML namespace
 *
 * @since Sina Weibo Like Button 1.0.0
 */
function swlb_language_attributes($xmlns_attribute) {
  $xmlns_attribute .= ' xmlns:wb="http://open.weibo.com/wb" ';
  return $xmlns_attribute;
}

add_filter('language_attributes','swlb_language_attributes');

/**
 * Add Sina Weibo javascript
 *
 * @since Sina Weibo Like Button 1.0.0
 */
function swlb_head() {
  echo '<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>';
}

add_action('wp_head','swlb_head');

/**
 * Additional Sina Weibo attributes
 *
 * @since Sina Weibo Like Button 1.0.0
 */
function swlb_attributes() {
  global $post; if ( is_singular() ) {
    echo '<meta name="weibo:article:create_at" content="' . $post->post_date . '">';
    echo '<meta name="weibo:article:update_at" content="' . $post->post_modified . '">';
  }
}

add_action('wp_head','swlb_attributes');

/**
 * Apply XML namespace
 *
 * @since Sina Weibo Like Button 1.0.0
 */
function swlb_content($text) {
  if ( is_singular() ){
    return $text . '<wb:like></wb:like>';
  }
  return $text;
}

add_filter('the_content','swlb_content');

/**
 * Load Open Graph library
 *
 * If you have the opengraph plugin running alongside jetpack, we assume you'd rather use your own opengraph support, so disable my opengraph library.
 * @since Sina Weibo Like Button 1.0.1
 */
require_once( dirname(__FILE__) . '/includes/opengraph/opengraph.php' );

if ( ! function_exists('is_plugin_active')) {
  require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if ( is_plugin_active('jetpack/jetpack.php')) {
  remove_action('wp_head', 'opengraph_meta_tags');
}
?>
