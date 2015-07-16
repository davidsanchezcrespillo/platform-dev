<?php

/**
 * @file
 * Contains \Drupal\nexteuropa_token\Tests\PlainNodeSummaryTokenHandlerTest.
 */

namespace Drupal\nexteuropa_token\Tests;

use Drupal\nexteuropa_token\PlainNodeSummaryTokenHandler;

/**
 * Class PlainNodeSummaryTokenHandlerTest.
 *
 * @package Drupal\nexteuropa_token\Tests
 */
class PlainNodeSummaryTokenHandlerTest extends TokenHandlerAbstractTest {

  /**
   * Instance of PlainNodeSummaryTokenHandlerTest.
   *
   * @var \Drupal\nexteuropa_token\PlainNodeSummaryTokenHandlerTest
   */
  protected $handler;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->handler = new PlainNodeSummaryTokenHandler();
  }

  /**
   * PlainNodeSummaryTokenHandlerTest::hookTokenInfoAlter() produces well-formed array.
   *
   * @param string $entity_type
   *    Entity type machine name.
   *
   * @dataProvider entityTypeMachineNamesProvider
   */
  public function testHookTokenInfoAlter($entity_type) {
    $data = array();
    $this->handler->hookTokenInfoAlter($data);

    $this->assertArrayHasKey('tokens', $data);
    $this->assertArrayHasKey($entity_type, $data['tokens']);
    $this->assertArrayHasKey(PlainNodeSummaryTokenHandler::TOKEN_NAME, $data['tokens'][$entity_type]);
    $this->assertArrayHasKey('name', $data['tokens'][$entity_type][PlainNodeSummaryTokenHandler::TOKEN_NAME]);
    $this->assertArrayHasKey('description', $data['tokens'][$entity_type][PlainNodeSummaryTokenHandler::TOKEN_NAME]);
  }

  /**
   * Test that nexteuropa_token_token_info_alter() actually works.
   *
   * @param string $entity_type
   *    Entity type machine name.
   *
   * @dataProvider entityTypeMachineNamesProvider
   */
  public function testAvailableTokens($entity_type) {
    $tokens = token_get_info();
    $this->assertArrayHasKey($entity_type, $tokens['tokens']);
    $this->assertArrayHasKey(PlainNodeSummaryTokenHandler::TOKEN_NAME, $tokens['tokens'][$entity_type]);
  }

  /**
   * Test PlainNodeSummaryTokenHandler::hookTokens().
   */
  public function testNodeHookTokens() {

    $type = 'node';
    $node = $this->getTestNode('testnode', 'body with token [node:plain-text-summary]');
    $tokens = array(PlainNodeSummaryTokenHandler::TOKEN_NAME => PlainNodeSummaryTokenHandler::TOKEN_NAME);
    $data = array($type => $node);

    $replacements = $this->handler->hookTokens($type, $tokens, $data);
    $this->assertArrayHasKey(PlainNodeSummaryTokenHandler::TOKEN_NAME, $replacements);

  }

  /**
   * Test hook_nexteuropa_token_token_handlers() implementation.
   */
  public function testHookHandler() {
    $handlers = module_invoke_all('nexteuropa_token_token_handlers');
    $this->assertArrayHasKey('plain_node_summary_handler', $handlers);
  }

  /**
   * Data provider: provides list of entity machine names.
   *
   * @return array
   *    Return PHPUnit data.
   */
  public static function entityTypeMachineNamesProvider() {
    return array(array('node'));
  }

}
