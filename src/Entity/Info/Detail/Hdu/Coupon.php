<?php
namespace Neronplex\MioponApi\Entity\Info\Detail\Hdu;

use Neronplex\MioponApi\Entity\Info\Detail\CouponBase;
use stdClass;

/**
 * Class Coupon
 * hduサービスコードが割り当てられている回線の詳細情報を格納するCouponオブジェクト
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Info\Detail\Hdu
 * @since     0.0.1
 */
class Coupon extends CouponBase
{
    /**
     * hduサービスコード
     *
     * @var string
     */
    protected $hduServiceCode = null;

    /**
     * hduサービスコードを取得する
     *
     * @return string
     */
    public function hduServiceCode(): string
    {
        return $this->hduServiceCode;
    }

    /**
     * {@inheritdoc}
     */
    protected function set(stdClass $info)
    {
        $this->hduServiceCode = $info->hduServiceCode;
    }
}
