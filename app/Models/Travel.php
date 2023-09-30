<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Travel extends Model
{
    use HasFactory;
    use HasSlug;

    protected $table = 'travels';

    protected $fillable = [
        'name',
        'description',
        'slug', 
        'is_public',
        'number_of_days',

    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getNumberOfDaysNightsAttribute()
    {
        return $this->number_of_days - 1;
    }
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }


}
