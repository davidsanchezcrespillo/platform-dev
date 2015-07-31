<?php

/**
 * @file
 * Class definition of FeedsNodeProcessor.
 */

/**
 * Creates nodes from feed items.
 */
class NewsroomFeedsNodeProcessor extends FeedsProcessor {

  /**
   * Define entity type.
   */
  public function entityType() {
    return 'node';
  }

  /**
   * Implements parent::entityInfo().
   */
  protected function entityInfo() {
    $info = parent::entityInfo();
    $info['label plural'] = t('Nodes');
    return $info;
  }

  /**
   * Creates a new node in memory and returns it.
   */
  protected function newEntity(FeedsSource $source) {
    $node = new stdClass();
    $node->type = $this->bundle();
    $node->changed = REQUEST_TIME;
    $node->created = REQUEST_TIME;
    $node->language = LANGUAGE_NONE;
    $node->is_new = TRUE;
    node_object_prepare($node);
    // Populate properties that are set by node_object_prepare().
    $node->log = 'Created by FeedsNodeProcessor';
    $node->uid = $this->config['author'];
    return $node;
  }

  /**
   * Loads an existing node.
   *
   * If the update existing method is not FEEDS_UPDATE_EXISTING, only the node
   * table will be loaded, foregoing the node_load API for better performance.
   *
   * @todo Reevaluate the use of node_object_prepare().
   */
  protected function entityLoad(FeedsSource $source, $nid) {
    $node = parent::entityLoad($source, $nid);

    if ($this->config['update_existing'] != FEEDS_UPDATE_EXISTING) {
      $node->uid = $this->config['author'];
    }

    node_object_prepare($node);

    // Workaround for issue #1247506. See #1245094 for backstory.
    if (!empty($node->menu)) {
      // If the node has a menu item(with a valid mlid) it must be flagged
      // 'enabled'.
      $node->menu['enabled'] = (int) (bool) $node->menu['mlid'];
    }

    // Populate properties that are set by node_object_prepare().
    if ($this->config['update_existing'] == FEEDS_UPDATE_EXISTING) {
      $node->log = 'Updated by FeedsNodeProcessor';
    }
    else {
      $node->log = 'Replaced by FeedsNodeProcessor';
    }
    return $node;
  }

  /**
   * Check that the user has permission to save a node.
   */
  protected function entitySaveAccess($entity) {

    // The check will be skipped for anonymous nodes.
    if ($this->config['authorize'] && !empty($entity->uid)) {

      $author = user_load($entity->uid);

      // If the uid was mapped directly, rather than by email or username, it
      // could be invalid.
      if (!$author) {
        throw new FeedsAccessException(t('User %uid is not a valid user.', array('%uid' => $entity->uid)));
      }

      if (empty($entity->nid) || !empty($entity->is_new)) {
        $op = 'create';
        $access = node_access($op, $entity->type, $author);
      }
      else {
        $op = 'update';
        $access = node_access($op, $entity, $author);
      }

      if (!$access) {
        throw new FeedsAccessException(
            t('User %name is not authorized to %op content type %content_type.',
                array(
                  '%name' => $author->name,
                  '%op' => $op,
                  '%content_type' => $entity->type)
                )
            );
      }
    }
  }

  /**
   * Validates a node.
   */
  protected function entityValidate($entity) {
    if (!isset($entity->uid) || !is_numeric($entity->uid)) {
      $entity->uid = $this->config['author'];
    }
  }

  /**
   * Save a node.
   */
  public function entitySave($entity) {
    node_save($entity);
  }

  /**
   * Delete a series of nodes.
   */
  protected function entityDeleteMultiple($nids) {
    node_delete_multiple($nids);
  }

