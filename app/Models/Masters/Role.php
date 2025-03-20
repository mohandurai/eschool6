<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'role_title ',
        'role_description'
    ];

    public function timestamps()
    {
        $this->timestamp('updated_at');

        $this->timestamp('created_at')->useCurrent();

    }
}
