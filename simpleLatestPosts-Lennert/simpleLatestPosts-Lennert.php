<?php
/**
 * @package simpleLatestPosts-Lennert
 */
/**
 * Plugin Name: simple Latest Posts - a plugin by Pikawika
 * Plugin URI: https://github.com/pikawika/wp-simpleLatestPosts
 * Description: A small plugin to load some of the latest blog posts with a few extra's.
 * Version: 1.0.0
 * Author: Lennert Bontinck (Pikawika)
 * Author URI: https://www.lennertbontinck.com/
 * License: GPLv3
 * Text Domain: simpleLatestPosts-Lennert
 */

// Small security measures
if (!defined('ABSPATH')) {
    exit;
}

// add css to plugin
add_action('init', 'add_css');
add_action('wp_enqueue_scripts', 'enqueue_css');

function add_css()
{
    wp_register_style('style_slp', plugins_url('/css/style.css', __FILE__));
}

function enqueue_css()
{
    wp_enqueue_style('style_slp');
}

// Enable usage of shortcode with name simpleLatestPosts
add_shortcode('simple_latest_posts', 'initialise_slp');

//init function that accepts optional params for custom button text used in the plugin and default loaded posts
function initialise_slp($atts)
{
    extract(shortcode_atts(array(
        'read_more_text' => 'Read more',
        'initial_amount_of_posts' => 10,
    ), $atts));

    //get the posts from the database
    $posts_to_add_to_list = get_latest_posts_slp($initial_amount_of_posts);

    //process the posts list to html
    $formatted_posts = print_posts_slp($posts_to_add_to_list, $read_more_text);

    //show the html to the user
    return $formatted_posts;
}

function get_latest_posts_slp($amount_to_load, $amount_to_skip = 0)
{
    $query_args = array(
        'order' => 'desc', //newest first
        'post_type' => 'post', //any type of post
        'posts_per_page' => $amount_to_load, //how many posts should be loaded
        'offset' => $amount_to_skip //skip certain items if needed (load more button)
    );
    return new WP_Query($query_args);
}

function print_posts_slp($posts_to_show, $read_more_text)
{
    ob_start(); //record all the echo data

    if ($posts_to_show->have_posts()) {
        //loop all posts and put them in a pretty div
        while ($posts_to_show->have_posts()) {
            $posts_to_show->the_post();
            echo '<div class="column_slp popup_effect_slp">
            <img class="img_slp" src="' . get_the_post_thumbnail_url() . '">
            <p class="title_slp">' . get_the_title() . '</p>
            <p class="description_slp">' . get_the_content() . '</p>
            <a href="' . get_permalink() . '"><p class="button_slp">' . $read_more_text . '</p></a>            
            </div>';
        }
        // Restore original Post Data
        wp_reset_postdata();
    } else {
        //there are no blog posts uploaded
        echo '<H3> No blogposts found</H3>';
    }

    $formatted_posts = ob_get_contents(); //get all the echo data
    ob_end_clean(); // stop and clean echo listener
    return $formatted_posts; //html for the iterated posts
}