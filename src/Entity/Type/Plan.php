<?php
namespace Neronplex\MioponApi\Entity\Type;

use Neronplex\MioponApi\Enum;

/**
 * Class Plan
 * 提供されている利用プラン
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity\Type
 * @since     0.0.1
 */
final class Plan extends Enum
{
    /**
     * ミニマムスタートプラン
     *
     * @var string
     */
    const MINIMUM_START = 'Minimum Start';

    /**
     * ライトスタートプラン
     *
     * @var string
     */
    const LIGHT_START = 'Light Start';

    /**
     * ファミリーシェアプラン
     *
     * @var string
     */
    const FAMILY_SHARE = 'Family Share';

    /**
     * エコプランミニマム
     *
     * @var string
     */
    const ECO_MINIMUM = 'Eco Minimum';

    /**
     * エコプランスタンダード
     *
     * @var string
     */
    const ECO_STANDARD = 'Eco Standard';
}
