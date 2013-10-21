php-supervisord
===============

generate supervisord configuration files

```
use Francodacosta\Supervisord\Loader\ArrayLoader;
use Francodacosta\Supervisord\Configuration;

$config = array(
    'programs' => array(
        'ls command' => array('command' => 'ls -la'),
        'cat command' => array('command' => 'tail -f /var/log/messages'),
    )
);

$loader = new ArrayLoader($config, new Configuration);

$supervisordConfig = $loader->load();

file_put_contents('supervisord.conf', $supervisordConfig->generate());

```
