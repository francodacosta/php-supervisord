<?php
namespace Francodacosta\Supervisord\Processors;

use Francodacosta\Supervisord\ProcessorInterface;
use Francodacosta\Supervisord\ConfigurationItemInterface;

class CommandConfigurationProcessor implements ProcessorInterface
{
    public function appliesTo(ConfigurationItemInterface $item)
    {
        return $item instanceOf \Francodacosta\Supervisord\Command;
    }

    private function getSectionName($data)
    {
        if (isset($data['name'])) {
            return $data['name'];
        }

        @list($command, $params) = explode(' ', $data['command'],2);

        $name = basename($command);

        return $name;
    }

    public function process(ConfigurationItemInterface $item)
    {
        $data = $item->get();
        $buffer = array();

        $name = $this->getSectionName($data);

        $buffer['section']='[program:'.$name.']';

        if (isset($data['numprocs']) && ($data['numprocs'] > 1)) {
            $buffer['process_name'] = "process_name=%(program_name)s_%(process_num)02d";
        }

        foreach ($data as $option => $value) {
            $buffer[$option] = $option .'='. $value;
        }

        return implode("\n", $buffer);
    }
}
