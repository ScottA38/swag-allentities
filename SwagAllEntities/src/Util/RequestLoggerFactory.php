<?php
declare(strict_types=1);

namespace Swag\AllEntities\Util;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Shopware\Core\Kernel;

/**
 * Class RequestLoggerFactory
 */
class RequestLoggerFactory
{
    public const LOG_FILE_NAME = "api_hits.log";

    private string $fileName;

    /**
     * @param Kernel $kernel
     */
    public function __construct(Kernel $kernel)
    {
        $this->fileName = implode(
            DIRECTORY_SEPARATOR,
            [$kernel->getLogDir(), static::LOG_FILE_NAME]
        );
    }

    /**
     * @return Logger
     */
    public function create(): Logger
    {
        $logger = new Logger("api_hits");
        $handler = new StreamHandler($this->fileName);
        $psrLogMessageProcessor = new PsrLogMessageProcessor();
        $logger->pushHandler($handler);
        $logger->pushProcessor($psrLogMessageProcessor);

        return $logger;
    }
}
