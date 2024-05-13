<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class RoomGallery extends Model implements Sortable
{
    use HasFactory , SoftDeletes ,SortableTrait;

    public $sortable = [
      'order_column_name' => 'sort_order',
      'sort_when_creating' => true,
      // 'sort_on_has_many' => true,
    ];
  

    protected $fillable = [
      'room_id' , 'image' , 'sort_order' , 'is_published'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
