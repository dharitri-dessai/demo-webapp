<?php

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;    

class ReverseWordsExtension extends AbstractExtension {

    public function getFilters() : array
    {
        return [ new TwigFilter('reverse_words', [$this, 'reverseWords'])];
    }

    public function reverseWords($word) : string {

        return strrev($word);
    }
}