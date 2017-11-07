<?php
namespace Neronplex\MioponApi\Entity\Info;

use Neronplex\MioponApi\Entity\Info\Detail\Hdo\{
    Coupon as HdoCoupon,
    Packet as HdoPacket
};
use Neronplex\MioponApi\Entity\Info\Detail\Hdu\{
    Coupon as HduCoupon,
    Packet as HduPacket
};
use Neronplex\MioponApi\Entity\Type\Plan;
use stdClass;

/**
 * Class Base
 * 各Info Entityの基底クラス
 * SIMカードごとの詳細情報が格納される
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info
 * @since     0.0.1
 */
abstract class Base
{
    /**
     * hddサービスコード
     *
     * @var string
     */
    protected $hddServiceCode = null;

    /**
     * 契約中のプラン
     *
     * @var string
     */
    protected $plan = null;

    /**
     * 契約回線ごとの詳細情報
     *
     * @var HdoCoupon[]|HdoPacket[]
     */
    protected $hdoInfo = null;

    /**
     * 契約回線ごとの詳細情報
     *
     * @var HduCoupon[]|HduPacket[]
     */
    protected $hduInfo = null;

    /**
     * 使用するHdo/HduInfoクラスの名前を宣言する
     *
     * @return string
     */
    abstract protected function infoClassName(): string;

    /**
     * 非共通部分のデータ設定処理を実装する
     *
     * @param  stdClass $Info
     * @return void
     */
    abstract protected function set(stdClass $Info);

    /**
     * InfoBase constructor.
     *
     * @param stdClass $info
     */
    final public function __construct(stdClass $info)
    {
        // 共通部分のデータを格納する
        $this->hddServiceCode = $info->hddServiceCode;
        $this->plan           = (new Plan($info->plan))->value();

        // 回線ごとの詳細情報を格納する
        if (!empty($info->hdoInfo))
        {
            $this->hdoInfo = array_map(
                function ($v) {
                    $className = implode('\\', [
                        'Neronplex\\MioponApi',
                        'Entity\\Info\\Detail\\Hdo',
                        $this->infoClassName()
                    ]);

                    return new $className($v);
                },
                $info->hdoInfo
            );
        }

        // 回線ごとの詳細情報を格納する
        if (!empty($info->hduInfo))
        {
            $this->hduInfo = array_map(
                function ($v) {
                    $className = implode('\\', [
                        'Neronplex\\MioponApi',
                        'Entity\\Info\\Detail\\Hdu',
                        $this->infoClassName()
                    ]);

                    return new $className($v);
                },
                $info->hduInfo
            );
        }

        // 非共通部分のデータを格納する
        $this->set($info);
    }

    /**
     * hddサービスコードを取得する
     *
     * @return string
     */
    public function hddServiceCode(): string
    {
        return $this->hddServiceCode;
    }

    /**
     * 契約中のプラン名を取得する
     *
     * @return string
     */
    public function plan(): string
    {
        return $this->plan;
    }

    /**
     * ライトスタートプランを利用中か判定する
     *
     * @return bool
     */
    public function isLightStart(): bool
    {
        return ($this->plan() === Plan::LIGHT_START);
    }

    /**
     * ミニマムスタートプランを利用中か判定する
     *
     * @return bool
     */
    public function isMinimunStart(): bool
    {
        return ($this->plan() === Plan::MINIMUM_START);
    }

    /**
     * ファミリーシェアプランを利用中か判定する
     *
     * @return bool
     */
    public function isFamilyShare(): bool
    {
        return ($this->plan() === Plan::FAMILY_SHARE);
    }

    /**
     * エコプランミニマムを利用中か判定する
     *
     * @return bool
     */
    public function isEcoMinimum(): bool
    {
        return ($this->plan() === Plan::ECO_MINIMUM);
    }

    /**
     * エコプランスタンダードを利用中か判定する
     *
     * @return bool
     */
    public function isEcoStandard(): bool
    {
        return ($this->plan() === Plan::ECO_STANDARD);
    }

    /**
     * 基本プランを利用中か判定する
     *
     * @link   https://www.iijmio.jp/hdd/spec/ 基本プランに関する詳細
     * @return bool
     */
    public function isStandardPlan(): bool
    {
        return (bool) max([
            $this->isMinimunStart().
            $this->isLightStart(),
            $this->isFamilyShare()
        ]);
    }

    /**
     * エコプランを利用中か判定する
     *
     * @link   https://www.iijmio.jp/eco/ エコプランに関する情報
     * @return bool
     */
    public function isEcoPlan(): bool
    {
        return (bool) max([
            $this->isEcoMinimum(),
            $this->isEcoStandard()
        ]);
    }

    /**
     * SIMカードごとの詳細情報 (hdo/hduInfo) を取得する
     *
     * @param  string|null $hdoServiceCode hdoサービスコード
     * @return HdoCoupon[]|HdoPacket[]|HdoCoupon|HdoPacket|bool
     */
    public function hdoInfo(string $hdoServiceCode = null)
    {
        // hdoサービスコードが指定されていない場合は全件を取得する
        if (empty($hdoServiceCode))
        {
            return $this->hdoInfo;
        }

        // hdoサービスコードが指定されている場合は配列をなめて検索する
        $hdoInfo = array_filter(
            $this->hdoInfo,
            function ($v) use ($hdoServiceCode) {
                return ($v->hdoServiceCode() === $hdoServiceCode);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($hdoInfo) > 0) ? current($hdoInfo) : false;
    }

    /**
     * SIMカードごとの詳細情報 (hduInfo) を取得する
     * （エコプランの場合は現状hduInfoにしか情報が格納されていない）
     *
     * @param  string|null $hduServiceCode hduサービスコード
     * @return HduCoupon[]|HduPacket[]|HduCoupon|HduPacket|bool
     */
    public function hduInfo(string $hduServiceCode = null)
    {
        // hdoサービスコードが指定されていない場合は全件を取得する
        if (empty($hduServiceCode))
        {
            return $this->hduInfo;
        }

        // hduサービスコードが指定されている場合は配列をなめて検索する
        $hduInfo = array_filter(
            $this->hduInfo,
            function ($v) use ($hduServiceCode) {
                return ($v->hduServiceCode() === $hduServiceCode);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($hduInfo) > 0) ? current($hduInfo) : false;
    }
}
