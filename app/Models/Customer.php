<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $nationality
 * @property string $residence_place
 * @property string $postal_code
 * @property \Carbon\Carbon $approx_enrollment
 * @property string $marital_status
 * @property string $family
 * @property string $document_number
 * @property int $document_type_id
 * @property string $unique
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nationality',
        'residence_place',
        'postal_code',
        'cencus',
        'marital_status',
        'family',
        'document_number',
        'document_type_id',
        'unique',
        'notes'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'document_type_id' => 'integer',
    ];

    protected static function booted()
    {
        static::deleting(function (Customer $customer) {
            $customer->membership()->update(['membership_status' => 'inactive']);
        });

        static::restoring(function (Customer $customer) {
            $customer->membership()->update(['membership_status' => 'active']);
        });
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function membership(): HasOne
    {
        return $this->hasOne(Membership::class);
    }
}
