<?php
namespace Neronplex\MioponApi\Entity\Detail;

use Neronplex\MioponApi\Entity\Type\HistoryType;
use stdClass;

/**
 * Class History
 * クーポン上限値変更履歴の詳細情報を格納するオブジェクト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Detail
 * @since     0.0.1
 */
class History
{
    /**
     * 日付
     *
     * @var string YYYYMMDD
     */
    protected $date = null;

    /**
     * イベント名
     *
     * @var string
     */
    protected $event = null;

    /**
     * クーポン残量
     *
     * @var int MB単位
     */
    protected $volume = null;

    /**
     * クーポン種別
     * (bundle / topup)
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
        $this->date   = $detail->date;
        $this->event  = $detail->event;
        $this->volume = $detail->volume;
        $this->type   = (new HistoryType($detail->type))->value();
    }

    /**
     * 日付を返す
     *
     * @return string
     */
    public function date(): string
    {
        return $this->date;
    }

    /**
     * イベント名を返す
     *
     * @return string
     */
    public function event(): string
    {
        return $this->event;
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
        return ($this->type() === HistoryType::BUNDLE);
    }

    /**
     * 上限値変更であるか判定する
     *
     * @return bool
     */
    public function isTopup(): bool
    {
        return ($this->type() === HistoryType::TOPUP);
    }
}
