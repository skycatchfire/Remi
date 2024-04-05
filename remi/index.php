<?php
/**
* Plugin Name: Remi
* Plugin URI: https://github.com/skycatchfire/Fire-Image-Proxy/
* Description: Display remote images from a live site while working locally. Save bandwidth and speed up development.
* Version: 1.0
* Author: SKYCATCHFIRE
* Author URI: https://skycatchfire.com/
**/

/**
 * SETTINGS PAGE
*/

// adds settings link on plugins page
function remi_add_settings_link($links) {
  $settings_link = '<a href="/wp-admin/tools.php?page=remi-settings">' . __('Settings') . '</a>';
  array_unshift($links, $settings_link);
  return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'remi_add_settings_link');

add_action('admin_menu', 'remi_settings_page');
function remi_settings_page() {
  add_management_page(
    'Remi 🐕 - Remote Image Settings ', // page title
    'Remi - Settings ', // menu title
    'manage_options', // capability
    'remi-settings', // menu slug
    'remi_settings_page_html' // callback function
  );
}

add_action('admin_notices', 'show_updated_message');
function show_updated_message() {
    // Check if we're on the options page
    if (isset($_GET['page']) && $_GET['page'] == 'remi-settings') {
      ?>
      <div class="updated notice is-dismissible">
          <p><?php _e('The settings were updated!', 'text-domain'); ?></p>
      </div>
      <?php
    }
}

function remi_settings_page_html() {
  // check user capabilities
  if (!current_user_can('manage_options')) {
    return;
  }
  ?>
  <div class="wrap">
		<h1><?= esc_html(get_admin_page_title()); ?></h1>
    <!-- css styles -->
    <style>
      .description{
        font-size: 14px !important;
        margin-top: 0 !important;
        margin-bottom: 8px !important;
        max-width: 620px;
      }
      .switch {
        position: relative;
        display: inline-block;
        width: 36px;
        height: 20px;
      }
      .switch input {
        opacity: 0;
        width: 0;
        height: 0;
      }
      #remi-form .form-table th {
        display: none;
      }
      #remi-form .form-table td {
        padding-left: 0;
      }
      .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
      }
      .remi-title{
        margin-top: 0;
        margin-bottom: 4px;
      }
      .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
      }
      input:checked + .slider {
        background-color: #2271b1;
      }
      input:focus + .slider {
        box-shadow: 0 0 1px #2271b1;
      }
      input:checked + .slider:before {
        -webkit-transform: translateX(16px);
        -ms-transform: translateX(16px);
        transform: translateX(16px);
      }
      /* Rounded sliders */
      .slider.round {
        border-radius: 34px;
      }
      .slider.round:before {
        border-radius: 50%;
      }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        function removeTrailingSlash(url) {
          if (url.value.slice(-1) === '/') {
            url.value = url.value.slice(0, -1);
          }
        }
        let timeout = null;
        const form = document.getElementById('remi-form');
        const remi_active = document.getElementById('remi_active');
        const remi_download = document.getElementById('remi_download');
        if (remi_active.checked) {
          remi_download.disabled = false;
        }

        remi_active.addEventListener('change', (e) => {
          if (!e.target.checked) {
            remi_download.checked = false;
          }
          remi_download.disabled = !e.target.checked;
        });

        document.getElementById('remi_url').addEventListener('change', function() {
          removeTrailingSlash(this);
        });

        document.getElementById('local_url').addEventListener('change', function() {
          removeTrailingSlash(this);
        });
      });
    </script>
    <form action="options.php" method="post" id="remi-form">
      <?php
      settings_fields('remi');

      // output setting sections and their fields
      do_settings_sections('remi-settings');

      // output save settings button
      submit_button('Save Settings');
      ?>
    </form>
  </div>
  <?php
}
function remi_settings_html() {
  $options = get_option('remi_settings');?>

  <div style="margin-bottom:1.5em;">
    <h3 class="remi-title" style="margin-bottom: 10px;">Remote Site URL</h3>
    <input type="url" id="remi_url" name="remi_settings[remi_url]" style="width:300px;" placeholder="https://example.com" value="<?= esc_attr($options['remi_url'] ?? ''); ?>">
  </div>

  <div style="margin-bottom:1.5em;">
    <h3 class="remi-title" style="margin-bottom: 10px;">Local Site URL</h3>
    <input type="url" id="local_url" name="remi_settings[local_url]" style="width:300px;" placeholder="https://example.local" value="<?= esc_attr($options['local_url'] ?? ''); ?>">
  </div>

  <div style="margin-bottom:1.5em;">
    <h3 class="remi-title" style="margin:0 10px 0 0;">Remote Image Swapping</h3>
    <div style="display:flex; align-items:center; margin:10px 0 10px;">
      <label class="switch">
        <input type="checkbox" id="remi_active" name="remi_settings[remi_active]" <?= isset($options['remi_active']) ? 'checked' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <h4 style="margin:0 0 0 10px;">Enable Swapping</h4>
    </div>
    <p class="description">Swap all local images for remote images.</p>
  </div>

  <div style="margin-bottom:1.5em;">
    <h3 class="remi-title" style="margin-bottom: 10px;">Remote Image Downloading</h3>
    <div style="display:flex; align-items:center; margin:10px 0 10px;">
      <label class="switch">
        <input type="checkbox" id="remi_download" disabled name="remi_settings[remi_download]" <?= isset($options['remi_download']) ? 'checked' : ''; ?>>
        <span class="slider round"></span>
      </label>
      <h4 style="margin:0 0 0 10px;">Enable Downloading</h4>
    </div>
    <p class="description">Download images to your local uploads directory. On first load, images will load from remote and begin downloading. When page is reloaded all the downloaded images will be served instead of remote images.</p>
  </div>
  <?php
}

