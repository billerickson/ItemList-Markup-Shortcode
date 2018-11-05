<?php
/**
 * Main class.
 *
 * @package    BE_ItemList_Markup
 * @author     Bill Erickson
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2017
 */
final class BE_ItemList_Markup {

	/**
	 * Instance of the class.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * BE ItemList Markup Instance.
	 *
	 * @since 1.0.0
	 *
	 * @return BE_ItemList_Markup
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof BE_ItemList_Markup ) ) {

			self::$instance = new BE_ItemList_Markup();

			add_shortcode( 'itemlist_markup', array( self::$instance, 'shortcode' ) );
			add_action( 'register_shortcode_ui', array( self::$instance, 'shortcode_ui' ) );
		}
		return self::$instance;
	}

	/**
	 * ItemList Markup
	 * @see https://developers.google.com/search/docs/guides/mark-up-listings#summary-page--multiple-full-details-pages
	 *
	 */
	public function itemlist_markup( $loop = false ) {
		global $wp_query;
		$loop = empty( $loop ) ? $wp_query : $loop;

		if( ! $loop->have_posts() )
			return;

		$output = array();
		foreach( $loop->posts as $i => $post ) {
			$position = $i + 1;
			$output [] = '{
			      "@type":"ListItem",
			      "position":' . $position . ',
			      "url":"' . get_permalink( $post->ID ) . '"
			  }';
		}

		return '<script type="application/ld+json">
		{
		  "@context":"http://schema.org",
		  "@type":"ItemList",
		  "itemListElement":[' . join( ',', $output ) . ']
		}
		</script>';
	}

	/**
	 * ItemList Markup Shortcode
	 *
	 */
	function shortcode( $atts = array() ) {

		$atts = shortcode_atts( array(
			'ids' => false,
		), $atts, 'itemlist_markup' );

		if( empty( $atts['ids'] ) )
			return;

		// Remove spaces
		$atts['ids'] = str_replace( ' ', '', $atts['ids'] );

		// Explode into a sanitized array
		$ids = array_map( 'intval', explode( ',', $atts['ids'] ) );

		// Remove empty ids
		$ids = array_filter( $ids );

		if( empty( $ids ) )
			return;


		if( is_admin() ) {
			$output = '<aside class="inpost-itemlist">';
			$output .= '<p>ItemList Markup will appear for the following posts:</p>';
			$output .= '<ul>';
			foreach( $ids as $id ) {
				$output .= '<li><a href="' . get_permalink( $id ) . '">' . get_the_title( $id ) . '</a></li>';
			}
			$output .= '</ul>';
			$output .= '</aside>';

		} else {
			$args = array( 'posts_per_page' => 999, 'post__in' => $ids, 'orderby' => 'post__in' );
			$loop = new WP_Query( $args );
			$output = $this->itemlist_markup( $loop );
		}

		return $output;
	}

	/**
	 * ItemList Markup Shortcode UI
	 *
	 */
	function shortcode_ui() {

		$fields = array(
			array(
				'label' => 'Post IDs',
				'description' => 'Comma separated list of Post IDs',
				'attr'  => 'ids',
				'type'  => 'text',
			),
		);

		$shortcode_ui_args = array(
			'label' => 'ItemList Markup',
			'listItemImage' => 'dashicons-editor-code',
			'attrs' => $fields,
		);

		shortcode_ui_register_for_shortcode( 'itemlist_markup', $shortcode_ui_args );

	}



}
