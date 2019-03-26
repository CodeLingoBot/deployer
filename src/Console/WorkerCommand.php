<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Console;

use Deployer\Deployer;
use Deployer\Exception\GracefulShutdownException;
use Deployer\Exception\NonFatalException;
use Deployer\Host\Host;
use Deployer\Host\Storage;
use Deployer\Task\Context;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
class WorkerCommand extends Command
{
    /**
     * @var Deployer
     */
    private $deployer;

    /**
     * @var Host
     */
    private $host;

    /**
     * @param Deployer $deployer
     */
    public function __construct(Deployer $deployer)
    {
        parent::__construct('worker');
        $this->setDescription('Deployer uses workers for parallel deployment');
        if (method_exists($this, 'setHidden')) {
            $this->setHidden(true);
        }
        $this->deployer = $deployer;
        $this->addArgument(
            'stage',
            InputArgument::OPTIONAL,
            'Stage or hostname'
        );
        $this->addOption(
            'hostname',
            null,
            InputOption::VALUE_REQUIRED
        );
        $this->addOption(
            'task',
            null,
            InputOption::VALUE_REQUIRED
        );
        $this->addOption(
            'config-file',
            null,
            InputOption::VALUE_REQUIRED
        );
        $this->addOption(
            'log',
            null,
            InputOption::VALUE_REQUIRED
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->doExecute($input, $output);
        } catch (GracefulShutdownException $e) {
            $this->deployer->informer->taskException($e, $this->host);
            return 1;
        } catch (NonFatalException $e) {
            $this->deployer->informer->taskException($e, $this->host);
            return 2;
        } catch (\Throwable $e) {
            $this->deployer->informer->taskException($e, $this->host);
            return 255;
        }
    }

    
}
