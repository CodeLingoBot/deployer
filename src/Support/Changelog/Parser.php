<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Support\Changelog;

class Parser
{
    /**
     * @var string[]
     */
    private $tokens;

    /**
     * @var string[]
     */
    private $span;

    /**
     * @var int
     */
    private $lineNumber = 0;

    /**
     * @var bool
     */
    private $strict;

    public function __construct(string $changelog, bool $strict = true)
    {
        $this->tokens = array_map('trim', explode("\n", $changelog));
        $this->strict = $strict;
    }

    

    

    

    

    

    

    public function parse(): Changelog
    {
        $changelog = $this->parseTitle();

        $this->acceptEmptyLine();
        $this->acceptEmptyLine();

        while ($this->matchVersion($this->current())) {
            $version = $this->parseVersion();
            $changelog->addVersion($version);
        }

        $refs = $this->parseReferences();
        $changelog->setReferences($refs);

        $this->acceptEmptyLine();
        $this->acceptEof();

        return $changelog;
    }

    

    

    

    
}
