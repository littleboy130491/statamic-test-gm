<?php

namespace App\Bard;

use Statamic\Facades\Asset;
use Statamic\Fieldtypes\Bard\ImageNode;
use Statamic\Support\Str;
use Tiptap\Utils\HTML;

/**
 * Render gambar Bard sebagai <figure> + <figcaption> kalau asset punya caption.
 *
 * Caption diambil dari .meta asset (field `caption` di blueprint assets),
 * yaitu tempat Statamic menyimpan metadata gambar. Kalau caption kosong,
 * output-nya tetap <img> biasa seperti bawaan Statamic.
 */
class CaptionedImageNode extends ImageNode
{
    public function renderHTML($node, $HTMLAttributes = [])
    {
        $caption = $this->captionFor($node->attrs->src ?? null);

        if ($caption === null) {
            return parent::renderHTML($node, $HTMLAttributes);
        }

        // Serializer tiptap tidak bisa menyusun <figure><img><figcaption>teks
        // lewat bentuk array bersarang (tidak ada cara menaruh teks setelah
        // elemen void). Bentuk ['content' => ...] merender string apa adanya.
        $attributes = HTML::renderAttributes(
            HTML::mergeAttributes($this->options['HTMLAttributes'], $HTMLAttributes)
        );

        return ['content' => sprintf(
            '<figure class="bard-figure"><img%s><figcaption class="bard-figcaption">%s</figcaption></figure>',
            $attributes,
            e($caption)
        )];
    }

    protected function captionFor($src): ?string
    {
        if (! $src || ! Str::startsWith($src, 'asset::')) {
            return null;
        }

        $asset = Asset::find(Str::after($src, 'asset::'));

        if (! $asset) {
            return null;
        }

        $caption = trim((string) ($asset->get('caption') ?? ''));

        return $caption === '' ? null : $caption;
    }
}
