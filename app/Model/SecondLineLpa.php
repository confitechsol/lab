<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SecondLineLpa extends Model
{
    protected $table = 't_2stlinelpa';
    protected $fillable = ['enroll_id','sample_id','test_date','created_by','updated_by','status','lpa_interpretation_id','gyra','wt18590','wt28993','wt39297','mut1A90V','mut2S91P','mut3aD94A','mut3bD94N','mut3cD94G','mut3dD94H','gyrb','wt1536541','mut1N538D','mut2E540V','rrs','wt1140102','wt21484','mut1A1401G','mut2G1484T','eis','wt137','wt2141210','wt32','mut1c14t', 'lab_code', 'sample_label', 'finalInterpretation','tub_band','tag', 'dna_extraction_date', 'pcr_test_date', 'hybridization_date', 'hybridization_result', 'type', 'mtb_result', 'quinolone', 'slid', 'slid_eis', 'clinical_interpretation', 'reason_edit', 'comments', 'lab_serial_no'];
}