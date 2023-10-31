<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $pengeluarans;
    protected $primaryKey = 'id_pengeluaran';

    public $incrementing = false;
    public $timestamps = true;
}
