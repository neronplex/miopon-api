<?php
namespace Neronplex\MioponApi\Test\Cases\Entity;

use Neronplex\MioponApi\Entity\Coupon;
use Neronplex\MioponApi\Entity\Detail\History as HistoryDetail;
use Neronplex\MioponApi\Entity\Info\Coupon as CouponInfo;
use Neronplex\MioponApi\Entity\Info\Detail\Hdu\Coupon as HduCoupon;
use PHPUnit\Framework\TestCase;

/**
 * Class EcoCouponTest
 * Coupon Entity（エコプラン契約時）のユニットテストを行う
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Test\Cases\Entity
 * @since     0.0.1
 */
class EcoCouponTest extends TestCase
{
    /**
     * @var Coupon
     */
    protected $entity = null;

    /**
     * @var CouponInfo
     */
    protected $couponInfo = null;

    /**
     * Entityのセットアップを行う
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->entity = new Coupon(
            json_decode('{
                "returnCode" : "OK",
                "couponInfo" : [
                    {
                        "hddServiceCode": "hddXXXXXXXX",
                        "plan" : "Eco Minimum",
                        "hduInfo" : [
                            {
                                "hduServiceCode": "hduXXXXXXXX",
                                "number": "080XXXXXXXX",
                                "iccid": "XXXXXXXXXXXXXXXXXXX",
                                "regulation": true,
                                "sms": true,
                                "voice": true,
                                "couponUse": true
                            }
                       ],
                       "history": [
                          {"date": "20170101", "event": "add", "volume": 3000, "type": "bundle"},
                          {"date": "20170105", "event": "add", "volume": 1000, "type": "topup"}
                       ],
                       "remains": 50000
                    }
                ]
            }'),
            200
        );

        $this->couponInfo = $this->entity->couponInfo('hddXXXXXXXX');
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
        $this->assertEquals('hddXXXXXXXX', $this->couponInfo->hddServiceCode());
        $this->assertEquals('Eco Minimum', $this->couponInfo->plan());
        $this->assertEquals(50000, $this->couponInfo->remains());
        $this->assertTrue($this->couponInfo->isEcoMinimum());
        $this->assertTrue($this->couponInfo->isEcoPlan());
        $this->assertFalse($this->couponInfo->isStandardPlan());
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
        $hduinfo = $this->couponInfo->hduInfo('hduXXXXXXXX');

        $this->assertEquals('hduXXXXXXXX', $hduinfo->hduServiceCode());
        $this->assertEquals('080XXXXXXXX', $hduinfo->number());
        $this->assertEquals('XXXXXXXXXXXXXXXXXXX', $hduinfo->iccid());
        $this->assertTrue($hduinfo->regulation());
        $this->assertTrue($hduinfo->sms());
        $this->assertTrue($hduinfo->voice());
        $this->assertTrue($hduinfo->couponUse());
    }

    /**
     * 期待通りにCouponInfoからHistoryDetailを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHistoryAll()
    {
        $coupon = $this->couponInfo->history();

        $this->assertTrue(array_walk(
            $coupon,
            function ($v) {
                $this->assertInstanceOf(HistoryDetail::class, $v);
            }
        ));
    }

    /**
     * 期待通りにクーポン上限値変更履歴の詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHistoryDetail()
    {
        /**
         * @var HistoryDetail
         */
        $history = $this->couponInfo->history('20170101');

        $this->assertEquals('20170101', $history->date());
        $this->assertEquals('add', $history->event());
        $this->assertEquals(3000, $history->volume());
        $this->assertEquals('bundle', $history->type());
        $this->assertTrue($history->isBundle());
        $this->assertFalse($history->isTopup());
    }
}
