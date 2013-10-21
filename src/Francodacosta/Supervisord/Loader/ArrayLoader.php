<?php
namespace Francodacosta\Supervisord\Loader;

use Francodacosta\Supervisord\ConfigurationItemInterface;
use Francodacosta\Supervisord\Command;
use Francodacosta\Supervisord\Configuration;

class ArrayLoader implements LoaderInterface
{
    private $source;
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct($source = null, $configuration = null)
    {
        $this->setSource($source);
        $this->setConfiguration($configuration);
    }

    /**
     * Gets the value of source.
     *
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets the value of source.
     *
     * @param mixed $source the source
     *
     * @return self
     */
    public function setSource($source)
    {
        if (null === $source) {
            return;
        }

        if (false === is_array($source)) {
            throw new \InvalidArgumentException("source expecting array got " . gettype($source));

        }
        $this->source = $source;

        return $this;
    }

    private function processGenericEntry(ConfigurationItemInterface $obj, $data)
    {
        foreach ($data as $key => $value) {
            $obj->set($key, $value);
        }

        return $obj;
    }

    private function processCommandEntry(array $entry)
    {
        $ret = array();
        foreach ($entry as $commandName => $config) {
            $ret[] = $this->processGenericEntry(new Command, $config);
        }

        return $ret;
    }

    /**
     * processes an configuration entry
     *
     * @param string $key
     * @param array  $data
     *
     * @return array
     */
    private function processEntry($key, array $data)
    {
        switch (strtolower($key)) {
            case 'command':
            case 'program':
            case 'commands':
            case 'programs':
                return $this->processCommandEntry($data);
                break;
        }
    }

    /**
     * loads this configuration.
     * example configuration:
     *     array (
     *         "command" => array(
     *             'command 1' => array()
     *             ...
     *             'command N' => array()
     *         )
     *     )
     *
     * @return Configuration
     */
    public function load()
    {
        $configurationObject = $this->getConfiguration();

        $config = array();
        foreach ($this->getSource() as $key => $data) {
            $processed = $this->processEntry($key, $data);
            $config = array_merge($config, $processed);
        }

        foreach ($config as $configItem) {
            $configurationObject->add($configItem);
        }

        return $configurationObject;
    }

    /**
     * Gets the value of configuration.
     *
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Sets the value of configuration.
     *
     * @param Configuration $configuration the configuration
     *
     * @return self
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }
}
