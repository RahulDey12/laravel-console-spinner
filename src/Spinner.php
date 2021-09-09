<?php

namespace Rahul900Day\LaravelConsoleSpinner;

use Illuminate\Console\OutputStyle;

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

    public function __construct(OutputStyle $output, int $max = 0)
    {
        $this->step = 0;
        $this->chars = config('console-spinner.chars');

        $this->progressBar = $output->createProgressBar($max);
        $this->progressBar->setBarCharacter('✔');
        $this->progressBar->setProgressCharacter($this->chars[0]);
        $this->progressBar->setMessage('');
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

    public function advance(int $step = 1)
    {
        $this->step += $step;
        $this->progressBar->setProgressCharacter($this->chars[$this->step % count($this->chars)]);
        $this->progressBar->advance($step);
    }
}
