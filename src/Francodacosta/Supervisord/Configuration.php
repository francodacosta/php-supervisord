<?php

namespace Francodacosta\Supervisord;

class Configuration
{
    private $items;
    private $processors = array();

    /**
     * register processors for configuration items
     *
     * @param ProcessorInterface $processor [description]
     */
    public function registerProcessor(ProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }

    /**
     * adds a configuration item
     *
     * @param ConfigurationItemInterface $item
     */
    public function add(ConfigurationItemInterface $item)
    {
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    private function getProcessor(ConfigurationItemInterface $item)
    {
        foreach ($this->processors as $processor) {
            if ($processor->appliesTo($item)) {
                return $processor;
            }
        }

        throw new \InvalidArgumentException('No processor could be found');
    }

    /**
     * generates the supervisord configuration
     *
     * @return string
     */
    public function generate()
    {
        $items = $this->items;
        $buffer = array();

        foreach ($items as $item) {
            $processor = $this->getProcessor($item);
            $buffer[] = $processor->process($item);
        }

        return implode("\n\n", $buffer);
    }
}
