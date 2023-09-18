<?php

namespace App\Http\Requests;

use App\Rules\ImportProductsFileSize;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ImportProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'importProductsFile' => [
                'required',
                'file',
                'mimes:xls,xlsx,xlm,xla,xlc,xlt,xlw,xlam,xlsb,xlsm,xltm',
                'mimetypes:application/excel,application/vnd.ms-excel,application/vnd.ms-excel.sheet.macroEnabled.12,' .
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                new ImportProductsFileSize // but File::default()->max('10mb') is more simple:)
            ]
        ];
    }
}
