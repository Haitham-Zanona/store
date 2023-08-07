<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable= [
        'name',
        'description',
        'image',
        'parent_id',
        'status',
        'slug',
    ];

    public function scopeActive(Builder $builder){
        $builder->where('status', '=', 'active');
    }
    public function scopeFilter(Builder $builder, $filter){

        $builder->when($filter['name'] ?? false, function($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });
        $builder->when($filter['status'] ?? false, function($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });

       /*  if ($filter['name'] ?? false) {
            $builder->where('name', 'LIKE', "%{$filter['name']}%");
        }
        if ($filter['status'] ?? false) {
            // $query->where('status', '=', $status);
            $builder->whereStatus($filter['status']);
        } */
    }

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

    public $timestamps = false;
}
