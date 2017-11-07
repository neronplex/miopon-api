<?php
namespace Neronplex\MioponApi\Entity;

use stdClass;

/**
 * Class Base
 * 各ルートEntityの基底クラス
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi\Entity
 * @since     0.0.1
 */
abstract class Base
{
    /**
     * リクエストが成功した場合のリターンコード
     *
     * @var string
     */
    const SUCCESS_RETURN_CODE = 'OK';

    /**
     * リクエストが成功した場合のステータスコード
     *
     * @var int
     */
    const SUCCESS_STATUS_CODE = 200;

    /**
     * レスポンスメッセージ
     *
     * @var string
     */
    protected $returnCode = null;

    /**
     * HTTPステータスコード
     *
     * @var int
     */
    protected $statusCode = null;

    /**
     * 非共通部分のデータ設定処理を実装する
     *
     * @param  stdClass $response
     * @return void
     */
    abstract protected function set(stdClass $response);

    /**
     * EntityBase constructor.
     *
     * @param stdClass $response
     * @param int      $statusCode
     */
    final public function __construct(stdClass $response, int $statusCode)
    {
        $this->returnCode = $response->returnCode;
        $this->statusCode = $statusCode;

        $this->set($response);
    }

    /**
     * レスポンスメッセージを取得する
     *
     * @return string
     */
    public function returnCode(): string
    {
        return $this->returnCode;
    }

    /**
     * HTTPステータスコードを取得する
     *
     * @return int
     */
    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * リクエストが成功したか判定する
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (bool) min([
            $this->returnCode() === static::SUCCESS_RETURN_CODE,
            $this->statusCode() === static::SUCCESS_STATUS_CODE
        ]);
    }
}
