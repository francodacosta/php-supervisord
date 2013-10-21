<?php
namespace Francodacosta\Supervisord;

interface ConfigurationItemInterface
{
    public function set($key, $value);
    public function get($key = null);
}
