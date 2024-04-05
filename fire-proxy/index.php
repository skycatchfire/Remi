<?php
/**
* Plugin Name: Fire Image Proxy
* Plugin URI: https://github.com/skycatchfire/Fire-Image-Proxy/
* Description: Proxy images from a live site to a local site. Save bandwidth and speed up development.
* Version: 0.1
* Author: SKYCATCHFIRE
* Author URI: https://skycatchfire.com/
**/

function enqueue_stage_file_proxy_script() {
  wp_register_script('fire-proxy', plugins_url('/fire-proxy/fire-proxy.js'), array(), false, true);

  $script_data_array = array(
    'ajax_url' => admin_url('admin-ajax.php'),
  );
  wp_localize_script('fire-proxy', 'ajax_object', $script_data_array);
  wp_enqueue_script('fire-proxy');
}

add_action('admin_menu', 'proxy_settings_page');
function proxy_settings_page() {
  add_management_page(
    'Fire Image Proxy Settings', // page title
    'Fire Image Proxy', // menu title
    'manage_options', // capability
    'proxy-settings', // menu slug
    'proxy_settings_page_html' // callback function
  );
}
add_action('admin_notices', 'show_updated_message');

add_action('admin_notices', 'show_updated_message');
function show_updated_message() {
    // Check if we're on the options page
    if (isset($_GET['page']) && $_GET['page'] == 'proxy-settings') {
      ?>
      <div class="updated notice is-dismissible">
          <p><?php _e('The settings were updated!', 'text-domain'); ?></p>
      </div>
      <?php
    }
}

