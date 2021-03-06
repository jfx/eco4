<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class KernelDbTestCase extends KernelTestCase
{
    protected $entityManager;
    protected $application;

    protected function setUp()
    {
        self::bootKernel();

        $this->application = new Application(self::$kernel);
        $this->application->setAutoExit(false);

        $this->execute('doctrine:database:drop --force --no-interaction');
        $this->execute('doctrine:database:create --no-interaction');
        $this->execute('doctrine:schema:create --no-interaction');
        $this->execute('doctrine:fixtures:load --no-interaction');

        $this->container = static::$kernel->getContainer();

        $this->entityManager = $this->container->get('doctrine')->getManager();
    }

    protected function execute($command)
    {
        $input = new StringInput($command);
        $output = new NullOutput();

        $this->application->run($input, $output);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
