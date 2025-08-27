<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * App\Models\Member
 *
 * @property int $id
 * @property string $member_code
 * @property string $barcode
 * @property string|null $nisn_nip
 * @property string $name
 * @property string|null $email
 * @property string|null $address
 * @property string|null $phone
 * @property string $member_type
 * @property string $status
 * @property int|null $school_class_id
 * @property int|null $major_id
 * @property \Illuminate\Support\Carbon $joined_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Major|null $major
 * @property-read \App\Models\SchoolClass|null $schoolClass
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereJoinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMemberCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMemberType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereNisnNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereSchoolClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member active()
 * @method static \Database\Factories\MemberFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'member_code',
        'barcode',
        'nisn_nip',
        'name',
        'email',
        'address',
        'phone',
        'member_type',
        'status',
        'school_class_id',
        'major_id',
        'joined_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'joined_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            if (!$member->member_code) {
                $member->member_code = 'MBR' . date('Y') . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
            if (!$member->barcode) {
                $member->barcode = 'MB' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get the school class this member belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Get the major this member belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    /**
     * Get the transactions for this member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope a query to only include active members.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}