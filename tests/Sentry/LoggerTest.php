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

namespace Superbrave\LoggerBundle\Tests\Sentry;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use RuntimeException;
use Sentry\Severity;
use Sentry\State\HubInterface;
use Superbrave\LoggerBundle\Sentry\Logger;

/**
 * LoggerTest.
 */
class LoggerTest extends TestCase
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var HubInterface|MockObject
     */
    private $hubMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->hubMock = $this->getMockBuilder(HubInterface::class)
            ->getMock();

        $this->logger = new Logger($this->hubMock);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->hubMock = null;
        $this->logger = null;
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
    public function testLog(string $level, string $message, Severity $severity)
    {
        $this->hubMock->expects($this->once())
            ->method('captureMessage')
            ->with($message, $this->equalTo($severity));

        $this->logger->log($level, $message);
    }

    /**
     * Tests if Logger::logException passes the exception to HubInterface::captureException.
     */
    public function testLogException()
    {
        $exception = new RuntimeException('Foo!');

        $this->hubMock->expects($this->once())
            ->method('captureException')
            ->with($exception);

        $this->logger->logException($exception);
    }

    /**
     * Returns a list with test-cases for @see testLog.
     *
     * @return array
     */
    public function provideLogTestCases()
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
