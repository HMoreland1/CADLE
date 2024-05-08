<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Metrics\Chartable;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class AuthLog extends Model
{
    use HasFactory, Filterable, Chartable, Sortable, AsSource ;
    protected $table = 'auth_logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_at',
        'logout_at',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    protected $allowedFilters = [
        'user_id'              => Like::class,
        'ip_address'       => Like::class,
        'type'       => Like::class,
    ];

    protected $allowedSorts = [
        'name',
        'description',
        'login_at',
        'logout_at',
    ];
    /**
     * Get the user associated with the authentication log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
