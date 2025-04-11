<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[DashboardController::class,'index'] );
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::resource('/profiles' , App\Http\Controllers\EmployeeController::class);
// PUR //
Route::resource('/pur-pr' , App\Http\Controllers\PurchaseRequestController::class);
Route::get('/pr-approved1' , [App\Http\Controllers\PurchaseRequestController::class , 'ApprovedPr1']);
Route::get('/pr-approved2' , [App\Http\Controllers\PurchaseRequestController::class , 'ApprovedPr2']);
Route::get('/pr-approved3' , [App\Http\Controllers\PurchaseRequestController::class , 'ApprovedPr3']);
Route::post('/getDataPr' , [App\Http\Controllers\PurchaseRequestController::class , 'getDataPr']);
Route::post('/confirmDelPr' , [App\Http\Controllers\PurchaseRequestController::class , 'confirmDelPr']);
Route::get('/report-proutstanding' , [App\Http\Controllers\PurchaseRequestController::class , 'ReportPrOutstanding']);
Route::resource('/pur-po' , App\Http\Controllers\PurchaseOrderController::class);
Route::get('/po-approved1' , [App\Http\Controllers\PurchaseOrderController::class , 'ApprovedPo1']);
Route::get('/po-approved2' , [App\Http\Controllers\PurchaseOrderController::class , 'ApprovedPo2']);
Route::get('/po-approved3' , [App\Http\Controllers\PurchaseOrderController::class , 'ApprovedPo3']);
Route::get('/po-approvedclose1' , [App\Http\Controllers\PurchaseOrderController::class , 'ApprovedPoClose1']);
Route::get('/po-approvedclose2' , [App\Http\Controllers\PurchaseOrderController::class , 'ApprovedPoClose2']);
Route::post('/getDataPo' , [App\Http\Controllers\PurchaseOrderController::class , 'getDataPo']);
Route::post('/confirmDelPo' , [App\Http\Controllers\PurchaseOrderController::class , 'confirmDelPo']);
Route::get('/report-pooutstanding' , [App\Http\Controllers\PurchaseOrderController::class , 'ReportPoOutstanding']);
Route::get('/report-purchaseorder' , [App\Http\Controllers\PurchaseOrderController::class , 'ReportPurchaseOrder']);
Route::resource('/pur-ase' , App\Http\Controllers\ExpensesOrderController::class);
Route::get('/ase-approved1' , [App\Http\Controllers\ExpensesOrderController::class , 'ApprovedAse1']);
Route::get('/ase-approved2' , [App\Http\Controllers\ExpensesOrderController::class , 'ApprovedAse2']);
Route::get('/ase-approved3' , [App\Http\Controllers\ExpensesOrderController::class , 'ApprovedAse3']);
Route::post('/getDataAse' , [App\Http\Controllers\ExpensesOrderController::class , 'getDataAse']);
Route::post('/confirmDelAse' , [App\Http\Controllers\ExpensesOrderController::class , 'confirmDelAse']);
// PUR //
// STOCK RM //
Route::resource('/wh-issue' , App\Http\Controllers\WhIssueStockController::class);
Route::get('/report-warehouse' , [App\Http\Controllers\WhIssueStockController::class , 'ReportWarehouse']);
Route::resource('/wh-adjust' , App\Http\Controllers\WhAjustStockController::class);
// STOCK RM //
// Maintenance //
Route::resource('/mt-checklist' , App\Http\Controllers\MaintenanceCheckList::class);
Route::resource('/mt-docpdt' , App\Http\Controllers\MaintenanceDocpdt::class);
Route::resource('/mt-docoff' , App\Http\Controllers\MaintenanceDocoff::class);
// Maintenance //
// REPORT //
Route::get('/report-planningpd' , [App\Http\Controllers\DashboardController::class , 'ReportPlanningPd']);
Route::get('/report-planningdl' , [App\Http\Controllers\DashboardController::class , 'ReportPlanningDl']);
Route::get('/report-planningdl2' , [App\Http\Controllers\DashboardController::class , 'ReportPlanningDl2']);
Route::get('/report-planningpdmonth' , [App\Http\Controllers\DashboardController::class , 'ReportPlanningPdMonth']);
Route::get('/report-planningpdyear' , [App\Http\Controllers\DashboardController::class , 'ReportPlanningPdYear']);
Route::get('/report-planningpdday' , [App\Http\Controllers\DashboardController::class , 'ReportPlanningPdDay']);
Route::get('/report-deliveryday' , [App\Http\Controllers\DashboardController::class , 'ReportDeliveryDay']);
Route::get('/report-receiveday' , [App\Http\Controllers\DashboardController::class , 'ReportReceiveDay']);
// REPORT //

