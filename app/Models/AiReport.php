<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiReport extends Model
{
    protected $fillable = ['question_id', 'report_text', 'model_used'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
