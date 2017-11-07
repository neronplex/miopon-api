<?php
namespace Neronplex\MioponApi\Entity\Type;

use Neronplex\MioponApi\Enum;

/**
 * Class CouponType
 * クーポン種別
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Type
 * @since     0.0.1
 */
final class CouponType extends Enum
{
    /**
     * バンドルクーポン
     *
     * @var string
     */
    const BUNDLE = 'bundle';

    /**
     * 追加クーポン
     *
     * @var string
     */
    const TOPUP = 'topup';

    /**
     * SIM内クーポン
     *
     * @var string
     */
    const SIM = 'sim';
}
