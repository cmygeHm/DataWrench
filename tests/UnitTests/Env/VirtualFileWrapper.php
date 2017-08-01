<?php
declare(strict_types=1);

namespace tests\UnitTests\Env;

class VirtualFileWrapper
{
    public $context;

    private $position = 0;

    private $data = '';


    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_stat()
    {
        $data = [
            'dev'     => 0,
            'ino'     => getmyinode(),
            'mode'    => 'r',
            'nlink'   => 0,
            'uid'     => getmyuid(),
            'gid'     => getmygid(),
            'rdev'    => 0,
            'size'    => 0,
            'atime'   => time(),
            'mtime'   => getlastmod(),
            'ctime'   => false,
            'blksize' => 0,
            'blocks'  => 0,
        ];

        return array_merge(array_values($data), $data);
    }

    public function stream_read()
    {
        $nextEndOfLine = strpos($this->data, PHP_EOL, $this->position) + strlen(PHP_EOL);
        $result = substr($this->data, $this->position, $nextEndOfLine);
        $this->position = $nextEndOfLine;

        return $result;
    }

    public function stream_write($line)
    {
        $line .= PHP_EOL;
        $this->data .= $line;
        $this->position += strlen($line);
    }

    public function stream_eof()
    {
        return $this->position >= strlen($this->data);
    }

    public function stream_seek($offset, $whence = SEEK_SET)
    {
        if ($whence != SEEK_SET) {
            trigger_error(
                'For unit tests available only SEEK_SET whence',
                E_WARNING
            );
        }

        $this->position = $offset;
    }
}
