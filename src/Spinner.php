<?php

namespace Rahul900Day\LaravelConsoleSpinner;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class Spinner
{
    /**
     * @var array
     */
    protected $chars;

    /**
     * @var \Symfony\Component\Console\Helper\ProgressBar
     */
    protected $progressBar;

    /**
     * @var int
     */
    protected $step;

    public function __construct(int $max = 0)
    {
        $this->step = 0;
        $this->chars = config('console-spinner.chars');

        $section = (new ConsoleOutput())->section();
        $this->progressBar = new ProgressBar($section, $max);
        $this->progressBar->setBarCharacter('✔');
        $this->progressBar->setProgressCharacter($this->chars[0]);
        $this->progressBar->setFormat('%bar% %message%');
        $this->progressBar->setBarWidth(1);
        $this->progressBar->setRedrawFrequency(31);
    }

    /**
     * @return \Symfony\Component\Console\Helper\ProgressBar
     */
    public function getOriginalProgressBar()
    {
        return $this->progressBar;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->progressBar, $name], $arguments);
    }

    public function start(int $max = null)
    {
        $this->progressBar->start($max);
    }

    public function advance(int $step = 1)
    {
        $this->step += $step;
        $this->progressBar->setProgressCharacter($this->chars[$this->step % count($this->chars)]);
        $this->progressBar->advance($step);
    }
}