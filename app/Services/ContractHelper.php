<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Order;
use Illuminate\Support\Str;

class ContractHelper
{
    public array $replaceFunctions = [
        '[nextArticleNumber]' => '{{ $contractHelper->getNextArticleNumber() }}',
        '[articleNumber]'     => '{{ $contractHelper->getArticleNumber() }}',
        '[signature]'         => '{!! $contractHelper->getSignature() !!}',
        '[startBlur]'         => "<div class='blur'>",
        '[endBlur]'           => "</div>",
    ];

    public array $replaceString = [
        '-&gt;'  => '->',
        '&quot;' => '"',
    ];

    public string $signatureUrl;

    public function __construct(
        public readonly Contract $contract,
        public readonly array    $answers = [],
        private int              $articleNumber = 0,
        private readonly ?Order  $order = null,
    )
    {
        $this->signatureUrl = 'https://www.shutterstock.com/image-vector/fake-autograph-samples-handdrawn-signatures-260nw-2325821623.jpg';
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

    public function formatMarkdown(?string $content): string
    {
        $content = $this->replaceEscapeString($content);

        $dynamicContent = $this->replaceFunctions($content);

        return $this->parseCustomConditions($this->replaceEscapeString($dynamicContent));
    }

    public function replaceFunctions(?string $markdown): string
    {
        $helperFunctionReplaced = Str::replace(array_keys($this->replaceFunctions), array_values($this->replaceFunctions), $markdown);

        return $this->replaceDynamicValues($helperFunctionReplaced);
    }

    public function replaceDynamicValues(string $markdown): string
    {
        $pattern = '/\[(?:contract|answers|values)->(\w+)]/';

        return preg_replace_callback($pattern, function ($matches) {
            $key = $matches[1];

            if (Str::startsWith($matches[0], "[contract")) {
                return $this->contract->getAttribute($key) ?? $matches[0];
            }

            if (Str::startsWith($matches[0], "[answers")) {
                $answer = (!empty($this->answers[$key]))
                    ? $this->answers[$key]
                    : Str::repeat('_', 15);

                return htmlspecialchars($answer);
            }

            if (Str::startsWith($matches[0], "[values")) {
                $answer = '"' . ($this->answers[$key] ?? "") . '"';

                return htmlspecialchars($answer);
            }

            return $matches[0];
        }, $markdown);
    }

    public function getSignature(): string
    {
        $signature = '';

        if ($this->order?->signature_option) {
            return "<img src='$this->signatureUrl'/>";
        }

        return $signature;
    }

    public function replaceEscapeString(?string $markdown): string
    {
        return Str::replace(array_keys($this->replaceString), array_values($this->replaceString), $markdown);
    }

    public function parseCustomConditions(?string $markdown): string
    {
        return preg_replace_callback('/\[if->(.*?)\](.*?)\[endif\]/s', static function ($matches) {
            $condition = strip_tags($matches[1]);

            return eval("return $condition;")
                ? $matches[2]
                : '';
        }, $markdown);
    }
}