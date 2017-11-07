<?php
namespace Neronplex\MioponApi;

use BadMethodCallException;
use GuzzleHttp\{
    Client as GuzzleClient,
    ClientInterface
};
use InvalidArgumentException;
use LogicException;
use Neronplex\MioponApi\Entity\{
    Coupon,
    Packet,
    Simple
};
use Neronplex\MioponApi\Type\Mode;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * IIJmioクーポンスイッチAPIクライアント
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi
 * @since     0.0.1
 */
class Client
{
    /**
     * リクエスト成功時のステータスコード
     *
     * @var int
     */
    const SUCCESS_STATUS_CODE = 200;

    /**
     * 各エンドポイントごとのURL
     *
     * @var array
     */
    const ENDPOINT   = [
        'coupon' => 'https://api.iijmio.jp/mobile/d/v2/coupon/',
        'packet' => 'https://api.iijmio.jp/mobile/d/v2/log/packet/'
    ];

    /**
     * Guzzleクライアント
     *
     * @var ClientInterface
     */
    protected $client = null;

    /**
     * Guzzleレスポンス
     *
     * @var ResponseInterface
     */
    protected $response = null;

    /**
     * リクエスト種別
     * (coupon / packet / toggle)
     *
     * @var string
     */
    protected $mode = null;

    /**
     * IIJmioのデベロッパーID
     *
     * @var string
     */
    protected $developerId = null;

    /**
     * IIJmioのアクセストークン
     *
     * @var string
     */
    protected $accessToken = null;

    /**
     * hdo / hduサービスコードごとにクーポンを使用するか指定する
     *
     * @var array
     */
    protected $toggleOrder = [];

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    /**
     * リクエスト種別をセットする
     *
     * @param  string $mode リクエスト種別
     *                      coupon クーポン残量照会・クーポンのON/OFF状態照会
     *                      packet データ利用量照会
     *                      toggle クーポンのON/OFF
     * @throws InvalidArgumentException 未定義のリクエスト種別が指定された場合
     * @return self
     */
    public function setMode(string $mode)
    {
        $this->mode = (new Mode($mode))->value();

        return $this;
    }

    /**
     * デベロッパーIDをセットする
     *
     * @param  string $developerId IIJmioから割り当てられたデベロッパーID
     * @return self
     */
    public function setDeveloperId(string $developerId)
    {
        $this->developerId = $developerId;

        return $this;
    }

    /**
     * デベロッパーIDを取得する
     *
     * @return string
     */
    public function getDeveloperId(): string
    {
        return $this->developerId;
    }

    /**
     * アクセストークンをセットする
     *
     * @param  string $accessToken IIJmioから割り当てられたアクセストークン
     * @return self
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * アクセストークンを取得する
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * hdo / hduサービスコードごとにクーポン使用有無を指定した配列をセットする
     *
     * @param  array $toggleOrder ['サービスコード' => bool（クーポンを使用する場合はtrue）]の形式で指定する
     * @return self
     */
    public function setToggleOrder(array $toggleOrder)
    {
        $this->toggleOrder = $toggleOrder;

        return $this;
    }

    /**
     * hdo / hduサービスコードごとにクーポン使用有無を指定した配列を取得する
     *
     * @return array ['サービスコード' => bool（クーポンを使用する場合はtrue）]で返却される
     */
    public function getToggleOrder(): array
    {
        return $this->toggleOrder;
    }

    /**
     * IIJmioクーポンスイッチAPIへのリクエストを実行する
     *
     * @return bool リクエストに成功していればtrue
     */
    public function execute(): bool
    {
        // リクエスト実行前にいくつか確認する
        $this->precheck();

        // リクエストを実行してその結果を返す
        return $this->{$this->mode}();
    }