  /**
   * Implement expire().
   *
   * @todo: move to processor stage?
   */
  public function expire($time = NULL) {
    if ($time === NULL) {
      $time = $this->expiryTime();
    }
    if ($time == FEEDS_EXPIRE_NEVER) {
      return;
    }
    $count = $this->getLimit();
    $nodes = db_query_range("SELECT n.nid FROM {node} n JOIN {feeds_item} fi ON fi.entity_type = 'node' AND n.nid = fi.entity_id WHERE fi.id = :id AND n.created < :created", 0, $count, array(':id' => $this->id, ':created' => REQUEST_TIME - $time));
    $nids = array();
    foreach ($nodes as $node) {
      $nids[$node->nid] = $node->nid;
    }
    $this->entityDeleteMultiple($nids);
    if (db_query_range("SELECT 1 FROM {node} n JOIN {feeds_item} fi ON fi.entity_type = 'node' AND n.nid = fi.entity_id WHERE fi.id = :id AND n.created < :created", 0, 1, array(':id' => $this->id, ':created' => REQUEST_TIME - $time))->fetchField()) {
      return FEEDS_BATCH_ACTIVE;
    }
    return FEEDS_BATCH_COMPLETE;
  }

  /**
   * Return expiry time.
   */
  public function expiryTime() {
    return $this->config['expire'];
  }

  /**
   * Override parent::configDefaults().
   */
  public function configDefaults() {
    return array(
      'expire' => FEEDS_EXPIRE_NEVER,
      'author' => 0,
      'authorize' => TRUE,
    ) + parent::configDefaults();
  }

  /**
   * Override parent::configForm().
   */
  public function configForm(&$form_state) {
    $form = parent::configForm($form_state);

    $author = user_load($this->config['author']);
    $form['author'] = array(
      '#type' => 'textfield',
      '#title' => t('Author'),
      '#description' => t('Select the author of the nodes to be created - leave empty to assign "anonymous".'),
      '#autocomplete_path' => 'user/autocomplete',
      '#default_value' => empty($author->name) ? 'anonymous' : check_plain($author->name),
    );
    $form['authorize'] = array(
      '#type' => 'checkbox',
      '#title' => t('Authorize'),
      '#description' => t('Check that the author has permission to create the node.'),
      '#default_value' => $this->config['authorize'],
    );
    $period = drupal_map_assoc(
        array(FEEDS_EXPIRE_NEVER, 3600, 10800, 21600, 43200,
          86400, 259200, 604800, 2592000, 2592000 * 3,
          2592000 * 6, 31536000),
        'feeds_format_expire'
        );
    $form['expire'] = array(
      '#type' => 'select',
      '#title' => t('Expire nodes'),
      '#options' => $period,
      '#description' => t("Select after how much time nodes should be deleted. The node's published date will be used for determining the node's age, see Mapping settings."),
      '#default_value' => $this->config['expire'],
    );
    return $form;
  }

  /**
   * Override parent::configFormValidate().
   */
  public function configFormValidate(&$values) {
    if ($author = user_load_by_name($values['author'])) {
      $values['author'] = $author->uid;
    }
    else {
      $values['author'] = 0;
    }
  }

  /**
   * Reschedule if expiry time changes.
   */
  public function configFormSubmit(&$values) {
    if ($this->config['expire'] != $values['expire']) {
      feeds_reschedule($this->id);
    }
    parent::configFormSubmit($values);
  }

  /**
   * Override setTargetElement to operate on a target item that is a node.
   */
  public function setTargetElement(FeedsSource $source, $target_node, $target_element, $value) {
    switch ($target_element) {
      case 'created':
        $target_node->created = feeds_to_unixtime($value, REQUEST_TIME);
        break;

      case 'feeds_source':
        // Get the class of the feed node importer's fetcher and set the source
        // property. See feeds_node_update() how $node->feeds gets stored.
        if ($id = feeds_get_importer_id($this->bundle())) {
          $class = get_class(feeds_importer($id)->fetcher);
          $target_node->feeds[$class]['source'] = $value;
          // This effectively suppresses 'import on submission' feature.
          // See feeds_node_insert().
          $target_node->feeds['suppress_import'] = TRUE;
        }
        break;

      case 'user_name':
        if ($user = user_load_by_name($value)) {
          $target_node->uid = $user->uid;
        }
        break;

      case 'user_mail':
        if ($user = user_load_by_mail($value)) {
          $target_node->uid = $user->uid;
        }
        break;

      default:
        parent::setTargetElement($source, $target_node, $target_element, $value);
        break;

    }
  }

