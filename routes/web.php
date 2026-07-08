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

    $labels = GlobalSet::findByHandle('product_label_information')
        ?->in($site)
        ?->toAugmentedArray() ?? [];

    $image = $entry->augmentedValue('featured_image')->value();

    $rows = collect([
        ['label' => $labels['model_labels'] ?? 'Model', 'value' => $entry->value('sku') ?: $entry->value('title')],
        ['label' => $labels['power'] ?? 'Power', 'value' => $entry->value('power')],
        ['label' => $labels['torque'] ?? 'Torque', 'value' => $entry->value('torque')],
        ['label' => $labels['standard_emission'] ?? 'Emission', 'value' => $entry->value('standard_emission')],
        ['label' => $labels['gcw'] ?? 'GCW', 'value' => $entry->value('gcw')],
        ['label' => $labels['gvw'] ?? 'GVW', 'value' => $entry->value('gvw')],
        ['label' => $labels['fuel_tank_capacity'] ?? 'Fuel Tank Capacity', 'value' => $entry->value('fuel_tank_capacity')],
    ])->map(fn ($row) => [
        'label' => $row['label'],
        // Nilai kosong (placeholder / hide baris).
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
