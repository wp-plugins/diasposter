<?php
/**
 * Diasposter uninstaller
 *
 * @package plugin
 */

// Don't execute any uninstall code unless WordPress core requests it.
if (!defined('WP_UNINSTALL_PLUGIN')) { exit(); }

// Delete options.
delete_option('diasposter_settings');
delete_option('_diasposter_admin_notices');

delete_post_meta_by_key('diasposter_crosspost');
delete_post_meta_by_key('diasposter_use_geo');
/**
 * TODO: Should we really delete this post meta?
 *       That'll wipe Tumblr post IDs and blog hostnames. :\
 *       We need these to be able to re-associate WordPress posts
 *       with the Tumblr posts that they were cross-posted to.
 */
// delete_post_meta_by_key('diaspora_post_id');
// delete_post_meta_by_key('diaspora_host');
// delete_post_meta_by_key('diaspora_aspect_ids');

// Delete caches.
global $wpdb;
$wpdb->query($wpdb->prepare(
    "
    DELETE FROM {$wpdb->options}
    WHERE option_name LIKE '%s'
    ",
    $wpdb->esc_like('_transient_diasposter') . '%'
));
$wpdb->query($wpdb->prepare(
    "
    DELETE FROM {$wpdb->options}
    WHERE option_name LIKE '%s'
    ",
    $wpdb->esc_like('_transient_timeout_diasposter') . '%'
));
