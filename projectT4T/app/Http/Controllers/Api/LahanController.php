<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\User;
use App\Lahan;

class LahanController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/GetLahanNotComplete",
     *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Lahan Not Complete",
     *   operationId="GetLahanNotComplete",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="userId",in="query", type="string"),
     *      @SWG\Parameter(name="farmer_no",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetLahanNotComplete(Request $request){
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        $getfarmerno = $request->farmer_no;
        if($getfarmerno){$farmer_no='%'.$getfarmerno.'%';}
        else{$farmer_no='%%';}
        try{
            $GetLahanNotComplete = Lahan::where('user_id', '=', $request->userId)->where('farmer_no', 'Like', $request->farmer_no)->where('is_dell', '=', 0)->where('complete_data', '=', 0)->orderBy('id', 'ASC')->limit($limit)->offset($offset)->get();
            // var_dump(count($GetLahanNotComplete));
            if(count($GetLahanNotComplete)!=0){
                $count = Lahan::where('user_id', '=', $request->userId)->where('is_dell', '=', 0)->where('complete_data', '=', 0)->count();
                $data = ['count'=>$count, 'data'=>$GetLahanNotComplete];
                $rslt =  $this->ResultReturn(200, 'success', $data);
                return response()->json($rslt, 200);  
            }
            else{
                $rslt =  $this->ResultReturn(404, 'doesnt match data', 'doesnt match data');
                return response()->json($rslt, 404);
            } 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Get(
     *   path="/api/GetLahanCompleteNotApprove",
     *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Lahan Complete Not Approve",
     *   operationId="GetLahanCompleteNotApprove",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="userId",in="query", type="string"),
     *      @SWG\Parameter(name="farmer_no",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetLahanCompleteNotApprove(Request $request){
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        $getfarmerno = $request->farmer_no;
        if($getfarmerno){$farmer_no='%'.$getfarmerno.'%';}
        else{$farmer_no='%%';}
        try{
            $GetLahanCompleteNotApprove = Lahan::where('user_id', '=', $request->userId)->where('farmer_no', 'Like', $farmer_no)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 0)->orderBy('id', 'ASC')->limit($limit)->offset($offset)->get();
            if(count($GetLahanCompleteNotApprove)!=0){
                $count = Lahan::where('user_id', '=', $request->userId)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 0)->count();
                $data = ['count'=>$count, 'data'=>$GetLahanCompleteNotApprove];
                $rslt =  $this->ResultReturn(200, 'success', $data);
                return response()->json($rslt, 200);  
            }
            else{
                $rslt =  $this->ResultReturn(404, 'doesnt match data', 'doesnt match data');
                return response()->json($rslt, 404);
            } 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Get(
     *   path="/api/GetCompleteAndApprove",
     *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Complete And Approve",
     *   operationId="GetCompleteAndApprove",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="userId",in="query", type="string"),
     *      @SWG\Parameter(name="farmer_no",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetCompleteAndApprove(Request $request){
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        $getfarmerno = $request->farmer_no;
        if($getfarmerno){$farmer_no='%'.$getfarmerno.'%';}
        else{$farmer_no='%%';}
        try{
            $GetCompleteAndApprove = Lahan::where('user_id', '=', $request->userId)->where('farmer_no', 'Like', $farmer_no)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 1)->orderBy('id', 'ASC')->limit($limit)->offset($offset)->get();
            if(count($GetCompleteAndApprove)!=0){
                $count = Lahan::where('user_id', '=', $request->userId)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 1)->count();
                $data = ['count'=>$count, 'data'=>$GetCompleteAndApprove];
                $rslt =  $this->ResultReturn(200, 'success', $data);
                return response()->json($rslt, 200);  
            }
            else{
                $rslt =  $this->ResultReturn(404, 'doesnt match data', 'doesnt match data');
                return response()->json($rslt, 404);
            } 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Get(
     *   path="/api/GetLahanDetail",
     *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Lahan Detail",
     *   operationId="GetLahanDetail",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="id",in="query", type="string")
     * )
     */
    public function GetLahanDetail(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
            $GetLahanDetail = 
            DB::table('lahans')->where('lahans.id', '=', $request->id)
            ->leftjoin('provinces', 'provinces.province_code', '=', 'lahans.province')
            ->leftjoin('kabupatens', 'kabupatens.kabupaten_no', '=', 'lahans.city')
            ->leftjoin('kecamatans', 'kecamatans.kode_kecamatan', '=', 'lahans.kecamatan')
            ->leftjoin('desas', 'desas.kode_desa', '=', 'lahans.village')
            ->first();
            if($GetLahanDetail){
                $rslt =  $this->ResultReturn(200, 'success', $GetLahanDetail);
                return response()->json($rslt, 200);  
            }
            else{
                $rslt =  $this->ResultReturn(404, 'doesnt match data', 'doesnt match data');
                return response()->json($rslt, 404);
            } 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Get(
     *   path="/api/GetLahanDetailBarcode",
     *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Lahan Detail Barcode",
     *   operationId="GetLahanDetailBarcode",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="barcode",in="query", type="string")
     * )
     */
    public function GetLahanDetailBarcode(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'barcode' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
            $GetLahanDetailBarcode = 
            DB::table('lahans')->where('lahans.barcode', '=', $request->barcode)
            ->leftjoin('provinces', 'provinces.province_code', '=', 'lahans.province')
            ->leftjoin('kabupatens', 'kabupatens.kabupaten_no', '=', 'lahans.city')
            ->leftjoin('kecamatans', 'kecamatans.kode_kecamatan', '=', 'lahans.kecamatan')
            ->leftjoin('desas', 'desas.kode_desa', '=', 'lahans.village')
            ->first();
            if($GetLahanDetailBarcode){
                $rslt =  $this->ResultReturn(200, 'success', $GetLahanDetailBarcode);
                return response()->json($rslt, 200);  
            }
            else{
                $rslt =  $this->ResultReturn(404, 'doesnt match data', 'doesnt match data');
                return response()->json($rslt, 404);
            } 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/AddMandatoryLahan",
	 *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Mandatory Lahan",
     *   operationId="AddMandatoryLahan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Mandatory Lahan",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="document_no", type="string", example="0909090909"),
     *              @SWG\Property(property="land_area", type="string", example="8200.00"),
     *              @SWG\Property(property="longitude", type="date", example="110.3300613"),
     *              @SWG\Property(property="latitude", type="string", example="-7.580778"),
     *              @SWG\Property(property="coordinate", type="string", example="S734.847E11019.935"),
     *              @SWG\Property(property="village", type="string", example="33.05.10.18"),
     *              @SWG\Property(property="kecamatan", type="string", example="33.05.10"),
     *              @SWG\Property(property="city", type="string", example="33.05"),
     *              @SWG\Property(property="province", type="string", example="JT"),
     *              @SWG\Property(property="mu_no", type="string", example="025"),
     *              @SWG\Property(property="target_area", type="string", example="025001"),
     *              @SWG\Property(property="farmer_no", type="string", example="F00000001"),
     *              @SWG\Property(property="fertilizer", type="string", example="Kimia"),   
     *              @SWG\Property(property="pesticide", type="string", example="Kimia"),
     *              @SWG\Property(property="sppt", type="string", example="File"),
     *              @SWG\Property(property="active", type="int", example="1"),
     *              @SWG\Property(property="user_id", type="int", example="2")
     *          ),
     *      )
     * )
     *
     */
    public function AddMandatoryLahan(Request $request){
        try{
            $validator = Validator::make($request->all(), [                
                'document_no' => 'required|max:255',
                'land_area' => 'required|max:255',
                'longitude' => 'required|max:255',
                'latitude' => 'required|max:255',
                'coordinate' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'target_area' => 'required|max:255',
                'mu_no' => 'required|max:255',
                'active' => 'required|max:1',
                'farmer_no' => 'required|max:11',
                'user_id' => 'required|max:11',
                'fertilizer' => 'required|max:255',
                'pesticide' => 'required|max:255',
                'sppt' => 'required',
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $getLastIdLahan = Lahan::orderBy('lahan_no','desc')->first(); 
            if($getLastIdLahan){
                $lahan_no = 'L'.str_pad(((int)substr($getLastIdLahan->lahan_no,-8) + 1), 8, '0', STR_PAD_LEFT);
            }else{
                $lahan_no = 'L00000001';
            }

            Lahan::create([
                'lahan_no' => $lahan_no,
                'barcode' => $lahan_no,
                'document_no' => $request->document_no,
                'land_area' => $request->land_area,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'coordinate' => $request->coordinate,
                'village' => $request->village,
                'kecamatan' => $request->kecamatan,
                'city' => $request->city,
                'province' => $request->province,
                'mu_no' => $request->mu_no,
                'target_area' => $request->target_area,
                'active' => $request->active,
                'farmer_no' => $request->farmer_no,
                'user_id' => $request->user_id,
                'fertilizer' => $request->fertilizer,
                'pesticide' => $request->pesticide,
                'sppt' => $request->sppt,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

                'planting_area' => $this->ReplaceNull($request->planting_area, 'int'),
                'polygon' => $this->ReplaceNull($request->polygon, 'string'),
                'description' => $this->ReplaceNull($request->description, 'string'),
                'elevation' => $this->ReplaceNull($request->elevation, 'string'),
                'soil_type' => $this->ReplaceNull($request->soil_type, 'string'),
                'current_crops' => $this->ReplaceNull($request->current_crops, 'string'),
                'tutupan_lahan' => $this->ReplaceNull($request->tutupan_lahan, 'string'),
                'photo1' => $this->ReplaceNull($request->photo1, 'string'),
                'photo2' => $this->ReplaceNull($request->photo2, 'string'),
                'photo3' => $this->ReplaceNull($request->photo3, 'string'),
                'photo4' => $this->ReplaceNull($request->photo4, 'string'),
                'group_no' => $this->ReplaceNull($request->group_no, 'string'),
                'kelerengan_lahan' => $this->ReplaceNull($request->kelerengan_lahan, 'string'),
                'access_to_water_sources' => $this->ReplaceNull($request->access_to_water_sources, 'string'),
                'access_to_lahan' => $this->ReplaceNull($request->access_to_lahan, 'string'),

                'is_dell' => 0
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200); 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/AddMandatoryLahanBarcode",
	 *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Mandatory Lahan Barcode",
     *   operationId="AddMandatoryLahanBarcode",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Mandatory Lahan Barcode",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="user_id", type="integer", example=1),
     *              @SWG\Property(property="barcode", type="string", example="L0000001"),
     *              @SWG\Property(property="longitude", type="string", example="110.3300613"),
     *              @SWG\Property(property="latitude", type="string", example="-7.580778")
     *          ),
     *      )
     * )
     *
     */
    public function AddMandatoryLahanBarcode(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required', 
                'barcode' => 'required|max:255|unique:lahans',
                'longitude' => 'required|max:255',
                'latitude' => 'required|max:255'
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $coordinate = $this->getCordinate($request->longitude, $request->latitude);

            // var_dump($coordinate);
            Lahan::create([
                'lahan_no' => $request->barcode,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'coordinate' => $coordinate,
                'barcode' => $request->barcode,
                'user_id' => $request->user_id,

                'document_no' => $this->ReplaceNull($request->document_no, 'string'),
                'land_area' => $this->ReplaceNull($request->land_area, 'int'),                
                'village' => $this->ReplaceNull($request->village, 'string'),
                'kecamatan' => $this->ReplaceNull($request->kecamatan, 'string'),
                'city' => $this->ReplaceNull($request->city, 'string'),
                'province' => $this->ReplaceNull($request->province, 'string'),
                'mu_no' => $this->ReplaceNull($request->mu_no, 'string'),
                'target_area' => $this->ReplaceNull($request->target_area, 'string'),
                'active' => $this->ReplaceNull($request->active, 'int'),
                // 'farmer_no' => $this->ReplaceNull($request->farmer_no, 'string'),                
                'fertilizer' => $this->ReplaceNull($request->fertilizer, 'string'),
                'pesticide' => $this->ReplaceNull($request->pesticide, 'string'),
                'sppt' => $this->ReplaceNull($request->sppt, 'string'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

                'planting_area' => $this->ReplaceNull($request->planting_area, 'int'),
                'polygon' => $this->ReplaceNull($request->polygon, 'string'),
                'description' => $this->ReplaceNull($request->description, 'string'),
                'elevation' => $this->ReplaceNull($request->elevation, 'string'),
                'soil_type' => $this->ReplaceNull($request->soil_type, 'string'),
                'current_crops' => $this->ReplaceNull($request->current_crops, 'string'),
                'tutupan_lahan' => $this->ReplaceNull($request->tutupan_lahan, 'string'),
                'photo1' => $this->ReplaceNull($request->photo1, 'string'),
                'photo2' => $this->ReplaceNull($request->photo2, 'string'),
                'photo3' => $this->ReplaceNull($request->photo3, 'string'),
                'photo4' => $this->ReplaceNull($request->photo4, 'string'),
                'group_no' => $this->ReplaceNull($request->group_no, 'string'),
                'kelerengan_lahan' => $this->ReplaceNull($request->kelerengan_lahan, 'string'),
                'access_to_water_sources' => $this->ReplaceNull($request->access_to_water_sources, 'string'),
                'access_to_lahan' => $this->ReplaceNull($request->access_to_lahan, 'string'),

                'is_dell' => 0
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200); 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/UpdateLahan",
	 *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Lahan",
     *   operationId="UpdateLahan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Lahan",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example="0909090909"),
     *              @SWG\Property(property="document_no", type="string", example="0909090909"),
     *              @SWG\Property(property="land_area", type="string", example="8200.00"),
     *              @SWG\Property(property="longitude", type="date", example="110.3300613"),
     *              @SWG\Property(property="latitude", type="string", example="-7.580778"),
     *              @SWG\Property(property="coordinate", type="string", example="S734.847E11019.935"),
     *              @SWG\Property(property="village", type="string", example="33.05.10.18"),
     *              @SWG\Property(property="kecamatan", type="string", example="33.05.10"),
     *              @SWG\Property(property="city", type="string", example="33.05"),
     *              @SWG\Property(property="province", type="string", example="JT"),
     *              @SWG\Property(property="mu_no", type="string", example="025"),
     *              @SWG\Property(property="target_area", type="string", example="025001"),
     *              @SWG\Property(property="farmer_no", type="string", example="F00000001"),
     *              @SWG\Property(property="fertilizer", type="string", example="Kimia"),   
     *              @SWG\Property(property="pesticide", type="string", example="Kimia"),
     *              @SWG\Property(property="sppt", type="string", example="File"),
     *              @SWG\Property(property="description", type="string", example="Nullable"),
     *              @SWG\Property(property="photo1", type="string", example="Nullable"),
     *              @SWG\Property(property="photo2", type="string", example="Nullable"),
     *              @SWG\Property(property="photo3", type="string", example="Nullable"),
     *              @SWG\Property(property="photo4", type="string", example="Nullable"),
     *              @SWG\Property(property="group_no", type="string", example="Nullable"),
     *              @SWG\Property(property="planting_area", type="string", example="Nullable"),
     *              @SWG\Property(property="polygon", type="string", example="Nullable"),
     *              @SWG\Property(property="elevation", type="string", example="Nullable"),
     *              @SWG\Property(property="soil_type", type="string", example="Nullable"),
     *              @SWG\Property(property="current_crops", type="string", example="Nullable"),
     *              @SWG\Property(property="tutupan_lahan", type="string", example="Nullable"),
     *              @SWG\Property(property="kelerengan_lahan", type="string", example="Nullable"),
     *              @SWG\Property(property="access_to_water_sources", type="string", example="Nullable"),
     *              @SWG\Property(property="access_to_lahan", type="string", example="Nullable"),    
     *              @SWG\Property(property="active", type="int", example="1"),
     *              @SWG\Property(property="user_id", type="int", example="2")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateLahan(Request $request){
        try{
            $validator = Validator::make($request->all(), [    
                'id' => 'required|max:255',            
                'document_no' => 'required|max:255',
                'land_area' => 'required|max:255',
                'longitude' => 'required|max:255',
                'latitude' => 'required|max:255',
                'coordinate' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'target_area' => 'required|max:255',
                'mu_no' => 'required|max:255',
                'active' => 'required|max:1',
                'farmer_no' => 'required|max:11',
                'user_id' => 'required|max:11',
                'fertilizer' => 'required|max:255',
                'pesticide' => 'required|max:255',
                'sppt' => 'required',
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $getLastIdLahan = Lahan::orderBy('lahan_no','desc')->first(); 
            if($getLastIdLahan){
                $lahan_no = 'L'.str_pad(((int)substr($getLastIdLahan->lahan_no,-8) + 1), 8, '0', STR_PAD_LEFT);
            }else{
                $lahan_no = 'L00000001';
            }

            $description = $this->ReplaceNull($request->description, 'string');
            $photo1 = $this->ReplaceNull($request->photo1, 'string');
            $photo2 = $this->ReplaceNull($request->photo2, 'string');
            $photo3 = $this->ReplaceNull($request->photo3, 'string');
            $photo4 = $this->ReplaceNull($request->photo4, 'string');
            $group_no = $this->ReplaceNull($request->group_no, 'string');
            $planting_area = $this->ReplaceNull($request->planting_area, 'int');
            $polygon = $this->ReplaceNull($request->polygon, 'string');
            $elevation = $this->ReplaceNull($request->elevation, 'string');
            $soil_type = $this->ReplaceNull($request->soil_type, 'string');
            $current_crops = $this->ReplaceNull($request->current_crops, 'string');
            $tutupan_lahan = $this->ReplaceNull($request->tutupan_lahan, 'string');
            $kelerengan_lahan = $this->ReplaceNull($request->kelerengan_lahan, 'string');
            $access_to_water_sources = $this->ReplaceNull($request->access_to_water_sources, 'string');
            $access_to_lahan = $this->ReplaceNull($request->access_to_lahan, 'string');


            Lahan::where('id', '=', $request->id)
            ->update([
                'lahan_no' => $lahan_no,
                'barcode' => $lahan_no,
                'document_no' => $request->document_no,
                'land_area' => $request->land_area,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'coordinate' => $request->coordinate,
                'village' => $request->village,
                'kecamatan' => $request->kecamatan,
                'city' => $request->city,
                'province' => $request->province,
                'mu_no' => $request->mu_no,
                'target_area' => $request->target_area,
                'active' => $request->active,
                'farmer_no' => $request->farmer_no,
                'user_id' => $request->user_id,
                'fertilizer' => $request->fertilizer,
                'pesticide' => $request->pesticide,
                'sppt' => $request->sppt,

                'updated_at'=>Carbon::now(),

                'planting_area' => $planting_area,
                'polygon' => $polygon,
                'description' => $description,
                'elevation' => $elevation,
                'soil_type' => $soil_type,
                'current_crops' => $current_crops,
                'tutupan_lahan' => $tutupan_lahan,
                'photo1' => $photo1,
                'photo2' => $photo2,
                'photo3' => $photo3,
                'photo4' => $photo4,
                'group_no' => $group_no,
                'kelerengan_lahan' => $kelerengan_lahan,
                'access_to_water_sources' => $access_to_water_sources,
                'access_to_lahan' => $access_to_lahan,

                'is_dell' => 0
            ]);
            // $getUserIdLahan = Lahan::where('id','=',$request->id)->first();
            // if($request->user_id == $getUserIdLahan->user_id ){}
            if($description != "-" && $photo1 != "-" )
            {
                Lahan::where('id', '=', $request->id)
                ->update
                (['complete_data' => 1]);
            }

            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200); 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/SoftDeleteLahan",
	 *   tags={"Lahan"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Soft Delete Lahan",
     *   operationId="SoftDeleteLahan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Soft Delete Lahan",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="string", example="2")
     *          ),
     *      )
     * )
     *
     */
    public function SoftDeleteLahan(Request $request){
        try{
            $validator = Validator::make($request->all(), [    
                'id' => 'required|max:255'
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
            Lahan::where('id', '=', $request->id)
                    ->update
                    ([
                        'is_dell' => 1
                    ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200); 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
}
