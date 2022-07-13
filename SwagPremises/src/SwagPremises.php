<?php declare(strict_types=1);
/**
 * Swag Premises module
 *
 * @category  Business Assets
 * @package   \Swag\Premises\SwagPremises
 * @author    Scott Anderson <s.anderson@shopware.com>
 * @copyright 2022 shopware AG
 * @license   https://opensource.org/licenses/MIT MIT license
 */

namespace Swag\Premises;

use Shopware\Core\Framework\Plugin;

$autoloader = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($autoloader)) {
    require_once $autoloader;
}

class SwagPremises extends Plugin
{
}
