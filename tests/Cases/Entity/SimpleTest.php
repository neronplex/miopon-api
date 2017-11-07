<?php
namespace Neronplex\MioponApi\Test\Cases\Entity;

use Neronplex\MioponApi\Entity\Simple;
use PHPUnit\Framework\TestCase;

/**
 * Class SimpleTest
 * Simple Entityのユニットテスト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Test\Cases\Entity
 * @since     0.0.1
 */
class SimpleTest extends TestCase
{
    /**
     * @var Simple
     */
    protected $entity = null;

    /**
     * Entityのセットアップを行う
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->entity = new Simple(
            json_decode('{"returnCode": "OK"}'),
            200
        );
    }

    /**
     * 期待通りにリクエストが成功していると判定できるかテストする
     *
     * @return void
     */
    public function testIsSuccess()
    {
        $this->assertTrue($this->entity->isSuccess());
    }

    /**
     * 期待通りにリターンコードが取得できるかテストする
     *
     * @return void
     */
    public function testReturnCode()
    {
        $this->assertEquals('OK', $this->entity->returnCode());
    }

    /**
     * 期待通りにステータスコードを取得できるかテストする
     *
     * @return void
     */
    public function testStatusCode()
    {
        $this->assertEquals(200, $this->entity->statusCode());
    }
}
