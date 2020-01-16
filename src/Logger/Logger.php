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

namespace Superbrave\LoggerBundle\Logger;

use Psr\Log\AbstractLogger;
use Superbrave\LoggerBundle\Adapter\AdapterInterface;
use Throwable;

class Logger extends AbstractLogger
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Logger constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Pass the message to the log method of the adapter
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $array
     */
    public function log($level, $message, array $array = []): void
    {
        $this->adapter->log($level, $message, $array);
    }

    /**
     * Pass the exception to the logException method of the adapter
     *
     * @param Throwable $exception
     */
    public function logException(Throwable $exception): void
    {
        $this->adapter->logException($exception);
    }
}
