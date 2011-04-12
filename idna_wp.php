<?php
/**
 * @package IDNA
 * @author David Wright
 * @version 1.2.0
 */
/*
Plugin Name: IDNA
Plugin URI: http://www.dwright.us/misc/idna/
Description: This plugin adds IDN support to Wordpress. IDN (Internationalized domain name) is a domain name that contains non-ascii characters.
Author: David Wright
Version: 1.2.0
Author URI: http://dwright.us
*/

/*
        Copyright 2010 David Wright (email: david_v_wright@yahoo.com)

        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        at your option) any later version.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
        See the GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* 
  this lib does all the work - read it's docs for more info
  http://freshmeat.net/projects/php_net_idna
*/
require_once dirname(dirname(__FILE__)) . '/idna/idna_convert.class.php'; 

/**
 * on login, an IDN will not pass the WP 'ascii-only' url checks
 * so, convert the IDN to an ascii version
 * i.e. müller.com becomes xn--mller-kva.com
 * there is an odd 'redirect' issue on bulk operations, hack included
 *
 * @since 1.2.0
 *
 * @param string $location The url to redirect to
 * @return $location (ascii-ified)
 */
function login_idn_support( $location ) {
        $location = idn_to_ascii( $location );
	return _idna__handle_odd_path_append_issue( $location );
}

/**
 * convert an IDN to it's Punycode representation
 * pass url through 'idn to punycode' (the ascii representation) converter
 * i.e. müller.com becomes xn--mller-kva.com
 *
 * @since 1.2.0
 *
 * @param string $url (url/uri) assumes valid UTF8
 * @return $url (ascii-ified)
 */

function idn_to_ascii( $url ) {
	$IDN = new idna_convert();
	// this is probably overly optimistic
	// may need some encoding checks added
	$url = $IDN->encode( $url );
	return $url;
}

// removed - re: refactored
// @since 0.0.1
//
//function idn_support( $location ) {
//
//}

/**
 * re: on general-options when hitting save with this plugin enabled,
 * we get a redirct * with an extra 'wp-admin' in the path!? 
 * there is no hook at the location, so I have to work around it,...
 * with this undesirable hack implementation
 *
 * see: wp-admin/options.php line:89 wp_redirect( $goback )
 * (http://example.com/wp-admin/wp-admin/options-general.php?updated=true)
 *
 * @since 0.0.1
 *
 * @param string $relative_url The path (possible args) to redirect to
 * @return $relative_url
 */
function _idna__handle_odd_path_append_issue( $relative_url ) {
	if( ! $_SERVER['REQUEST_URI'] ) return $relative_url;

	$url = parse_url( $relative_url );
	// only apply hack if receiving relative url
	if ( substr( $url['path'], 0, 4 ) == 'http' ) return $relative_url;
    
	$s_uri = pathinfo( $_SERVER['REQUEST_URI'] );
	//NOTE 'parse_url' does not work with relative url's 
	$uri   = pathinfo( $relative_url );

	// since, I don't really know why the redirect path append is occuring
	// maybe if one of these is not set the 'normal' redirect will just work
	// so only apply hack to this special case
	if ( basename( $s_uri['dirname'] ) == basename( $uri['dirname'] ) ) {
		// resource is in same dir, just return basename (not fqp)
		$s_section = basename( $s_uri['dirname'] );
		if ( $s_section == 'wp-admin' ) return $uri['basename'];
	}
	return $relative_url;
}

/**
 * When we are creating a (rss) feed we need the Punycode (ascii) version,
 * RSS readers will barf on the urls otherwise.
 * 
 * for contrast, when we are creating/editing/etc Posts we want
 * the (displayed) Permalink to be in IDN form, so, leave it alone.
 *
 * (Thanks to Chris Ramey for reporting this bug)
 *
 * @since 1.2.0
 *
 * @param string $url
 * @return $location (Punycode (ascii)-ified if feed requested) IDN on all else
 */
function if_as_xml_feed__uri_to_ascii( $url ) {
	// one way to do it
	//if ( stripos( $_REQUEST['feed'], 'rss' ) !== false ) return idn_to_ascii($url);
	//if ( stripos( $_REQUEST['feed'], 'atom' ) !== false ) return idn_to_ascii($url);
	//if ( stripos( $_REQUEST['feed'], 'rdf' ) !== false ) return idn_to_ascii($url);

	if ( stripos( $_SERVER['QUERY_STRING'], 'feed' ) !== false ) return idn_to_ascii($url);

	return $url;
}

// utilized hooks below
//
// see wp-includes/pluggable.php ->  wp_redirect($location, $status = 302)
add_filter( 'wp_redirect', 'login_idn_support', 10, 1 );

// rss feeds bug - make valid (Punycode) urls that rss readers wont choke on
add_filter( 'the_permalink_rss', 'idn_to_ascii', 10, 1 );
add_filter( 'get_comment_link',  'idn_to_ascii', 10, 1 );
add_filter( 'bloginfo_rss',      'idn_to_ascii', 10, 1 );
add_filter( 'page_link',         'idn_to_ascii', 10, 1 );
// permalink on posts
add_filter( 'home_url',  'if_as_xml_feed__uri_to_ascii', 10, 1 );
// is permalink on posts, so only apply if called in rss context
add_filter( 'post_link', 'if_as_xml_feed__uri_to_ascii', 10, 1 );


// not needed at this time
/*
function ascii_to_idn( $url ) {
	$IDN = new idna_convert();
	// this is probably overly optimistic
	// may need some encoding checks added
	$url = $IDN->decode( $url );
	return $url;
}
// unknown
add_filter( 'the_permalink', 'idn_to_ascii', 10, 1 );
add_filter( 'the_permalink', 'ascii_to_idn', 10, 1 );
add_filter( 'the_content_more_link', 'idn_to_ascii', 10, 1 );
add_filter( 'wp_get_attachment_link', 'idn_to_ascii', 10, 1 );
add_filter( 'wp_get_attachment_url', 'idn_to_ascii', 10, 1 );
add_filter( 'wp_get_attachment_thumb_url', 'idn_to_ascii', 10, 1 );
add_filter( 'clean_url', 'idn_to_ascii', 10, 1 );
add_filter( 'logout_url', 'idn_to_ascii', 10, 1 );
//add_filter( 'lostpassword_url', 'idn_to_ascii', 10, 1 );
add_filter( 'register', 'idn_to_ascii', 10, 1 );
add_filter('bloginfo_url', 'idn_to_ascii', 10, 1);
add_filter( 'the_feed_link', 'idn_to_ascii', 10, 1 ); // is permalink on posts
add_filter( 'feed_link', 'idn_to_ascii', 10, 1 ); // is permalink on posts
add_filter( 'site_url', 'idn_to_ascii', 10, 1 ); // if rss
add_filter( 'admin_url', 'idn_to_ascii', 10, 1 ); // if rss
add_filter( 'atom_enclosure', 'idn_to_ascii', 10, 1 ); // if rss
add_filter( 'get_sample_permalink_html', 'idn_to_ascii', 10, 1 ); // if rss
add_filter( 'editable_slug', 'idn_to_ascii', 10, 1 );

// apply if type of feed. rss2 | atom | rss | rdf
add_filter('the_content_feed', $content, $feed_type);
add_filter( 'esc_url', 'idn_support', 10, 1 );
*/

?>