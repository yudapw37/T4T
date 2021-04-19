<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\User;
use App\Farmer;

class FarmerController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/GetFarmerNotComplete",
     *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Farmers Not Complete",
     *   operationId="GetFarmerNotComplete",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="name",in="query", type="string"),
     *      @SWG\Parameter(name="userId",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetFarmerNotComplete(Request $request){
        $userId = $request->userId;
        $getname = $request->name;
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        if($getname){$name='%'.$getname.'%';}
        else{$name='%%';}
        try{
            $GetFarmerNotComplete = Farmer::where('user_id', '=', $userId)->where('name', 'Like', $name)->where('is_dell', '=', 0)->where('complete_data', '=', 0)->orderBy('name', 'ASC')->limit($limit)->offset($offset)->get();
            if(count($GetFarmerNotComplete)!=0){
                $count = Farmer::where('user_id', '=', $userId)->where('is_dell', '=', 0)->where('complete_data', '=', 0)->count();
                $data = ['count'=>$count, 'data'=>$GetFarmerNotComplete];
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
     *   path="/api/GetFarmerCompleteNotApprove",
     *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Farmers Complete Not Approve",
     *   operationId="GetFarmerCompleteNotApprove",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="name",in="query", type="string"),
     *      @SWG\Parameter(name="userId",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetFarmerCompleteNotApprove(Request $request){
        $userId = $request->userId;
        $getname = $request->name;
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        if($getname){$name='%'.$getname.'%';}
        else{$name='%%';}
        try{
            $GetFarmerCompleteNotApprove = Farmer::where('user_id', '=', $userId)->where('name', 'Like', $name)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 0)->orderBy('name', 'ASC')->limit($limit)->offset($offset)->get();
            if(count($GetFarmerCompleteNotApprove)!=0){
                $count = Farmer::where('user_id', '=', $userId)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 0)->count();
                $data = ['count'=>$count, 'data'=>$GetFarmerCompleteNotApprove];
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
     *   path="/api/GetFarmerCompleteAndApprove",
     *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Farmers Complete And Approve",
     *   operationId="GetFarmerCompleteAndApprove",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="name",in="query", type="string"),
     *      @SWG\Parameter(name="userId",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetFarmerCompleteAndApprove(Request $request){
        $userId = $request->userId;
        $getname = $request->name;
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        if($getname){$name='%'.$getname.'%';}
        else{$name='%%';}
        try{
            $GetFarmerCompleteAndApprove = Farmer::where('user_id', '=', $userId)->where('name', 'Like', $name)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 1)->orderBy('name', 'ASC')->limit($limit)->offset($offset)->get();
            if(count($GetFarmerCompleteAndApprove)!=0){
                $count = Farmer::where('user_id', '=', $userId)->where('is_dell', '=', 0)->where('complete_data', '=', 1)->where('approve', '=', 1)->count();
                $data = ['count'=>$count, 'data'=>$GetFarmerCompleteAndApprove ];
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
     *   path="/api/GetFarmerDetail",
     *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Get Farmer Detail",
     *   operationId="GetFarmerDetail",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="id",in="query", type="string")
     * )
     */
    public function GetFarmerDetail(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
            $GetFarmerDetail = 
            DB::table('farmers')->where('farmers.id', '=', $request->id)
            ->leftjoin('provinces', 'provinces.province_code', '=', 'farmers.province')
            ->leftjoin('kabupatens', 'kabupatens.kabupaten_no', '=', 'farmers.city')
            ->leftjoin('kecamatans', 'kecamatans.kode_kecamatan', '=', 'farmers.kecamatan')
            ->leftjoin('desas', 'desas.kode_desa', '=', 'farmers.village')
            ->first();
            if($GetFarmerDetail){
                $rslt =  $this->ResultReturn(200, 'success', $GetFarmerDetail);
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
     *   path="/api/GetFarmerNoDropDown",
     *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get FarmerNumber DropDown",
     *   operationId="GetFarmerNoDropDown",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="user_id",in="query", type="string"),
     *      @SWG\Parameter(name="name",in="query", type="string")
     * )
     */
    public function GetFarmerNoDropDown(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }
            $GetFarmerNoDropDown = 
            DB::table('farmers')->select('id', 'farmer_no', 'name', 'user_id')->where('user_id', '=', $request->user_id)
            ->where('name', 'Like', '%'.$request->name.'%')->orderBy('name', 'ASC')->limit(10)->get();
            if($GetFarmerNoDropDown){
                $rslt =  $this->ResultReturn(200, 'success', $GetFarmerNoDropDown);
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
     *   path="/api/AddMandatoryFarmer",
	 *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Mandatory Farmer",
     *   operationId="AddMandatoryFarmer",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Mandatory Farmer",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="ktp_no", type="string", example="0909090909"),
     *              @SWG\Property(property="name", type="string", example="Budi Indra"),
     *              @SWG\Property(property="birthday", type="date", example="2000-10-20"),
     *              @SWG\Property(property="religion", type="string", example="Islam"),
     *              @SWG\Property(property="address", type="string", example="Jl Cemara No 22, Kemiri, Salatiga"),
     *              @SWG\Property(property="village", type="string", example="33.05.10.18"),
     *              @SWG\Property(property="kecamatan", type="string", example="33.05.10"),
     *              @SWG\Property(property="city", type="string", example="33.05"),
     *              @SWG\Property(property="province", type="string", example="JT"),
     *              @SWG\Property(property="marrital_status", type="string", example="Kawin"),
     *              @SWG\Property(property="phone", type="string", example="085777771111"),
     *              @SWG\Property(property="ethnic", type="string", example="Jawa"),   
     *              @SWG\Property(property="origin", type="string", example="lokal"),
     *              @SWG\Property(property="gender", type="string", example="male"),
     *              @SWG\Property(property="join_date", type="date", example="2021-03-20"),
     *              @SWG\Property(property="number_family_member", type="int", example="2"),   
     *              @SWG\Property(property="mu_no", type="string", example="024"),
     *              @SWG\Property(property="target_area", type="string", example="test"),
     *              @SWG\Property(property="active", type="int", example="1"),
     *              @SWG\Property(property="user_id", type="int", example="2"),
     *              @SWG\Property(property="ktp_document", type="int", example="test"),
     *          ),
     *      )
     * )
     *
     */
    public function AddMandatoryFarmer(Request $request){
        try{
            // date_default_timezone_set("Asia/Bangkok");

            $validator = Validator::make($request->all(), [
                'ktp_no' => 'required|max:255',
                'name' => 'required|max:255',
                'birthday' => 'required|max:255',
                'religion' => 'required|max:255',
                'address' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'marrital_status' => 'required|max:255',
                'phone' => 'required|max:255',
                'ethnic' => 'required|max:255',
                'origin' => 'required|max:255',
                'gender' => 'required|max:255',
                'join_date' => 'required|max:255',
                'number_family_member' => 'required|max:11',              
                'mu_no' => 'required|max:255',
                'target_area' => 'required|max:255',
                'active' => 'required|max:1',
                'user_id' => 'required|max:11',
                'ktp_document' => 'required'                
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $getLastIdFarmer = Farmer::orderBy('farmer_no','desc')->first(); 
            if($getLastIdFarmer){
                $farmerno = 'F'.str_pad(((int)substr($getLastIdFarmer->farmer_no,-8) + 1), 8, '0', STR_PAD_LEFT);
            }else{
                $farmerno = 'F00000001';
            }
            // $farmercount = Farmer::count();
            // $farmerno = 'F'.str_pad($farmercount+1, 8, '0', STR_PAD_LEFT);

            Farmer::create([
                'farmer_no' => $farmerno,
                'name' => $request->name,
                'birthday' => $request->birthday,
                'religion' => $request->religion,
                'ethnic' => $request->ethnic,
                'origin' => $request->origin,
                'gender' => $request->gender,
                'join_date' => $request->join_date,
                'number_family_member' => $request->number_family_member,
                'ktp_no' => $request->ktp_no,
                'phone' => $request->phone,
                'address' => $request->address,
                'village' => $request->village,
                'kecamatan' => $request->kecamatan,
                'city' => $request->city,
                'province' => $request->province,
                'mu_no' => $request->mu_no,
                'target_area' => $request->target_area,
                'active' => $request->active,
                'user_id' => $request->user_id,
                'ktp_document' => $request->ktp_document,
                'marrital_status' => $request->marrital_status,
                
                'post_code' => $this->ReplaceNull($request->post_code, 'string'),
                'group_no' => $this->ReplaceNull($request->group_no, 'string'),
                'mou_no' => $this->ReplaceNull($request->mou_no, 'string'),
                'main_income' => $this->ReplaceNull($request->main_income, 'int'),
                'side_income' => $this->ReplaceNull($request->side_income, 'int'),
                'main_job' => $this->ReplaceNull($request->main_job, 'string'),
                'side_job' => $this->ReplaceNull($request->side_job, 'string'),
                'education' => $this->ReplaceNull($request->education, 'string'),
                'non_formal_education' => $this->ReplaceNull($request->non_formal_education, 'string'),
                'farmer_profile' => $this->ReplaceNull($request->farmer_profile, 'string'),               
                
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

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
     *   path="/api/UpdateFarmer",
	 *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Farmer",
     *   operationId="UpdateFarmer",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Farmer",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="string", example="2"),
     *              @SWG\Property(property="ktp_no", type="string", example="0909090909"),
     *              @SWG\Property(property="name", type="string", example="Budi Indra"),
     *              @SWG\Property(property="birthday", type="date", example="2000-10-20"),
     *              @SWG\Property(property="religion", type="string", example="Islam"),
     *              @SWG\Property(property="address", type="string", example="Jl Cemara No 22, Kemiri, Salatiga"),
     *              @SWG\Property(property="village", type="string", example="33.05.10.18"),
     *              @SWG\Property(property="kecamatan", type="string", example="33.05.10"),
     *              @SWG\Property(property="city", type="string", example="33.05"),
     *              @SWG\Property(property="province", type="string", example="JT"),
     *              @SWG\Property(property="marrital_status", type="string", example="Kawin"),
     *              @SWG\Property(property="phone", type="string", example="085777771111"),
     *              @SWG\Property(property="ethnic", type="string", example="Jawa"),   
     *              @SWG\Property(property="origin", type="string", example="lokal"),
     *              @SWG\Property(property="gender", type="string", example="male"),
     *              @SWG\Property(property="join_date", type="date", example="2021-03-20"),
     *              @SWG\Property(property="number_family_member", type="int", example="2"),   
     *              @SWG\Property(property="mu_no", type="string", example="024"),
     *              @SWG\Property(property="target_area", type="string", example="test"),
     *              @SWG\Property(property="active", type="int", example="1"),
     *              @SWG\Property(property="user_id", type="int", example="2"),
     *              @SWG\Property(property="ktp_document", type="int", example="test"),              
     *              @SWG\Property(property="post_code", type="string", example="nullable"),
     *              @SWG\Property(property="group_no", type="string", example="nullable"),
     *              @SWG\Property(property="mou_no", type="string", example="nullable"),   
     *              @SWG\Property(property="main_income", type="int", example="nullable"),
     *              @SWG\Property(property="side_income", type="int", example="nullable"),
     *              @SWG\Property(property="main_job", type="string", example="nullable"),
     *              @SWG\Property(property="side_job", type="string", example="nullable"),
     *              @SWG\Property(property="education", type="string", example="nullable"),
     *              @SWG\Property(property="non_formal_education", type="string", example="nullable"),
     *              @SWG\Property(property="farmer_profile", type="string", example="nullable") 
     *          ),
     *      )
     * )
     *
     */
    public function UpdateFarmer(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|max:255',
                'ktp_no' => 'required|max:255',
                'name' => 'required|max:255',
                'birthday' => 'required|max:255',
                'religion' => 'required|max:255',
                'address' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'marrital_status' => 'required|max:255',
                'phone' => 'required|max:255',
                'ethnic' => 'required|max:255',
                'origin' => 'required|max:255',
                'gender' => 'required|max:255',
                'join_date' => 'required|max:255',
                'number_family_member' => 'required|max:11',              
                'mu_no' => 'required|max:255',
                'target_area' => 'required|max:255',
                'active' => 'required|max:1',
                'user_id' => 'required|max:11',
                'ktp_document' => 'required|max:255'                
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }

            $post_code = $this->ReplaceNull($request->post_code, 'string');
            $group_no = $this->ReplaceNull($request->group_no, 'string');
            $mou_no = $this->ReplaceNull($request->mou_no, 'string');
            $main_income = $this->ReplaceNull($request->main_income, 'int');
            $side_income = $this->ReplaceNull($request->side_income, 'int');
            $main_job = $this->ReplaceNull($request->main_job, 'string');
            $side_job = $this->ReplaceNull($request->side_job, 'string');
            $education = $this->ReplaceNull($request->education, 'string');
            $non_formal_education = $this->ReplaceNull($request->non_formal_education, 'string');
            $farmer_profile = $this->ReplaceNull($request->farmer_profile, 'string');

            Farmer::where('id', '=', $request->id)
            ->update
            ([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'religion' => $request->religion,
                'ethnic' => $request->ethnic,
                'origin' => $request->origin,
                'gender' => $request->gender,
                'join_date' => $request->join_date,
                'number_family_member' => $request->number_family_member,
                'ktp_no' => $request->ktp_no,
                'phone' => $request->phone,
                'address' => $request->address,
                'village' => $request->village,
                'kecamatan' => $request->kecamatan,
                'city' => $request->city,
                'province' => $request->province,
                'mu_no' => $request->mu_no,
                'target_area' => $request->target_area,
                'active' => $request->active,
                'user_id' => $request->user_id,
                'ktp_document' => $request->ktp_document,
                'marrital_status' => $request->marrital_status,
                
                'post_code' => $post_code,
                'group_no' => $group_no,
                'mou_no' => $mou_no,
                'main_income' => $main_income,
                'side_income' => $side_income,
                'main_job' => $main_job,
                'side_job' => $side_job,
                'education' => $education,
                'non_formal_education' => $non_formal_education,
                'farmer_profile' => $farmer_profile,               
                
                'updated_at'=>Carbon::now(),

                'is_dell' => 0
            ]);
            if($post_code != "-" && $group_no != "-" && $mou_no != "-" && $main_income != 0 && $side_income != 0 && $main_job != "-" && $side_job != "-" && $education != "-" && $non_formal_education != "-" && $farmer_profile != "-" )
            {
                Farmer::where('id', '=', $request->id)
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
     *   path="/api/SoftDeleteFarmer",
	 *   tags={"Farmers"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Soft Delete Farmer",
     *   operationId="SoftDeleteFarmer",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Soft Delete Farmer",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="string", example="2")
     *          ),
     *      )
     * )
     *
     */
    public function SoftDeleteFarmer(Request $request){
        try{
            $validator = Validator::make($request->all(), [    
                'id' => 'required|max:255'
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors()->first(), $validator->errors()->first());
                return response()->json($rslt, 400);
            }
            Farmer::where('id', '=', $request->id)
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

    public function addFarmer(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'farmer_no' => 'required|max:255',
                'name' => 'required|max:255',
                'birthday' => 'required|max:255',
                'religion' => 'required|max:255',
                'ethnic' => 'required|max:255',
                'origin' => 'required|max:255',
                'gender' => 'required|max:255',
                'join_date' => 'required|max:255',
                'number_family_member' => 'required|max:255',
                'ktp_no' => 'required|max:255',
                'phone' => 'required|max:255',
                'address' => 'required|max:255',
                'village' => 'required|max:255',
                'kecamatan' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'post_code' => 'required|max:255',
                'mu_no' => 'required|max:255',
                'target_area' => 'required|max:255',
                'group_no' => 'required|max:255',
                'mou_no' => 'required|max:255',
                'main_income' => 'required|max:255',
                'side_income' => 'required|max:255',
                'active' => 'required|max:255',
                'user_id' => 'required|max:255',
                'created_at' => 'required|max:255',
                'updated_at' => 'required|max:255',
                'ktp_document' => 'required|max:255',
                'farmer_profile' => 'required|max:255',
                'marrital_status' => 'required|max:255',
                'main_job' => 'required|max:255',
                'side_job' => 'required|max:255',
                'education' => 'required|max:255',
                'non_formal_education' => 'required|max:255'
            ]);

            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }

            Farmer::create([
                'farmer_no' => $farmer_no,
                'name' => $name,
                'birthday' => $birthday,
                'religion' => $religion,
                'ethnic' => $ethnic,
                'origin' => $origin,
                'gender' => $gender,
                'join_date' => $join_date,
                'number_family_member' => $number_family_member,
                'ktp_no' => $ktp_no,
                'phone' => $phone,
                'address' => $address,
                'village' => $village,
                'kecamatan' => $kecamatan,
                'city' => $city,
                'province' => $province,
                'post_code' => $post_code,
                'mu_no' => $mu_no,
                'target_area' => $target_area,
                'group_no' => $group_no,
                'mou_no' => $mou_no,
                'main_income' => $main_income,
                'side_income' => $side_income,
                'active' => $active,
                'user_id' => $user_id,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
                'ktp_document' => $ktp_document,
                'farmer_profile' => $farmer_profile,
                'marrital_status' => $marrital,
                'main_job' => $main_job,
                'side_job' => $side_job,
                'education' => $education,
                'non_formal_education' => $main_job,
                'is_dell' => 0
            ]);
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200); 
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
}
