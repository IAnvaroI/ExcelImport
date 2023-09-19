<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProductsRequest;
use App\Imports\ProductsImport;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Validators\Failure;

class ImportProductsController extends Controller
{
    public function importFile(ImportProductsRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $path = $request->file('importProductsFile')->store('importProducts');

        Session::put('importTotalRows', 0);
        $import = new ProductsImport();

        Debugbar::measure('Import excel', function() use ($import, $path) {
            $import->import($path);
        });

        $refusedToImport = $import->failures()->groupBy(function (Failure $item, int $key) {
            return $item->row();
        })->sortKeys();

        return view('importResults', ['counter' => Session::get('importTotalRows'), 'refusedToImport' => $refusedToImport]);
    }
}
