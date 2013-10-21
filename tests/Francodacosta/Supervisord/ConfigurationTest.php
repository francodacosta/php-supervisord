<?php
use Francodacosta\Supervisord\Command;
use Francodacosta\Supervisord\Configuration;
use Francodacosta\Supervisord\Processors\CommandConfigurationProcessor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerate()
    {
        $configuration = new Configuration;

        $lsCommand = new Command;
        $lsCommand->set('command', 'ls -la');

        $catCommand = new Command;
        $catCommand->set('command', 'cat');
        $catCommand->set('numprocs', 10);

        $configuration->registerProcessor(new CommandConfigurationProcessor);
        $configuration->add($lsCommand);
        $configuration->add($catCommand);

        $result = $configuration->generate();

        $expected ="[program:ls]
command=ls -la

[program:cat]
process_name=%(program_name)s_%(process_num)02d
command=cat
numprocs=10";

        $this->assertEquals($expected, $result);

    }
}
