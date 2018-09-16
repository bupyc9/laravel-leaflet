<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Point
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $longitude
 * @property float $latitude
 * @property int $category_id
 * @method static Builder|Point whereCategoryId($value)
 * @method static Builder|Point whereCreatedAt($value)
 * @method static Builder|Point whereId($value)
 * @method static Builder|Point whereLatitude($value)
 * @method static Builder|Point whereLongitude($value)
 * @method static Builder|Point whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Category $category
 */
class Point extends Model
{
    protected $fillable = ['longitude', 'latitude', 'category_id'];

    protected $casts = [
        'created_at' => 'datetime:' . \DateTime::ATOM,
        'updated_at' => 'datetime:' . \DateTime::ATOM,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
