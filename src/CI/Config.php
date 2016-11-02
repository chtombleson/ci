<?php
namespace CI;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;

class Config
{
    protected $config;
    protected $file;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new Exception('Unable to load config: ' . $file);
        }

        $this->file = $file;
        $this->load();
    }

    public function load()
    {
        $parser = new Parser();
        $this->config = $parser->parse(file_get_contents($this->file));

        return $this;
    }

    public function save()
    {
        $dumper = new Dumper();
        $yaml = $dumper->dump($this->config);
        file_put_contents($this->file, $yaml);

        return $this;
    }

    public function get($key)
    {
        if (strpos($key, '.') !== false) {
            $paths = explode('.', $key);
        } else {
            $paths = [$key];
        }

        $depth = count($paths);
        $current = $this->config;

        if ($depth == 1 && isset($current[$paths[0]])) {
            return $current[$paths[0]];
        }

        $current = $current[$paths[0]];

        for ($i=1; $i <= $depth; $i++) {
            if (isset($current[$paths[$i]]) && $i == ($depth - 1)) {
                return $current[$paths[$i]];
            } else {
                if (isset($current[$paths[$i]])) {
                    $current = $current[$paths[$i]];
                }
            }
        }
    }

    public function toArray()
    {
        return $this->config;
    }
}
