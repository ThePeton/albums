<?php
namespace App\UnitTestBundle;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppTestCase extends WebTestCase
{
    protected static $consoleQuite = true;
    private static $client;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private static $container;
    private static $application;
    private static $environment = 'test';

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client A Client instance
     */
    public static function getClient()
    {
        return self::$client;
    }

    /**
     * @return string
     */
    public static function getEnvironment()
    {
        return self::$environment;
    }

    public static function setUpBeforeClass()
    {
        try {
            self::initProperties();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function initProperties()
    {
        $client = static::createClient(['environment' => self::$environment, 'debug' => true]);
        self::$container = $client->getContainer();
        self::$client = $client;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public static function getContainer()
    {
        return self::$container;
    }

    /**
     * It always run with given environment and in quiet mode (no output on the console)
     * @param $command
     * @param array $options
     * @param bool $checkResult
     * @throws \Exception
     * @return int
     */
    protected static function runConsole($command, array $options = [], $checkResult = true)
    {
        $options['-e'] = self::$environment;
        if (self::$consoleQuite) {
            $options['-q'] = true;
        }

        $input = new ArrayInput(array_merge($options, array('command' => $command)));

        self::getApplication()->setCatchExceptions(false);

        $result = self::getApplication()->run($input);

        if (0 != $result && $checkResult) {
            throw new \RuntimeException(sprintf('Something has gone wrong, got return code %d for command %s', $result, $command));
        }

        return $result;
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            self::$application = new Application(self::$kernel);
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }
}
