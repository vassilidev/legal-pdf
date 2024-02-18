<?php

namespace App\Services;

use App\Models\Contract;
use Illuminate\Support\Str;

class ContractHelper
{
    public array $replaceFunctions = [
        '#nextArticleNumber#' => '{{ $contractHelper->getNextArticleNumber() }}',
        '#articleNumber#' => '{{ $contractHelper->getArticleNumber() }}',
    ];

    public array $replaceString = [
        '-&gt;' => '->',
    ];

    public function __construct(
        public readonly Contract $contract,
        private int              $articleNumber = 0,
    )
    {
    }

    public function getArticleNumber(): int
    {
        return $this->articleNumber;
    }

    public function setArticleNumber(int $articleNumber): self
    {
        $this->articleNumber = $articleNumber;

        return $this;
    }

    public function incrementArticleNumber(): self
    {
        $this->articleNumber++;

        return $this;
    }

    public function decrementArticleNumber(): self
    {
        $this->articleNumber--;

        return $this;
    }

    public function getNextArticleNumber(): int
    {
        $this->incrementArticleNumber();

        return $this->getArticleNumber();
    }

    public function render(): string
    {
        $markdown = $this->contract->content;

        return $this->formatMarkdown($markdown);
    }

    public function formatMarkdown(string $markdown): string
    {
        $replaceFunction = $this->replaceFunctions($markdown);

        return Str::markdown($this->replaceEscapeString(Str::markdown($replaceFunction)));
    }

    public function replaceFunctions(string $markdown): string
    {
        $helperFunctionReplaced = Str::replace(array_keys($this->replaceFunctions), array_values($this->replaceFunctions), $markdown);

        return $this->replaceDynamicValues($helperFunctionReplaced);
    }

    public function replaceDynamicValues(string $markdown): string
    {
        $pattern = '/#(?:contract|answers)->(\w+)#/';

        return preg_replace_callback($pattern, function($matches) {
            $answers = [];

            $key = $matches[1];

            if (Str::startsWith($matches[0], "#contract")) {
                return $this->contract->getAttribute($key) ?? $matches[0];
            }

            if (Str::startsWith($matches[0], "#answers")) {
                return $answers[$key] ?? $matches[0];
            }
            return $matches[0];
        }, $markdown);
    }

    public function replaceEscapeString(string $markdown): string
    {
        return Str::replace(array_keys($this->replaceString), array_values($this->replaceString), $markdown);
    }
}