  /**
   * Return available mapping targets.
   */
  public function getMappingTargets() {
    $type = node_type_get_type($this->bundle());

    $targets = parent::getMappingTargets();
    if ($type && $type->has_title) {
      $targets['title'] = array(
        'name' => t('Title'),
        'description' => t('The title of the node.'),
        'optional_unique' => TRUE,
      );
    }
    $targets['nid'] = array(
      'name' => t('Node ID'),
      'description' => t('The nid of the node. NOTE: use this feature with care, node ids are usually assigned by Drupal.'),
      'optional_unique' => TRUE,
    );
    $targets['uid'] = array(
      'name' => t('User ID'),
      'description' => t('The Drupal user ID of the node author.'),
    );
    $targets['user_name'] = array(
      'name' => t('Username'),
      'description' => t('The Drupal username of the node author.'),
    );
    $targets['user_mail'] = array(
      'name' => t('User email'),
      'description' => t('The email address of the node author.'),
    );
    $targets['status'] = array(
      'name' => t('Published status'),
      'description' => t('Whether a node is published or not. 1 stands for published, 0 for not published.'),
    );
    $targets['created'] = array(
      'name' => t('Published date'),
      'description' => t('The UNIX time when a node has been published.'),
    );
    $targets['promote'] = array(
      'name' => t('Promoted to front page'),
      'description' => t('Boolean value, whether or not node is promoted to front page. (1 = promoted, 0 = not promoted)'),
    );
    $targets['sticky'] = array(
      'name' => t('Sticky'),
      'description' => t('Boolean value, whether or not node is sticky at top of lists. (1 = sticky, 0 = not sticky)'),
    );

    // Include language field if Locale module is enabled.
    if (module_exists('locale')) {
      $targets['language'] = array(
        'name' => t('Language'),
        'description' => t('The two-character language code of the node.'),
      );
    }

    // Include comment field if Comment module is enabled.
    if (module_exists('comment')) {
      $targets['comment'] = array(
        'name' => t('Comments'),
        'description' => t('Whether comments are allowed on this node: 0 = no, 1 = read only, 2 = read/write.'),
      );
    }

    // If the target content type is a Feed node, expose its source field.
    if ($id = feeds_get_importer_id($this->bundle())) {
      $name = feeds_importer($id)->config['name'];
      $targets['feeds_source'] = array(
        'name' => t('Feed source'),
        'description' => t('The content type created by this processor is a Feed Node, it represents a source itself. Depending on the fetcher selected on the importer "@importer", this field is expected to be for example a URL or a path to a file.', array('@importer' => $name)),
        'optional_unique' => TRUE,
      );
    }

    // Let other modules expose mapping targets.
    self::loadMappers();
    $entity_type = $this->entityType();
    $bundle = $this->bundle();
    drupal_alter('feeds_processor_targets', $targets, $entity_type, $bundle);

    return $targets;
  }

  /**
   * Get nid of an existing feed item node if available.
   */
  protected function existingEntityId(FeedsSource $source, FeedsParserResult $result) {
    $query = db_select('feeds_item')
        ->fields('feeds_item', array('entity_id'))
        ->condition('entity_type', $this->entityType())
        ->condition('id', $source->id);

    // Iterate through all unique targets and test whether they do already
    // exist in the database.
    foreach ($this->uniqueTargets($source, $result) as $target => $value) {
      switch ($target) {
        case 'url':
          $nid = $query->condition('url', $value)->execute()->fetchField();
          break;

        case 'guid':
          $nid = $query->condition('guid', $value)->execute()->fetchField();
          break;

      }
    }
    if (isset($nid)) {
      // Return with the content id found.
      return $nid;
    }

    // Iterate through all unique targets and test whether they do already
    // exist in the database.
    foreach ($this->uniqueTargets($source, $result) as $target => $value) {
      switch ($target) {
        case 'nid':
          $nid = db_query("SELECT nid FROM {node} WHERE nid = :nid", array(':nid' => $value))->fetchField();
          break;

        case 'title':
          $nid = db_query("SELECT nid FROM {node} WHERE title = :title AND type = :type", array(':title' => $value, ':type' => $this->bundle()))->fetchField();
          break;

        case 'feeds_source':
          if ($id = feeds_get_importer_id($this->bundle())) {
            $nid = db_query("SELECT fs.feed_nid FROM {node} n JOIN {feeds_source} fs ON n.nid = fs.feed_nid WHERE fs.id = :id AND fs.source = :source", array(':id' => $id, ':source' => $value))->fetchField();
          }
          break;

      }
      if ($nid) {
        // Return with the first nid found.
        return $nid;
      }
    }
    return 0;
  }

