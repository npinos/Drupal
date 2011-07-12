<?php
/**
 * Form builder. 
 *
 * Example form which has one "normal" FAPI field, plus CCK fields
 * from a hypothetical content type called "article". 
 */
function MYMODULE_my_custom_form(&$form_state) {
  // Add some normal FAPI item.
  $form['title'] = array (
    '#type' => 'textfield',
    '#title' => 'Title',
    '#required' => true,
    '#default_value' => NULL,
    '#maxlength' => 255,
    '#weight' => -5,
  );
  // Add special CCK form items.
  module_load_include('inc', 'content', 'includes/content.node_form');
  // Assume a hypothetical content type called "article"
  $type = content_types('article');
  // Go through each of its custom fields and add them to our form.
  foreach ($type['fields'] as $field_name => $field) {
    // If we wanted a specific field, we'd filter it here, by name:
    // if ($field_name == 'field_article_public') { }
    // But for this example we're going to add them all.
    $form['#field_info'][$field['field_name']] = $field;
    $form += (array) content_field_form($form, $form_state, $field);
  }
  $form['submit'] = array (
    '#value' => 'Submit',
    '#type' => 'submit',
  );
  return $form;
}

function MYMODULE_my_custom_form_submit(&$form, &$form_state) {
  // Submitted values for the CCK fields arrive here successfully and 
  // from what I've tested they even get validated accordingly by 
  // their "parent modules" (the CCK modules which define their 
  // functionality).
  //var_dump($form_state['values']);
}
