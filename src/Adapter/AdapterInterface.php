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

use Throwable;

/**
 * Interface AdapterInterface.
 *
 * Simply write a new adapter that extends this interface and implement the necessary logic for interaction with your
 * logging provider (New Relic, Sentry etc.) into the log and logException method. Inject this adapter into the Logger
 * class in the service definition and you are ready to go.
 */
interface AdapterInterface
{
    /**
     * This method will be used by the Logger to log messages to the adapters logging provider.
     *
     * @param mixed $level
     * @param mixed $message
     * @param array $array
     */
    public function log($level, $message, array $array = []): void;

    /**
     * This method will be used by the Logger to log exceptions to the adapters logging provider.
     *
     * @param Throwable $exception
     */
    public function logException(Throwable $exception): void;
}
