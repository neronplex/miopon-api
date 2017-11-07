<?php
namespace Neronplex\MioponApi\Entity;

use Neronplex\MioponApi\Entity\Info\PacketLog as PacketLogInfo;
use stdClass;

/**
 * Class Packet
 * データ利用量照会リクエスト時のルートEntity
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity
 * @since     0.0.1
 */
class Packet extends Base
{
    /**
     * 契約プランごとのデータ利用量情報が格納された配列
     *
     * @var PacketLogInfo[]
     */
    protected $packetLogInfo = null;

    /**
     * 契約プランごとの詳細情報を取得する
     *
     * @param  string|null $hddServiceCode 欲しい契約プランのhddサービスコード
     * @return PacketLogInfo[]|PacketLogInfo|bool hddサービスコードが指定されていない場合はPacketLogが格納された配列
     *                                            hddサービスコードが指定されている場合はその契約のPacketLog
     *                                            hddサービスコードが指定されているものの見つからなかった場合はfalse
     */
    public function packetLogInfo(string $hddServiceCode = null)
    {
        // hddサービスコードが指定されていない場合は全件を取得する
        if (empty($hddServiceCode))
        {
            return $this->packetLogInfo;
        }

        // hddサービスコードが指定されている場合は配列をなめて検索する
        $packetLogInfo = array_filter(
            $this->packetLogInfo,
            function ($v) use ($hddServiceCode) {
                return ($v->hddServiceCode() === $hddServiceCode);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($packetLogInfo) > 0) ? current($packetLogInfo) : false;
    }

    /**
     * データ通信量オブジェクトの格納処理
     *
     * {@inheritdoc]
     */
    protected function set(stdClass $response)
    {
        // 契約プランごとのデータ通信量に関する情報を配列にまとめて格納する
        $this->packetLogInfo = array_map(
            function ($v) {
                return new PacketLogInfo($v);
            },
            $response->packetLogInfo
        );
    }
}
