<?php

namespace Blackfire\Player\Tests;

use Symfony\Component\VarDumper\Cloner\Cursor;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class VarDumper extends CliDumper
{
    /**
     * {@inheritdoc}
     */
    public function enterHash(Cursor $cursor, $type, $class, $hasChild)
    {
        if (Cursor::HASH_INDEXED === $type || Cursor::HASH_ASSOC === $type) {
            $class = 0;
        }
        parent::enterHash($cursor, $type, $class, $hasChild);
    }

    /**
     * {@inheritdoc}
     */
    protected function dumpKey(Cursor $cursor)
    {
        if (Cursor::HASH_INDEXED !== $cursor->hashType) {
            parent::dumpKey($cursor);
        } elseif (null !== $cursor->hashKey && $cursor->hardRefTo) {
            $this->line .= $this->style('ref', '&'.($cursor->hardRefCount ? $cursor->hardRefTo : ''), ['count' => $cursor->hardRefCount]).' ';
        }
    }
}
