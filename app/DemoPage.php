<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoPage extends Model
{
    use HasFactory;

    protected $table = 'demo_pages';

    protected $fillable = ['id', 'link', 'email', 'status'];
}
