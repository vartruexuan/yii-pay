<?php

namespace vartruexuan\pay;

use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{

    public function emergency($message, array $context = []): void
    {
        $this->log($this->levelMapYii('emergency'), $message, $context);
    }

    public function alert($message, array $context = []): void
    {
        $this->log($this->levelMapYii('alert'), $message, $context);
    }

    public function critical($message, array $context = []): void
    {
        $this->log($this->levelMapYii('critical'), $message, $context);
    }

    public function notice($message, array $context = []): void
    {
        $this->log($this->levelMapYii('notice'), $message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->log($this->levelMapYii('error'), $message, $context);
    }

    public function warning($message, array $context = []): void
    {
        $this->log($this->levelMapYii('warning'), $message, $context);
    }


    public function info($message, array $context = []): void
    {
        $this->log($this->levelMapYii('info'), $message, $context);
    }

    public function debug($message, array $context = []): void
    {
        $this->log($this->levelMapYii('debug'), $message, $context);
    }

    public function log($level, $message, array $context = []): void
    {
        if (!is_numeric($level)) {
            $level = $this->levelMapYii($level);
        }
        \Yii::getLogger()->log($this->strReplacePlaceholder($message, $context), $level, get_called_class());
    }


    /**
     * level映射yii框架日志
     *
     * @param $level
     * @return array|mixed
     */
    public function levelMapYii($level = null)
    {
        $mapLevels = [
            'warning' => \yii\log\Logger::LEVEL_WARNING,

            'error' => \yii\log\Logger::LEVEL_ERROR,
            'emergency' => \yii\log\Logger::LEVEL_ERROR,

            'info' => \yii\log\Logger::LEVEL_INFO,
            'notice' => \yii\log\Logger::LEVEL_INFO,
            'critical' => \yii\log\Logger::LEVEL_INFO,
            'alert' => \yii\log\Logger::LEVEL_INFO,
            'debug' => \yii\log\Logger::LEVEL_INFO,
        ];

        if ($level) {
            return $mapLevels[$level];
        }
        return $mapLevels;
    }


    protected function strReplacePlaceholder($str, $replaceArr, $placeholderLeft = '{', $placeholderRight = '}')
    {
        $paramsNames = array_map(function ($n) use ($placeholderLeft, $placeholderRight) {
            return "/" . preg_quote($placeholderLeft . $n . $placeholderRight) . "/";
        }, array_keys($replaceArr));
        return preg_replace($paramsNames, array_values($replaceArr), $str);
    }
}