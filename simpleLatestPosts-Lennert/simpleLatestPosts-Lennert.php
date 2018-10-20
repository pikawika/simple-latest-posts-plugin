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
add_shortcode('simpleLatestPosts', 'initialise_SMP');

//init function that accepts optional params for custom button text used in the plugin and default loaded posts
//atrr params are not camelcased since wordpress always passes them ass lowercase
function initialise_SMP($atts) {
    extract(shortcode_atts(array(
        'readmoretext' => 'Read more',
        'initialamountofposts' => 10,
        'amountofmorepoststoload' => 5,
    ), $atts));

    //get the posts from the database
    $postsToAddToList =  getLatestPosts_SMP($initialamountofposts);

    //process the posts list to html
    $formattedPosts = printPosts_SMP($postsToAddToList, $readmoretext);

    //show the html to the user
    return $formattedPosts;
}

function getLatestPosts_SMP($amountToLoad, $amountToSkip = 0) {
    $queryArgs = array(
        'order' => 'asc', //newest first
        'post_type' => 'post', //any type of post
        'posts_per_page' => $amountToLoad, //how many posts should be loaded
        'offset' => $amountToSkip //skip certain items if needed (load more button)
    );
    return new WP_Query( $queryArgs );
}

function printPosts_SMP($postsToShow, $readmoretext ) {
    ob_start(); //record all the echo data

    if ( $postsToShow->have_posts() ) {
        echo '<ul>';
        while ( $postsToShow->have_posts() ) {
            $postsToShow->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
        /* Restore original Post Data */
        wp_reset_postdata();
    } else {
        echo '<H3> No blogposts found</H3>';
    }

    $formattedPosts = ob_get_contents(); //get all the echo data
    ob_end_clean(); // stop and clean echo listener
    return $formattedPosts; //html for the itterated posts
}