function proxy_settings_page_html() {
  // check user capabilities
  if (!current_user_can('manage_options')) {
    return;
  }
  ?>
  <div class="wrap">
    <svg width="22" height="35" style="float:left; margin-right:10px;" viewBox="0 0 22 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.1017 3.10836H11.6558C11.8705 3.10836 12.0647 3.02122 12.2055 2.88066C12.3458 2.7401 12.4329 2.54587 12.4329 2.33121V0.777153C12.4329 0.562494 12.346 0.368268 12.2052 0.227706C12.1332 0.155456 12.0476 0.0981471 11.9534 0.0590708C11.8591 0.0199944 11.7581 -7.99605e-05 11.656 2.3936e-07H10.102C9.88732 2.3936e-07 9.69334 0.0868976 9.55253 0.227706C9.41172 0.368514 9.32507 0.562494 9.32507 0.777153V2.33121C9.32507 2.54587 9.41197 2.73985 9.55253 2.88066C9.69309 3.02147 9.88707 3.10836 10.1017 3.10836Z" fill="#01A27F"/><path d="M20.9807 21.7579H19.4249C19.2127 21.7574 19.0199 21.6717 18.8796 21.5329C18.7393 21.394 18.6517 21.2018 18.6495 20.9889V16.3186C18.6495 16.1041 18.5626 15.9099 18.422 15.7691C18.2814 15.6283 18.0872 15.5416 17.8725 15.5416H16.3182C16.1038 15.5416 15.9096 15.6285 15.7688 15.7691C15.628 15.9097 15.5413 16.1039 15.5413 16.3186V17.881L15.5408 17.8768C15.5401 18.0817 15.4582 18.2779 15.3131 18.4226C15.1728 18.5631 14.9783 18.65 14.7634 18.65H13.2091C12.9955 18.65 12.8012 18.7367 12.6602 18.8772C12.5191 19.0178 12.4322 19.212 12.4322 19.4269V20.981C12.4322 21.1959 12.3456 21.3901 12.205 21.5304C12.0647 21.671 11.8707 21.7579 11.6561 21.7581H10.1013C9.88783 21.7581 9.69361 21.6712 9.5528 21.5307C9.41199 21.3901 9.32485 21.1959 9.32485 20.981V16.3186C9.32485 16.1036 9.41224 15.9094 9.55305 15.7689C9.69385 15.6283 9.88808 15.5416 10.102 15.5416H11.6558C11.8705 15.5416 12.0647 15.4545 12.2053 15.3139C12.3461 15.1734 12.433 14.9792 12.433 14.7645V10.0999L12.4325 10.0979C12.4337 9.88372 12.5213 9.69048 12.6619 9.5509C12.8025 9.41132 12.9962 9.32467 13.2091 9.32467H14.7642C14.9788 9.32467 15.1728 9.23777 15.3136 9.09721C15.4544 8.95665 15.5413 8.76242 15.5413 8.54776V6.99346C15.5413 6.77905 15.4542 6.58482 15.3136 6.44401C15.1731 6.3032 14.9788 6.21655 14.7642 6.21655H13.2101C12.9955 6.21655 12.8012 6.30345 12.6607 6.44401C12.5201 6.58457 12.433 6.7788 12.433 6.99346V8.55589L12.4325 8.5517C12.4317 8.75658 12.3499 8.95282 12.2048 9.09746C12.0645 9.23777 11.87 9.32467 11.6551 9.32467H10.1018C9.8871 9.32467 9.69312 9.41181 9.55231 9.55238C9.4115 9.69294 9.3246 9.88716 9.3246 10.1018V11.6559C9.3246 11.871 9.23795 12.0653 9.09739 12.2058C8.95683 12.3464 8.7626 12.433 8.5477 12.433H6.99339C6.77898 12.433 6.58475 12.5199 6.44394 12.6607C6.37171 12.7328 6.31443 12.8185 6.27539 12.9128C6.23636 13.0071 6.21634 13.1081 6.21648 13.2102V14.7642C6.21648 14.9792 6.12959 15.1734 5.98902 15.3139C5.84846 15.4545 5.65424 15.5414 5.43933 15.5414H3.88527C3.67061 15.5414 3.47639 15.6283 3.33582 15.7689C3.19526 15.9094 3.10812 16.1036 3.10812 16.3183V17.8726C3.10812 18.0875 3.02147 18.2815 2.88115 18.4221C2.74084 18.5626 2.54686 18.6493 2.3322 18.6495H0.776907C0.562248 18.6495 0.368021 18.7364 0.227459 18.8772C0.0868974 19.018 0 19.212 0 19.4267V27.1972C0 27.4119 0.0868973 27.6061 0.227706 27.7467C0.368514 27.8872 0.562494 27.9744 0.777153 27.9744H2.33195C2.54686 27.9744 2.74084 28.0615 2.88115 28.2018C3.02147 28.3421 3.10812 28.5366 3.10812 28.7513C3.10812 28.7459 3.10886 28.7407 3.1096 28.7353C3.10886 28.7407 3.10836 28.7459 3.10836 28.7515V30.3056C3.10836 30.5202 3.19526 30.7142 3.33582 30.855C3.47639 30.9958 3.67061 31.0827 3.88527 31.0827H5.43933C5.44475 31.0827 5.44967 31.082 5.45484 31.0813C5.46001 31.0805 5.46469 31.0798 5.46986 31.0795H5.47084C5.46567 31.0795 5.46075 31.0805 5.45558 31.0813C5.45041 31.082 5.44548 31.0827 5.44007 31.0827C5.64553 31.0823 5.84275 31.1635 5.98838 31.3085C6.13401 31.4534 6.21614 31.6502 6.21673 31.8557V31.8577L6.21648 31.8596V33.4139C6.21648 33.6284 6.30338 33.8226 6.44394 33.9634C6.58475 34.1037 6.77873 34.1908 6.99339 34.1908H14.7642C14.9786 34.1908 15.1728 34.104 15.3136 33.9634C15.4542 33.8226 15.5411 33.6286 15.5411 33.4139V31.8577L15.5408 31.8557C15.5418 31.6415 15.6295 31.4483 15.7703 31.3087C15.9111 31.1691 16.1043 31.0827 16.3175 31.0827H17.8723C18.087 31.0827 18.2812 30.9956 18.4217 30.855C18.5623 30.7145 18.6495 30.5202 18.6495 30.3056V28.7515L18.6492 28.7495V28.7473C18.6502 28.5334 18.7378 28.3402 18.8784 28.2003C19.0189 28.0605 19.2127 27.9744 19.4256 27.9744H20.9807C21.1951 27.9744 21.3893 27.8875 21.5301 27.7467C21.6709 27.6059 21.7576 27.4119 21.7576 27.1972V22.5348C21.7576 22.3204 21.6707 22.1262 21.5301 21.9853C21.3895 21.8445 21.1953 21.7579 20.9807 21.7579ZM15.5408 27.2009L15.5406 27.1992V27.1972C15.5408 27.2993 15.5209 27.4005 15.4819 27.4949C15.4429 27.5893 15.3857 27.675 15.3135 27.7472C15.2413 27.8195 15.1555 27.8767 15.0611 27.9157C14.9667 27.9546 14.8656 27.9746 14.7634 27.9744H13.2101C12.9955 27.9744 12.8012 28.0613 12.6607 28.2018C12.5201 28.3424 12.433 28.5366 12.433 28.7513V29.5301L12.4325 30.3093V30.3073L12.4322 30.3053C12.4322 30.5205 12.3453 30.7147 12.2048 30.8553C12.0642 30.9958 11.87 31.0825 11.6551 31.0825H6.99437C6.7807 31.0825 6.58647 30.9958 6.44542 30.8553C6.30437 30.7147 6.21722 30.5205 6.21722 30.3053L6.21698 30.3093C6.21672 30.3105 6.21655 30.3117 6.21648 30.313V28.7513C6.21648 28.5366 6.12959 28.3426 5.98902 28.2018C5.84846 28.061 5.65424 27.9741 5.43958 27.9741H3.88453H3.88527C3.6716 27.9741 3.47737 27.8875 3.33656 27.7469C3.19575 27.6063 3.10836 27.4121 3.10836 27.197V19.4267C3.10836 19.2118 3.19575 19.0173 3.33656 18.877C3.47737 18.7367 3.6716 18.6495 3.88552 18.6495H3.88502H5.43982C5.65473 18.6495 5.84871 18.7364 5.98927 18.877C6.12983 19.0175 6.21648 19.2118 6.21648 19.4267V20.9807C6.21648 21.1951 6.30363 21.3894 6.44419 21.5302C6.58475 21.6707 6.77898 21.7576 6.99364 21.7576H8.54868H8.5477C8.76285 21.7576 8.95707 21.8445 9.09763 21.9851C9.2382 22.1257 9.32485 22.3199 9.32485 22.5348V24.0888C9.32485 24.3035 9.41175 24.4977 9.55231 24.6383C9.69312 24.7791 9.8871 24.866 10.102 24.866H14.7639C14.9788 24.8662 15.1728 24.9531 15.3134 25.0935C15.4585 25.2382 15.5403 25.4345 15.5408 25.6395V27.2009Z" fill="#01A27F"/></svg>
      <h1><?= esc_html(get_admin_page_title()); ?></h1>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        function removeTrailingSlash(url) {
          if (url.value.slice(-1) === '/') {
            url.value = url.value.slice(0, -1);
          }
        }
        let timeout = null;
        const form = document.getElementById('fire-proxy-form');
        // disable proxy_download if proxy_on is not checked and enable it if it is
        const proxy_on = document.getElementById('proxy_on');
        const proxy_download = document.getElementById('proxy_download');
        // id proxy_on is checked, enable proxy_download
        if (proxy_on.checked) {
          proxy_download.disabled = false;
        }

        proxy_on.addEventListener('change', (e) => {
          if (!e.target.checked) {
            proxy_download.checked = false;
          }
          proxy_download.disabled = !e.target.checked;
        });

        document.getElementById('proxy_url').addEventListener('change', function() {
          removeTrailingSlash(this);
        });

        document.getElementById('local_url').addEventListener('change', function() {
          removeTrailingSlash(this);
        });
      });
    </script>
    <form action="options.php" method="post" id="fire-proxy-form">
      <?php
      // output security fields for the registered setting "proxy"
      settings_fields('proxy');

      // output setting sections and their fields
      do_settings_sections('proxy-settings');
      echo "<p>If <strong>Download Images</strong> is selected, images from the remote url will be downloaded and put them in your local uploads directory.</p>";

      // output save settings button
      submit_button('Save Settings');
      ?>
    </form>
  </div>
  <?php
}

