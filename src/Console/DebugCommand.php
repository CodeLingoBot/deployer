<?php
/* (c) Anton Medvedev <anton@medv.io>
/* (c) Oskar van Velden <oskar@rakso.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Console;

use Deployer\Deployer;
use Deployer\Task\GroupTask;
use Deployer\Task\TaskCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;

class DebugCommand extends Command
{
    /** @var Output */
    protected $output;

    /**
     * @var TaskCollection
     */
    private $tasks;

    /**
     * @var Deployer
     */
    private $deployer;

    /**
     * @var array
     */
    private $tree;

    /**
     * Depth of nesting (for rendering purposes)
     * @var int
     */
    private $depth = 0;

    /**
     * @var array
     */
    private $openGroupDepths = [];

    /**
     * @param Deployer $deployer
     */
    public function __construct(Deployer $deployer)
    {
        parent::__construct('debug:task');
        $this->setDescription('Display the task-tree for a given task');
        $this->deployer = $deployer;
        $this->tree = [];
    }

    /**
     * Configures the command
     */
    protected function configure()
    {
        $this->addArgument(
            'task',
            InputArgument::REQUIRED,
            'Task to display the tree for'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(Input $input, Output $output)
    {
        $this->output = $output;

        $rootTaskName = $input->getArgument('task');

        $this->buildTree($rootTaskName);
        $this->outputTree($rootTaskName);
    }

    /**
     * Build the tree based on the given taskName
     * @param $taskName
     *
     * @return void
     */
    

    /**
     * Create a tree from the given taskname
     *
     * @param string $taskName
     * @param string $postfix
     * @param bool $isLast
     *
     * @return void
     */
    

    /**
     * Add the (formatted) taskName to the rendertree, with some additional information
     *
     * @param string $taskName formatted with prefixes if needed
     * @param bool $isLast indication for what symbol to use for rendering
     */
    

    /**
     * Render the tree, after everything is build
     *
     * @param $taskName
     */
    
}
