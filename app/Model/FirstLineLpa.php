<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FirstLineLpa extends Model
{
    protected $table = 't_1stlinelpa';
    protected $fillable = ['enroll_id','sample_id','test_date','created_by','updated_by','status','lpa_interpretation_id','RpoB','wt1','wt2','wt3','wt4','wt5','wt6','wt7','wt8','mut1DS16V','mut2aH526Y','mut2bH526D','mut3S531L','katg','wt1315','mut1S315T1','mut2S315T2','inha','wt1516','wt28','mut1C15T','mut2A16G','mut3aT8C','mut3bT8A','lab_code', 'sample_label', 'finalterpretation', 'tub_band','tag', 'dna_extraction_date', 'pcr_test_date', 'hybridization_date', 'hybridization_result', 'type', 'mtb_result', 'rif', 'inh', 'kat_g', 'clinical_interpretation', 'reason_edit', 'comments', 'lab_serial_no'];
}