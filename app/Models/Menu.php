<?php

namespace App\Models;

use App\Traits\RestrictOnDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, RestrictOnDelete;

    protected $with = ['childrens'];
    protected $table = 'menus';
    protected $fillable = [
        'title',
        'name',
        'module',
        'slug',
        'icon',
        'type',
        'url',
        'parent_id',
        'order',
    ];

    public function childrens()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function accesses()
    {
        return $this->hasMany(Access::class, 'menu_id', 'id');
    }
}