    /**
     * APIからのレスポンスをGuzzleのResponse objectで取得する
     *
     * @return ResponseInterface GuzzleのResponse object
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * APIからのレスポンスをEntityで取得する
     *
     * @throws BadMethodCallException APIへのリクエスト前に呼ぼうとすると投げられる
     * @return Simple|Coupon|Packet|bool リクエストに失敗している場合、toggleモードの場合はSimple
     *                                   couponモードの場合はCoupon
     *                                   Packetモードの場合はPacket
     *                                   JSONが取れなかった場合はfalse
     */
    public function entity()
    {
        // self::execute()がまだ実行されていないと思われる場合
        if (!($this->response() instanceof ResponseInterface))
        {
            throw new BadMethodCallException(
                'It can not be execute until execute() is executed.'
            );
        }

        // JSONのレスポンスがなかった場合
        if (empty($this->response()->getBody()))
        {
            return false;
        }

        // JSONをデコードする
        $body = json_decode($this->response()->getBody());

        // リクエストに失敗している場合
        if ($this->response()->getStatusCode() !== 200)
        {
            return new Simple($body, $this->response()->getStatusCode());
        }

        // リクエストの種別によって格納するEntityを使い分ける
        switch ($this->mode)
        {
            case Mode::COUPON:
                return new Coupon($body, $this->response()->getStatusCode());
                break;
            case Mode::PACKET:
                return new Packet($body, $this->response()->getStatusCode());
                break;
            case Mode::TOGGLE:
                return new Simple($body, $this->response()->getStatusCode());
                break;
        }

        // ここまではたどり着かない想定（たどり着いた場合はライブラリに起因するバグ）
        throw new LogicException('Assumption that we can not reach here.');
    }

    /**
     * APIリクエスト前のパラメータチェック
     *
     * @throws BadMethodCallException 必須パラメータがセットされていない場合
     * @return bool
     */
    protected function precheck(): bool
    {
        // デベロッパーIDがセットされていない場合
        if (empty($this->getDeveloperId()))
        {
            throw new BadMethodCallException('Please set developer ID.');
        }

        // アクセストークンがセットされていない場合
        if (empty($this->getAccessToken()))
        {
            throw new BadMethodCallException('Please set access token.');
        }

        return true;
    }

    /**
     * クーポン情報を取得する
     *
     * @return bool
     */
    protected function coupon(): bool
    {
        $response = $this->client->request('GET', self::ENDPOINT['coupon'], [
            'headers'     => $this->header(),
            'http_errors' => FALSE
        ]);

        $this->response = $response;

        return ($response->getStatusCode() === self::SUCCESS_STATUS_CODE);
    }

    /**
     * データ利用量情報を取得する
     *
     * @return bool
     */
    protected function packet(): bool
    {
        $response = $this->client->request('GET', self::ENDPOINT['packet'], [
            'headers'     => $this->header(),
            'http_errors' => FALSE
        ]);

        $this->response = $response;

        return ($response->getStatusCode() === self::SUCCESS_STATUS_CODE);
    }

    /**
     * クーポンのオン・オフを操作する
     *
     * @return bool
     */
    protected function toggle(): bool
    {
        $response = $this->client->request('PUT', self::ENDPOINT['coupon'], [
            'headers' => array_merge($this->header(), [
                'Content-Type' => 'application/json'
            ]),
            'body' => json_encode([
                'couponInfo' => [
                    [
                        'hdoInfo' => $this->searchToggleOrder('hdo'),
                        'hduInfo' => $this->searchToggleOrder('hdu')
                    ]
                ]
            ]),
            'http_errors' => FALSE
        ]);

        $this->response = $response;

        return ($response->getStatusCode() === self::SUCCESS_STATUS_CODE);
    }

    /**
     * HTTPヘッダーを生成する
     *
     * @return array
     */
    protected function header(): array
    {
        return [
            'X-IIJmio-Developer'     => $this->getDeveloperId(),
            'X-IIJmio-Authorization' => $this->getAccessToken()
        ];
    }

    /**
     * 指定したサービスコード種別のAPIリクエスト用に整形された配列を返す
     *
     * @param  string $type サービスコード種別 hdo / hdu
     * @return array
     */
    protected function searchToggleOrder(string $type): array
    {
        // 指定されたサービスコード種別でフィルタする
        $filtered = array_filter(
            $this->getToggleOrder(),
            function ($k) use ($type) {
                return (strpos($k, $type) !== false);
            },
            ARRAY_FILTER_USE_KEY
        );

        // APIのリクエスト形式に配列を整形する
        foreach ($filtered as $k => $v)
        {
            $order[] = (object) [
                "{$type}ServiceCode" => $k,
                'couponUse'          => $v
            ];
        }

        return $order ?? [];
    }
}
