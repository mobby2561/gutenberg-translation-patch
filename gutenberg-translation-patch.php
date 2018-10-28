<?php 
/*
Plugin Name:       Gutenberg Translation Patch
Plugin URI:        https://github.com/luciano-croce/gutenberg-translation-patch/
Description:       Patch the missing and shared translation strings code on Gutenberg file gutenberg.php
Version:           0.0.3
Requires at least: 4.9
Tested up to:      5.1-alpha
Requires PHP:      5.2.4
Author:            Luciano Croce
Author URI:        https://github.com/luciano-croce/
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:       gutenberg-translation-patch
Domain Path:       /languages
Network:           true
GitHub Plugin URI: https://github.com/luciano-croce/gutenberg-translation-patch/
GitHub Branch:     master
Requires WP:       4.9
 *
 * Copyright 2018 Luciano Croce (email: luciano.croce@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other compatible version of the GPL, or version compatible with GPL.
 *
 * This program is distributed in the hope that it will be useful, on an "AS IS", but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This program is written with the intent of being helpful,
 * but you are responsible for its use or actions on your own website.
 *
 * According to the terms of the Detailed Plugin Guidelines (wordpress.org) in particular:
 * - This developer(s) are responsible(s) for the contents and actions of this plugin.
 * - Stable version of this plugin is only available from the WordPress Plugin Directory page.
 * - Plugin version numbers is be incremented for each new release.
 * - Complete plugin was be available on GitHub before the time of submission.
 * - This plugin respect trademarks, copyrights, and project names.
 *
 * This plugin use Semantic Versioning number MAJOR.MINOR.PATCH - More details are available here: https://semver.org/
 *
 * Tips: a neat trick, is to put this single file gutenberg-translation-patch.php (not its parent directory)
 * in the /wp-content/mu-plugins/ directory (create it if not exists) so you won't even have to enable it,
 * and will be loaded by default, also, since first step installation of WordPress setup!
 *
 * Also, for translation functionality, put all files of the single languages
 * that you need (not its parent directory) in the /wp-content/mu-plugins/ directory (create it if not exists)
 * and will be loaded by default, they also, since first step installation of WordPress setup!
 *
 */

if ( ! defined( 'PLUGIN_GUTENBERG_TRANSLATION_PATCH_VERSION' ) ) define( 'PLUGIN_GUTENBERG_TRANSLATION_PATCH_VERSION', '0.0.3' );
if ( ! defined( 'PLUGIN_GUTENBERG_TRANSLATION_PATCH_RELEASE' ) ) define( 'PLUGIN_GUTENBERG_TRANSLATION_PATCH_RELEASE', '2018-10-28' );
 
remove_action( 'admin_init', 'gutenberg_add_edit_link_filters', 0 );
remove_action( 'admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button', 0 );

add_action( 'admin_init', 'gutenberg_add_edit_link_filters_translation_patch', 0 );
add_action( 'admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button_translation_patch', 0 );

add_filter( 'plugins_loaded', 'gutenberg_replace_default_add_new_button_translation_patch_plugin_textdomain', 0 );
add_filter( 'plugins_loaded', 'gutenberg_replace_default_add_new_button_translation_patch_muplugin_textdomain', 0 );

/**
 * Load Plugin Textdomain.
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 0.0.1 (Build 2018-10-26)
 */
