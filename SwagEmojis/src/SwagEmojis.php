<?php
declare(strict_types=1);

namespace Swag\Emojis;

if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

use Shopware\Core\Framework\Plugin;

/**
 * Class SwagEmojis
 */
class SwagEmojis extends Plugin
{
}
