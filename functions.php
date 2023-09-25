<?php
// define WC APP Keys.
define('WP_CONSUMER_KEY', 'developer');
define('WP_CONSUMER_SECRET', '8w(QTIRPwbaiSK4Kk&');

/**
 * Validate Authorization header for an API calls.
 */
function validate_authorization_header()
{

    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {

        $wc_header = 'Basic ' . base64_encode(WP_CONSUMER_KEY . ':' . WP_CONSUMER_SECRET);
        if ($headers['Authorization'] == $wc_header) {
            return true;
        }
    }
    return false;
}
function my_custom_login()
{
    echo '<link rel="stylesheet" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');
function gymsonline_theme_support()
{
    // Add dynamic title tag support
    add_theme_support('title-tag');
    // Add thumbnails support
    add_theme_support('post-thumbnails');
    // Add custom Logo support
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'gymsonline_theme_support');

include get_template_directory() . '/includes/cleanup.php';
include get_template_directory() . '/includes/enqueue.php';
include get_template_directory() . '/includes/custom-posts.php';



function acfFilt($type)
{
    add_filter('rest_' . $type . '_query', function ($args) {
        if (isset($_GET['value'])) {

            $fields = explode(",", $_GET['field']);
            $vals = explode(",", $_GET['value']);
            $completeQuery = array();
            if (count($fields) > 0) {
                for ($i = 0; $i < count($fields); $i++) {
                    $thear = array(
                        'key'   => $fields[$i],
                        'value' => esc_sql($vals[$i]),
                         'compare' => 'LIKE'
                    );
                    array_push($completeQuery, $thear);
                }
                
                $args['meta_query'] = $completeQuery; // Agrega la cláusula meta_query aquí
            }
        }
        
        if(isset($_GET['pp'])) {
            $args['posts_per_page'] = $_GET['pp'];
        }
        
        if (isset($_GET['orderby'])) {
            $args['orderby'] = $_GET['orderby'];
        }

        if (isset($_GET['order'])) {
            $args['order'] = $_GET['order'];
        }

        
        return $args;
    });
}

if (isset($_GET['field']) || isset($_GET['oby'])) {
    // acfFilt("faq");
}

function my_rest_prepare_term($data, $item, $request)
{
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => $item->taxonomy,
                'field' => 'slug',
                'terms' => $item->slug
            )
        ),
        'posts_per_page' => 5
    );
    $posts = get_posts($args);
    $posts_arr = array();
    foreach ($posts as $p) {
        $posts_arr[] = array(
            'ID' => $p->ID,
            'title' => $p->post_title
        );
    }
    $data->data['posts'] = $posts_arr;
    return $data;
}
add_filter('rest_prepare_category', 'my_rest_prepare_term', 10, 3);

function custom_meta_query()
{
    if (isset($_GET['meta_query'])) {
        $query = $_GET['meta_query'];
        // Set the arguments based on our get parameters
        $args = array(
            'relation' => $query[0]['relation'],
            array(
                'key' => $query[0]['key'],
                'value' => $query[0]['value'],
                'compare' => '=',
            ),
        );
        // Run a custom query
        $meta_query = new WP_Query($args);
        if ($meta_query->have_posts()) {
            //Define and empty array
            $data = array();
            // Store each post's title in the array
            while ($meta_query->have_posts()) {
                $meta_query->the_post();
                $data[] =  get_the_title();
            }
            // Return the data
            return $data;
        } else {
            // If there is no post
            return 'No post to show';
        }
    }
}

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
}
add_action('admin_head', 'fix_svg');

add_filter('use_block_editor_for_post_type', '__return_false');