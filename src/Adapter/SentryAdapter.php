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

namespace Superbrave\LoggerBundle\Adapter;

use Psr\Log\LogLevel;
use Sentry\Severity;
use Sentry\State\HubInterface;
use Throwable;

/**
 * Class SentryAdapter.
 *
 * This adapter can be used in the Logger to implement Sentry for logging
 */
class SentryAdapter implements AdapterInterface
{
    /**
     * @var HubInterface
     */
    private $hub;

    /**
     * @var array
     */
    private $severityLevels;

    /**
     * Constructs a new Logger instance.
     *
     * @param HubInterface $hub
     */
    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;

        $this->severityLevels = [
            LogLevel::EMERGENCY => Severity::fatal(),
            LogLevel::ALERT => Severity::fatal(),
            LogLevel::CRITICAL => Severity::fatal(),
            LogLevel::ERROR => Severity::error(),
            LogLevel::WARNING => Severity::warning(),
            LogLevel::NOTICE => Severity::warning(),
            LogLevel::INFO => Severity::info(),
            LogLevel::DEBUG => Severity::debug(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = []): void
    {
        $this->hub->captureMessage($message, $this->createSeverity($level));
    }

    /**
     * Logs the exception.
     *
     * @param Throwable $exception
     */
    public function logException(Throwable $exception): void
    {
        $this->hub->captureException($exception);
    }

    /**
     * Creates and returns a Severity instance based on the @see LogLevel.
     *
     * @param string $level
     *
     * @return Severity
     */
    private function createSeverity(string $level): Severity
    {
        // Force undefined log level to error level
        if (false === array_key_exists($level, $this->severityLevels)) {
            $level = LogLevel::ERROR;
        }

        return $this->severityLevels[$level];
    }
}
