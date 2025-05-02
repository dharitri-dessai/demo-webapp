<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FontExtension extends AbstractExtension {

    public function getFunctions() : array
    {
        return [
            new TwigFunction('font_selector', [$this, 'renderFontSelector'] , ['is_safe' => ['html']]),
            new TwigFunction('color_selector', [$this, 'renderColorSelector'] , ['is_safe' => ['html']])
        ];
    }

    public function renderFontSelector() : string {
        $fonts = ['Arial', 'Georgia', 'Courier New'];

        $html = '<select id="fontSelector" onchange="changeFont(this.value)">';
        foreach ($fonts as $font) {
            $html .= sprintf('<option value="%s">%s</option>', $font, $font);
        }
        $html .= '</select>';

        // Inline JS for simplicity
        $html .= <<<JS
        <script>
            function changeFont(font) {
                document.body.style.fontFamily = font;
            }
        </script>
        JS;

        return $html;
    }

    public function renderColorSelector() : string {
        $colours = ['Red', 'Blue', 'Green'];

        $html = '<select id="colorSelector" onchange="changeColor(this.value)">';
        foreach ($colours as $colour) {
            $html .= sprintf('<option value="%s">%s</option>', $colour, $colour);
        }
        $html .= '</select>';

        // Inline JS
        $html .= <<<JS
        <script>
            function changeColor(colour) {
                document.body.style.color = colour;
            }
        </script>
        JS;

        return $html;
    }
}