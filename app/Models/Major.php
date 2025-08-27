<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Major
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $members
 * @property-read int|null $members_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Major newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Major newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Major query()
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Major whereUpdatedAt($value)
 * @method static \Database\Factories\MajorFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Major extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the members in this major.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}