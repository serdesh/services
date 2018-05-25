<?php

/**
 * @return \yii\console\Application|\yii\web\Application|\yii\web\Application
 */
function app()
{
    return Yii::$app;
}

/**
 * @param $var
 */
function _end($var)
{
    echo \yii\helpers\VarDumper::dumpAsString($var, 5, true);
    exit();
}

/**
 * @param $var
 */
function _dump($var)
{
    echo \yii\helpers\VarDumper::dumpAsString($var, 5, true);
}

/**
 * @param $var
 */
function _log ($var)
{
    Yii::info(\yii\helpers\VarDumper::dumpAsString($var, 5), '_');
}