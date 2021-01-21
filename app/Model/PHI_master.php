<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PHI_master extends Model
{
  protected $table = 'm_dmcs_phi_relation';
  protected $fillable = ['TBUCode','STOCode','DTOCode','DMC_PHI_Code','DMC_PHI_Name'];
}
