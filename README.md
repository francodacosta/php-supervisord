php-supervisord
===============

generate supervisord configuration files

```php
<<?php

require __DIR__ . '/../../vendor/autoload.php';

use Francodacosta\Supervisord\Loader\ArrayLoader;
use Francodacosta\Supervisord\Configuration;
use Francodacosta\Supervisord\Processors\CommandConfigurationProcessor;

// setup supervisord config object, with a processor for command entries
$configuration = new Configuration;
$configuration->registerProcessor(new CommandConfigurationProcessor);

// configuration to generate
$config = array(
    'programs' => array(
        'cat command' => array('command' => 'tail -f /var/log/messages'),
        'ls command' => array('command' => 'ls -la', 'numprocs' => 3),
    )
);

// load the configuration object from the $config array
$loader = new ArrayLoader($config, $configuration);
$supervisordConfig = $loader->load();

// dump the generate configuration
echo $supervisordConfig->generate();

```

this generates the following configuraiton

```ini
[program:tail]
command=tail -f /var/log/messages

[program:ls]
process_name=%(program_name)s_%(process_num)02d
command=ls -la
numprocs=3
```
