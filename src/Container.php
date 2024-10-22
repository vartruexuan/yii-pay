<?php

namespace vartruexuan\pay;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    public function set($id, $value)
    {
        return \Yii::$container->set($id, $value);
    }

    public function get(string $id)
    {
        return \Yii::$container->get($id);
    }

    public function has(string $id)
    {
        return \Yii::$container->has($id);
    }

    public function clear(string $id)
    {
        \Yii::$container->clear($id);
    }
}