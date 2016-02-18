<?php
/**
 * Implements template_preprocess_page.
 *
 * Add convenience variables and template suggestions.
 */
function mtlz_preprocess_page(&$variables) {

  $links = menu_tree_output(menu_tree_all_data(variable_get('menu_secondary_links_source', 'user-menu')));

  // Top bar menus.
  $variables['top_bar_main_menu'] = '';
  if (!empty($variables['main_menu'])) {
    $variables['top_bar_main_menu'] = theme('links__topbar_main_menu', array(
      'links' => $variables['main_menu'],
      'attributes' => array(
        'id' => 'main-menu',
        'class' => array('left', 'hide-on-med-and-down'),
      ),
    ));
  }

  $variables['top_bar_secondary_menu'] = '';
  if (!empty($variables['secondary_menu'])) {
    $variables['top_bar_secondary_menu'] = theme('links__topbar_secondary_menu', array(
      'links' => $variables['secondary_menu'],
      'attributes' => array(
        'class' => array('right', 'hide-on-med-and-down'),
      ),
    ));
  }

  $variables['sidebar_combined_menu'] = '';
  if (!empty($variables['main_menu'])) {
    $variables['sidebar_combined_menu'] .= theme('links__sidebar_combined_menu', array(
      'links' => array_merge($variables['main_menu'], $variables['secondary_menu']),
      'attributes' => array(
        'id' => array('nav-mobile'),
        'class' => array('side-nav'),
      ),
    ));
  }

  $variables['linked_logo'] = '';
  if (!empty($variables['logo_img'])) {
    $variables['linked_logo'] = l($variables['logo_img'], '<front>', array(
      'attributes' => array(
        'rel' => 'home',
        'title' => strip_tags($variables['site_name']) . ' ' . t('Home'),
      ),
      'html' => TRUE,
    ));
  }

  $variables['linked_site_name'] = '';
  if (!empty($variables['site_name'])) {
    $variables['linked_site_name'] = l($variables['site_name'], '<front>', array(
      'attributes' => array(
        'rel' => 'home',
        'title' => strip_tags($variables['site_name']) . ' ' . t('Home'),
      ),
      'html' => TRUE,
    ));
  }

}

/**
 * Implements theme_links() targeting the main menu topbar.
 */
function mtlz_links__topbar_main_menu($variables) {
  // We need to fetch the links ourselves because we need the entire tree.
  $links = menu_tree_output(menu_tree_all_data(variable_get('menu_main_links_source', 'main-menu')));
  $output = _mtlz_links($links);

  return '<ul' . drupal_attributes($variables['attributes']) . '>' . $output . '</ul>';
}

/**
 * Implements theme_links() targeting the secondary menu topbar.
 */
function mtlz_links__topbar_secondary_menu($variables) {
  // We need to fetch the links ourselves because we need the entire tree.
  $links = menu_tree_output(menu_tree_all_data(variable_get('menu_secondary_links_source', 'user-menu')));
  $output = _mtlz_links($links);

  return '<ul' . drupal_attributes($variables['attributes']) . '>' . $output . '</ul>';
}

/**
 * Implements theme_links() targeting the combined menu sidebar.
 */
function mtlz_links__sidebar_combined_menu($variables) {

  // We need to fetch the links ourselves because we need the entire tree.
  $links = $variables['links'];
  $output = '';

  $output .= theme('links__system_main_menu', array('links' =>   $links, 'attributes' => $variables['attributes']));

  return $output;
}

/**
 * Helper function to output a Drupal menu as a Foundation Top Bar.
 *
 * @links array
 *   An array of menu links.
 *
 * @return string
 *   A rendered list of links, with no <ul> or <ol> wrapper.
 *
 * @see mtlz_links__system_main_menu()
 * @see mtlz_links__system_secondary_menu()
 */
function _mtlz_links($links) {
  $output = '';

  foreach (element_children($links) as $key) {
    $output .= _mtlz_render_link($links[$key]);
  }

  return $output;
}

/**
 * Helper function to recursively render sub-menus.
 *
 * @link array
 *   An array of menu links.
 *
 * @return string
 *   A rendered list of links, with no <ul> or <ol> wrapper.
 *
 * @see _mtlz_links()
 */
function _mtlz_render_link($link) {
  $output = '';
  // This is a duplicate link that won't get the dropdown class and will only
  // show up in small-screen.
  $small_link = $link;

  if (!empty($link['#below'])) {
    $link['#attributes']['class'][] = 'has-dropdown';
  }

  // Render top level and make sure we have an actual link.
  if (!empty($link['#href'])) {
    $rendered_link = NULL;

    // Foundation offers some of the same functionality as Special Menu Items;
    // ie: Dividers and Labels in the top bar. So let's make sure that we
    // render them the Foundation way.
    if (module_exists('special_menu_items')) {
      if ($link['#href'] === '<nolink>') {
        $rendered_link = '<label>' . $link['#title'] . '</label>';
      }
      else {
        if ($link['#href'] === '<separator>') {
          $link['#attributes']['class'][] = 'divider';
          $rendered_link = '';
        }
      }
    }

    if (!isset($rendered_link)) {
      $rendered_link = theme('mtlz_menu_link', array('link' => $link));
    }

    // Test for localization options and apply them if they exist.
    if (isset($link['#localized_options']['attributes']) && is_array($link['#localized_options']['attributes'])) {
      $link['#attributes'] = array_merge_recursive($link['#attributes'], $link['#localized_options']['attributes']);
    }

    $output .= '<li>' . $rendered_link . '</li>';

  }

  return $output;
}

/**
 * Theme function to render a single top bar menu link.
 */
function theme_mtlz_menu_link($variables) {
  $link = $variables['link'];

  $options = array(
    'attributes' => array(
      'class' => array('mtlz-navigation__link'),
    ),
  );

  return l($link['#title'], $link['#href'], $options);
}

/**
 * Implements hook_theme().
 */
function mtlz_theme() {
  $return = array();

  $return['mtlz_menu_link'] = array(
    'variables' => array('link' => NULL),
    'function' => 'theme_mtlz_menu_link',
  );
  return $return;
}
