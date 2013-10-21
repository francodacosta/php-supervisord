<?php

namespace Francodacosta\Supervisord;

class Command implements ConfigurationItemInterface{
    /**
     * currently set options
     *
     * @var array
     */
    private $options = array();

    /**
     * allowed option keys
     *
     * @var array
     */
    protected $allowedKeys = array(
        'name',
        'command',
        'process_name',
        'numprocs',
        'directory',
        'umask',
        'priority',
        'autostart',
        'autorestart',
        'startsecs',
        'startretries',
        'exitcodes',
        'stopsignal',
        'stopwaitsecs',
        'user',
        'redirect_stderr',
        'stdout_logfile',
        'stdout_logfile_maxbytes',
        'stdout_logfile_backups',
        'stdout_capture_maxbytes',
        'stderr_logfile',
        'stderr_logfile_maxbytes',
        'stderr_logfile_backups',
        'stderr_capture_maxbytes',
        'environment',
        'serverurl',
    );

    /**
     * should we check if key is in allowed keys
     *
     * @var boolean
     */
    private $checkKeys = true;


    public function __contruct($checkKeys = true)
    {
        $this->checkKeys = $checkKeys;
    }

    /**
     * Sets an option
     *
     * @param string $key   the option name
     * @param mixed  $value the option value
     */
    public function set($key, $value)
    {
        if ($this->checkKeys) {
            if (false === in_array($key, $this->allowedKeys)) {
                throw new \InvalidArgumentException('The option "'. $key .'" is not recognized');
            }
        }
        $this->options[$key] = $value;
    }

    /**
     * return the value of option $key or all if key is null
     *
     * @param  string|null $key the option name
     *
     * @return mixed|array
     */
    public function get($key = null)
    {
        if (null === $key) {
            return $this->options;
        }

        return $this->options[$key];
    }
}