add_action('admin_init', 'proxy_settings_init');
function proxy_settings_init() {
    register_setting('proxy', 'proxy_settings');

    add_settings_section(
      'proxy_settings_section', // section ID
      'Proxy Settings', // section title
      '', // section callback function
      'proxy-settings' // menu slug
    );

    add_settings_field(
      'proxy_url', // field ID
      'Remote URL', // field title
      'proxy_url_field_html', // field callback function
      'proxy-settings', // menu slug
      'proxy_settings_section' // section ID
    );

    add_settings_field(
      'local_url', // field ID
      'Local URL', // field title
      'local_url_field_html', // field callback function
      'proxy-settings', // menu slug
      'proxy_settings_section' // section ID
    );

    add_settings_field(
        'proxy_on',
        'Proxy On',
        'proxy_on_field_html',
        'proxy-settings',
        'proxy_settings_section'
    );

    add_settings_field(
        'proxy_download',
        'Download Images',
        'proxy_download_field_html',
        'proxy-settings',
        'proxy_settings_section'
    );
}

function proxy_url_field_html() {
  $options = get_option('proxy_settings');?>
  <input type="url" id="proxy_url" name="proxy_settings[proxy_url]" style="width:300px;" placeholder="https://example.com" value="<?= esc_attr($options['proxy_url'] ?? ''); ?>">
  <p>Enter the remote URL to load images from</p>
  <?php
}
function local_url_field_html() {
  $options = get_option('proxy_settings');?>
  <input type="url" id="local_url" name="proxy_settings[local_url]" style="width:300px;" placeholder="https://example.local" value="<?= esc_attr($options['local_url'] ?? ''); ?>">
  <p>Enter the local URL</p>
  <?php
}

