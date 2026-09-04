<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Authenticatable
{
     protected $table = 'tbl_nexa_admin';
       protected $primaryKey = 'id';
       protected $fillable = [
    'username',
    'email',
    'password_hash',
    'full_name',
    'role',
    'status',
    'avatar_url',
    'phone',
    'last_login_at',
    'created_at',
    'updated_at'
];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    // บอก Laravel ว่าฟิลด์ password คือ nn_staff_password
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
