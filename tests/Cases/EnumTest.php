<?php
namespace Neronplex\MioponApi\Test\Cases;

use InvalidArgumentException;
use Neronplex\MioponApi\Enum;
use Neronplex\MioponApi\Test\Mocks\EnumMock;
use PHPUnit\Framework\TestCase;

/**
 * Class EnumTest
 * Enumのユニットテスト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Test\Cases
 * @since     0.0.1
 */
class EnumTest extends TestCase
{
    /**
     * 期待通りにEnumのインスタンスが生成されることをテストする
     *
     * @return void
     */
    public function testNewInstance()
    {
        $this->assertInstanceOf(Enum::class, new EnumMock('hoge'));
        $this->assertInstanceOf(Enum::class, new EnumMock('fuga'));
    }

    /**
     * 期待通りにEnumのインスタンス生成に失敗することをテストする
     *
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testNewInstanceFail()
    {
        new EnumMock('test');
    }

    /**
     * 期待通りにオブジェクトがstringキャストされるかテストする
     *
     * @return void
     */
    public function testToString()
    {
        $this->assertEquals('hoge', (string) new EnumMock('hoge'));
        $this->assertEquals('fuga', (string) new EnumMock('fuga'));
    }

    /**
     * 期待通りにstaticコールできるかテストする
     *
     * @return void
     */
    public function testCallStatic()
    {
        $this->assertEquals('hoge', EnumMock::HOGE());
        $this->assertEquals('fuga', EnumMock::FUGA());
    }

    /**
     * 期待通りにEnumの値を取得できるかテストする
     *
     * @return void
     */
    public function testValue()
    {
        $this->assertEquals('hoge', (new EnumMock('hoge'))->value());
        $this->assertEquals('fuga', (new EnumMock('fuga'))->value());
    }

    /**
     * 期待通りにEnumに定義されたconstのlistを取得できるかテストする
     *
     * @return void
     */
    public function testConstants()
    {
        $this->assertEquals(
            ['HOGE' => 'hoge', 'FUGA' => 'fuga'],
            (new EnumMock('hoge'))->constants()
        );
    }
}
