<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $fillable = [
        'title ',
        'type',
        'file_path'
    ];

    public function timestamps()
    {
        $this->timestamp('updated_date');

        $this->timestamp('created_date')->useCurrent();

    }
}