function proxy_on_field_html() {
  $options = get_option('proxy_settings');?>
  <input type="checkbox" id="proxy_on" name="proxy_settings[proxy_on]" <?= isset($options['proxy_on']) ? 'checked' : ''; ?>>
  <?php
}

function proxy_download_field_html() {
  $options = get_option('proxy_settings');?>
  <input type="checkbox" id="proxy_download" disabled name="proxy_settings[proxy_download]" <?= isset($options['proxy_download']) ? 'checked' : ''; ?>>
  <?php
}

$options = get_option('proxy_settings');
define( 'PROXY_REMOTE_URL', $options['proxy_url'] );
define( 'PROXY_LOCAL_URL', $options['local_url'] );
define( 'PROXY_ON', isset($options['proxy_on']) );
define( 'PROXY_DOWNLOAD', isset($options['proxy_download']) );

if (defined('PROXY_REMOTE_URL') && defined('PROXY_LOCAL_URL') && PROXY_ON) {
  add_action('wp_enqueue_scripts', 'enqueue_stage_file_proxy_script');
  add_action('wp_ajax_download_image', 'download_image');
  add_action('wp_ajax_nopriv_download_image', 'download_image');
}

function download_image() {
  $src = filter_input(INPUT_POST, 'src', FILTER_SANITIZE_STRING);
  $live_site_url = PROXY_REMOTE_URL;
  $local_site_url = PROXY_LOCAL_URL;

  if(!PROXY_DOWNLOAD){
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
