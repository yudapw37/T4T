<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use App\FieldFacilitator;

class FieldFacilitatorController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/GetFieldFacilitator",
     *   tags={"FieldFacilitator"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Field Facilitator",
     *   operationId="GetFieldFacilitator",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="name",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetFieldFacilitator(Request $request){
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        $getname = $request->name;
        if($getname){$name='%'.$getname.'%';}
        else{$name='%%';}
        try{
            $GetFieldFacilitator = FieldFacilitator::select('id', 'ff_no', 'name', 'gender', 'ktp_no','address','active', 'created_at')->where('name', 'Like', $name)->orderBy('name', 'ASC')->limit($limit)->offset($offset)->get();
            // var_dump($GetFieldFacilitator);
            if(count($GetFieldFacilitator)!=0){
                $count = FieldFacilitator::count();
                $data = ['count'=>$count, 'data'=>$GetFieldFacilitator];
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
     *   path="/api/GetFieldFacilitatorDetail",
     *   tags={"FieldFacilitator"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Field Facilitator Detail",
     *   operationId="GetFieldFacilitatorDetail",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="id",in="query", type="string")
     * )
     */
    public function GetFieldFacilitatorDetail(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
            $GetFieldFacilitatorDetail = FieldFacilitator::where('id', '=', $request->id)
            ->first();
            if($GetFieldFacilitatorDetail){
                $rslt =  $this->ResultReturn(200, 'success', $GetFieldFacilitatorDetail);
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
     *   path="/api/AddFieldFacilitator",
	 *   tags={"FieldFacilitator"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Field Facilitator",
     *   operationId="AddFieldFacilitator",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Field Facilitator",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="name", type="string", example="Mangga"),
     *              @SWG\Property(property="birthday", type="date", example="1990-01-30"),
     *              @SWG\Property(property="religion", type="string", example="islam"),
     *              @SWG\Property(property="gender", type="string", example="male/female"),
     *              @SWG\Property(property="ktp_no", type="string", example="33101700020001"),
     *              @SWG\Property(property="address", type="string", example="Jl Cemara 11"),
     *              @SWG\Property(property="village", type="string", example="32.04.30.01"),
     *              @SWG\Property(property="kecamatan", type="string", example="32.04.30.01"),
     *              @SWG\Property(property="city", type="string", example="32.04"),
     *              @SWG\Property(property="province", type="string", example="JT"),
     *              @SWG\Property(property="mu_no", type="string", example="023"),
     *              @SWG\Property(property="target_area", type="string", example="023001"),
     *              @SWG\Property(property="active", type="string", example="1"),
     *              @SWG\Property(property="user_id", type="string", example="023"),
     *              @SWG\Property(property="marrital", type="string", example="Nullable"),
     *              @SWG\Property(property="join_date", type="date", example="Nullable"),
     *              @SWG\Property(property="phone", type="string", example="Nullable"),
     *              @SWG\Property(property="post_code", type="string", example="Nullable"),
     *              @SWG\Property(property="bank_account", type="string", example="Nullable"),
     *              @SWG\Property(property="bank_branch", type="date", example="Nullable"),
     *              @SWG\Property(property="bank_name", type="string", example="Nullable"),
     *              @SWG\Property(property="ff_photo", type="string", example="Nullable"),
     *              @SWG\Property(property="ff_photo_path", type="string", example="Nullable")
     *          ),
     *      )
     * )
     *
     */
    public function AddFieldFacilitator(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'birthday' => 'required|max:255',
                'religion' => 'required|max:255',
                'gender' => 'required|max:255',
                'ktp_no' => 'required|max:255',
                'address' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'mu_no' => 'required|max:255',
                'target_area' => 'required|max:255',
                'active' => 'required|max:255',
                'user_id' => 'required|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $getLastIdFieldFacilitator = FieldFacilitator::where('mu_no','=',$request->mu_no)->orderBy('ff_no','desc')->first(); 
            // var_dump($$getLastIdTrees->tree_code);
            $getYearNow = Carbon::now()->format('Y');
            if($getLastIdFieldFacilitator){
                $ff_no = $request->mu_no.$getYearNow.str_pad(((int)substr($getLastIdFieldFacilitator->ff_no,-4) + 1), 4, '0', STR_PAD_LEFT);
            }else{
                $ff_no = $request->mu_no.$getYearNow.'0001';
            }

            
    
            FieldFacilitator::create([
                'ff_no' => $ff_no,
                'name' => $request->name,
                'birthday' => $request->birthday,
                'religion' => $request->religion,
                'ktp_no' => $request->ktp_no,
                'address' => $request->address,
                'village' => $request->village,
                'kecamatan' => $request->kecamatan,
                'city' => $request->city,
                'province' => $request->province,
                'mu_no' => $request->mu_no,
                'target_area' => $request->target_area,
                'active' => $request->active,
                'user_id' => $request->user_id,
                

                'marrital' => $this->ReplaceNull($request->marrital, 'string'),
                'join_date' => $this->ReplaceNull($request->join_date, 'date'),
                'phone' => $this->ReplaceNull($request->phone, 'string'),
                'post_code' => $this->ReplaceNull($request->post_code, 'string'),
                'bank_account' => $this->ReplaceNull($request->bank_account, 'string'),
                'bank_branch' => $this->ReplaceNull($request->bank_branch, 'string'),
                'bank_name' => $this->ReplaceNull($request->bank_name, 'string'),
                'ff_photo' => $this->ReplaceNull($request->ff_photo, 'string'),
                'ff_photo_path' => $this->ReplaceNull($request->ff_photo_path, 'string'),

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
     *   path="/api/UpdateFieldFacilitator",
	 *   tags={"FieldFacilitator"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Field Facilitator",
     *   operationId="UpdateFieldFacilitator",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Field Facilitator",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="name", type="string", example="Mangga"),
     *              @SWG\Property(property="birthday", type="date", example="1990-01-30"),
     *              @SWG\Property(property="religion", type="string", example="islam"),
     *              @SWG\Property(property="gender", type="string", example="male/female"),
     *              @SWG\Property(property="ktp_no", type="string", example="33101700020001"),
     *              @SWG\Property(property="address", type="string", example="Jl Cemara 11"),
     *              @SWG\Property(property="village", type="string", example="32.04.30.01"),
     *              @SWG\Property(property="kecamatan", type="string", example="32.04.30.01"),
     *              @SWG\Property(property="city", type="string", example="32.04"),
     *              @SWG\Property(property="province", type="string", example="JT"),
     *              @SWG\Property(property="mu_no", type="string", example="023"),
     *              @SWG\Property(property="target_area", type="string", example="023001"),
     *              @SWG\Property(property="active", type="string", example="1"),
     *              @SWG\Property(property="user_id", type="string", example="023"),
     *              @SWG\Property(property="marrital", type="string", example="Nullable"),
     *              @SWG\Property(property="join_date", type="date", example="Nullable"),
     *              @SWG\Property(property="phone", type="string", example="Nullable"),
     *              @SWG\Property(property="post_code", type="string", example="Nullable"),
     *              @SWG\Property(property="bank_account", type="string", example="Nullable"),
     *              @SWG\Property(property="bank_branch", type="date", example="Nullable"),
     *              @SWG\Property(property="bank_name", type="string", example="Nullable"),
     *              @SWG\Property(property="ff_photo", type="string", example="Nullable"),
     *              @SWG\Property(property="ff_photo_path", type="string", example="Nullable")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateFieldFacilitator(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|max:255',
                'name' => 'required|max:255',
                'birthday' => 'required|max:255',
                'religion' => 'required|max:255',
                'gender' => 'required|max:255',
                'ktp_no' => 'required|max:255',
                'address' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'mu_no' => 'required|max:255',
                'target_area' => 'required|max:255',
                'active' => 'required|max:255',
                'user_id' => 'required|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            FieldFacilitator::where('id', '=', $request->id)
            ->update([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'religion' => $request->religion,
                'ktp_no' => $request->ktp_no,
                'address' => $request->address,
                'village' => $request->village,
                'kecamatan' => $request->kecamatan,
                'city' => $request->city,
                'province' => $request->province,
                'mu_no' => $request->mu_no,
                'target_area' => $request->target_area,
                'active' => $request->active,
                'user_id' => $request->user_id,
                

                'marrital' => $this->ReplaceNull($request->marrital, 'string'),
                'join_date' => $this->ReplaceNull($request->join_date, 'date'),
                'phone' => $this->ReplaceNull($request->phone, 'string'),
                'post_code' => $this->ReplaceNull($request->post_code, 'string'),
                'bank_account' => $this->ReplaceNull($request->bank_account, 'string'),
                'bank_branch' => $this->ReplaceNull($request->bank_branch, 'string'),
                'bank_name' => $this->ReplaceNull($request->bank_name, 'string'),
                'ff_photo' => $this->ReplaceNull($request->ff_photo, 'string'),
                'ff_photo_path' => $this->ReplaceNull($request->ff_photo_path, 'string'),

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
     *   path="/api/DeleteFieldFacilitator",
	 *   tags={"FieldFacilitator"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Field Facilitator",
     *   operationId="DeleteFieldFacilitator",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Field Facilitator",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function DeleteFieldFacilitator(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
    
            DB::table('field_facilitators')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
}
