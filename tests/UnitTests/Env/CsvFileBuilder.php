<?php
declare(strict_types=1);

namespace tests\UnitTests\Env;

class CsvFileBuilder
{
    private const STREAM_PROTOCOL = 'virtual';

    /** @var string[] */
    private $lines = [];

    public static function create() : self
    {
        $isProtocolRegistered = in_array(self::STREAM_PROTOCOL, stream_get_wrappers());
        if ($isProtocolRegistered) {
            stream_wrapper_unregister(self::STREAM_PROTOCOL);
        }

        if (!stream_wrapper_register(self::STREAM_PROTOCOL, VirtualFileWrapper::class)) {
            if ($isProtocolRegistered) {
                stream_wrapper_restore(self::STREAM_PROTOCOL);
            }

            throw new \RuntimeException(
                sprintf(
                    'Failed to register wrapper with protocol "%s"',
                    self::STREAM_PROTOCOL
                )
            );
        }

        return new self();
    }

    public function build()
    {
        $fp = fopen(self::STREAM_PROTOCOL . "://myvar", "r+");
        foreach ($this->lines as $line) {
            fwrite($fp, $line);
        }

        rewind($fp);

        while (!feof($fp)) {
            echo fgets($fp);
        }
    }

    public function addLine(string $line) : self
    {
        $this->lines[] = $line;

        return $this;
    }
}
