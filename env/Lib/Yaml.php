<?php

namespace Lib;

class Yaml {

    private $file;

    public function setFile($file) { $this->file = $file; }
    public function getFile() { return $this->file; }

    public function __construct($file = "")
    {
        $this->file = $file;
    }

    public function parse()
    {
        if (!\file_exists($this->file))
            return;
        $yamlFd = \fopen($this->file, 'r');
        $json = [];
        $yamlFile = $this->stringifyFile($yamlFd);
        $json = $this->findNamingYaml($yamlFile, 0);
        var_dump($json);
/*        if ($yamlFile) {

            while (($buffer = \fgets($yamlFile)) !== false) {

                if (($lenght = strlen($buffer)) > 3) {
                    if ($buffer[$lenght - 3] === ':' && $buffer[0] !== '\t') { // Read for new line and \0
                        $json[$$buffer] =
                    }
                    echo('SIZE: ' . $lenght);
                    echo('<br>');
                }
            }
        } else {
            return;
        }*/
        \fclose($yamlFd);
    }

    private function stringifyFile($yamlFile)
    {
        $stringFile = "";
        if ($yamlFile) {
            while (($buffer = \fgets($yamlFile))) {
                $stringFile .= $buffer;
            }
        }
        return $stringFile;
    }

    private function findNamingYaml($yamlFile, $depth, $start = 0, $flag = 0)
    {
        $line = strtok($yamlFile, PHP_EOL);
        $tab = [];
        $i = 0;
        while ($i < $start && $line) {
            $line = strtok(PHP_EOL);
            $i++;
        }
        while ($line) {
            $i++;
            if (strlen($line) > 3 && $this->checkNChar($line, ' ', $depth * 4, $flag, true) && $line[strlen($line) - 1] === ':') {

                $line = substr($line, 0, -1);
                $tab[$line] = $this->findNamingYaml($yamlFile, $depth + 1, $i, 1);
            }
            $line = strtok(PHP_EOL);
        }
        strtok('', '');
        return $tab;
    }

    // Check if has exactly $n iteration of $c in $str from $i = 0
    // $flag value can be -1, 0, or 1 respectivly for:
    // Or less, exactly, or more
    // $strict = true stop first time $str[i] !== $c

    private function checkNChar($str, $c, $n, $flag = 0, $strict = false)
    {
        $i = 0;
        $nCheck = 0;
        while ($str[$i]) {
            if ($str[$i] === $c) $nCheck++;
            if ($strict && $str[$i] !== $c) break;
            $i++;
        }
        if ($flag === -1 && $nCheck <= $n) return true;
        if ($flag === 0 && $nCheck === $n) return true;
        if ($flag === 1 && $nCheck >= $n) return true;
        return false;
    }

    public function parseFile($file = "")
    {
        $this->file = $file;
        return $this->parse();
    }
}
