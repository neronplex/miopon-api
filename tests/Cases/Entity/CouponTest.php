<?php
namespace Neronplex\MioponApi\Test\Cases\Entity;

use Neronplex\MioponApi\Entity\Coupon;
use Neronplex\MioponApi\Entity\Detail\Coupon as CouponDetail;
use Neronplex\MioponApi\Entity\Info\Coupon as CouponInfo;
use Neronplex\MioponApi\Entity\Info\Detail\Hdo\Coupon as HdoCoupon;
use Neronplex\MioponApi\Entity\Info\Detail\Hdu\Coupon as HduCoupon;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Class CouponTest
 * Coupon Entityのユニットテストを行う
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Test\Cases\Entity
 * @since     0.0.1
 */
class CouponTest extends TestCase
{
    /**
     * @var Coupon
     */
    protected $entity = null;

    /**
     * @var CouponInfo
     */
    protected $couponInfo = null;

    public function setUp()
    {
        parent::setUp();

        $this->entity = new Coupon(
            json_decode('{
                "couponInfo": [
                    {
                        "coupon": [
                            {
                                "expire": "201704",
                                "type": "bundle",
                                "volume": 3420
                            },
                            {
                                "expire": "201705",
                                "type": "bundle",
                                "volume": 6000
                            },
                            {
                                "expire": "201704",
                                "type": "topup",
                                "volume": 0
                            },
                            {
                                "expire": "201705",
                                "type": "topup",
                                "volume": 0
                            },
                            {
                                "expire": "201706",
                                "type": "topup",
                                "volume": 0
                            },
                            {
                                "expire": "201707",
                                "type": "topup",
                                "volume": 0
                            }
                        ],
                        "hddServiceCode": "hdd01234567890",
                        "hdoInfo": [
                            {
                                "coupon": [
                                    {
                                        "expire": null,
                                        "type": "sim",
                                        "volume": 10
                                    }
                                ],
                                "couponUse": true,
                                "hdoServiceCode": "hdo01234567890",
                                "iccid": "TEST01234567890",
                                "number": "09000000000",
                                "regulation": false,
                                "sms": true,
                                "voice": true
                            }
                        ],
                        "hduInfo": [
                            {
                                "coupon": [
                                    {
                                        "expire": null,
                                        "type": "sim",
                                        "volume": 7
                                    }
                                ],
                                "couponUse": true,
                                "hduServiceCode": "hdu01234567890",
                                "iccid": "TEST09876543210",
                                "number": "07000000000",
                                "regulation": false,
                                "sms": true,
                                "voice": true
                            }
                        ],
                        "plan": "Light Start"
                    }
                ],
                "returnCode": "OK"
            }'),
            200
        );

        $this->couponInfo = $this->entity->couponInfo('hdd01234567890');
    }

    /**
     * 期待通りにリクエストが正常終了していると判定できるかテストする
     *
     * @return void
     */
    public function testReturn()
    {
        $this->assertEquals(200, $this->entity->statusCode());
        $this->assertEquals('OK', $this->entity->returnCode());
    }

