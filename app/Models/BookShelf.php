<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BookShelf
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookShelf whereUpdatedAt($value)
 * @method static \Database\Factories\BookShelfFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class BookShelf extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
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
     * Get the books in this shelf.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}