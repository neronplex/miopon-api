<?php
namespace Neronplex\MioponApi\Entity;

use Neronplex\MioponApi\Entity\Info\Coupon as CouponInfo;
use stdClass;

/**
 * Class Coupon
 * クーポン残量照会・オンオフ状態確認リクエスト時のルートEntity
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity
 * @since     0.0.1
 */
class Coupon extends Base
{
    /**
     * 契約プランごとの情報が格納されたオブジェクト
     *
     * @var CouponInfo[]
     */
    protected $couponInfo = null;

    /**
     * 契約プランごとの詳細情報を取得する
     *
     * @param  string|null $hddServiceCode  欲しい契約プランのhddサービスコード
     * @return CouponInfo[]|CouponInfo|bool hddサービスコードが指定されていない場合はCouponInfoが格納された配列
     *                                      hddサービスコードが指定されている場合はその契約のCouponInfo
     *                                      hddサービスコードが指定されているものの見つからなかった場合はfalse
     */
    public function couponInfo(string $hddServiceCode = null)
    {
        // hddサービスコードが指定されていない場合は全件を取得する
        if (empty($hddServiceCode))
        {
            return $this->couponInfo;
        }

        // hddサービスコードが指定されている場合は配列をなめて検索する
        $couponInfo = array_filter(
            $this->couponInfo,
            function ($v) use ($hddServiceCode) {
                return ($v->hddServiceCode() === $hddServiceCode);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($couponInfo) > 0) ? current($couponInfo) : false;
    }

    /**
     * CouponInfoオブジェクトの格納処理
     *
     * {@inheritdoc}
     */
    protected function set(stdClass $response)
    {
        // 契約プランごとのクーポン残量・オンオフに関する情報を配列にまとめて格納する
        $this->couponInfo = array_map(
            function ($v) {
                return new CouponInfo($v);
            },
            $response->couponInfo
        );
    }
}
