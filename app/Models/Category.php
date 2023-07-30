<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'description',
        'image',
        'parent_id',
        'status',
        'slug'
    ];

    public static function rules($id = 0){
        return[
            'name' => ['required',
            'string',
            'min:3',
            'max:255',
            Rule::unique('categories', 'name')->ignore($id),
            // "unique:categories, name, $id"
            /* function($attribute, $value, $fails){
                if (strtolower($value) == 'laravel') {
                    $fails('This name is forbidden!');
                }
            }, */
            'filter:php,laravel,html',
            // new Filter(['laravel', 'php', 'html']),
        ],
            'parent_id' => [
                'nullable', 'int', 'exists:categories,id',
            ],
            'image' => [
                'max:1048576', 'dimensions:min_width=100,min_height=100'
            ],
            'status' => 'required|in:active,archived'
        ];
    }

    /* protected $guarded= [
        'id'
    ]; */
}
