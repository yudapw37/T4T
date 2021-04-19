<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('Regist', 'UserController@Regist');
Route::post('Login', 'UserController@Login');
Route::post('ForgotPassword', 'UserController@ForgotPassword');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('Logout', 'UserController@Logout');
    Route::post('EditProfile', 'UserController@EditProfile');

    Route::get('GetProvince', 'Api\UtilitiesController@GetProvince');
    Route::get('GetKabupaten', 'Api\UtilitiesController@GetKabupaten');
    Route::get('GetKecamatan', 'Api\UtilitiesController@GetKecamatan');
    Route::get('GetDesa', 'Api\UtilitiesController@GetDesa');

    Route::post('AddProvince', 'Api\UtilitiesController@AddProvince');
    Route::post('AddKabupaten', 'Api\UtilitiesController@AddKabupaten');
    Route::post('AddKecamatan', 'Api\UtilitiesController@AddKecamatan');
    Route::post('AddDesa', 'Api\UtilitiesController@AddDesa');

    Route::post('UpdateProvince', 'Api\UtilitiesController@UpdateProvince');
    Route::post('UpdateKabupaten', 'Api\UtilitiesController@UpdateKabupaten');
    Route::post('UpdateKecamatan', 'Api\UtilitiesController@UpdateKecamatan');
    Route::post('UpdateDesa', 'Api\UtilitiesController@UpdateDesa');

    Route::post('DeleteProvince', 'Api\UtilitiesController@DeleteProvince');
    Route::post('DeleteKabupaten', 'Api\UtilitiesController@DeleteKabupaten');
    Route::post('DeleteKecamatan', 'Api\UtilitiesController@DeleteKecamatan');
    Route::post('DeleteDesa', 'Api\UtilitiesController@DeleteDesa');

    Route::get('GetManagementUnit', 'Api\UtilitiesController@GetManagementUnit');
    Route::get('GetTargetArea', 'Api\UtilitiesController@GetTargetArea');
    Route::post('AddManagementUnit', 'Api\UtilitiesController@AddManagementUnit');
    Route::post('AddTargetArea', 'Api\UtilitiesController@AddTargetArea');
    Route::post('UpdateManagementUnit', 'Api\UtilitiesController@UpdateManagementUnit');
    Route::post('UpdateTargetArea', 'Api\UtilitiesController@UpdateTargetArea');
    Route::post('DeleteManagementUnit', 'Api\UtilitiesController@DeleteManagementUnit');
    Route::post('DeleteTargetArea', 'Api\UtilitiesController@DeleteTargetArea');

    Route::get('GetVerification', 'Api\UtilitiesController@GetVerification');
    Route::post('AddVerification', 'Api\UtilitiesController@AddVerification');
    Route::post('UpdateVerification', 'Api\UtilitiesController@UpdateVerification');
    Route::post('DeleteVerification', 'Api\UtilitiesController@DeleteVerification');

    Route::get('GetFarmerNotComplete', 'Api\FarmerController@GetFarmerNotComplete');
    Route::get('GetFarmerCompleteNotApprove', 'Api\FarmerController@GetFarmerCompleteNotApprove');
    Route::get('GetFarmerCompleteAndApprove', 'Api\FarmerController@GetFarmerCompleteAndApprove');
    Route::get('GetFarmerDetail', 'Api\FarmerController@GetFarmerDetail');
    Route::get('GetFarmerNoDropDown', 'Api\FarmerController@GetFarmerNoDropDown');
    Route::post('AddMandatoryFarmer', 'Api\FarmerController@AddMandatoryFarmer');
    Route::post('UpdateFarmer', 'Api\FarmerController@UpdateFarmer');
    Route::post('SoftDeleteFarmer', 'Api\FarmerController@SoftDeleteFarmer');

    Route::get('GetLahanNotComplete', 'Api\LahanController@GetLahanNotComplete');
    Route::get('GetLahanCompleteNotApprove', 'Api\LahanController@GetLahanCompleteNotApprove');
    Route::get('GetCompleteAndApprove', 'Api\LahanController@GetCompleteAndApprove');
    Route::get('GetLahanDetail', 'Api\LahanController@GetLahanDetail');
    Route::get('GetLahanDetailBarcode', 'Api\LahanController@GetLahanDetailBarcode');
    Route::post('AddMandatoryLahan', 'Api\LahanController@AddMandatoryLahan');
    Route::post('AddMandatoryLahanBarcode', 'Api\LahanController@AddMandatoryLahanBarcode');
    Route::post('UpdateLahan', 'Api\LahanController@UpdateLahan');
    Route::post('SoftDeleteLahan', 'Api\LahanController@SoftDeleteLahan');

    Route::get('GetTrees', 'Api\TreesController@GetTrees');
    Route::get('GetTreesDetail', 'Api\TreesController@GetTreesDetail');
    Route::post('AddTrees', 'Api\TreesController@AddTrees');
    Route::post('UpdateTrees', 'Api\TreesController@UpdateTrees');
    Route::post('DeleteTrees', 'Api\TreesController@DeleteTrees');

    Route::get('GetFieldFacilitator', 'Api\FieldFacilitatorController@GetFieldFacilitator');
    Route::get('GetFieldFacilitatorDetail', 'Api\FieldFacilitatorController@GetFieldFacilitatorDetail');
    Route::post('AddFieldFacilitator', 'Api\FieldFacilitatorController@AddFieldFacilitator');
    Route::post('UpdateFieldFacilitator', 'Api\FieldFacilitatorController@UpdateFieldFacilitator');
    Route::post('DeleteFieldFacilitator', 'Api\FieldFacilitatorController@DeleteFieldFacilitator');

    Route::get('GetActivityUserId', 'Api\ActivityController@GetActivityUserId');
    Route::get('GetActivityLahanUser', 'Api\ActivityController@GetActivityLahanUser');
    Route::post('AddActivity', 'Api\ActivityController@AddActivity');
    Route::post('UpdateActivity', 'Api\ActivityController@UpdateActivity');
    Route::post('DeleteActivity', 'Api\ActivityController@DeleteActivity');
    Route::get('GetActivityDetail', 'Api\ActivityController@GetActivityDetail');
    Route::post('AddActivityDetail', 'Api\ActivityController@AddActivityDetail');
    Route::post('UpdateActivityDetail', 'Api\ActivityController@UpdateActivityDetail');
    Route::post('DeleteActivityDetail', 'Api\ActivityController@DeleteActivityDetail');
});
