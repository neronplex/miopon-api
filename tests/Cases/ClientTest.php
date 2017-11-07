<?php
namespace Neronplex\MioponApi\Test\Cases;

use Neronplex\MioponApi\Client;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Class ClientTest
 * Clientのユニットテスト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Test\Cases
 * @since     0.0.1
 */
class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client = null;

    /**
     * Clientオブジェクトの初期設定を行う
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = new Client();
        $this->client
            ->setDeveloperId('developerid12345678')
            ->setAccessToken('accesstoken12345678');
    }

    /**
     * 期待通りのデベロッパーIDが返却されるかテストする
     *
     * @return void
     */
    public function testGetDeveloperId()
    {
        $this->assertEquals('developerid12345678', $this->client->getDeveloperId());
    }

    /**
     * 期待通りのアクセストークンが返却されるかテストする
     *
     * @return void
     */
    public function testGetAccessToken()
    {
        $this->assertEquals('accesstoken12345678', $this->client->getAccessToken());
    }

    /**
     * 期待通りのリクエストヘッダーの配列が返却されるかテストする
     *
     * @return void
     */
    public function testHeader()
    {
        $method = new ReflectionMethod($this->client, 'header');
        $method->setAccessible(true);

        $this->assertEquals(
            [
            'X-IIJmio-Developer'     => $this->client->getDeveloperId(),
            'X-IIJmio-Authorization' => $this->client->getAccessToken()
            ],
            $method->invoke($this->client)
        );
    }

    /**
     * 期待通りにリクエストモードをセットできるかをテストする
     *
     * @return void
     */
    public function testSetMode()
    {
        $property = new ReflectionProperty($this->client, 'mode');
        $property->setAccessible(true);

        $this->assertEquals('coupon', $property->getValue($this->client->setMode('coupon')));
        $this->assertEquals('packet', $property->getValue($this->client->setMode('packet')));
        $this->assertEquals('toggle', $property->getValue($this->client->setMode('toggle')));
    }

    /**
     * 期待通りにクーポンスイッチのオーダーを登録できるかテストする
     *
     * @return void
     */
    public function testSetToggleOrder()
    {
        $client = clone $this->client;

        $client->setToggleOrder([
            'hdo12345678' => true,
            'hdo98765432' => false,
            'hdu12345678' => true,
            'hdu98765432' => false
        ]);

        $this->assertEquals(
            [
                'hdo12345678' => true,
                'hdo98765432' => false,
                'hdu12345678' => true,
                'hdu98765432' => false
            ],
            $client->getToggleOrder()
        );
    }

    /**
     * 期待通りに指定したサービスコードのスイッチオーダーを取ってこれるかテストする
     *
     * @return void
     */
    public function testSearchToggleOrder()
    {
        $client = clone $this->client;

        $client->setToggleOrder([
            'hdo12345678' => true,
            'hdo98765432' => false,
            'hdu12345678' => true,
            'hdu98765432' => false
        ]);

        $method = new ReflectionMethod($client, 'searchToggleOrder');
        $method->setAccessible(true);

        $this->assertEquals(2, count($method->invoke($client, 'hdo')));
        $this->assertEquals(2, count($method->invoke($client, 'hdu')));
    }
}
