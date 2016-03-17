<?php
namespace Mage\Task\BuiltIn\Composer;

use Mage\Task\ErrorWithMessageException;

class GenerateAutoloadTask extends ComposerAbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Generate autoload via Composer [built-in]';
    }

    /**
     * Runs the task
     *
     * @return bool
     * @throws ErrorWithMessageException
     */
    public function run()
    {
        return $this->runCommand($this->getComposerCmd() . ' dumpautoload --optimize');
    }
}