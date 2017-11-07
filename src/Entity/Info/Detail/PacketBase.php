<?php
namespace Neronplex\MioponApi\Entity\Info\Detail;

use Neronplex\MioponApi\Entity\Detail\PacketLog;
use stdClass;

/**
 * Class PacketBase
 * データ利用量照会リクエストの詳細情報を格納する基底クラス
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info\Detail
 * @since     0.0.1
 */
abstract class PacketBase
{
    /**
     * 当日を含めた31日分のデータ利用量情報
     *
     * @var PacketLog[]
     */
    protected $packetLog = null;

    /**
     * 非共通部分のデータ設定処理を実装する
     *
     * @param  stdClass $info
     * @return void
     */
    abstract protected function set(stdClass $info);

    /**
     * PacketBase constructor.
     *
     * @param stdClass $info
     */
    public function __construct(stdClass $info)
    {
        $this->packetLog = array_map(
            function ($v) {
                return new PacketLog($v);
            },
            $info->packetLog
        );

        $this->set($info);
    }

    /**
     * データ利用量情報を取得する
     *
     * @param  null|string $date
     * @return PacketLog[]|PacketLog|bool 日付が指定されていない場合はPacketLogが全件格納された配列
     *                                    $dateが指定されている場合はその日の情報が格納されたPacketLog
     *                                    $dateが指定されていたが見つからなかった場合はfalse
     */
    public function packetLog(string $date = null)
    {
        // 日付が指定されていない場合は全件を取得する
        if (empty($date))
        {
            return $this->packetLog;
        }

        // hdoサービスコードが指定されている場合は配列をなめて検索する
        $packetLog = array_filter(
            $this->packetLog,
            function ($v) use ($date) {
                return ($v->date() === $date);
            }
        );

        // 見つかった場合はそのEntityを、見つからなければfalse
        return (count($packetLog) > 0) ? current($packetLog) : false;
    }
}
