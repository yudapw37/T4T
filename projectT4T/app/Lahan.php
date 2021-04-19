<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    protected $table = 'lahans';
    protected $fillable = ['lahan_no', 'document_no', 'land_area', 'planting_area', 'longitude', 'latitude', 'coordinate', 'polygon', 'village', 'kecamatan', 'city', 'province', 'description', 'elevation', 'soil_type',
    'current_crops', 'active', 'farmer_no', 'mu_no', 'target_area', 'user_id', 'created_at', 'updated_at', 'sppt','photo1', 'photo2', 'photo3', 'photo4', 'group_no',
    'kelerengan_lahan', 'fertilizer', 'pesticide', 'tutupan_lahan','access_to_water_sources', 'access_to_lahan', 'potency','barcode', 'is_dell', 'complete_data', 'approve'];
}
