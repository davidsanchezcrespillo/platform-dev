<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_token\PlainNodeSummaryTokenHandler.
 */

namespace Drupal\nexteuropa_token;

/**
 * Class PlainNodeSummaryTokenHandler.
 *
 * @package Drupal\nexteuropa_token
 */
class PlainNodeSummaryTokenHandler extends TokenAbstractHandler {

  const DEFAULT_PREFIX = 'prefix';
  const TOKEN_NAME = 'plain-text-summary';

  /**
   * {@inheritdoc}
   */
  public function hookTokens($type, $tokens, array $data = array(), array $options = array()) {
    
    if (isset($options['language'])) {
      $language_code = $options['language']->language;
    }
    else {
      $language_code = NULL;
    }

    // Init our return array.
    $replacements = array();

    // Only trigger.
    if ($this->isValidTokenType($type)) {
      foreach ($tokens as $name => $original) {
        if ($name == self::TOKEN_NAME && isset($data['node'])) {
          if ($items = field_get_items('node', $data['node'], 'body', $language_code)) {
            $instance = field_info_instance('node', 'body', $data['node']->type);
            $field_langcode = field_language('node', $data['node'], 'body', $language_code);
            // If the summary was requested and is not empty, use it.
            $output = !empty($items[0]['summary']) 
              ? _text_sanitize($instance, $field_langcode, $items[0], 'summary') 
              : text_summary(_text_sanitize($instance, $field_langcode, $items[0], 'value'));
            // Place it in the response.
            $replacements[$original] = strip_tags($output);
          }
        }
      }
    }
    return $replacements;
  }

  /**
   * {@inheritdoc}
   */
  public function hookTokenInfoAlter(&$data) {
    foreach ($this->getEntityTokenTypes() as $token_type => $entity_info) {
      $data['tokens'][$token_type][self::TOKEN_NAME] = array(
        'name' => t("!entity Plain text summary", array('!entity' => $entity_info['label'])),
        'description' => t("The node summary without any html."),
      );
    }
  }

}
