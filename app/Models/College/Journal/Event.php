<?php

namespace App\Models\College\Journal;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "journal_events";

    public function concept()
    {
        return $this->hasOne(Concept::class, 'id', 'concept_id');
    }
}
