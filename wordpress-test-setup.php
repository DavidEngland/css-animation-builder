<?php
/**
 * WordPress Test Site Setup
 * Quick setup for testing CSS Animation Builder plugin
 */

// Create test pages and posts for the plugin
function create_css_animation_test_content() {
    
    // Test Post 1: Basic Handwriting Demo
    $post1 = array(
        'post_title' => 'The Art of Digital Handwriting',
        'post_content' => 'Welcome to the fascinating world of digital handwriting animations!

[css-animation class="handwriting-quill" text="Coca-Cola" duration="4s"]

In the early days of writing, scribes used quill pens to create beautiful manuscripts. Today, we can recreate that elegance with CSS animations.

[css-animation class="handwriting-fountain" text="Shakespeare" duration="3s"]

The fountain pen brought sophistication to writing, and our digital version captures that same grace.

[css-animation class="handwriting-casual" text="Modern Web Design" duration="5s"]

Whether you\'re creating a vintage website or adding personality to your brand, handwriting animations bring life to digital text.

[css-animation class="handwriting-signature" text="Your Name Here" duration="4s"]',
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_category' => array(1), // Default category
    );
    
    $post1_id = wp_insert_post($post1);
    
    // Test Page 1: About Us
    $page1 = array(
        'post_title' => 'About Our Handwriting Animations',
        'post_content' => '# Professional Handwriting Animations

[css-animation class="handwriting-quill" text="Welcome to Excellence" duration="4s"]

## Why Choose Handwriting Animations?

Transform your website from ordinary to extraordinary with professional handwriting effects that captivate your audience.

[css-animation class="handwriting-fountain" text="Sophisticated Design" duration="3s"]

### Perfect for:
- Luxury Brands - Add elegance and sophistication
- Personal Blogs - Create intimate, personal connections  
- Portfolio Sites - Stand out from the competition
- Wedding Sites - Romantic and memorable experiences

[css-animation class="handwriting-casual" text="Easy to Use" duration="3s"]

### Multiple Styles Available:

**Quill Writing:**
[css-animation class="handwriting-quill" text="Traditional Elegance" duration="4s"]

**Fountain Pen:**
[css-animation class="handwriting-fountain" text="Modern Sophistication" duration="3s"]

**Casual Script:**
[css-animation class="handwriting-casual" text="Friendly and Approachable" duration="3s"]

**Formal Script:**
[css-animation class="handwriting-formal" text="Professional Excellence" duration="4s"]

**Signature Style:**
[css-animation class="handwriting-signature" text="Personal Touch" duration="5s"]',
        'post_status' => 'publish',
        'post_type' => 'page',
    );
    
    $page1_id = wp_insert_post($page1);
    
    // Test Page 2: Contact
    $page2 = array(
        'post_title' => 'Contact Us',
        'post_content' => 'We\'d love to hear from you!

[css-animation class="handwriting-quill" text="Send us a message" duration="3s"]

Feel free to reach out with any questions about our handwriting animations.

[css-animation class="handwriting-signature" text="We\'ll respond within 24 hours" duration="4s"]',
        'post_status' => 'publish',
        'post_type' => 'page',
    );
    
    $page2_id = wp_insert_post($page2);
    
    // Test Post 2: Restaurant Demo
    $post2 = array(
        'post_title' => 'Authentic Italian Cuisine',
        'post_content' => '# Benvenuti alla Nostra Famiglia

[css-animation class="handwriting-quill" text="Welcome to Our Family" duration="4s"]

## Our Story

For three generations, our family has been serving authentic Italian cuisine with love and passion.

[css-animation class="handwriting-casual" text="Traditional Recipes" duration="3s"]

## Today\'s Specials

### Pasta alla Carbonara
[css-animation class="handwriting-formal" text="Chef\'s Special" duration="3s"]

Traditional Roman dish with pancetta, eggs, and pecorino cheese.

### Osso Buco Milanese
[css-animation class="handwriting-fountain" text="Slow Cooked Perfection" duration="4s"]

Braised veal shanks with vegetables, white wine, and broth.

### Tiramisu
[css-animation class="handwriting-signature" text="Nonna\'s Secret Recipe" duration="4s"]

Our grandmother\'s famous tiramisu, made fresh daily.',
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_category' => array(1),
    );
    
    $post2_id = wp_insert_post($post2);
    
    // Test Post 3: Portfolio
    $post3 = array(
        'post_title' => 'Our Latest Projects',
        'post_content' => '# Recent Work

[css-animation class="handwriting-formal" text="Project Showcase" duration="4s"]

## Website Redesign for Luxury Brand

[css-animation class="handwriting-quill" text="Elegant • Sophisticated • Memorable" duration="5s"]

We transformed their digital presence with handwriting animations that reflect their premium positioning.

## Wedding Photography Site

[css-animation class="handwriting-casual" text="Love Stories in Motion" duration="4s"]

Romantic handwriting effects that capture the emotion of each couple\'s special day.

## Corporate Identity Project

[css-animation class="handwriting-fountain" text="Professional Excellence" duration="3s"]

Clean, professional animations that enhance brand credibility and user engagement.',
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_category' => array(1),
    );
    
    $post3_id = wp_insert_post($post3);
    
    // Create a menu with test pages
    $menu_name = 'CSS Animation Test Menu';
    $menu_id = wp_create_nav_menu($menu_name);
    
    // Add pages to menu
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Home',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-type' => 'custom'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'About',
        'menu-item-object-id' => $page1_id,
        'menu-item-object' => 'page',
        'menu-item-status' => 'publish',
        'menu-item-type' => 'post_type'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Contact',
        'menu-item-object-id' => $page2_id,
        'menu-item-object' => 'page',
        'menu-item-status' => 'publish',
        'menu-item-type' => 'post_type'
    ));
    
    // Set as primary menu location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    return array(
        'posts' => array($post1_id, $post2_id, $post3_id),
        'pages' => array($page1_id, $page2_id),
        'menu' => $menu_id
    );
}

