<?php

use Illuminate\Support\Facades\Route;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Site;

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

/*
|--------------------------------------------------------------------------
| Product comparison (AJAX)
|--------------------------------------------------------------------------
| Returns the specification data for a single product so the comparison
| section on the single-product page can swap columns without a reload.
*/
Route::get('/api/products/{id}/comparison', function (string $id) {
    $site = Site::current()->handle();

    $entry = Entry::find($id)?->in($site);

    if (!$entry || $entry->collectionHandle() !== 'products') {
        return response()->json(['message' => 'Product not found'], 404);
    }

    $global = GlobalSet::findByHandle('product_label_information')?->in($site);

    $image = $entry->augmentedValue('featured_image')->value();

    // Sumber tunggal: checkboxes "spesification_info".
    // Options (key => label) dari blueprint, key tercentang dari value.
    $options = collect($global?->blueprint()?->field('spesification_info')?->config()['options'] ?? [])
        ->mapWithKeys(function ($opt, $k) {
            if (is_array($opt) && array_key_exists('key', $opt)) {
                return [$opt['key'] => $opt['value'] ?? $opt['key']];
            }
            return [$k => $opt];
        });

    $selected = collect($global?->value('spesification_info') ?? [])->filter(fn ($v) => is_string($v));

    // Handle field yang benar-benar ada di produk (key tanpa field diabaikan).
    $productFieldHandles = $entry->blueprint()?->fields()->all()->keys() ?? collect();

    $specRows = $options
        ->filter(fn ($label, $key) => $selected->contains($key) && $productFieldHandles->contains($key))
        ->map(fn ($label, $key) => [
            'field' => $key,
            'label' => $label ?: $key,
            'value' => $entry->value($key),
        ])
        ->values();

    // Baris Model selalu paling atas, lalu baris dari spesification_info.
    $rows = collect([
        ['field' => 'model', 'label' => $global?->value('model_labels') ?: 'Model', 'value' => $entry->value('sku') ?: $entry->value('title')],
    ])->concat($specRows)->map(fn ($row) => [
        'field' => $row['field'],
        'label' => $row['label'],
        // Nilai kosong ditangani klien (placeholder / hide baris).
        'value' => (string) ($row['value'] ?? ''),
    ])->values();

    return response()->json([
        'id' => $entry->id(),
        'title' => $entry->value('title'),
        'model' => $entry->value('sku') ?: $entry->value('title'),
        'image' => $image?->url(),
        'rows' => $rows,
    ]);
})->name('products.comparison');
