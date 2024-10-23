# yii-pay

[![php](https://img.shields.io/badge/php-^7.4|^8.0-brightgreen.svg?maxAge=2592000)](https://github.com/php/php-src)
[![Latest Stable Version](https://img.shields.io/packagist/v/vartruexuan/yii-pay)](https://packagist.org/packages/vartruexuan/yii-pay)
[![Total Downloads](https://img.shields.io/packagist/dt/vartruexuan/yii-pay)](https://packagist.org/packages/vartruexuan/yii-pay)
[![License](https://img.shields.io/packagist/l/vartruexuan/yii-pay)](https://github.com/vartruexuan/yii-pay)

# 概述
yii版支付组件
- 基于组件 [yansongda/pay](https://github.com/yansongda/pay)
## 组件能力

- 支付宝支付
- 微信支付
- 银联支付
- 抖音支付 (>=3.7.9)
- 江苏银行e融支付 (>=3.7.7)

# 安装
- 安装组件
```shell
composer require vartruexuan/yii-pay
```
## 使用
```php 
\Yii::$app->pay->wechat(); // 微信
\Yii::$app->pay->alipay();// 支付宝
\Yii::$app->pay->unipay();// 银联 
\Yii::$app->pay->jsb();// 江苏银行e融支付 (>=3.7.7)
\Yii::$app->pay->douyin();// 抖音(>=3.7.9)
// 微信
\Yii::$app->pay->wechat()->scan($order); // 微信扫码支付
\Yii::$app->pay->wechat()->app($order); // app支付
\Yii::$app->pay->wechat()->mini($order); // 小程序支付
\Yii::$app->pay->wechat()->mp($order); // 公众号支付

\Yii::$app->pay->wechat()->wap($order); // H5支付
\Yii::$app->pay->wechat()->h5($order); // H5支付 (>=3.6.0)

```
- 单例模式
```php
\vartruexuan\pay\Pay::instance()->setConfig($config)->wechat();
// ...
```
### 配置
- 配置组件 `components`
```php
[
    'components' => [
        // 支付组件
        'pay' => [
            'class' => 'vartruexuan\pay\Pay',
            'config' => [
                'wechat' => [
                    'default' => [
                        // 必填-商户号，服务商模式下为服务商商户号
                        // 可在 https://pay.weixin.qq.com/ 账户中心->商户信息 查看
                        'mch_id' => '',
                        // 选填-v2商户私钥
                        'mch_secret_key_v2' => '',
                        // 必填-v3 商户秘钥
                        // 即 API v3 密钥(32字节，形如md5值)，可在 账户中心->API安全 中设置
                        'mch_secret_key' => '',
                        // 必填-商户私钥 字符串或路径
                        // 即 API证书 PRIVATE KEY，可在 账户中心->API安全->申请API证书 里获得
                        // 文件名形如：apiclient_key.pem
                        'mch_secret_cert' => '',
                        // 必填-商户公钥证书路径
                        // 即 API证书 CERTIFICATE，可在 账户中心->API安全->申请API证书 里获得
                        // 文件名形如：apiclient_cert.pem
                        'mch_public_cert_path' => '',
                        // 必填-微信回调url
                        // 不能有参数，如?号，空格等，否则会无法正确回调
                        'notify_url' => 'https://yansongda.cn/wechat/notify',
                        // 选填-公众号 的 app_id
                        // 可在 mp.weixin.qq.com 设置与开发->基本配置->开发者ID(AppID) 查看
                        'mp_app_id' => '2016082000291234',
                        // 选填-小程序 的 app_id
                        'mini_app_id' => '',
                        // 选填-app 的 app_id
                        'app_id' => '',
                        // 选填-服务商模式下，子公众号 的 app_id
                        'sub_mp_app_id' => '',
                        // 选填-服务商模式下，子 app 的 app_id
                        'sub_app_id' => '',
                        // 选填-服务商模式下，子小程序 的 app_id
                        'sub_mini_app_id' => '',
                        // 选填-服务商模式下，子商户id
                        'sub_mch_id' => '',
                        // 选填-微信平台公钥证书路径, optional，强烈建议 php-fpm 模式下配置此参数
                        'wechat_public_cert_path' => [
                            '45F59D4DABF31918AFCEC556D5D2C6E376675D57' => __DIR__ . '/Cert/wechatPublicKey.crt',
                        ],
                        // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SERVICE
                        'mode' => Pay::MODE_NORMAL,
                    ]
                ],
            ],

        ],
    ]
];
```
### 日志
```php
[
    'components'=>[
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            // 流输出日志
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'info', 'warning'],
                /*'categories' => [
                    // 过滤指定分类
                    'vartruexuan*',
                ],*/
                // $_GET，$_POST，$_FILES，$_COOKIE，$_SESSION 和 $_SERVER
                'logVars' => [],
            ],
           ]
    ]
]
```
### 具体文档版本差异参考 [yansongda/pay](https://pay.yansongda.cn/docs/v3/)

## License

MIT
