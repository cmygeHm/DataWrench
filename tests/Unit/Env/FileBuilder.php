<?php
declare(strict_types=1);

namespace DataWrench\UnitTest\Env;

class FileBuilder
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
        $path = self::STREAM_PROTOCOL . "://myvar";
        $fp = fopen($path, "r+");
        foreach ($this->lines as $line) {
            fwrite($fp, $line);
        }

        rewind($fp);

        return $fp;
    }

    public function addLine(string $line) : self
    {
        $this->lines[] = $line;

        return $this;
    }
}
