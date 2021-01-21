<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cbnaat_lab_details extends Model
{
  protected $table = 'm_cbnaat_lab_details';
    protected $fillable = ['lab_name','lab_addr','contact_name','contact_no','contact_email','sr_no','date_caliberation','reporting_year','status'];
}
