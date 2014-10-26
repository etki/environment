# Another useful PHP package

Hi there, kids.

This package helps with everyday environment-related tasks - save and restore
`$_POST`/`$_GET`/`$_ENV`/`$_SERVER` and even `$_COOKIE` and `$_SESSION`, verify
that your request comes from CLI or from web, retrieve family of current OS,
run shell commands without hassle and *stuff*.

# Installation

## Swag installation

```bash
composer require etki/environment:~0.1.0
```

## Oldskool installation

```bash
wget -O env.zip https://github.com/etki/environment/archive/master.zip
unzip env.zip && rm env.zip
mkdir -p vendor/etki
mv environment-master vendor/etki/environment
```

And require `vendor/etki/environment/autoload.php` in your code. 

## Handmade installation

Download `.zip`, unpack, require `autoload.php` in your code.

# Usage

## Working with global variables

```php
$environment = new Etki\Environment\Environment;

// Emulating environment
$snapshot = $environment->variables->load(
    [
        'get' => [
            'step' => 2,
        ],
        'post' => [
            'dbname' => 'wordpress',
            'uname' => 'wordpress',
            'pwd' => 'oh my god this is password so secret i'm gonna tweet about it',
            'dbhost' => 'localhost',
            'prefix' => 'wp_',
        ],
    ]
);

// A little bit of customization

$environment->variables->setQueryParameter('with-kittens', 'yes, please');

// Another snap, please

$secondShot = $environment->variables->snapshot();

require $wpRoot . '/wp-admin/setup-config.php';

// Restoring pre-emulated environment.
$environment->variables->reset();
// Actually, restore(0) would give the very same thing, though reset(true) will
// erase everything it can. Be careful with session, though.

// oh my god, i've forgot to do something! time machine to the rescue!

$environment->variables->restore($snapshot);

// Oh yeah, kittens

$environment->variables->restore($secondShot);

// Did you know that thing use incremental backups and doesn't erase history
// entries past restore point by default?

// ...but it will erase them as soon as you'll start rewriting it

$environment->variables->reset();
$environment->variables->snapshot();
$environment->variables->restore($secondSnap); // will throw an exception
// however, $secondSnap is just an integer ID, no hashing magic, so it's value
// *may* become legal later
```

Boring API:

```
$environment->variables->setQueryParameter($key, $value);

// will throw an exception if parameter doesn't exist
$environment->variables->getQueryParameter($key);
// will return default if the parameter doesn't exit
$environment->variables->getQueryParameter($key, $default);

$environment->variables->hasQueryParameter($key);
// Won't throw an exception. Since user's intention is destroying this
// parameter, it is considered that action has succeeded.
$environment->variables->deleteQueryParameter($key);

// the very same behavior with post, request, session, cookie and server.

// simple wrapper around server HTTP_* variables
$environment->variables->getHeader($key);
$environment->variables->getHeader($key, $default);
```

## Fetching OS data

```php
$environment = new Etki\Environment\Environment;
$environment->os->getFamily();         // 'ubuntu'
$environment->os->getFamilyBranch();   // ['unix', 'linux', 'debian', 'ubuntu']
                                       // i guess i'll rename this method later,
                                       // though it will be supported up to 1.0
$environment->os->belongsTo('unix');   // true
$environment->os->belongsTo('linux');  // true
$environment->os->belongsTo('debian'); // true
$environment->os->belongsTo('ubuntu'); // true; that's the last level for now
$environment->os->belongsTo('mac');    // false; moreover, this detection is not
                                       // implemented yet
$environment->os->locateBinary('php'); // '/usr/bin/php';
$environment->os->getTemporaryDirectory(); // Simple wrapper for sys_get_temp_dir()
                                       // Added only to keep code consistency.
```

Planned for future updates:

```php
$environment->os->getBitness();        // 64
// Etki\Environment\OperatingSystem\OperatingSystemInterface::ARCHITECTURE_X86_64
$environment->os->getArchitecture();

// Some of these will throw exceptions on some platforms
$environment->os->getVersion();        // 14.04
$environment->os->getCodename();       // 'trusty'
$environment->os->getDescription();    // 'Ubuntu 14.04.1 LTS' (even though it's Lubuntu)
$environment->os->getKernelVersion();  // '3.13.0-37-generic'
$environment->os->user->isSuperuser(); // false
$environment->os->signal($pid, $signal);
$environment->os->kill($pid);
```

## Shell

```php
// throws RuntimeException if exit code is other than 0
// returns Etki\Environment\OperatingSystem\Shell\ExecutionResult
$environment->shell->execute('/usr/local/bin/composer update -d /var/www/project');
// Heya, no exceptions
$environment->shell->execute('/usr/local/bin/composer update -d /var/www/project', true);

// Quite the same effect, but will print execution data directly on screen, and
// result won't have any output attached for obvious reasons. This may change
// in future versions.
$environment->shell->passthru('/usr/local/bin/composer update -d /var/www/project');
$environment->shell->passthru('/usr/local/bin/composer update -d /var/www/project', true);

// You know the drill. Basically appends os-dependent run-in-background flag
$environment->shell->background('/usr/local/bin/composer update -d /var/www/project');

// Alternative syntax for command setting. Will auto-escape spaces and convert
// boolean true/false into string 'true' and 'false'. Will also throw exceptions
// on non-convertible types.
$environment->shell->execute(['command', '--flag', true, 'directory with spaces']);
```

## Interpreter

The name of the magic property is subject to change in future releases (though
it will be supported up to release 1.0)

```php
$environment->interpreter->getVersion();       // 5.5.9
$environment->interpreter->getVersion(true);   // 5.5.9-1ubuntu4.4
$environment->interpreter->isSessionEnabled(); // true
$environment->interpreter->getExtensions();    // ['Core', 'date', 'ereg',..]
```