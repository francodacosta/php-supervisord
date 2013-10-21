<?php
namespace Francodacosta\Supervisord;

interface ProcessorInterface
{
    public function appliesTo(ConfigurationItemInterface $item);
    public function process(ConfigurationItemInterface $item);
}
