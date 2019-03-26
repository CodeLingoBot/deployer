<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Initializer;

use Deployer\Initializer\Exception\IOException;
use Deployer\Initializer\Exception\TemplateNotFoundException;
use Deployer\Initializer\Template\TemplateInterface;

/**
 * Initializer system
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class Initializer
{
    /**
     * @var array|TemplateInterface[]
     */
    private $templates;

    /**
     * Add template to initializer
     *
     * @param string            $name
     * @param TemplateInterface $template
     *
     * @return Initializer
     */
    public function addTemplate($name, TemplateInterface $template)
    {
        $this->templates[$name] = $template;

        return $this;
    }

    /**
     * Get template names
     *
     * @return array
     */
    public function getTemplateNames()
    {
        return array_keys($this->templates);
    }

    /**
     * Initialize deployer in project
     *
     * @param string $template
     * @param string $directory
     * @param string $file
     * @param array $params
     * @return string The configuration file path
     *
     * @throws TemplateNotFoundException
     */
    public function initialize($template, $directory, $file = 'deploy.php', $params = [])
    {
        if (!isset($this->templates[$template])) {
            throw TemplateNotFoundException::create($template, array_keys($this->templates));
        }

        $this->checkDirectoryBeforeInitialize($directory);
        $this->checkFileBeforeInitialize($directory, $file);

        $filePath = $directory . '/' . $file;

        $this->templates[$template]->initialize($filePath, $params);

        return $filePath;
    }

    /**
     * Check the directory before initialize
     *
     * @param string $directory
     *
     * @throws IOException
     */
    

    /**
     * Check the file before initialize
     *
     * @param string $directory
     * @param string $file
     *
     * @throws IOException
     */
    
}