    /**
     * 期待通りにCouponInfoを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetCouponInfoAll()
    {
        $coupon = $this->entity->couponInfo();
        $this->assertTrue(array_walk(
            $coupon,
            function ($v) {
                $this->assertInstanceOf(CouponInfo::class, $v);
            }
        ));
    }

    /**
     * 期待通りに契約プランの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testCouponInfo()
    {
        $this->assertInstanceOf(CouponInfo::class, $this->couponInfo);
        $this->assertEquals('hdd01234567890', $this->couponInfo->hddServiceCode());
        $this->assertEquals('Light Start', $this->couponInfo->plan());
        $this->assertTrue($this->couponInfo->isLightStart());
    }

    /**
     * 期待通りにHdoCouponを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHdoInfoAll()
    {
        $hdoinfo = $this->couponInfo->hdoInfo();
        $this->assertTrue(array_walk(
            $hdoinfo,
            function ($v) {
                $this->assertInstanceOf(HdoCoupon::class, $v);
            }
        ));
    }

    /**
     * 期待通りにHdoInfoからSIMカードの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHdoInfo()
    {
        $hdoinfo = $this->couponInfo->hdoInfo('hdo01234567890');

        $this->assertEquals('hdo01234567890', $hdoinfo->hdoServiceCode());
        $this->assertEquals('09000000000', $hdoinfo->number());
        $this->assertEquals('TEST01234567890', $hdoinfo->iccid());
        $this->assertFalse($hdoinfo->regulation());
        $this->assertTrue($hdoinfo->sms());
        $this->assertTrue($hdoinfo->voice());
        $this->assertTrue($hdoinfo->couponUse());
    }

    /**
     * 期待通りにHduCouponを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHduInfoAll()
    {
        $hdoinfo = $this->couponInfo->hduInfo();
        $this->assertTrue(array_walk(
            $hdoinfo,
            function ($v) {
                $this->assertInstanceOf(HduCoupon::class, $v);
            }
        ));
    }

    /**
     * 期待通りにHduInfoからSIMカードの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHduInfo()
    {
        $hduinfo = $this->couponInfo->hduInfo('hdu01234567890');

        $this->assertEquals('hdu01234567890', $hduinfo->hduServiceCode());
        $this->assertEquals('07000000000', $hduinfo->number());
        $this->assertEquals('TEST09876543210', $hduinfo->iccid());
        $this->assertFalse($hduinfo->regulation());
        $this->assertTrue($hduinfo->sms());
        $this->assertTrue($hduinfo->voice());
        $this->assertTrue($hduinfo->couponUse());
    }

    /**
     * 期待通りにHdoInfoからSIM内クーポンの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHdoSimCouponDetail()
    {
        $hdoinfo = $this->couponInfo->hdoInfo('hdo01234567890');
        $coupon = $hdoinfo->coupon();

        $this->assertInstanceOf(CouponDetail::class, $coupon);
        $this->assertNull($coupon->expire());
        $this->assertEquals(10, $coupon->volume());
        $this->assertEquals('sim', $coupon->type());
        $this->assertFalse($coupon->isBundle());
        $this->assertFalse($coupon->isTopup());
        $this->assertTrue($coupon->isSim());
    }

    /**
     * 期待通りにHduInfoからSIM内クーポンの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHduSimCouponDetail()
    {
        $hdoinfo = $this->couponInfo->hduInfo('hdu01234567890');
        $coupon = $hdoinfo->coupon();

        $this->assertInstanceOf(CouponDetail::class, $coupon);
        $this->assertNull($coupon->expire());
        $this->assertEquals(7, $coupon->volume());
        $this->assertEquals('sim', $coupon->type());
        $this->assertFalse($coupon->isBundle());
        $this->assertFalse($coupon->isTopup());
        $this->assertTrue($coupon->isSim());
    }

    /**
     * 期待通りに使用するInfoClassのクラス名を取得できるかテストする
     *
     * @return void
     */
    public function testInfoClassName()
    {
        $method = new ReflectionMethod($this->couponInfo, 'infoClassName');
        $method->setAccessible(true);

        $this->assertEquals('Coupon', $method->invoke($this->couponInfo));
    }

    /**
     * 期待通りにCouponDetailを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetCouponAll()
    {
        $coupon = $this->couponInfo->coupon();

        $this->assertTrue(array_walk(
            $coupon,
            function ($v) {
                $this->assertInstanceOf(CouponDetail::class, $v);
            }
        ));
    }

    /**
     * 期待通りにクーポンの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testCouponDetail()
    {
        /**
         * @var CouponDetail
         */
        $coupon = $this->couponInfo->coupon('201704');

        $this->assertEquals('201704', $coupon->expire());
        $this->assertEquals(3420, $coupon->volume());
        $this->assertEquals('bundle', $coupon->type());
        $this->assertTrue($coupon->isBundle());
        $this->assertFalse($coupon->isTopup());
        $this->assertFalse($coupon->isSim());
    }
}
