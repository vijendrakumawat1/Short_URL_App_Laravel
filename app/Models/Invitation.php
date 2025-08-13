<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'company_id', 'email', 'role', 'creates_new_company', 'new_company_name', 'token',
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
