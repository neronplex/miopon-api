<?php
namespace Neronplex\MioponApi\Entity\Info;

use stdClass;

/**
 * Class PacketLog
 * データ利用量照会リクエスト時のInfo Entity
 * 契約プランごとの詳細情報が格納される
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info
 * @since     0.0.1
 */
class PacketLog extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function infoClassName(): string
    {
        return 'Packet';
    }

    /**
     * {@inheritdoc}
     */
    protected function set(stdClass $Info)
    {
        // Entity独自の格納処理がないため未実装
    }
}