// Run this function to create test content
// create_css_animation_test_content();

/**
 * Test shortcode examples for quick copy-paste
 */
function get_test_shortcodes() {
    return array(
        'Basic Quill' => '[css-animation class="handwriting-quill" text="Hello World"]',
        'Custom Duration' => '[css-animation class="handwriting-fountain" text="Shakespeare" duration="5s"]',
        'Long Text' => '[css-animation class="handwriting-formal" text="The quick brown fox jumps over the lazy dog"]',
        'Custom Style' => '[css-animation class="handwriting-signature" text="Your Name" style="color: #e74c3c; font-size: 3rem;"]',
        'Multiple Styles' => '[css-animation class="handwriting-quill" text="Coca-Cola"]
[css-animation class="handwriting-fountain" text="Shakespeare"]
[css-animation class="handwriting-casual" text="Modern Design"]',
    );
}

/**
 * Quick test function to check if plugin is working
 */
function test_css_animation_plugin() {
    echo '<div style="padding: 20px; background: #f0f0f0; margin: 20px;">';
    echo '<h3>CSS Animation Builder Plugin Test</h3>';
    
    // Test basic shortcode
    echo '<p>Basic Test:</p>';
    echo do_shortcode('[css-animation class="handwriting-quill" text="Plugin Test"]');
    
    // Test with custom duration
    echo '<p>Custom Duration Test:</p>';
    echo do_shortcode('[css-animation class="handwriting-fountain" text="5 Second Animation" duration="5s"]');
    
    // Test multiple animations
    echo '<p>Multiple Animations Test:</p>';
    echo do_shortcode('[css-animation class="handwriting-casual" text="First Animation"]');
    echo do_shortcode('[css-animation class="handwriting-signature" text="Second Animation"]');
    
    echo '</div>';
}

// Add admin menu for testing
add_action('admin_menu', 'css_animation_test_menu');
function css_animation_test_menu() {
    add_management_page(
        'CSS Animation Test',
        'CSS Animation Test',
        'manage_options',
        'css-animation-test',
        'css_animation_test_page'
    );
}

function css_animation_test_page() {
    ?>
    <div class="wrap">
        <h1>CSS Animation Builder - Test Page</h1>
        
        <h2>Quick Test</h2>
        <?php test_css_animation_plugin(); ?>
        
        <h2>Test Shortcodes</h2>
        <p>Copy and paste these shortcodes into posts or pages:</p>
        
        <?php
        $shortcodes = get_test_shortcodes();
        foreach ($shortcodes as $name => $code) {
            echo '<h3>' . $name . '</h3>';
            echo '<code>' . esc_html($code) . '</code><br><br>';
        }
        ?>
        
        <h2>Create Test Content</h2>
        <p>Click the button below to create sample posts and pages with handwriting animations:</p>
        
        <form method="post">
            <input type="hidden" name="create_test_content" value="1">
            <?php wp_nonce_field('create_test_content', 'test_nonce'); ?>
            <button type="submit" class="button button-primary">Create Test Content</button>
        </form>
        
        <?php
        if (isset($_POST['create_test_content']) && wp_verify_nonce($_POST['test_nonce'], 'create_test_content')) {
            $created = create_css_animation_test_content();
            echo '<div class="notice notice-success"><p>Test content created successfully!</p></div>';
        }
        ?>
    </div>
    <?php
}
?>
