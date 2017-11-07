<?php
namespace Neronplex\MioponApi\Test\Cases\Entity;

use Neronplex\MioponApi\Entity\Detail\PacketLog as PacketLogDetail;
use Neronplex\MioponApi\Entity\Info\Detail\Hdo\Packet as HdoPacket;
use Neronplex\MioponApi\Entity\Info\Detail\Hdu\Packet as HduPacket;
use Neronplex\MioponApi\Entity\Info\PacketLog;
use Neronplex\MioponApi\Entity\Packet;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Class PacketTest
 * Packet Entityのユニットテストを行う
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Test\Cases\Entity
 * @since     0.0.1
 */
class PacketTest extends TestCase
{
    /**
     * @var Packet
     */
    protected $entity = null;

    /**
     * @var PacketLog
     */
    protected $packetLogInfo = null;

    /**
     * Entityのセットアップを行う
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->entity = new Packet(
            json_decode('{
                "packetLogInfo": [
                    {
                        "hddServiceCode": "hdd01234567890",
                        "hdoInfo": [
                            {
                                "hdoServiceCode": "hdo01234567890",
                                "packetLog": [
                                    {
                                        "date": "20170312",
                                        "withCoupon": 2,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170313",
                                        "withCoupon": 207,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170314",
                                        "withCoupon": 23,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170315",
                                        "withCoupon": 24,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170316",
                                        "withCoupon": 298,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170317",
                                        "withCoupon": 275,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170318",
                                        "withCoupon": 1,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170319",
                                        "withCoupon": 9,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170320",
                                        "withCoupon": 172,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170321",
                                        "withCoupon": 130,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170322",
                                        "withCoupon": 392,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170323",
                                        "withCoupon": 184,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170324",
                                        "withCoupon": 178,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170325",
                                        "withCoupon": 18,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170326",
                                        "withCoupon": 9,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170327",
                                        "withCoupon": 58,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170328",
                                        "withCoupon": 201,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170329",
                                        "withCoupon": 40,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170330",
                                        "withCoupon": 74,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170331",
                                        "withCoupon": 129,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170401",
                                        "withCoupon": 102,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170402",
                                        "withCoupon": 197,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170403",
                                        "withCoupon": 336,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170404",
                                        "withCoupon": 251,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170405",
                                        "withCoupon": 431,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170406",
                                        "withCoupon": 335,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170407",
                                        "withCoupon": 323,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170408",
                                        "withCoupon": 1,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170409",
                                        "withCoupon": 1,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170410",
                                        "withCoupon": 276,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170411",
                                        "withCoupon": 334,
                                        "withoutCoupon": 0
                                    }
                                ]
                            }
                        ],
                        "hduInfo": [
                            {
                                "hduServiceCode": "hdu01234567890",
                                "packetLog": [
                                    {
                                        "date": "20170312",
                                        "withCoupon": 2,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170313",
                                        "withCoupon": 207,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170314",
                                        "withCoupon": 23,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170315",
                                        "withCoupon": 24,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170316",
                                        "withCoupon": 298,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170317",
                                        "withCoupon": 275,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170318",
                                        "withCoupon": 1,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170319",
                                        "withCoupon": 9,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170320",
                                        "withCoupon": 172,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170321",
                                        "withCoupon": 130,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170322",
                                        "withCoupon": 392,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170323",
                                        "withCoupon": 184,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170324",
                                        "withCoupon": 178,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170325",
                                        "withCoupon": 18,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170326",
                                        "withCoupon": 9,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170327",
                                        "withCoupon": 58,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170328",
                                        "withCoupon": 201,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170329",
                                        "withCoupon": 40,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170330",
                                        "withCoupon": 74,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170331",
                                        "withCoupon": 129,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170401",
                                        "withCoupon": 102,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170402",
                                        "withCoupon": 197,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170403",
                                        "withCoupon": 336,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170404",
                                        "withCoupon": 251,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170405",
                                        "withCoupon": 431,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170406",
                                        "withCoupon": 335,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170407",
                                        "withCoupon": 323,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170408",
                                        "withCoupon": 1,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170409",
                                        "withCoupon": 1,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170410",
                                        "withCoupon": 276,
                                        "withoutCoupon": 0
                                    },
                                    {
                                        "date": "20170411",
                                        "withCoupon": 334,
                                        "withoutCoupon": 0
                                    }
                                ]
                            }
                        ],
                        "plan": "Light Start"
                    }
                ],
                "returnCode": "OK"
            }'),
            200
        );

        $this->packetLogInfo = $this->entity->packetLogInfo('hdd01234567890');
    }

    /**
     * 期待通りにリクエストが正常終了していると判定できるかテストする
     *
     * @return void
     */
    public function testReturn()
    {
        $this->assertEquals(200,$this->entity->statusCode());
        $this->assertEquals('OK',$this->entity->returnCode());
    }

