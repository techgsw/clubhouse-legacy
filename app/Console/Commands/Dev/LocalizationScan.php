<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class LocalizationScan extends Command
{
    protected $signature = 'lang:scan {--root=} {--file=} {--key=} {--string=} {--brief=}';
    protected $description = 'Scan Blade files for localization errors.';
    protected $totalFiles = 0;
    protected $tests = 0;
    protected $totalTests = 0;
    protected $totalErrors = 0;
    protected $errorDump;

    public function handle()
    {
        $this->errorDump = collect();

        $root = $this->option('root') ?: '/resources';

        $rootPath = base_path($root);

        collect(File::allFiles($rootPath))->each(function ($file) {
            $filePath = "\033[01;33m" . $file->getRelativePathname() . "\033[0m" . PHP_EOL;
            $contents = $file->getContents();

            if ($this->option('file') && $file->getRelativePathname() !== $this->option('file')) {
                return;
            }

            $errors = $this->readFile($filePath, $contents);

            $this->totalErrors+= $errors;
            $this->totalFiles++;

            $resultsOnly = $this->tests < 1 && $this->option('brief');

            if (! $resultsOnly && $this->option('verbose')) {
                echo $filePath;
            }

            if (! $resultsOnly && $errors === 0 && $this->option('verbose')) {
                echo " \033[01;32m{$this->tests} tests...OKAY\033[0m" . PHP_EOL;
            }

        });
        if (! $this->option('key')) {
            $this->echoSuccess();
        }

        if ($this->totalErrors === 0) {
            echo  "\033[01;32mNo errors found.\033[0m" . PHP_EOL;
        } else {
            $this->dumpErrors();
        }
    }

    protected function getMatches(string $line)
    {
        $matches = null;

        // Test for PHP files
        if (strpos($line, '__(') !== false) {
            preg_match_all("/(__\()(')([a-z._]+)('\)|,[\w]+)/", $line, $matches);
            $matches = $matches[3] ?? null;
        }
        if (strpos($line, 'trans_choice(') !== false) {
            preg_match_all("/(trans_choice\()(')([a-z._]+)(',)(.*)/", $line, $matches);
            $matches = $matches[3] ?? null;
        }
        // Tests for Vue/Javascript files
        if (strpos($line, 'language.') !== false) {
            preg_match_all("/(language.)([\w._]+)/", $line, $matches);
            $matches = $matches[2] ?? null;
        }
        if (strpos($line, 'icons.') !== false) {
            preg_match_all("/(icons.)([\w._]+)/", $line, $matches);
            $matches = $matches[2] ?? null;
            $matches = array_map(function ($match) {
                return 'icons.' . $match;
            }, $matches);
        }

        return $matches;
    }

    protected function readFile(string $filePath, string $contents)
    {
        $lineNum = 1;
        $errors = 0;
        $this->tests = 0;

        collect(explode("\n", $contents))->each(function ($line) use ($filePath, &$lineNum, &$errors) {
            $result = $this-> getMatches($line);
            if (! $result) {
                return;
            }

            $this->tests++;

            collect($result)->each(function ($found) use ($filePath, $line, &$lineNum, &$errors) {
                // __($found) === $found indicates that the localization string is not found in the lang files

                if ($this->option('key') && $this->option('key') === $found) {
                    echo $filePath;
                    echo "\t" . '"' . $found . '" found on Line ' . $lineNum . PHP_EOL;
                    return;
                }

                if ($found && (__($found) === $found || is_array(__($found)))) {
                    $message = $filePath;
                    $message .= "\t" . trim($line) . PHP_EOL;
                    $message .= "\tProblem: (" . $found . ')' . PHP_EOL;
                    $message .= "\t" . 'Line ' . $lineNum . PHP_EOL;

                    $this->errorDump->push($message);

                    $errors++;
                } else if ($this->option('string') === __($found)) {
                    $message = $filePath;
                    $message .= "\t" . trim($line) . PHP_EOL;
                    $message .= "\t" . 'Line ' . $lineNum . PHP_EOL;
                    echo $message;
                }

                $this->totalTests++;
            });

            $lineNum++;
        });

        return $errors;
    }

    protected function echoSuccess()
    {
        $tests = number_format($this->totalTests, 0, '.', ',');
        $files = number_format($this->totalFiles, 0, '.', ',');

        echo  "\033[01;32m{$tests} total tests in {$files} files.\033[0m" . PHP_EOL;
    }

    protected function dumpErrors()
    {
        $this->errorDump->each(function ($message) {
            echo $message;
        });

        echo  "\033[01;31m" . $this->totalErrors . " total error(s)\033[0m" . PHP_EOL;
    }
}
