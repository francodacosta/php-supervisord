<?php
use Francodacosta\Supervisord\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
    }


    public function testSet()
    {
        $command = new Command;
        $command->set('command', 'command');

        $this->assertEquals('command', $command->get('command'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidOption()
    {
        $command = new Command;
        $command->set('sdfghjkl', 'command');

        $this->assertEquals('command', $command->get('command'));
    }

    public function testGet()
    {
        $command = new Command;
        $command->set('command', 'command');
        $command->set('numprocs', 10);

        $this->assertEquals(10, $command->get('numprocs'));

        $all = $command->get();

        $this->assertTrue(is_array($all));
        $this->assertEquals(2, count($all));
        $this->AssertSame('command', $all['command']);
        $this->AssertSame(10, $all['numprocs']);
    }

}
