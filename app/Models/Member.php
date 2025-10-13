<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory, Sluggable, SoftDeletes;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'onUpdate' => true,
                // build slug from code + name
                'source' => ['code', 'name']
            ]
        ];
    }

    // ensure model has guarded definition
    protected $guarded = ['id'];

    /**
     * Relationship: Loyality belongs to Member
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public $with = ['transaction', 'redeem'];

    public function transaction()
    {
        return $this->hasMany(MemberTransaction::class)->latest();
    }

    public function redeem()
    {
        return $this->hasMany(MemberRedeem::class)->latest();
    }

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["type"] ?? false, function ($query, $search) {
            return $query->whereHas("type", function ($query) use ($search) {
                $query->where("slug", $search);
            });
        });

        $query->when($filters["search"] ?? false, function ($query, $search) {
            return $query->where("name", "like", "%$search%")->orWhere('code', 'like', "%$search%");
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birthday' => 'date',
        ];
    }


}
