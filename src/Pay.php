<?php

namespace vartruexuan\pay;


use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use vartruexuan\pay\http\HttpClientArtful;
use vartruexuan\pay\log\Logger;
use Yansongda\Pay\Contract\HttpClientInterface;
use Yansongda\Pay\Exception\ContainerException;
use yii\base\StaticInstanceTrait;
use yii\helpers\ArrayHelper;
use vartruexuan\pay\http\HttpClient;
use \Yansongda\Pay\Pay as YsdPay;

/**
 * @method alipay(array $config = [], $container = null) 支付宝
 * @method wechat(array $config = [], $container = null) 微信
 * @method unipay(array $config = [], $container = null) 银联支付
 * @method douyin(array $config = [], $container = null) 抖音(>=3.7.9)
 * @method jsb(array $config = [], $container = null) 江苏银行e融支付(>=3.7.7)
 */
class Pay extends \yii\base\Component
{
    use StaticInstanceTrait;

    /**
     * 配置
     *
     * @var array
     */
    public array $config = [];


    public function __call($name, $params)
    {
        if (!$this->hasMethod($name)) {
            if (!empty($params)) {
                YsdPay::config(...$params);
            }
            return YsdPay::get($name);
        }
        return parent::__call($name, $params); // TODO: Change the autogenerated stub
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->initPay();
    }

    /**
     * 初始化支付信息
     *
     * @return void
     * @throws ContainerException
     */
    private function initPay()
    {
        // 初始化配置
        YsdPay::config((array)$this->config);
        // 配置日志
        $this->initLog();
        // 初始化 http 客户端
        $this->initHttpClient();
    }


    /**
     * 初始化日志组件
     *
     * @return void
     * @throws \Yansongda\Artful\Exception\ContainerException
     */
    public function initLog()
    {
        $interfaces = [
            'Yansongda\Pay\Contract\LoggerInterface' => Logger::class,
            'Yansongda\Artful\Contract\LoggerInterface' => Logger::class,
        ];
        foreach ($interfaces as $interface => $client) {
            if (interface_exists($interface)) {
                YsdPay::set($interface, new $client());
            }
        }
    }

    /**
     * 初始化 http 客户端
     *
     * @return void
     * @throws \Yansongda\Artful\Exception\ContainerException
     */
    public function initHttpClient()
    {
        $interfaces = [
            'Yansongda\Pay\Contract\HttpClientInterface' => HttpClient::class,
            'Yansongda\Artful\Contract\HttpClientInterface' => HttpClientArtful::class,
        ];
        foreach ($interfaces as $interface => $client) {
            if (interface_exists($interface)) {
                YsdPay::set($interface, new $client($this->getConfig('http', [])));
            }
        }
    }


    /**
     * 获取配置
     *
     * @param string|null $key
     * @param null $default
     * @return array
     */
    public function getConfig(string $key = null, $default = null)
    {
        if ($key) {
            return ArrayHelper::getValue($this->config, $key, $default);
        }
        return $this->config;
    }

    /**
     * 设置配置
     *
     * @param $config
     * @return $this
     * @throws \Yansongda\Artful\Exception\ContainerException
     */
    public function setConfig(array $config, bool $force = true)
    {
        if ($force) {
            // 强制覆盖
            $config['_force'] = true;
        }
        $this->config = $config;
        YsdPay::config($this->config);
        $this->init();
        return $this;
    }
}