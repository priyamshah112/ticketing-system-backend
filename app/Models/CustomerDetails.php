<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetails extends Model
{
    use HasFactory;
    protected $table = 'customer_details';
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
        "enable",
        "image_name"
    ];
}
