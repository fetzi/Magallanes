<?php
/*
 * This file is part of the Magallanes package.
*
* (c) Andrés Montañez <andres@andresmontanez.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Mage\Task;

use Exception;
use Mage\Config;

/**
 * Task Factory
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class Factory
{
    /**
     * Gets an instance of a Task.
     *
     * @param string|array $taskData
     * @param \Mage\Config $taskConfig
     * @param bool $inRollback
     * @param string $stage
     * @return \Mage\Task\AbstractTask
     * @throws \Exception
     */
    public static function get($taskData, Config $taskConfig, $inRollback = false, $stage = null)
    {
        if (is_array($taskData)) {
            $taskName       = $taskData['name'];
            $taskParameters = $taskData['parameters'];
        } else {
            $taskName       = $taskData;
            $taskParameters = array();
        }

        $instance = null;
        $taskName = ucwords(str_replace('-', ' ', $taskName));
        $taskName = str_replace(' ', '', $taskName);

        if (strpos($taskName, '/') === false) {
            $className = 'Task\\' . $taskName;
        } else {
            $className = str_replace(
                ' ',
                '\\',
                ucwords(str_replace('/', ' ', $taskName))
            );
            $className = 'Mage\\Task\\BuiltIn\\' . $className . 'Task';
        }

        if (!class_exists($className)) {
            throw new Exception('Task "' . $taskName . '" not found.');
        }

        $instance = new $className($taskConfig, $inRollback, $stage, $taskParameters);

        if (!($instance instanceof AbstractTask)) {
            throw new Exception('The Task ' . $taskName . ' must be an instance of Mage\Task\AbstractTask.');
        }

        return $instance;
    }
}