<?php
namespace Neronplex\MioponApi\Entity\Detail;

use Neronplex\MioponApi\Entity\Type\CouponType;
use stdClass;

/**
 * Class Coupon
 * クーポン残量の詳細情報を格納するオブジェクト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Detail
 * @since     0.0.1
 */
class Coupon
{
    /**
     * クーポン残量
     *
     * @var int MB単位
     */
    protected $volume = null;

    /**
     * クーポン有効期限
     *
     * @var string YYYYMM
     */
    protected $expire = null;

    /**
     * クーポン種別
     * (bundle / topup / sim)
     *
     * @var string
     */
    protected $type = null;

    /**
     * Coupon constructor.
     *
     * @param stdClass $detail
     */
    public function __construct(stdClass $detail)
    {
        $this->volume = $detail->volume;
        $this->expire = $detail->expire;
        $this->type   = (new CouponType($detail->type))->value();
    }

    /**
     * クーポン残量を返す
     *
     * @return int
     */
    public function volume(): int
    {
        return $this->volume;
    }

    /**
     * クーポン有効期限を返す
     *
     * @return string|null バンドルor追加クーポンの場合はstring
     *                     SIM内クーポンの場合はnull
     */
    public function expire()
    {
        return $this->expire;
    }

    /**
     * クーポン種別を返す
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * バンドルクーポンであるか判定する
     *
     * @return bool
     */
    public function isBundle(): bool
    {
        return ($this->type() === CouponType::BUNDLE);
    }

    /**
     * 追加クーポンであるか判定する
     *
     * @return bool
     */
    public function isTopup(): bool
    {
        return ($this->type() === CouponType::TOPUP);
    }

    /**
     * SIM内クーポンであるか判定する
     *
     * @return bool
     */
    public function isSim(): bool
    {
        return ($this->type() === CouponType::SIM);
    }
}
