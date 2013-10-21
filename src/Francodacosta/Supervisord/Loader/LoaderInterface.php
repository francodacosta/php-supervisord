<?php
namespace Francodacosta\Supervisord\Loader;

use Francodacosta\Supervisord\Configuration;

interface LoaderInterface
{
    public function setSource($source);
    public function setConfiguration(Configuration $config);
    public function load();
}
