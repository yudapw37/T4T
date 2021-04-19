<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use App\Trees;

class TreesController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/GetTrees",
     *   tags={"Trees"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Trees",
     *   operationId="GetTrees",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="tree_name",in="query", type="string"),
     *      @SWG\Parameter(name="limit",in="query", type="integer"),
     *      @SWG\Parameter(name="offset",in="query", type="integer"),
     * )
     */
    public function GetTrees(Request $request){
        $limit = $this->limitcheck($request->limit);
        $offset =  $this->offsetcheck($limit, $request->offset);
        $gettreename = $request->tree_name;
        if($gettreename){$tree_name='%'.$gettreename.'%';}
        else{$tree_name='%%';}
        try{
            $GetTrees = Trees::select('id', 'tree_code', 'tree_name', 'scientific_name', 'english_name','tree_category', 'created_at')->where('tree_name', 'Like', $tree_name)->orderBy('tree_name', 'ASC')->limit($limit)->offset($offset)->get();
            if(count($GetTrees)!=0){
                $count = Trees::count();
                $data = ['count'=>$count, 'data'=>$GetTrees];
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
     *   path="/api/GetTreesDetail",
     *   tags={"Trees"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Get Trees Detail",
     *   operationId="GetTreesDetail",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=500, description="internal server error"),
     *      @SWG\Parameter(name="id",in="query", type="string")
     * )
     */
    public function GetTreesDetail(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }
            $GetTreesDetail = Trees::where('id', '=', $request->id)
            ->first();
            if($GetTreesDetail){
                $rslt =  $this->ResultReturn(200, 'success', $GetTreesDetail);
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
     *   path="/api/AddTrees",
	 *   tags={"Trees"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Add Trees",
     *   operationId="AddTrees",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Add Trees",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="tree_name", type="string", example="Mangga"),
     *              @SWG\Property(property="scientific_name", type="string", example="Mangifera indica"),
     *              @SWG\Property(property="common_name", type="string", example="Spanish Cherry"),
     *              @SWG\Property(property="short_information", type="string", example="Mangifera indica is a large evergreen tree to 20 m tall with a dark green. umbrella-shaped crown"),
     *              @SWG\Property(property="tree_category", type="string", example="Pohon"),
     *              @SWG\Property(property="english_name", type="string", example="Nullable"),
     *              @SWG\Property(property="description", type="string", example="Nullable"),
     *              @SWG\Property(property="product_list", type="string", example="Nullable"),
     *              @SWG\Property(property="estimate_income", type="string", example="Nullable"),
     *              @SWG\Property(property="co2_capture", type="integer", example=0),
     *              @SWG\Property(property="photo1", type="string", example="Nullable"),
     *              @SWG\Property(property="photo2", type="string", example="Nullable")
     *          ),
     *      )
     * )
     *
     */
    public function AddTrees(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'tree_name' => 'required|string|max:255',
                'scientific_name' => 'required|string|max:255',
                'common_name' => 'required|string|max:255',
                'short_information' => 'required|string|max:255',
                'tree_category' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }

            $getLastIdTrees = Trees::orderBy('tree_code','desc')->first(); 
            // var_dump($$getLastIdTrees->tree_code);
            if($getLastIdTrees){
                $tree_code = 'T'.str_pad(((int)substr($getLastIdTrees->tree_code,-4) + 1), 4, '0', STR_PAD_LEFT);
            }else{
                $tree_code = 'T0001';
            }

            
    
            Trees::create([
                'tree_code' => $tree_code,
                'tree_name' => $request->tree_name,
                'scientific_name' => $request->scientific_name,
                'common_name' => $request->common_name,
                'short_information' => $request->short_information,
                'tree_category' => $request->tree_category,

                'english_name' => $this->ReplaceNull($request->english_name, 'string'),
                'description' => $this->ReplaceNull($request->description, 'string'),
                'product_list' => $this->ReplaceNull($request->product_list, 'string'),
                'estimate_income' => $this->ReplaceNull($request->estimate_income, 'string'),
                'co2_capture' => $this->ReplaceNull($request->co2_capture, 'int'),
                'photo1' => $this->ReplaceNull($request->photo1, 'string'),
                'photo2' => $this->ReplaceNull($request->photo2, 'string'),

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
     *   path="/api/UpdateTrees",
	 *   tags={"Trees"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Update Trees",
     *   operationId="UpdateTrees",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Update Trees",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1),
     *              @SWG\Property(property="tree_name", type="string", example="Mangga"),
     *              @SWG\Property(property="scientific_name", type="string", example="Mangifera indica"),
     *              @SWG\Property(property="common_name", type="string", example="Spanish Cherry"),
     *              @SWG\Property(property="short_information", type="string", example="Mangifera indica is a large evergreen tree to 20 m tall with a dark green. umbrella-shaped crown"),
     *              @SWG\Property(property="tree_category", type="string", example="Pohon"),
     *              @SWG\Property(property="english_name", type="string", example="Nullable"),
     *              @SWG\Property(property="description", type="string", example="Nullable"),
     *              @SWG\Property(property="product_list", type="string", example="Nullable"),
     *              @SWG\Property(property="estimate_income", type="string", example="Nullable"),
     *              @SWG\Property(property="co2_capture", type="integer", example=0),
     *              @SWG\Property(property="photo1", type="string", example="Nullable"),
     *              @SWG\Property(property="photo2", type="string", example="Nullable")
     *          ),
     *      )
     * )
     *
     */
    public function UpdateTrees(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|max:255',
                'tree_name' => 'required|string|max:255',
                'scientific_name' => 'required|string|max:255',
                'common_name' => 'required|string|max:255',
                'short_information' => 'required|string|max:255',
                'tree_category' => 'required|string|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }
    
            Trees::where('id', '=', $request->id)
            ->update([
                'tree_name' => $request->tree_name,
                'scientific_name' => $request->scientific_name,
                'common_name' => $request->common_name,
                'short_information' => $request->short_information,
                'tree_category' => $request->tree_category,

                'english_name' => $this->ReplaceNull($request->english_name, 'string'),
                'description' => $this->ReplaceNull($request->description, 'string'),
                'product_list' => $this->ReplaceNull($request->product_list, 'string'),
                'estimate_income' => $this->ReplaceNull($request->estimate_income, 'string'),
                'co2_capture' => $this->ReplaceNull($request->co2_capture, 'int'),
                'photo1' => $this->ReplaceNull($request->photo1, 'string'),
                'photo2' => $this->ReplaceNull($request->photo2, 'string'),
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
     *   path="/api/DeleteTrees",
	 *   tags={"Trees"},
     *   security={
	 *     {"apiAuth": {}},
	 *   },
     *   summary="Delete Trees",
     *   operationId="DeleteTrees",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="Unauthenticated"),
     *   @SWG\Response(response=404, description="Not Found"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="Parameters",
     *          in="body",
	 *			description="Delete Trees",
     *          required=true, 
     *          type="string",
	 *   		@SWG\Schema(
     *              @SWG\Property(property="id", type="integer", example=1)
     *          ),
     *      )
     * )
     *
     */
    public function DeleteTrees(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer|max:255'
            ]);
    
            if($validator->fails()){
                $rslt =  $this->ResultReturn(400, $validator->errors(), $validator->errors());
                return response()->json($rslt, 400);
            }
    
            DB::table('trees')->where('id', $request->id)->delete();
            $rslt =  $this->ResultReturn(200, 'success', 'success');
            return response()->json($rslt, 200);
        }catch (\Exception $ex){
            return response()->json($ex);
        }
    }
}