  /**
   * Execute mapping on an item.
   *
   * This method encapsulates the central mapping functionality. When an item is
   * processed, it is passed through map() where the properties of $source_item
   * are mapped onto $target_item following the processor's mapping
   * configuration.
   *
   * For each mapping FeedsParser::getSourceElement() is executed to retrieve
   * the source element, then FeedsProcessor::setTargetElement() is invoked
   * to populate the target item properly. Alternatively a
   * hook_x_targets_alter() may have specified a callback for a mapping target
   * in which case the callback is asked to populate the target item instead of
   * FeedsProcessor::setTargetElement().
   *
   * @ingroup mappingapi
   *
   * @see hook_feeds_parser_sources_alter()
   * @see hook_feeds_data_processor_targets_alter()
   * @see hook_feeds_node_processor_targets_alter()
   * @see hook_feeds_term_processor_targets_alter()
   * @see hook_feeds_user_processor_targets_alter()
   */
  protected function map(FeedsSource $source, FeedsParserResult $result, $target_item = NULL) {
    // !!! THIS METHOD OVERRIDES DEFAULT ONE.
    // @TODO: To be removed when Feed modules is updated.
    // Probably we will have to replace or remove it, when the settings
    // will be available per field.
    // Static cache $targets as getMappingTargets() may be an expensive method.
    static $sources;
    if (!isset($sources[$this->id])) {
      $sources[$this->id] = feeds_importer($this->id)->parser->getMappingSources();
    }
    static $targets;
    if (!isset($targets[$this->id])) {
      $targets[$this->id] = $this->getMappingTargets();
    }
    $parser = feeds_importer($this->id)->parser;
    if (empty($target_item)) {
      $target_item = array();
    }

    // If value is empty or NULL, we override it, in th original method
    // it is not likes this.
    foreach ($this->config['mappings'] as $mapping) {
      if (isset($targets[$this->id][$mapping['target']]['real_target'])) {
//        unset($target_item->{$targets[$this->id][$mapping['target']]['real_target']});
        $target_item->{$targets[$this->id][$mapping['target']]['real_target']} = NULL;
      }
      else {
        $target_item->{$mapping['target']} = NULL;
      }
    }

    /*
    This is where the actual mapping happens: For every mapping we envoke
    the parser's getSourceElement() method to retrieve the value of the source
    element and pass it to the processor's setTargetElement() to stick it
    on the right place of the target item.

    If the mapping specifies a callback method, use the callback instead of
    setTargetElement().
    */
    self::loadMappers();
    foreach ($this->config['mappings'] as $mapping) {
      // Retrieve source element's value from parser.
      if (isset($sources[$this->id][$mapping['source']]) &&
          is_array($sources[$this->id][$mapping['source']]) &&
          isset($sources[$this->id][$mapping['source']]['callback']) &&
          function_exists($sources[$this->id][$mapping['source']]['callback'])) {
        $callback = $sources[$this->id][$mapping['source']]['callback'];
        $value = $callback($source, $result, $mapping['source']);
      }
      else {
        $value = $parser->getSourceElement($source, $result, $mapping['source']);
      }

      // Map the source element's value to the target.
      if (isset($targets[$this->id][$mapping['target']]) &&
          is_array($targets[$this->id][$mapping['target']]) &&
          isset($targets[$this->id][$mapping['target']]['callback']) &&
          function_exists($targets[$this->id][$mapping['target']]['callback'])) {
        $callback = $targets[$this->id][$mapping['target']]['callback'];
        $callback($source, $target_item, $mapping['target'], $value, $mapping);
      }
      else {
        $this->setTargetElement($source, $target_item, $mapping['target'], $value, $mapping);
      }
    }
    return $target_item;
  }

}