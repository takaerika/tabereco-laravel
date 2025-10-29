<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['meal_id','supporter_id','body'];

    public function meal(): BelongsTo { return $this->belongsTo(Meal::class); }
    public function supporter(): BelongsTo { return $this->belongsTo(User::class, 'supporter_id'); }
}