add_action('admin_init', 'remi_settings_init');
function remi_settings_init() {
  register_setting('remi', 'remi_settings');

  add_settings_section(
    'remi_settings_section', // section ID
    '', // section title
    '', // section callback function
    'remi-settings' // menu slug
  );

  add_settings_field(
    'remi_settings', // field ID
    'Remi Settings', // field title
    'remi_settings_html', // field callback function
    'remi-settings', // menu slug
    'remi_settings_section' // section ID
  );
}

$options = get_option('remi_settings');
define( 'REMI_REMOTE_URL', $options['remi_url'] );
define( 'REMI_LOCAL_URL', $options['local_url'] );
define( 'REMI_ACTIVE', isset($options['remi_active']) );
define( 'REMI_DOWNLOAD', isset($options['remi_download']) );


/**
 * REMOTE IMAGE SWAPPING & DOWNLOADING
*/

function enqueue_remi_script() {
  wp_register_script('remi', plugins_url('/remi/remi.js'), array(), false, true);

  $script_data_array = array(
    'ajax_url' => admin_url('admin-ajax.php'),
  );
  wp_localize_script('remi', 'ajax_object', $script_data_array);
  wp_enqueue_script('remi');
}

if (defined('REMI_REMOTE_URL') && defined('REMI_LOCAL_URL') && REMI_ACTIVE) {
  add_action('wp_enqueue_scripts', 'enqueue_remi_script');
  add_action('wp_ajax_remi_remote_image', 'remi_remote_image');
  add_action('wp_ajax_nopriv_remi_remote_image', 'remi_remote_image');
}

function remi_remote_image() {
  $src = filter_input(INPUT_POST, 'src', FILTER_SANITIZE_STRING);
  $live_site_url = REMI_REMOTE_URL;
  $local_site_url = REMI_LOCAL_URL;

  if(!REMI_DOWNLOAD){
    $src = str_replace($local_site_url, $live_site_url, $src);
    echo json_encode(['swapped' => $src]);
    wp_die();
  }

  $src = str_replace($local_site_url, $live_site_url, $src);
  $upload_dir = wp_upload_dir();
  $src_relative_path = str_replace($live_site_url.'/wp-content/uploads/', '', $src);
  $local_file_path = $upload_dir['basedir'].'/' . $src_relative_path;
  $file_name = basename($local_file_path);

  if (!file_exists($local_file_path)) {
    // if $src contains $local_site_url, replace it with $live_site_url
    if (strpos($src, $local_site_url) !== false) {
      $src = str_replace($local_site_url, $live_site_url, $src);
    }
    if (!file_exists(dirname($local_file_path))) {
      mkdir(dirname($local_file_path), 0755, true);
    }
    $files = [$file_name];
    $file = file_get_contents($src);
    file_put_contents($local_file_path, $file);
    if (substr($src, -5) === '.webp') {
      $file = file_get_contents(str_replace('.webp', '', $src));
      file_put_contents(str_replace('.webp', '', $local_file_path), $file);
      $files[] = str_replace('.webp', '', $file_name);
    }
    echo json_encode(['swapped' => $src, 'downloaded' => implode(",", $files)]);
    wp_die();
  } else {
    echo json_encode(['exists' => $local_file_path]);
    wp_die();
  }
}
