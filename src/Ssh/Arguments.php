<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer\Ssh;

use Deployer\Exception\Exception;
use Deployer\Host\Host;

/**
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class Arguments
{
    /**
     * @var array
     */
    private $flags = [];

    /**
     * @var array
     */
    private $options = [];

    public function getCliArguments()
    {
        $boolFlags = array_keys(array_filter($this->flags, 'is_null'));

        $valueFlags = array_filter($this->flags);
        $valueFlags = array_map(function ($key, $value) {
            return "$key $value";
        }, array_keys($valueFlags), $valueFlags);

        $options = array_map(function ($key, $value) {
            return "-o $key=$value";
        }, array_keys($this->options), $this->options);

        $args = sprintf('%s %s %s', implode(' ', $boolFlags), implode(' ', $valueFlags), implode(' ', $options));

        return trim(preg_replace('!\s+!', ' ', $args));
    }

    public function getOption(string $option)
    {
        return $this->options[$option] ?? '';
    }

    public function getFlag(string $flag)
    {
        if (!array_key_exists($flag, $this->flags)) {
            return false;
        }

        return $this->flags[$flag] ?? true;
    }

    public function withFlags(array $flags)
    {
        $clone = clone $this;
        $clone->flags = $this->buildFlagsFromArray($flags);

        return $clone;
    }

    public function withOptions(array $options)
    {
        $clone = clone $this;
        $clone->options = $options;

        return $clone;
    }

    public function withFlag(string $flag, string $value = null)
    {
        $clone = clone $this;
        $clone->flags = array_merge($this->flags, [$flag => $value]);

        return $clone;
    }

    public function withOption(string $option, string $value)
    {
        $clone = clone $this;
        $clone->options = array_merge($this->options, [$option => $value]);

        return $clone;
    }

    public function withDefaults(Arguments $defaultOptions)
    {
        $clone = clone $this;
        $clone->options = array_merge($defaultOptions->options, $this->options);
        $clone->flags = array_merge($defaultOptions->flags, $this->flags);

        return $clone;
    }

    public function withMultiplexing(Host $host)
    {
        $controlPath = $this->generateControlPath($host);

        $multiplexDefaults = (new Arguments)->withOptions([
            'ControlMaster' => 'auto',
            'ControlPersist' => '60',
            'ControlPath' => $controlPath,
        ]);

        return $this->withDefaults($multiplexDefaults);
    }

    /**
     * Return SSH multiplexing control path
     *
     * When ControlPath is longer than 104 chars we can get:
     *
     *     SSH Error: unix_listener: too long for Unix domain socket
     *
     * So try to get as descriptive path as possible.
     * %C is for creating hash out of connection attributes.
     *
     * @param Host $host
     * @return string ControlPath
     * @throws Exception
     */
    

    

    public function __toString()
    {
        return $this->getCliArguments();
    }
}
