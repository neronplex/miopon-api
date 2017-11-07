<?php
namespace Neronplex\MioponApi\Type;

use Neronplex\MioponApi\Enum;

/**
 * Class Mode
 * 定義されているAPIのリクエストモード
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Type
 * @since     0.0.1
 */
final class Mode extends Enum
{
    /**
     * クーポン残量照会・クーポンのON/OFF状態照会
     *
     * @var string
     */
    const COUPON = 'coupon';

    /**
     * データ利用量照会
     *
     * @var string
     */
    const PACKET = 'packet';

    /**
     * クーポンのON/OFF
     *
     * @var string
     */
    const TOGGLE = 'toggle';

    /**
     * Mode constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct(strtolower($value));
    }
}