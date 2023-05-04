<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
  use HasFactory;

  protected $casts = [
    'tags' => 'array'
  ];

  protected $guarded = [];

  public function type()
  {
    return $this->belongsTo(Document::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
