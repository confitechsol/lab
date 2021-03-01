<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DSTDrugTR extends Model
{
  protected $table = 't_dst_drugs_tr';
  protected $fillable = ['enroll_id','sample_id','service_id','drug_ids','microbiologist_comments','status','flag','created_by','updated_by', 'rec_flag'];
}
