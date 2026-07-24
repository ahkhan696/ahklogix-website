<?php

namespace App\Contracts;

interface ChatDriver
{
    public function isConfigured(): bool;

    /**
     * @param  array<array{role: string, content: string}>  $messages
     * @return \Generator<string>  yields text chunks as they arrive
     */
    public function stream(array $messages, string $system): \Generator;
}
