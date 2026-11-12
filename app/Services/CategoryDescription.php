<?php

namespace App\Services;

class CategoryDescription
{
    public static function clean(?string $html): string
    {
        if (! $html) {
            return '';
        }
        $document = new \DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><div>'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $allowed = ['div', 'p', 'br', 'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li', 'h2', 'h3', 'h4', 'blockquote', 'a', 'table', 'thead', 'tbody', 'tr', 'th', 'td'];
        $walk = function ($node) use (&$walk, $allowed) {
            foreach (iterator_to_array($node->childNodes) as $child) {
                if ($child instanceof \DOMElement) {
                    if (! in_array($child->tagName, $allowed, true)) {
                        $node->removeChild($child);
                        continue;
                    }
                    $href = $child->tagName === 'a' ? $child->getAttribute('href') : '';
                    foreach (iterator_to_array($child->attributes) as $attribute) {
                        $child->removeAttribute($attribute->name);
                    }
                    if (preg_match('~^(https?://|mailto:|/(?!/)|#)~i', $href)) {
                        $child->setAttribute('href', $href);
                    }
                    $walk($child);
                } elseif (! $child instanceof \DOMText) {
                    $node->removeChild($child);
                }
            }
        };
        $walk($document);

        return $document->saveHTML();
    }
}
