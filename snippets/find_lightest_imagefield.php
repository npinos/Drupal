<?php
/**
 * Based on my answer to: "How to get the first image field from a node without knowing the field's name?"
 * @see: http://stackoverflow.com/questions/6656595
 */
module_load_include('inc', 'content', 'includes/content.node_form');
$content_types = array('page', 'story', 'product', 'some_content_type');

$imagefields_per_content_type = array();
foreach ($content_types as $content_type_name) {
  $content_type_data = content_types($content_type_name);
  $last_weight = NULL;
  foreach ($content_type_data['fields'] as $field_name => $field_data) {
    if ($field_data['widget']['type'] == 'imagefield_widget' && (is_null($last_weight) || (int)$field_data['widget']['weight'] < $last_weight)) {
        $imagefields_per_content_type[$content_type_name] = $field_name;
        $last_weight = (int)$field_data['widget']['weight'];
    }
  }
}
/** Example Usage:
 * $node = load_some_node_i_want();
 * $node->$imagefields_per_content_type[$node->type]; // Accessing the lightest imagefield.
 */

