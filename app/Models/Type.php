<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function documents()
  {
    return $this->hasMany(Document::class);
  }
}
