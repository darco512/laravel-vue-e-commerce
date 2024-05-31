<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends StoreProductRequest
{
    public function rules() :array
    {
        $rules = parent::rules();

        // Override rules for the photos field
        $rules['photos'] = 'nullable|array|max:20';
        $rules['photos.*'] = 'nullable|image|max:10240';
        $rules['photosToDelete'] = 'nullable|array';
        $rules['photosToDelete.*'] = 'nullable|integer|exists:products_photos,id';

        return $rules;
    }
}
