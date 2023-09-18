<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProductsRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ImportProductsController extends Controller
{
    public function importFile(ImportProductsRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $path = $request->file('importProductsFile')->store('importProducts');

        return view('importResults', ['counter' => 1, 'refusedArray' => ['Reason' => 1]]);
    }
}
