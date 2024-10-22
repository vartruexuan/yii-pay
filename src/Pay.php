<?php

namespace vartruexuan\pay;


use Yansongda\Pay\Exception\ContainerException;
use yii\base\StaticInstanceTrait;
use yii\helpers\ArrayHelper;
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
    public array $config;


    public function __call($name, $params)
    {
        if (YsdPay::has($name)) {
            if (!empty($config)) {
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
        YsdPay::config($this->config,function (){
            return new Container();
        });
    }


    /**
     * 获取配置
     *
     * @param string $key
     * @return array
     * @throws \Exception
     */
    public function getConfig($key)
    {
        if ($key) {
            return ArrayHelper::getValue($this->config, $key);
        }
        return $this->config;
    }
}