<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cal extends Model
{
    use HasFactory;
    
    const CAL_STATUS_STRING = [
        '高',
        '中',
        '低',
    ];

    protected $fillable =[
        'user_id',
        "title",
        'timeid',
        'dateid',
        "date",
        "importance",
    ];
    //eloquentモデルで使用されるプロパティの一つで、指定された属性がユーザーからの入力を受け取ることができることを示す。
    // $fillableにtitle,date,importanceの3つの属性が指定されている。

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cal()
    {
        return $this->hasMany(Cal::class);
    }

    public function getCalStatusStringAttribute()
    {
        $calStatus = $this->attributes['importance'];

        if (!isset(self::CAL_STATUS_STRING[$calStatus])) {
            return '';
        }

        return self::CAL_STATUS_STRING[$calStatus];
    }

}
