<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithUpserts, WithChunkReading, WithBatchInserts, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private Collection $categories;

    function __construct()
    {
        $this->categories = Category::all();
    }

    /**
     * @param array $row
     * @return Product|null
     */
    public function model(array $row): ?Product
    {
        $is_present = $this->categories->search(function (Category $item, int $key) use ($row) {
            return $item->name == $row[2] && $item->rubric == $row[1];
        });

        Debugbar::debug($is_present);

        if ($is_present === false) {
            $category = Category::create([
                'rubric' => $row[1],
                'name' => $row[2],
            ]);

            $this->categories->push($category);
        } else {
            $category = $this->categories->get($is_present);
        }

        Session::put('importTotalRows', Session::get('importTotalRows') + 1);

        return new Product([
            'manufacturer' => $row[3],
            'name' => $row[4],
            'sku' => $row[5],
            'description' => $row[6],
            'price' => $row[7],
            'warranty' => ($row[8] == 'Нет') ? 0 : (int)$row[8],
            'is_available' => $row[9] == 'есть в наличие',
            'category_id' => $category->id,
        ]);
    }

    /**
     * @return string|array
     */
    public function uniqueBy(): array|string
    {
        return 'sku';
    }

    public function batchSize(): int
    {
        return 100; // can be replaced to different number for optimization
    }

    public function chunkSize(): int
    {
        return 800; // can be replaced to different number for optimization
    }

    public function rules(): array
    {
        return [
            '0' => ['required', 'string', 'max:100'],
            '1' => ['required', 'string', 'max:100'],
            '2' => ['required', 'string', 'max:100'],
            '3' => ['required', 'string', 'max:64'],
            '4' => ['required', 'string', 'max:256'],
            '5' => ['required', 'regex:/^[A-Z0-9]+$/', 'max:12'],
            '6' => ['required', 'string', 'max:1024'],
            '7' => ['required', 'integer', 'max:8388607'],
            '8' => ['required'], // TODO set a regex for 'Нет' or number
            '9' => ['required', 'string'],
        ];
    }
}
