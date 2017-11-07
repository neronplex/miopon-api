<?php
namespace Neronplex\MioponApi\Entity\Info\Detail;

use Neronplex\MioponApi\Entity\Detail\Coupon as CouponDetail;
use stdClass;

/**
 * Class CouponBase
 * クーポン残量照会・オンオフ状態確認リクエストの詳細情報を格納する基底クラス
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info\Detail
 * @since     0.0.1
 */
abstract class CouponBase
{
    /**
     * 回線の電話番号
     *
     * @var string
     */
    protected $number = null;

    /**
     * 回線のICCID
     *
     * @var string
     */
    protected $iccid = null;

    /**
     * 通信規制中かどうか
     *
     * @var bool
     */
    protected $regulation = null;

    /**
     * SMS機能付きかどうか
     *
     * @var bool
     */
    protected $sms = null;

    /**
     * 音声通話機能付きかどうか
     *
     * @var bool
     */
    protected $voice = null;

    /**
     * クーポン使用中かどうか
     *
     * @var bool
     */
    protected $couponUse = null;

    /**
     * SIM内クーポン
     *
     * @var CouponDetail[]
     */
    protected $coupon = null;

    /**
     * 非共通部分のデータ設定処理を実装する
     *
     * @param  stdClass $info
     * @return void
     */
    abstract protected function set(stdClass $info);

    /**
     * CouponBase constructor.
     * @param stdClass $info
     */
    public function __construct(stdClass $info)
    {
        $this->number     = $info->number;
        $this->iccid      = $info->iccid;
        $this->regulation = $info->regulation;
        $this->sms        = $info->sms;
        $this->voice      = $info->voice;
        $this->couponUse  = $info->couponUse;

        if (!empty($info->coupon))
        {
            $this->coupon     = array_map(
                function ($v) {
                    return new CouponDetail($v);
                },
                $info->coupon
            );
        }

        $this->set($info);
    }

    /**
     * 回線の電話番号を取得する
     *
     * @return string
     */
    public function number(): string
    {
        return $this->number;
    }

    /**
     * 回線のICCIDを取得する
     *
     * @return string
     */
    public function iccid(): string
    {
        return $this->iccid;
    }

    /**
     * 通信規制中か返す
     *
     * @return bool
     */
    public function regulation(): bool
    {
        return $this->regulation;
    }

    /**
     * SMS機能付きか返す
     *
     * @return bool
     */
    public function sms(): bool
    {
        return $this->sms;
    }

    /**
     * 音声通話機能付きか返す
     *
     * @return bool
     */
    public function voice(): bool
    {
        return $this->voice;
    }

    /**
     * クーポン使用中かどうかを返す
     *
     * @return bool
     */
    public function couponUse(): bool
    {
        return $this->couponUse;
    }

    /**
     * SIM内クーポンの情報を取得する
     *
     * @return CouponDetail
     */
    public function coupon(): CouponDetail
    {
        return current($this->coupon);
    }
}
