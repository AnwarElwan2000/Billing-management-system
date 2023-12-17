<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    use HasFactory;
    protected $fillable = [
        "invoice_number",
        "id_Invoice",
        "product",
        "Section",
        "Status",
        "Value_Status",
        "Payment_Date",
        "note",
        "user",
    ];

}
