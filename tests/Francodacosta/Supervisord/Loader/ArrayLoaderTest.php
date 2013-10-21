<?php
use Francodacosta\Supervisord\Loader\ArrayLoader;
use Francodacosta\Supervisord\Configuration;

class ArrayLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $obj = new ArrayLoader();

        $config = array(
            'programs' => array(
                'ls command' => array('command' => 'ls -la'),
                'cat command' => array('command' => 'tail -f /var/log/messages'),
            )
        );

        $obj->setSource($config);
        $obj->setConfiguration(new Configuration);

        $results = $obj->load();

        $this->assertInstanceOf('\Francodacosta\Supervisord\Configuration', $results);

        $results = $results->getItems();

        $this->assertInternalType('array', $results);
        $this->assertCount(2, $results);

        $singleResult = $results[0];
        $this->assertInstanceOf('\Francodacosta\Supervisord\Command', $singleResult);
        $this->assertEquals('ls -la', $singleResult->get('command'));

        $singleResult = $results[1];
        $this->assertInstanceOf('\Francodacosta\Supervisord\Command', $singleResult);
        $this->assertEquals('tail -f /var/log/messages', $singleResult->get('command'));

    }
}