function gutenberg_replace_default_add_new_button_translation_patch_plugin_textdomain() {
	load_plugin_textdomain( 'gutenberg-translation-patch', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

/**
 * Load MU-Plugin (dir) Textdomain.
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 0.0.2 (Build 2018-10-27)
 */
function gutenberg_replace_default_add_new_button_translation_patch_muplugin_textdomain() {
	load_muplugin_textdomain( 'gutenberg-translation-patch', false, basename( dirname( __FILE__ ) ) . '/' );
}

/**
 * Prints the JavaScript to replace the default "Add New" button.$_COOKIE
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 1.5.1
 * @since   1.5.0
 */
function gutenberg_replace_default_add_new_button_translation_patch() {
	global $typenow;

	if ( 'wp_block' === $typenow ) {
		?>
		<style type="text/css">
			.page-title-action {
				display: none;
			}
		</style>
		<?php
	}

	if ( ! gutenberg_can_edit_post_type( $typenow ) ) {
		return;
	}

	?>
	<script type="text/javascript">
		document.addEventListener( 'DOMContentLoaded', function() {
			var buttons = document.getElementsByClassName( 'page-title-action' ),
				button = buttons.item( 0 );
			if ( ! button ) {
				return;
			}
			var url = button.href;
			var urlHasParams = ( -1 !== url.indexOf( '?' ) );
			var classicUrl = url + ( urlHasParams ? '&' : '?' ) + 'classic-editor';
			var newbutton = '<span id="split-page-title-action" class="split-page-title-action">';
			newbutton += '<a href="' + url + '">' + button.innerText + '</a>';
			newbutton += '<span class="expander" tabindex="0" role="button" aria-haspopup="true" aria-label="<?php echo esc_js( __( 'Toggle editor selection menu', 'gutenberg' ) ); ?>"></span>';
			newbutton += '<span class="dropdown"><a href="' + url + '"><?php echo esc_js( __( 'Block Editor', 'gutenberg-translation-patch' ) ); ?></a>';
			newbutton += '<a href="' + classicUrl + '"><?php echo esc_js( __( 'Classic Editor', 'gutenberg-translation-patch' ) ); ?></a></span></span><span class="page-title-action" style="display:none;"></span>';
			button.insertAdjacentHTML( 'afterend', newbutton );
			button.parentNode.removeChild( button );
			var expander = document.getElementById( 'split-page-title-action' ).getElementsByClassName( 'expander' ).item( 0 );
			var dropdown = expander.parentNode.querySelector( '.dropdown' );
			function toggleDropdown() {
				dropdown.classList.toggle( 'visible' );
			}
			expander.addEventListener( 'click', function( e ) {
				e.preventDefault();
				toggleDropdown();
			} );
			expander.addEventListener( 'keydown', function( e ) {
				if ( 13 === e.which || 32 === e.which ) {
					e.preventDefault();
					toggleDropdown();
				}
			} );
		} );
	</script>
	<?php
}

/**
 * Adds the filters to register additional links for the Gutenberg editor in
 * the post/page screens.
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 1.5.1
 * @since   1.5.0
 */
function gutenberg_add_edit_link_filters_translation_patch() {
	// For hierarchical post types.
	add_filter( 'page_row_actions', 'gutenberg_add_edit_link_translation_patch', 10, 2 );
	// For non-hierarchical post types.
	add_filter( 'post_row_actions', 'gutenberg_add_edit_link_translation_patch', 10, 2 );
}

/**
 * Registers an additional link in the post/page screens to edit any post/page in
 * the Classic editor.
 *
 * @author  Luciano Croce <luciano.croce@gmail.com>
 * @version 1.5.1
 * @since   1.5.0
 *
 * @param  array   $actions Post actions.
 * @param  WP_Post $post    Edited post.
 *
 * @return array          Updated post actions.
 */
function gutenberg_add_edit_link_translation_patch( $actions, $post ) {
	// Build the classic edit action. See also: WP_Posts_List_Table::handle_row_actions().
	$title = _draft_or_post_title( $post->ID );

	if ( 'wp_block' === $post->post_type ) {
		unset( $actions['inline hide-if-no-js'] );

		// Export uses block raw content, which is only returned from the post
		// REST endpoint via `context=edit`, requiring edit capability.
		$post_type = get_post_type_object( $post->post_type );
		if ( ! current_user_can( $post_type->cap->edit_post, $post->ID ) ) {
			return $actions;
		}

		$actions['export'] = sprintf(
			'<button type="button" class="wp-list-reusable-blocks__export button-link" data-id="%s" aria-label="%s">%s</button>',
			$post->ID,
			esc_attr(
				sprintf(
					/* translators: %s: post title */
					__( 'Export &#8220;%s&#8221; as JSON', 'gutenberg' ),
					$title
				)
			),
			__( 'Export as JSON', 'gutenberg' )
		);
		return $actions;
	}

	if ( ! gutenberg_can_edit_post( $post ) ) {
		return $actions;
	}

	$edit_url = get_edit_post_link( $post->ID, 'raw' );
	$edit_url = add_query_arg( 'classic-editor', '', $edit_url );

	$edit_action = array(
		'classic' => sprintf(
			'<a href="%s" aria-label="%s">%s</a>',
			esc_url( $edit_url ),
			esc_attr(
				sprintf(
					/* translators: %s: post title */
					__( 'Edit &#8220;%s&#8221; in the Classic Editor', 'gutenberg' ),
					$title
				)
			),
			__( 'Classic Edit', 'gutenberg-translation-patch' )
		),
	);

	// Insert the Classic Edit action after the Edit action.
	$edit_offset = array_search( 'edit', array_keys( $actions ), true );
	$actions     = array_merge(
		array_slice( $actions, 0, $edit_offset + 1 ),
		$edit_action,
		array_slice( $actions, $edit_offset + 1 )
	);

	return $actions;
}
