<?php
declare(strict_types=1);

namespace DataWrench\Reader;

use DataWrench\Entity\Entity;
use DataWrench\Entity\FieldsMap;
use Exception;
use Generator;
use JsonStreamingParser\Listener\SimpleObjectQueueListener;

class JsonReader implements Reader
{
    /**
     * @var FieldsMap
     */
    private $fieldsMap;

    private $parser;
    private $fileHandler;

    public function __construct($fileHandler, FieldsMap $fieldsMap)
    {
        $this->fieldsMap = $fieldsMap;
        $this->fileHandler = $fileHandler;
    }

    public function read() : Generator
    {
        $listener = new SimpleObjectQueueListener(function($value) {
            yield Entity::create(
                $this->fieldsMap->mapSourceToDestination($value)
            );
        });

        try {
            $this->parser = new \JsonStreamingParser\Parser($this->fileHandler, $listener);
            $t = $this->parser->parse();
            fclose($this->fileHandler);
        } catch (Exception $e) {
            fclose($this->fileHandler);
            throw $e;
        }

//        while (true) {
////            $value = yield;
//            yield Entity::create(
//                $this->fieldsMap->mapSourceToDestination(yield)
//            );
//        }
    }
}
