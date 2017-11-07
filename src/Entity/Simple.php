<?php
namespace Neronplex\MioponApi\Entity;

use stdClass;

/**
 * Class Simple
 * エラー時・クーポンスイッチ操作時レスポンスで用いるEntity
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity
 * @since     0.0.1
 */
class Simple extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function set(stdClass $response)
    {
        // Entity独自の格納処理がないため未実装
    }
}
