<?php

/**
 * @file
 */
$export = (object) array(
  'vid' => '1',
  'uid' => '1',
  'title' => 'Title EN',
  'log' => '',
  'status' => '1',
  'comment' => '2',
  'promote' => '1',
  'sticky' => '0',
  'vuuid' => '90954ec0-8eb3-406a-8b9b-b8e9ff17589f',
  'nid' => '1',
  'type' => 'article',
  'language' => 'en',
  'created' => '1437134452',
  'changed' => '1437134487',
  'tnid' => '0',
  'translate' => '0',
  'uuid' => '4693beda-51ad-46fc-b389-07606ee9473a',
  'revision_timestamp' => '1437134487',
  'revision_uid' => '1',
  'body' => array(
    'en' => array(
      array(
        'value' => 'Body EN',
        'summary' => '',
        'format' => 'filtered_html',
        'safe_value' => "<p>Body EN</p>\n",
        'safe_summary' => '',
      ),
    ),
    'fr' => array(
      array(
        'value' => 'Body FR',
        'summary' => '',
        'format' => 'filtered_html',
        'safe_value' => "<p>Body FR</p>\n",
        'safe_summary' => '',
      ),
    ),
  ),
  'field_tags' => array(),
  'field_image' => array(),
  'title_field' => array(
    'en' => array(
      array(
        'value' => 'Title EN',
        'format' => NULL,
        'safe_value' => 'Title EN',
      ),
    ),
    'fr' => array(
      array(
        'value' => 'Title FR',
        'format' => NULL,
        'safe_value' => 'Title FR',
      ),
    ),
  ),
  'translations' => (object) array(
    'original' => 'en',
    'data' => array(
      'en' => array(
        'entity_type' => 'node',
        'entity_id' => '1',
        'revision_id' => '1',
        'language' => 'en',
        'source' => '',
        'uid' => '1',
        'status' => '1',
        'translate' => '0',
        'created' => '1437134452',
        'changed' => '1437134487',
      ),
      'fr' => array(
        'entity_type' => 'node',
        'entity_id' => '1',
        'revision_id' => '1',
        'language' => 'fr',
        'source' => 'en',
        'uid' => '1',
        'status' => '1',
        'translate' => '0',
        'created' => '1437134467',
        'changed' => '1437134467',
      ),
    ),
  ),
  'title_original' => 'Title EN',
  'entity_translation_handler_id' => 'node-eid-1-1',
  'rdf_mapping' => array(
    'field_image' => array(
      'predicates' => array(
        'og:image',
        'rdfs:seeAlso',
      ),
      'type' => 'rel',
    ),
    'field_tags' => array(
      'predicates' => array(
        'dc:subject',
      ),
      'type' => 'rel',
    ),
    'rdftype' => array(
      'sioc:Item',
      'foaf:Document',
    ),
    'title' => array(
      'predicates' => array(
        'dc:title',
      ),
    ),
    'created' => array(
      'predicates' => array(
        'dc:date',
        'dc:created',
      ),
      'datatype' => 'xsd:dateTime',
      'callback' => 'date_iso8601',
    ),
    'changed' => array(
      'predicates' => array(
        'dc:modified',
      ),
      'datatype' => 'xsd:dateTime',
      'callback' => 'date_iso8601',
    ),
    'body' => array(
      'predicates' => array(
        'content:encoded',
      ),
    ),
    'uid' => array(
      'predicates' => array(
        'sioc:has_creator',
      ),
      'type' => 'rel',
    ),
    'name' => array(
      'predicates' => array(
        'foaf:name',
      ),
    ),
    'comment_count' => array(
      'predicates' => array(
        'sioc:num_replies',
      ),
      'datatype' => 'xsd:integer',
    ),
    'last_activity' => array(
      'predicates' => array(
        'sioc:last_activity_date',
      ),
      'datatype' => 'xsd:dateTime',
      'callback' => 'date_iso8601',
    ),
  ),
  'cid' => '0',
  'last_comment_timestamp' => '1437134452',
  'last_comment_name' => NULL,
  'last_comment_uid' => '1',
  'comment_count' => '0',
  'name' => 'admin',
  'picture' => '0',
  'data' => 'b:0;',
  'path' => FALSE,
  'menu' => NULL,
  'node_export_drupal_version' => '7',
);
