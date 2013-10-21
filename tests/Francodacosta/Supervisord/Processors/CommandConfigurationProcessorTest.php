<?php
use Francodacosta\Supervisord\Command;
use Francodacosta\Supervisord\ConfigurationItemInterface;
use Francodacosta\Supervisord\Processors\CommandConfigurationProcessor;

class FakeClass implements ConfigurationItemInterface
{
    public function set($key, $value){}
    public function get($key = null){}
}
class CommandConfigurationProcessorTest extends \PHPUnit_Framework_TestCase
{

    public function testAppliesTo()
    {
        $processor = new CommandConfigurationProcessor;

        $this->assertTrue($processor->appliesTo(new Command));
        $this->assertFalse($processor->appliesTo(new FakeClass));
    }

    public function testProcessWithPathCommandWithParameters()
    {
        $processor = new CommandConfigurationProcessor;
        $command = new Command;

        $command->set('command', '/usr/bin/ls -la');
        $command->set('numprocs', 3);

        $config = $processor->process($command);
// echo $config; die;
        $data = "[program:ls]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/ls -la
numprocs=3";

        $this->assertEquals($data, $config);
    }

    public function testProcessWithPathCommandNoParameters()
    {
        $processor = new CommandConfigurationProcessor;
        $command = new Command;

        $command->set('command', '/usr/bin/ls');
        $command->set('numprocs', 3);

        $config = $processor->process($command);
// echo $config; die;
        $data = "[program:ls]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/ls
numprocs=3";

        $this->assertEquals($data, $config);
    }

    public function testProcessWithOutPathCommandNoParameters()
    {
        $processor = new CommandConfigurationProcessor;
        $command = new Command;

        $command->set('command', 'ls');
        $command->set('numprocs', 3);

        $config = $processor->process($command);
// echo $config; die;
        $data = "[program:ls]
process_name=%(program_name)s_%(process_num)02d
command=ls
numprocs=3";

        $this->assertEquals($data, $config);
    }

    public function testProcessWithForcedProgramName()
    {
        $processor = new CommandConfigurationProcessor;
        $command = new Command;

        $command->set('command', 'ls');
        $command->set('name', 'foo');
        $command->set('numprocs', 3);

        $config = $processor->process($command);
// echo $config; die;
        $data = "[program:foo]
process_name=%(program_name)s_%(process_num)02d
command=ls
name=foo
numprocs=3";

        $this->assertEquals($data, $config);
    }
}
