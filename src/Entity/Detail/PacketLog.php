<?php
namespace Neronplex\MioponApi\Entity\Detail;

use stdClass;

/**
 * Class PacketLog
 * データ通信量の詳細情報を格納するオブジェクト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Detail
 * @since     0.0.1
 */
class PacketLog
{
    /**
     * 通信を行った日
     *
     * @var string YYYYMMDD
     */
    protected $date = null;

    /**
     * クーポン使用状態でのデータ通信量
     *
     * @var int MB単位
     */
    protected $withCoupon = null;

    /**
     * クーポン未使用状態でのデータ通信量
     *
     * @var int MB単位
     */
    protected $withoutCoupon = null;

    /**
     * PacketLog constructor.
     *
     * @param stdClass $detail
     */
    public function __construct(stdClass $detail)
    {
        $this->date          = $detail->date;
        $this->withCoupon    = $detail->withCoupon;
        $this->withoutCoupon = $detail->withoutCoupon;
    }

    /**
     * 通信を行った日を返す
     *
     * @return string
     */
    public function date(): string
    {
        return $this->date;
    }

    /**
     * クーポン使用状態でのデータ通信量を返す
     *
     * @return int
     */
    public function withCoupon(): int
    {
        return $this->withCoupon;
    }

    /**
     * クーポン未使用状態でのデータ通信量を返す
     *
     * @return int
     */
    public function withoutCoupon(): int
    {
        return $this->withoutCoupon;
    }
}
