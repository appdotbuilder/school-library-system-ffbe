<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $transaction_code
 * @property int $member_id
 * @property int $book_id
 * @property int $borrowed_by
 * @property int|null $returned_by
 * @property \Illuminate\Support\Carbon $borrowed_date
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $returned_date
 * @property string $status
 * @property string|null $notes
 * @property float $fine_amount
 * @property bool $fine_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book $book
 * @property-read \App\Models\User $borrowedBy
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\User|null $returnedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBorrowedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBorrowedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFineAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFinePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReturnedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReturnedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction borrowed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction overdue()
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_code',
        'member_id',
        'book_id',
        'borrowed_by',
        'returned_by',
        'borrowed_date',
        'due_date',
        'returned_date',
        'status',
        'notes',
        'fine_amount',
        'fine_paid',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'borrowed_date' => 'date',
        'due_date' => 'date',
        'returned_date' => 'date',
        'fine_amount' => 'decimal:2',
        'fine_paid' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->transaction_code) {
                $transaction->transaction_code = 'TRX' . date('Ymd') . strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Get the member that borrowed the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the book that was borrowed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the staff who processed the borrowing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function borrowedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrowed_by');
    }

    /**
     * Get the staff who processed the return.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    /**
     * Scope a query to only include borrowed books.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBorrowed($query)
    {
        return $query->where('status', 'borrowed');
    }

    /**
     * Scope a query to only include overdue books.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'borrowed')
                  ->where('due_date', '<', now());
            });
    }
}