    /**
     * 期待通りにPacketLogを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetPacketLogInfoAll()
    {
        $packet = $this->entity->packetLogInfo();
        $this->assertTrue(array_walk(
            $packet,
            function ($v) {
                $this->assertInstanceOf(PacketLog::class,$v);
            }
        ));
    }

    /**
     * 期待通りに契約プランの詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testPacketLogInfo()
    {
        $this->assertEquals('hdd01234567890',$this->packetLogInfo->hddServiceCode());
        $this->assertEquals('Light Start',$this->packetLogInfo->plan());
        $this->assertTrue($this->packetLogInfo->isLightStart());
        $this->assertFalse($this->packetLogInfo->isMinimunStart());
        $this->assertFalse($this->packetLogInfo->isFamilyShare());
        $this->assertTrue($this->packetLogInfo->isStandardPlan());
        $this->assertFalse($this->packetLogInfo->isEcoPlan());
    }

    /**
     * 期待通りにHdoPacketを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHdoInfoAll()
    {
        $hdoinfo = $this->packetLogInfo->hdoInfo();
        $this->assertTrue(array_walk(
            $hdoinfo,
            function ($v) {
                $this->assertInstanceOf(HdoPacket::class,$v);
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
        $this->assertEquals(
            'hdo01234567890',
            $this->packetLogInfo->hdoInfo('hdo01234567890')->hdoServiceCode()
        );
    }

    /**
     * 期待通りにHdoPacketからPacketLogDetailを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHdoPacketLogAll()
    {
        $packet = $this->packetLogInfo->hdoInfo('hdo01234567890')->packetLog();

        $this->assertTrue(
            array_walk(
                $packet,
                function ($v) {
                    $this->assertInstanceOf(PacketLogDetail::class,$v);
                }
            )
        );
    }

    /**
     * 期待通りにデータ利用量の詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHdoPacketLog()
    {
        /**
         * @var PacketLogDetail
         */
        $packet = $this->packetLogInfo
            ->hdoInfo('hdo01234567890')
            ->packetLog('20170401');

        $this->assertInstanceOf(PacketLogDetail::class,$packet);
        $this->assertEquals('20170401',$packet->date());
        $this->assertEquals(102,$packet->withCoupon());
        $this->assertEquals(0,$packet->withoutCoupon());
    }

    /**
     * 期待通りにHduPacketを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHduInfoAll()
    {
        $hdoinfo = $this->packetLogInfo->hduInfo();
        $this->assertTrue(array_walk(
            $hdoinfo,
            function ($v) {
                $this->assertInstanceOf(HduPacket::class,$v);
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
        $this->assertEquals(
            'hdu01234567890',
            $this->packetLogInfo->hduInfo('hdu01234567890')->hduServiceCode()
        );
    }

    /**
     * 期待通りにHduPacketからPacketLogDetailを格納した配列を取得できるかテストする
     *
     * @return void
     */
    public function testGetHduPacketLogAll()
    {
        $packet = $this->packetLogInfo->hduInfo('hdu01234567890')->packetLog();

        $this->assertTrue(
            array_walk(
                $packet,
                function ($v) {
                    $this->assertInstanceOf(PacketLogDetail::class,$v);
                }
            )
        );
    }

    /**
     * 期待通りにデータ利用量の詳細情報を取得できるかテストする
     *
     * @return void
     */
    public function testHduPacketLog()
    {
        /**
         * @var PacketLogDetail
         */
        $packet = $this->packetLogInfo
            ->hduInfo('hdu01234567890')
            ->packetLog('20170315');

        $this->assertInstanceOf(PacketLogDetail::class, $packet);
        $this->assertEquals('20170315', $packet->date());
        $this->assertEquals(24, $packet->withCoupon());
        $this->assertEquals(0, $packet->withoutCoupon());
    }

    /**
     * 期待通りに使用するInfoClassのクラス名を取得できるかテストする
     *
     * @return void
     */
    public function testInfoClassName()
    {
        $method = new ReflectionMethod($this->packetLogInfo, 'infoClassName');
        $method->setAccessible(true);

        $this->assertEquals('Packet', $method->invoke($this->packetLogInfo));
    }
}
