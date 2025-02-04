<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
    protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }
}
