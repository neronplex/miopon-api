<?php
namespace Neronplex\MioponApi\Entity\Info;

use Neronplex\MioponApi\Entity\Detail\{
    Coupon as CouponDetail,
    History as HistoryDetail
};
use stdClass;

/**
 * Class Coupon
 * クーポン残量照会・オンオフ状態確認リクエスト時のInfo Entity
 * 契約プランごとの詳細情報が格納される
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info
 * @since     0.0.1
 */
class Coupon extends Base
{
    /**
     * 回線に紐付いているクーポン残量の情報（エコプラン以外の場合）
     * （SIM内クーポンの情報はInfo\Detail\***\Coupon::coupon()から取得する）
     *
     * @var CouponDetail[]
     */
    protected $coupon = null;

    /**
     * クーポン上限値変更履歴（エコプランの場合のみ）
     *
     * @var HistoryDetail[]
     */
    protected $history = null;

    /**
     * 当月のクーポン残量（エコプランの場合のみ）
     *
     * @var int MB単位
     */
    protected $remains = null;

    /**
     * 回線に紐付いているクーポンの情報を取得する
     *
     * @param  string|null $expire 欲しいクーポン情報の有効期限
     * @return CouponDetail[]|CouponDetail|bool 欲しいクーポン情報の有効期限が指定されていない場合はCouponDetailが格納された配列
     *                                          欲しいクーポン情報の有効期限が指定されている場合はそのCouponDetail
     *                                          欲しいクーポン情報の有効期限が指定されているが見つからなかった場合はfalse
     */
    public function coupon(string $expire = null)
    {
        // 日付が指定されていない場合は全件を取得する
        if (empty($expire))
        {
            return $this->coupon;
        }

        // クーポンの有効期限が指定されている場合は配列をなめて検索する
        $coupon = array_filter(
            $this->coupon,
            function ($v) use ($expire) {
                return ($v->expire() === $expire);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($coupon) > 0) ? current($coupon) : false;
    }

    /**
     * 回線に紐付いているクーポン上限値変更履歴を取得する
     *
     * @param  string|null $date 欲しいクーポン上限値変更履歴の日付
     * @return HistoryDetail[]|HistoryDetail|bool 欲しいクーポン上限値変更履歴の日付が指定されていない場合はHistoryDetailが格納された配列
     *                                            欲しいクーポン上限値変更履歴の日付が指定されている場合はそのHistoryDetail
     *                                            欲しいクーポン上限値変更履歴の日付が指定されているが見つからなかった場合はfalse
     */
    public function history(string $date = null)
    {
        // 日付が指定されていない場合は全件を取得する
        if (empty($date))
        {
            return $this->history;
        }

        // クーポンの有効期限が指定されている場合は配列をなめて検索する
        $history = array_filter(
            $this->history,
            function ($v) use ($date) {
                return ($v->date() === $date);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($history) > 0) ? current($history) : false;
    }

    /**
     * 当月のクーポン残量を取得する
     *
     * @return int
     */
    public function remains(): int
    {
        return $this->remains;
    }

    /**
     * {@inheritdoc}
     */
    protected function infoClassName(): string
    {
        return 'Coupon';
    }

    /**
     * SIMカードごとのクーポン情報の格納処理
     *
     * {@inheritdoc}
     */
    protected function set(stdClass $info)
    {
        // クーポン残量を格納する（エコプラン以外の場合のみ）
        if (!empty($info->coupon))
        {
            $this->coupon = array_map(
                function ($v) {
                    return new CouponDetail($v);
                },
                $info->coupon
            );
        }

        // クーポン上限値変更履歴を格納する（エコプランの場合のみ）
        if (!empty($info->history))
        {
            $this->history = array_map(
                function ($v) {
                    return new HistoryDetail($v);
                },
                $info->history
            );
        }

        // 当月のクーポン残量を格納する（エコプランの場合のみ）
        if (!empty($info->remains))
        {
            $this->remains = $info->remains;
        }
    }
}
