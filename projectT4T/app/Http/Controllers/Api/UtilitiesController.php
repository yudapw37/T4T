<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use App\Desa;
use App\Kecamatan;
use App\Kabupaten;
use App\Province;
use App\ManagementUnit;
use App\TargetArea;
use App\Verification;

class UtilitiesController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/GetProvince",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Province",
     *   operationId="GetProvince",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
     * )
     */
    public function GetProvince(Request $request){
        try{
            $GetProvince = Province::get();
            if(count($GetProvince)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetProvince);
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
     *   path="/api/GetKabupaten",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Kabupaten",
     *   operationId="GetKabupaten",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
      *      @SWG\Parameter(name="province_code",in="query", type="string"),
     * )
     */
    public function GetKabupaten(Request $request){
        try{
            $GetKabupaten = Kabupaten::where('province_code','=',$request->province_code)->get();
            if(count($GetKabupaten)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetKabupaten);
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
     *   path="/api/GetKecamatan",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Kecamatan",
     *   operationId="GetKecamatan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
      *      @SWG\Parameter(name="kabupaten_no",in="query", type="string"),
     * )
     */
    public function GetKecamatan(Request $request){
        try{
            $GetKecamatan = Kabupaten::where('kabupaten_no','=',$request->kabupaten_no)->get();
            if(count($GetKecamatan)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetKecamatan);
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
     *   path="/api/GetDesa",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Desa",
     *   operationId="GetDesa",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
      *      @SWG\Parameter(name="kode_kecamatan",in="query", type="string"),
     * )
     */
    public function GetDesa(Request $request){
        try{
            $GetDesa = Kabupaten::where('kode_kecamatan','=',$request->kode_kecamatan)->get();
            if(count($GetDesa)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetDesa);
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
     *   path="/api/AddProvince",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Province",
     *   operationId="AddProvince",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Province",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="province_code", type="string", example="JT"),
     *              @SWG\Property(property="name", type="string", example="Jawa Tengah")
     *          ),
     *      )
     * )
     *
     */
    public function AddProvince(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'province_code' => 'required|string|max:255|unique:provinces',
                'name' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Province::create([
                'province_code' => $request->province_code,
                'name' => $request->name,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/AddKabupaten",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Kabupaten",
     *   operationId="AddKabupaten",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Kabupaten",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="kabupaten_no", type="string", example="33.04"),
     *              @SWG\Property(property="kab_code", type="string", example="04"),
     *              @SWG\Property(property="province_code", type="string", example="JT"),
     *              @SWG\Property(property="name", type="string", example="Kab. Banjarnegara")
     *          ),
     *      )
     * )
     *
     */
    public function AddKabupaten(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'kabupaten_no' => 'required|string|max:255|unique:kabupatens',
                'province_code' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'kab_code' => 'required|string|max:255|unique:kabupatens',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Kabupaten::create([
                'kabupaten_no' => $request->kabupaten_no,
                'province_code' => $request->province_code,
                'name' => $request->name,
                'kab_code' => $request->kab_code,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/AddKecamatan",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Kecamatan",
     *   operationId="AddKecamatan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Kecamatan",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="kabupaten_no", type="string", example="33.04"),
     *              @SWG\Property(property="kode_kecamatan", type="string", example="33.04.09"),
     *              @SWG\Property(property="name", type="string", example="Banjarnegara")
     *          ),
     *      )
     * )
     *
     */
    public function AddKecamatan(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'kabupaten_no' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'kode_kecamatan' => 'required|string|max:255|unique:kecamatans',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Kecamatan::create([
                'kabupaten_no' => $request->kabupaten_no,
                'name' => $request->name,
                'kode_kecamatan' => $request->kode_kecamatan,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/AddDesa",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Desa",
     *   operationId="AddDesa",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Desa",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="kode_desa", type="string", example="33.04.09.02"),
     *              @SWG\Property(property="kode_kecamatan", type="string", example="33.04.09"),
     *              @SWG\Property(property="name", type="string", example="Desa Banjar")
     *          ),
     *      )
     * )
     *
     */
    public function AddDesa(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'kode_desa' => 'required|string|max:255|unique:desas',
                'name' => 'required|string|max:255',
                'kode_kecamatan' => 'required|string|max:255',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Desa::create([
                'kode_desa' => $request->kode_desa,
                'name' => $request->name,
                'kode_kecamatan' => $request->kode_kecamatan,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/UpdateProvince",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Province",
     *   operationId="UpdateProvince",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Province",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="province_code", type="string", example="JT"),
     *              @SWG\Property(property="name", type="string", example="Jawa Tengah")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateProvince(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'province_code' => 'required|string|max:255',
                'name' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Province::where('id', '=', $request->id)
            ->update([
                'province_code' => $request->province_code,
                'name' => $request->name,
                'updated_at'=>Carbon::now()
            ]);
            Kabupaten::where('province_code', '=', $request->province_code)
            ->update([
                'province_code' => $request->province_code,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/UpdateKabupaten",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Kabupaten",
     *   operationId="UpdateKabupaten",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Kabupaten",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="kabupaten_no", type="string", example="33.04"),
     *              @SWG\Property(property="kab_code", type="string", example="04"),
     *              @SWG\Property(property="province_code", type="string", example="JT"),
     *              @SWG\Property(property="name", type="string", example="Kab. Banjarnegara")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateKabupaten(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'kabupaten_no' => 'required|string|max:255',
                'province_code' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'kab_code' => 'required|string|max:255|unique:kabupatens',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Kabupaten::where('id', '=', $request->id)
            ->update([
                'kabupaten_no' => $request->kabupaten_no,
                'province_code' => $request->province_code,
                'name' => $request->name,
                'kab_code' => $request->kab_code,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/UpdateKecamatan",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Kecamatan",
     *   operationId="UpdateKecamatan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="UpdateKecamatan",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="kabupaten_no", type="string", example="33.04"),
     *              @SWG\Property(property="kode_kecamatan", type="string", example="33.04.09"),
     *              @SWG\Property(property="name", type="string", example="Banjarnegara")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateKecamatan(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'kabupaten_no' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'kode_kecamatan' => 'required|string|max:255',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Kecamatan::where('id', '=', $request->id)
            ->update([
                'kabupaten_no' => $request->kabupaten_no,
                'name' => $request->name,
                'kode_kecamatan' => $request->kode_kecamatan,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/UpdateDesa",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Desa",
     *   operationId="UpdateDesa",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Desa",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="kode_desa", type="string", example="33.04.09.02"),
     *              @SWG\Property(property="kode_kecamatan", type="string", example="33.04.09"),
     *              @SWG\Property(property="name", type="string", example="Desa Banjar")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateDesa(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'kode_desa' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'kode_kecamatan' => 'required|string|max:255',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            Desa::where('id', '=', $request->id)
            ->update([
                'kode_desa' => $request->kode_desa,
                'name' => $request->name,
                'kode_kecamatan' => $request->kode_kecamatan,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/DeleteProvince",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Province",
     *   operationId="DeleteProvince",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Province",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function DeleteProvince(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('provinces')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/DeleteKabupaten",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Kabupaten",
     *   operationId="DeleteKabupaten",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Kabupaten",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function DeleteKabupaten(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('kabupatens')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/DeleteKecamatan",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Kecamatan",
     *   operationId="DeleteKecamatan",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Kecamatan",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function DeleteKecamatan(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('kecamatans')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/DeleteDesa",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Desa",
     *   operationId="DeleteDesa",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Desa",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function DeleteDesa(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('desas')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Get(
     *   path="/api/GetManagementUnit",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Management Unit",
     *   operationId="GetManagementUnit",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
     * )
     */
    public function GetManagementUnit(Request $request){
        try{
            $GetManagementUnit = ManagementUnit::get();
            if(count($GetManagementUnit)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetManagementUnit);
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
     *   path="/api/GetTargetArea",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Target Area",
     *   operationId="GetTargetArea",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
     *   @SWG\Parameter(name="mu_no",in="query", type="string"),
     * )
     */
    public function GetTargetArea(Request $request){
        try{
            $GetTargetArea = TargetArea::where('mu_no','=', $request->mu_no)->get();
            if(count($GetTargetArea)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetTargetArea);
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
     *   path="/api/AddManagementUnit",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Management Unit",
     *   operationId="AddManagementUnit",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Management Unit",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="name", type="string", example="Kebumen")
     *          ),
     *      )
     * )
     *
     */
    public function AddManagementUnit(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            $getLastIdTargetArea = ManagementUnit::orderBy('mu_no','desc')->first(); 
            if($getLastIdTargetArea){
                $mu_no = (int)$getLastIdTargetArea->mu_no + 1;
            }else{
                $mu_no = 001;
            }
            // $getCountMU = ManagementUnit::count();
            // $mu_no = str_pad($getCountMU+1, 3, '0', STR_PAD_LEFT);

            ManagementUnit::create([
                'mu_no' => $mu_no,
                'name' => $request->name,
                'active' => 1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/AddTargetArea",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Target Area",
     *   operationId="AddTargetArea",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Target Area",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="mu_no", type="string", example="014"),
     *               @SWG\Property(property="name", type="string", example="Bojong"),
     *               @SWG\Property(property="kab_code", type="string", example="05"),
     *               @SWG\Property(property="fc_no", type="string", example="140120090070"),
     *               @SWG\Property(property="luas", type="int", example="100.0"),
     *               @SWG\Property(property="province_code", type="string", example="JT")
     *          ),
     *      )
     * )
     *
     */
    public function AddTargetArea(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'mu_no' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'kab_code' => 'required|string|max:255',
                'fc_no' => 'required|string|max:255',
                'luas' => 'required|max:255',
                'province_code' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            $getLastIdTargetArea = TargetArea::where('mu_no','=',$request->mu_no)->orderBy('area_code','desc')->first(); 
            if($getLastIdTargetArea){
                $getNewId = (int)substr($getLastIdTargetArea->area_code,-3) + 1;
            }else{
                $getNewId = 001;
            }
            
            $area_code = $request->mu_no.str_pad($getNewId, 3, '0', STR_PAD_LEFT);

            TargetArea::create([
                'area_code' => $area_code,
                'mu_no' => $request->mu_no,
                'name' => $request->name,
                'kab_code' => $request->kab_code,
                'fc_no' => $request->fc_no,
                'luas' => $request->luas,
                'province_code' => $request->province_code,
                'active' => 1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/UpdateManagementUnit",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Management Unit",
     *   operationId="UpdateManagementUnit",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Management Unit",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="name", type="string", example="Kebumen"),
     *              @SWG\Property(property="active", type="string", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function UpdateManagementUnit(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'name' => 'required|string|max:255',
                'active' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }

            ManagementUnit::where('id', '=', $request->id)
            ->update([
                'name' => $request->name,
                'active' => $request->name,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/UpdateTargetArea",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Target Area",
     *   operationId="UpdateTargetArea",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Target Area",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="name", type="string", example="Bojong1"),
     *              @SWG\Property(property="mu_no", type="string", example="014"),
     *              @SWG\Property(property="kab_code", type="string", example="05"),
     *              @SWG\Property(property="fc_no", type="string", example="140120090070"),
     *              @SWG\Property(property="luas", type="int", example="100.0"),
     *              @SWG\Property(property="province_code", type="string", example="JT"),
     *              @SWG\Property(property="active", type="string", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function UpdateTargetArea(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'name' => 'required|string|max:255',
                'mu_no' => 'required|string|max:255',
                'kab_code' => 'required|string|max:255',
                'fc_no' => 'required|string|max:255',
                'luas' => 'required|max:255',
                'province_code' => 'required|string|max:255',
                'active' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $getAreaCodeTargetArea = TargetArea::where('id', '=', $request->id)->first();
            if($getAreaCodeTargetArea->mu_no != $request->mu_no){
                $getLastIdTargetArea = TargetArea::where('mu_no','=',$request->mu_no)->orderBy('area_code','desc')->first(); 
                if($getLastIdTargetArea){
                    $getNewId = (int)substr($getLastIdTargetArea->area_code,-3) + 1;
                }else{
                    $getNewId = 001;
                }
                $area_code = $request->mu_no.str_pad($getNewId, 3, '0', STR_PAD_LEFT);
            }
            else{
                $area_code = $getAreaCodeTargetArea->area_code;
            }            

            TargetArea::where('id', '=', $request->id)
            ->update([
                'area_code' => $area_code,
                'mu_no' => $request->mu_no,
                'name' => $request->name,
                'kab_code' => $request->kab_code,
                'fc_no' => $request->fc_no,
                'luas' => $request->luas,
                'province_code' => $request->province_code,
                'active' => $request->active,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/DeleteManagementUnit",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Management Unit",
     *   operationId="DeleteManagementUnit",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Management Unit",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="string", example="1")
     *          ),
     *      )
     * )
     *
     */
    public function DeleteManagementUnit(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('managementunits')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/DeleteTargetArea",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Target Area",
     *   operationId="DeleteTargetArea",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Target Area",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="string", example="1")
     *          ),
     *      )
     * )
     *
     */
    public function DeleteTargetArea(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('target_areas')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Get(
     *   path="/api/GetVerification",
     *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Verification",
     *   operationId="GetVerification",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
     * )
     */
    public function GetVerification(Request $request){
        try{
            $GetVerification = Verification::select('verification_code', 'type')->get();
            if(count($GetVerification)!=0){
                $rslt =  $this->ResultReturn(200, 'success', $GetVerification);
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
     *   path="/api/AddVerification",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Verification",
     *   operationId="AddVerification",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Verification",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="verification_code", type="int", example="1"),
     *              @SWG\Property(property="type", type="string", example="verification_fc/verification_um/verification_plan/verification_pm")
     *          ),
     *      )
     * )
     *
     */
    public function AddVerification(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'verification_code' => 'required|integer|max:255|unique:verifications',
                'type' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            Verification::create([
                'verification_code' => $request->verification_code,
                'type' => $request->type,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/UpdateVerification",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Verification",
     *   operationId="UpdateVerification",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Verification",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="string", example="1"),
     *              @SWG\Property(property="verification_code", type="int", example="1"),
     *              @SWG\Property(property="type", type="enum", example="verification_fc/verification_um/verification_plan/verification_pm")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateVerification(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255',
                'verification_code' => 'required|integer|max:255',
                'type' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            Verification::where('id', '=', $request->id)
            ->update([
                'verification_code' => $request->verification_code,
                'type' => $request->type,
                'updated_at'=>Carbon::now()
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/DeleteVerification",
	 *   tags={"Utilities"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Verification",
     *   operationId="DeleteVerification",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Verification",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example="1")
     *          ),
     *      )
     * )
     *
     */
    public function DeleteVerification(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('verifications')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
}
