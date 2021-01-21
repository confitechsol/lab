<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HR extends Model
{
    protected $table = 'm_hr';
  	protected $fillable = ['name','designation','other_designation','qualification',
    'mode','date_joining','date_reliving','health_check','vaccination','training_subject',
    'training_date','created_by','updated_by','adhaar','type_qualification','org_source','lc','microscopy',
    'dst','lpa','geneXpert','bio_safe_t','fire_safe_t','bio_waste_man',
    'date_reliving_curr','qms','health_check','org_source','orientation_training',
    'date_orientation','date_biosafty','date_firesafty','date_qms','date_biowaste',
    'date_lc','date_GeneXpert','date_dst',
    'date_lpa','date_microscopy','flag',
    'lpa_2','date_lpa_2','dst_lc_2','date_dst_lc_2','date_dst_lj_1','dst_lj_1',
    'dst_lj_2','date_dst_lj_2','lj','date_lj',
    'other','name_other','date_other','org_source_other','refresher_training_date','refresher_training_name'
  ];
}
