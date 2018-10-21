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

// Enable usage of shortcode with name simpleLatestPosts
add_shortcode('simple_latest_posts', 'initialise_slp');

// Add css to plugin -> step 1
add_action('init', 'add_css');
// Add css to plugin -> step 2
add_action('wp_enqueue_scripts', 'enqueue_css');

// Add js to plugin
add_action('wp_print_scripts', 'add_js');

// Link ajax call to function
add_action('wp_ajax_load_more', 'ajax_load_more');
add_action('wp_ajax_nopriv_load_more', 'ajax_load_more');


// Add css to plugin -> step 1
function add_css()
{
    wp_register_style('style_slp', plugins_url('/css/style.css', __FILE__));
}

// Add css to plugin -> step 2
function enqueue_css()
{
    wp_enqueue_style('style_slp');
}

// Add js to plugin
function add_js() {
    wp_enqueue_script( "scripts", plugins_url('/js/scripts.js', __FILE__), array( 'jquery' ) );
    // make the ajaxurl var available to the above script
    wp_localize_script( 'scripts', 'the_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

//init function that accepts optional params for custom button text used in the plugin and default loaded posts
function initialise_slp($atts)
{
    extract(shortcode_atts(array(
        'read_more_text' => 'Read more',
        'load_more_text' => 'Load more',
        'initial_amount_of_posts' => 6,
        'load_more_amount' => 3,
    ), $atts));

    //get the posts from the database
    $posts_to_add_to_list = get_latest_posts_slp($initial_amount_of_posts);

    //process the posts list to html
    $formatted_posts = print_posts_slp($posts_to_add_to_list, $read_more_text, $load_more_text, intval($load_more_amount), intval($initial_amount_of_posts));

    //show the html to the user
    return $formatted_posts;
}

//function that returns post objects with specified params
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

//function that converts a list of post object to html
function print_posts_slp($posts_to_show, $read_more_text, $load_more_text, $load_more_amount, $amount_to_skip)
{
    ob_start(); //record all the echo data

    if ($posts_to_show->have_posts()) {
        //open container
        echo '<div class="simple_latest_posts_container" id="slp_container">';

        //loop al posts
        //we clear all tags so that no css etc is included
        while ($posts_to_show->have_posts()) {
            $posts_to_show->the_post();
            echo '<div class="column_slp popup_effect_slp">
            <img class="img_slp" src="' . get_the_post_thumbnail_url() . '">
            <p class="title_slp">' . preg_replace('/\s+/', ' ', wp_strip_all_tags( get_the_title() )) . '</p>
            <p class="description_slp">' . preg_replace('/\s+/', ' ', wp_strip_all_tags( get_the_content() )) . '</p>
            <a href="' . get_permalink() . '"><p class="read_more_button_slp">' . $read_more_text . '</p></a>            
            </div>';
        }

        //close container
        echo '</div>';

        //add load more button if possible to load more
        if (wp_count_posts()->publish > $amount_to_skip){
            echo '<a id="load_more_button" href="#"><p load-more-amount="' . $load_more_amount . '" amount-to-skip="' . $amount_to_skip.'"
        read-more-text="' . $read_more_text . '" load-more-text="' . $load_more_text . '"
        class="load_more_button_slp">' . $load_more_text . '</p></a>';
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

// ajax function that returns the new html that needs to be added
function ajax_load_more() {
    // first check if data is being sent and that it is the data we want (integer values)
    if ( isset($_POST["amount_to_load"]) && isset($_POST["amount_to_skip"]) & is_numeric($_POST["amount_to_load"])
        && is_numeric($_POST["amount_to_skip"]) && isset($_POST["read_more_text"]) && isset($_POST["load_more_text"]) ) {
        // set post values to local vars
        $amount_to_skip = intval($_POST["amount_to_skip"]);
        $amount_to_load = intval($_POST["amount_to_load"]);
        $read_more_text = $_POST["read_more_text"];
        $load_more_text = $_POST["load_more_text"];

        // get the blog post objects
        $posts_to_add_to_list = get_latest_posts_slp($amount_to_load, $amount_to_skip);

        //the new skip amount is the current one + the amount we're loading
        $amount_to_skip = $amount_to_skip + $amount_to_load;

        $formatted_posts = print_posts_slp($posts_to_add_to_list, $read_more_text, $load_more_text, $amount_to_load, $amount_to_skip);

        // send the response back to the front end
        echo $formatted_posts;
        die();
    }
    else {
        //not the params we want
        die();
    }
}

