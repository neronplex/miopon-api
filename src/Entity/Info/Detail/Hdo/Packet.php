<?php
namespace Neronplex\MioponApi\Entity\Info\Detail\Hdo;

use Neronplex\MioponApi\Entity\Info\Detail\PacketBase;
use stdClass;

/**
 * Class Packet
 * hdoサービスコードが割り当てられている回線の詳細情報を格納するPacketオブジェクト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info\Detail\Hdo
 * @since     0.0.1
 */
class Packet extends PacketBase
{
    /**
     * hdoサービスコード
     *
     * @var string
     */
    protected $hdoServiceCode = null;

    /**
     * hdoサービスコードを取得する
     *
     * @return string
     */
    public function hdoServiceCode(): string
    {
        return $this->hdoServiceCode;
    }

    /**
     * {@inheritdoc}
     */
    protected function set(stdClass $info)
    {
        $this->hdoServiceCode = $info->hdoServiceCode;
    }
}
