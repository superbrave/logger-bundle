<?php
/**
 * This file is part of the Logger bundle.
 *
 * @category  Bundle
 * @author    SuperBrave <info@superbrave.nl>
 * @copyright 2020 SuperBrave <info@superbrave.nl>
 * @license   https://github.com/superbrave/logger-bundle/blob/master/LICENSE MIT
 * @see       https://www.superbrave.nl/
 */

namespace Superbrave\LoggerBundle\Tests\Adapter;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use RuntimeException;
use Sentry\Severity;
use Sentry\State\HubInterface;
use Superbrave\LoggerBundle\Adapter\SentryAdapter;

class SentryAdapterTest extends TestCase
{
    /**
     * @var HubInterface|MockObject
     */
    private $mockHub;

    /**
     * @var SentryAdapter
     */
    private $adapter;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->mockHub = $this->getMockBuilder(HubInterface::class)
            ->getMock();

        $this->adapter = new SentryAdapter($this->mockHub);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->mockHub = null;
        $this->adapter = null;
    }

    /**
     * Tests if Logger::log passes the message with level transformed to Severity to HubInterface::captureMessage.
     *
     * @dataProvider provideLogTestCases
     *
     * @param string   $level
     * @param string   $message
     * @param Severity $severity
     */
    public function testLog(string $level, string $message, Severity $severity): void
    {
        $this->mockHub->expects($this->once())
            ->method('captureMessage')
            ->with($message, $this->equalTo($severity));

        $this->adapter->log($level, $message);
    }

    /**
     * Tests if Logger::logException passes the exception to HubInterface::captureException.
     */
    public function testLogException(): void
    {
        $exception = new RuntimeException('Foo!');

        $this->mockHub->expects($this->once())
            ->method('captureException')
            ->with($this->equalTo($exception));

        $this->adapter->logException($exception);
    }

    /**
     * Returns a list with test-cases for @return array
     *
     * @see testLog.
     */
    public function provideLogTestCases(): array
    {
        return [
            [LogLevel::EMERGENCY, 'Test message', Severity::fatal()],
            [LogLevel::ALERT, 'Test message', Severity::fatal()],
            [LogLevel::CRITICAL, 'Test message', Severity::fatal()],
            [LogLevel::ERROR, 'Test message', Severity::error()],
            [LogLevel::WARNING, 'Test message', Severity::warning()],
            [LogLevel::NOTICE, 'Test message', Severity::warning()],
            [LogLevel::INFO, 'Test message', Severity::info()],
            [LogLevel::DEBUG, 'Test message', Severity::debug()],
            ['undefined loglevel', 'Test message', Severity::error()],
        ];
    }
}
