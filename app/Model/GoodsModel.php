<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    protected $table='p_goods';
    protected $primaryKey='goods_id';
    public $timestamps=false;

    //黑名单
    protected $guarded=[];
}
