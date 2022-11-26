<?php

/* Even with explicit blessing, past events & discussions are available only when logged in on Meetup.com. We need other means to persist historical events and to dig into Meetup's API. This from https://github.com/bradp/wordpress-meetup-oembed/blob/master/meetupoembeds.php */

wp_oembed_add_provider('http://www.meetup.com/*','http://api.meetup.com/oembed?url=');
wp_oembed_add_provider('http://meetup.com/*','http://api.meetup.com/oembed?url=');
wp_oembed_add_provider('http://www.wpmke.com/*','http://api.meetup.com/oembed?url='); //love to #wpmke
wp_oembed_add_provider('http://www.mkepug.org/*','http://api.meetup.com/oembed?url=');

/* WP-on-WP oembed needs explicit blessing, too */

wp_oembed_add_provider( 'https://gamepath.io/*', 'https://gamepath.io/' );

/* - 
Hide all but Contributors' and Authors' own posts from everyone but Editors and Admins. Clean by default and can be opted-into per person. 
*/

function query_set_only_author( $wp_query ) {
    global $current_user;
    if( is_admin() && !current_user_can('edit_others_posts') ) {
        $wp_query->set( 'author', $current_user->ID );
    }
}
add_action('pre_get_posts', 'query_set_only_author' );

/* - 
For wp-admin users, hide various menu items and meta boxes from all but Editors and Admins. Varies by view options and plugins in-use.
*/

function remove_menus(){
 if( ! current_user_can( 'manage_options' ) ) {
  // remove_menu_page( 'upload.php' );              //Media
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'edit.php?post_type=seoal_container' ); // AutoLinker
  }
}
add_action( 'admin_menu', 'remove_menus', 999 );

/* REMOVE POST META BOXES - Streamline default writing space -- Clean by default and can be opted-into per person. */

function remove_my_post_metaboxes() {
  if( ! current_user_can( 'manage_options' ) ) {
    remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
    remove_meta_box( 'postoptions','post','normal' ); // Post Options     Metabox
    remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments     Status Metabox
    remove_meta_box( 'commentsdiv','post','normal' ); // Comments Metabox
    remove_meta_box( 'postcustom','post','normal' ); // Custom Fields     Metabox
    remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
    remove_meta_box( 'revisionsdiv','post','normal' ); // Revisions   Metabox
    remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
    remove_meta_box( 'trackbacksdiv','post','normal' ); // Trackback Metabox
  }
}
add_action('admin_menu','remove_my_post_metaboxes');

// 211026 - login - white bg and Remember Me
function login_page_white_bg() { ?>
    <style type="text/css">
        body.login {
            background-color:#ffffff !important;
            }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'login_page_white_bg' );

function login_checked_remember_me() {
    add_filter( 'login_footer', 'rememberme_checked' );
    }
    add_action( 'init', 'login_checked_remember_me' );
    
    function rememberme_checked() {
    echo "<script>document.getElementById('rememberme').checked = true;</script>";
    }
