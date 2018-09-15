<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'photo';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'storage_address',
        'file_extension',
    ];

    public function format() : array
    {
        return [
            'name' => $this->name,
            'url' => $this->storage_address,
            'extension' => $this->file_extension,
            'takenAt' => $this->created_at->timestamp,
        ];
    }
}
