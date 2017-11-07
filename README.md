# miopon-api

miopon-apiは[IIJmioクーポンスイッチAPI](https://api.iijmio.jp/mobile/d/)用のPHPクライアントです。

## Requirement

- PHP7.0以上
- [Guzzle](http://docs.guzzlephp.org/en/latest/) 6.2以上
- 契約中のmioIDを保持していること（IIJmioの契約者であること）

## インストール方法

[Packagist](https://packagist.org/)にて公開していますので、Composerでインストールしてください。

```
$ composer require neronplex/miopon-api
```

## デベロッパーID・アクセストークンの取得方法

取得方法に関しては、[公式リファレンスのご利用にあたって](https://www.iijmio.jp/hdd/coupon/mioponapi.jsp#goriyou)を参照してください。

## Example

### クーポン残量照会・クーポンのON/OFF状態照会

```php
$client = new Client();
$return = $client->setDeveloperId('xxxxx')
    ->setAccessToken('yyyyy')
    ->setMode('coupon')
    ->execute(); // リクエストが成功しているかどうかboolで返却

// JSONをオブジェクトに格納した形式でレスポンスを取得できます
$entity = $client->entity();

// リクエストに関する情報を取得します
$returnCode = $entity->returnCode() // e.g. OK
$statusCode = $entity->statusCode() // e.g. 200

// 1契約に関する情報を取得します
$couponInfo = $client->couponInfo('hddXXXXXXXX'); // hddサービスコードを指定しない場合は配列で返却
$hddServiceCode = $couponInfo->hddServiceCode(); // hddサービスコードを返却 e.g. hddXXXXXXXX
$plan = $couponInfo->plan(); // 契約中のプラン名を返却 e.g. Minimum Start
$coupon = $couponInfo->coupon(); // クーポンの残量情報を格納したオブジェクトが配列でラップされて返却（エコプラン以外で有効）

$total = 0;

foreach ($coupon as $couponDetail) {
    $expire = $couponDetail->expire(); // クーポンの有効期限 e.g. 201704
    $type   = $couponDetail->type(); // クーポン種別を返却 e.g. bundle
    $total += $couponDetail->volume(); // 残量を返却 e.g. 1000
}

$history = $couponInfo->history(); // クーポン上限値変更履歴を格納したオブジェクトが配列でラップされて返却（エコプランのみ有効）

foreach ($history as $historyDetail) {
    $date   = $historyDetail->date(); // 日付を返却 e.g. 20170401
    $event  = $historyDetail->event(); // add
    $volume = $historyDetail->volume(); // バンドルクーポン追加量を返却（MB単位） e.g. 1000
    $type   = $historyDetail->type(); // 追加タイプを返却 e.g. bundle
}

$remains = $couponInfo->remains(); // エコプランのクーポン残量を返却（エコプランのみ有効）

// SIMカードごとの情報を取得します（hduInfoについてもほぼ同様の使い方なので割愛）
$hdoInfo = $couponInfo->hdoInfo('hdoXXXXXXXX'); // hdoサービスコードを指定しない場合は配列で返却
$hdoServiceCode = $hdoInfo->hdoServiceCode(); // hdoサービスコードを返却 hdoXXXXXXXX
$number = $hdoInfo->number(); // 携帯電話番号を返却 e.g. 080XXXXXXXX
$iccid = $hdoInfo->iccid(); // ICCIDを返却 e.g. DN00XXXXXXXXXX
$regulation = $hdoInfo->regulation(); // 通信規制中かどうか返却 e.g. true
$sms = $hdoInfo->sms(); // SMSが使えるかどうか返却 e.g. true
$voice = $hdoInfo->voice(); // 音声通話が使えるかどうか返却 e.g. true
$couponUse = $hdoInfo->couponUse(); // クーポンを使用中かどうか返却 e.g. true
$coupon = $hdoInfo->coupon(); // 使い方は上記ほぼと同じ（配列でラップはされない）
```

## データ利用量照会

```php
$client = new Client();
$return = $client->setDeveloperId('xxxxx')
    ->setAccessToken('yyyyy')
    ->setMode('packet')
    ->execute(); // リクエストが成功しているかどうかboolで返却

// JSONをオブジェクトに格納した形式でレスポンスを取得できます
$entity = $client->entity();

// リクエストに関する情報を取得します
$returnCode = $entity->returnCode() // e.g. OK
$statusCode = $entity->statusCode() // e.g. 200

// 1契約に関する情報を取得します
$packetLogInfo = $client->packetLogInfo('hddXXXXXXXX'); // hddサービスコードを指定しない場合は配列で返却
$hddServiceCode = $packetLogInfo->hddServiceCode(); // hddサービスコードを返却 e.g. hddXXXXXXXX
$plan = $packetLogInfo->plan(); // 契約中のプラン名を返却 e.g. Minimum Start
$packetLog = $packetLogInfo->packetLog(); // データ利用量を格納したオブジェクトが配列でラップされて返却

foreach ($packetLog as $packetLogDetail) {
    $date          = $packetLogDetail->date(); // 通信日を返却 e.g. 20170401
    $withCoupon    = $packetLogDetail->withCoupon(); // クーポンを使用したデータ利用量を返却 e.g. 123
    $withoutCoupon = $packetLogDetail->withoutCoupon(); // クーポンを使用しないデータ利用量を返却 e.g. 456
}
```

## クーポンのオンオフ

```php
$client = new Client();
$return = $client->setDeveloperId('xxxxx')
    ->setAccessToken('yyyyy')
    ->setMode('toggle')
    ->setToggleOrder([
        'hdoXXXXXXXX' => true,
        'hduXXXXXXXX' => false
    ])
    ->execute(); // リクエストが成功しているかどうかboolで返却

// JSONをオブジェクトに格納した形式でレスポンスを取得できます
$entity = $client->entity();

// リクエストに関する情報を取得します
$returnCode = $entity->returnCode() // e.g. OK
$statusCode = $entity->statusCode() // e.g. 200
```

APIに関する詳細は[公式リファレンス](https://www.iijmio.jp/hdd/coupon/mioponapi.jsp#reference)を参照してください。

## License

Copyright &copy; 2017 暖簾 ([@neronplex](http://twitter.com/neronplex))
Licensed under the [Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).
