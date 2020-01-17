<?php
/**
 * This file is part of the Logger bundle.
 *
 * @category  Bundle
 *
 * @author    SuperBrave <info@superbrave.nl>
 * @copyright 2020 SuperBrave <info@superbrave.nl>
 * @license   https://github.com/superbrave/logger-bundle/blob/master/LICENSE MIT
 *
 * @see       https://www.superbrave.nl/
 */

namespace Superbrave\LoggerBundle\Tests\Logger;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use RuntimeException;
use Superbrave\LoggerBundle\Adapter\AdapterInterface;
use Superbrave\LoggerBundle\Logger\Logger;

/**
 * LoggerTest.
 */
class LoggerTest extends TestCase
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->adapter = $this->createMock(AdapterInterface::class);

        $this->logger = new Logger($this->adapter);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->adapter = null;
        $this->logger = null;
    }

    /**
     * Tests if Logger::log passes the message with level transformed to Severity to HubInterface::captureMessage.
     *
     * @dataProvider provideLogTestCases
     *
     * @param string $level
     * @param string $message
     */
    public function testLog(string $level, string $message): void
    {
        $this->adapter->expects($this->once())
            ->method('log')
            ->with($this->equalTo($level), $this->equalTo($message));

        $this->logger->log($level, $message);
    }

    /**
     * Tests if Logger::logException passes the exception to HubInterface::captureException.
     */
    public function testLogException(): void
    {
        $exception = new RuntimeException('Foo!');

        $this->adapter->expects($this->once())
            ->method('logException')
            ->with($this->equalTo($exception));

        $this->logger->logException($exception);
    }

    /**
     * Returns a list with test-cases for @see testLog.
     *
     * @return array
     */
    public function provideLogTestCases(): array
    {
        return [
            [LogLevel::EMERGENCY, 'Test message'],
            [LogLevel::ALERT, 'Test message'],
            [LogLevel::CRITICAL, 'Test message'],
            [LogLevel::ERROR, 'Test message'],
            [LogLevel::WARNING, 'Test message'],
            [LogLevel::NOTICE, 'Test message'],
            [LogLevel::INFO, 'Test message'],
            [LogLevel::DEBUG, 'Test message'],
            ['undefined loglevel', 'Test message'],
        ];
    }
}
