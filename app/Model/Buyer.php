<?php

namespace App\Model;

use App\Scopes\BuyerScope;
use App\User;
use App\Transformers\BuyerTransformer;

// use Illuminate\Database\Eloquent\Model;

// class Buyer extends Model
class Buyer extends User
{
    public $transformer = BuyerTransformer::class;
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
