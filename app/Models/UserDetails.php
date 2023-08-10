<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    protected $table = 'user_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        "user_id",
        "hireDate",
        "startDate",
        "firstName",
        "middleName",
        "lastName",
        "preferredName",
        "permanantAddress",
        "homePhone",
        "cellPhone",
        "email",
        "title",
        "projectName",
        "clientName",
        "clientLocation",
        "workLocation",
        "supervisorName",
        "request",
        "providingLaptop",
        "hiredAs",
        "image_name"
    ];
}
