<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * Class Project
 *
 * @property $id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Project extends Model  implements HasMedia, TranslatableContract{

    use HasFactory;
    use Translatable;

    use InteractsWithMedia;

    public $translatedAttributes = ['title', 'text'];


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['published_at','category_id'];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category(){
        
        return $this->belongsTo(Category::class);
    }

    public function medias(){
        return $this->morphMany(Media::class, 'mediable');
    }

}
