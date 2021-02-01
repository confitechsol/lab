<?php

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


use Illuminate\Support\Facades\Route;


Route::resource('/hello', 'Web\Admin\HelloController');

//Route::get('/admin_login','Web\Admin\UserController@admin_login')->name('admin_login');

//Route::post('/login', 'Auth\LoginController@webAuthenticate')->name('webAuthenticate');
Route::get('/trunct_tables', 'Web\Admin\AddUserController@main');
Route::get('/bccr_change_pass/{date}', 'Web\Admin\AddUserController@bccrypt');
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', 'Web\Admin\DashboardController@index');

    Route::resource('/microbiologist', 'Web\Admin\MicroController');
	Route::post('/ajax_microbiologist_list','Web\Admin\MicroController@ajaxMicrobiologistList'); 
	Route::get('/get_drugs','Web\Admin\MicroController@get_drugs');
	Route::get('/annexure15a', 'Web\Admin\MicroController@annexure15A');
	Route::post('/ajax_annexure15A_list', 'Web\Admin\MicroController@ajaxAnnexure15AList');
	Route::get('/history', 'Web\Admin\MicroController@history');
	//////////vendor login///////////
	Route::resource('/shipment-tracker', 'Web\Admin\ShipmentTrackerController');

    Route::get('/logout', 'Web\Admin\DashboardController@logout');

    Route::resource('/enroll/patient', 'Web\Admin\PatientController');

    Route::resource('/lab', 'Web\Admin\LabController');

    Route::resource('/sample', 'Web\Admin\SampleController');
    Route::get('/sample/print/{sample_str}', 'Web\Admin\SampleController@barCodePrint');


    Route::get('/pdfview/{id}/{pdf?}', 'Web\Admin\SampleController@pdfview');
    Route::get('/interimview/{id}/{pdf?}', 'Web\Admin\SampleController@interimview');

    Route::get('/annexurek', 'Web\Admin\SampleController@annexurek');
    Route::get('/annexurel', 'Web\Admin\SampleController@annexurel');

    Route::get('/sample/create/{id}', 'Web\Admin\SampleController@create');
    Route::get('/sample/editnew/{id}', 'Web\Admin\SampleController@editNew');
    Route::post('/sample/sample-update', 'Web\Admin\SampleController@newUpdate');
    Route::get('/check_for_storage/{enroll_id}', 'Web\Admin\SampleController@checkForStorage');
	Route::get('/check_for_sample_exist/{enroll_id}/{sentStep}/{tag?}/{recflag}', 'Web\Admin\SampleController@checkForSampleExist');	
    Route::get('/check_for_request_service/{enroll_id}', 'Web\Admin\MicroController@checkForRequestSeviceDataExist');	
    //Route::get('/check_for_sample_exist/{enroll_id}/{sentStep}', 'Web\Admin\SampleController@checkForSampleExist');	
    Route::get('/get_dst_drugs', 'Web\Admin\MicroController@getDstDrugs');
	Route::get('/get_add_dst_drugs/{enroll_id}', 'Web\Admin\MicroController@getAddTestDstDrugs');
	Route::get('/get_add_test_list/{enroll_id}', 'Web\Admin\MicroController@getAddTestList');
	Route::get('/get_existing_service_ids/{enroll_id}', 'Web\Admin\MicroController@getExistingServiceIds');
    Route::get('/check_for_nikshayid_exist/{enroll_id}', 'Web\Admin\PatientController@checkForNikshayIdExist');
    Route::get('/check_for_test_request/{enroll_id}/{service_id}/{tag?}/{reqServ_service_id}', 'Web\Admin\MicroController@checkForTestRequest');		
    Route::post('/microbiologist/sendnikshay', 'Web\Admin\MicroController@sendToNikshay');	
	Route::get('test_request/create/{id}', [
        'as' => 'test_request.create',
        'uses' => 'Web\Admin\TestRequestController@create'
    ]);
	Route::post('/search_test_request', 'Web\Admin\TestRequestController@searchTestRequest');
    Route::resource('/test_request', 'Web\Admin\TestRequestController', ['except' => [
        'create',
    ]]);

    Route::get('/result/{serviceId}/{sampleId}/{enrollmentId}/{tag_service_nm}', 'Web\Admin\MicroController@result')->name('result');
    Route::get('/restest_sento_to_map/{serviceId}/{optionId}/{tagId}', 'Web\Admin\MicroController@getRetestSentToMap')->name('restest_sento_to_map');
   
    Route::resource('/adduser', 'Web\Admin\AddUserController');

    Route::group(['middleware' => ['role:cbnaat,can_view']], function () {
        Route::resource('/cbnaat', 'Web\Admin\CbnaatController');
    });
   
	Route::group(['middleware' => ['role:microscopy,can_view']], function () {
        Route::resource('/microscopy', 'Web\Admin\MicroscopyController');
        Route::post('/dash_microscopy_bulk', 'Web\Admin\MicroscopyController@bulkStore')->name('microscopy.send-review.bulk');
    });

    Route::group(['middleware' => ['role:microscopy_review,can_view']], function () {
        Route::resource('/review_microscopy', 'Web\Admin\MicroscopyReviewController');
        Route::post('/dash_microscopy_review_bulk', 'Web\Admin\MicroscopyReviewController@bulkStore')->name('microscopy_review.send-review.bulk');
    });

    Route::resource('/serviceLog', 'Web\Admin\ServiceLogController');
    
    Route::get('/check_for_sample_already_process_pcr/{sample_id}/{enroll_id}/{service_id}/{tag?}/{recflag}', 'Web\Admin\ServiceLogController@checkForSampleAlreadyInProcessPcr')->name('check_for_sample_already_process_pcr');

    Route::get('/check_for_sample_already_process/{sample_id}/{enroll_id}/{service_id}/{tag?}/{recflag}', 'Web\Admin\ServiceLogController@checkForSampleAlreadyInProcess')->name('check_for_sample_already_process');
    
    Route::get('/check_for_sample_already_process_dnr/{sample_id}/{enroll_id}/{service_id}/{tag?}/{recflag}', 'Web\Admin\ServiceLogController@checkForSampleAlreadyInProcessDnr')->name('check_for_sample_already_process_dnr');

    //Route::get('/check_for_sample_already_process_from_microbiologist/{enroll_id}/{service_id}/{tag?}/{recflag}', 'Web\Admin\ServiceLogController@checkForSampleAlreadyInProcessFromMicrobio')->name('check_for_sample_already_process_from_microbiologist');
    Route::group(['middleware' => ['role:dna_extraction,can_view']], function () {
        Route::resource('/DNAextraction', 'Web\Admin\DNAextractionController');
    });

    Route::group(['middleware' => ['role:hybridization,can_view']], function () {
        Route::resource('/hybridization', 'Web\Admin\HybridizationController');
        Route::post('/dash_hybridization_bulk', 'Web\Admin\HybridizationController@bulkStore')->name('hybridization.send-review.bulk');
    });

    Route::group(['middleware' => ['role:decontamination_review,can_view']], function () {
        Route::resource('/decontamination', 'Web\Admin\DecontaminationController');
    });
   
   Route::get('/check_for_sample_already_process_decontamination/{sample_id}/{enroll_id}/{sent_for?}/{DecontStatus?}', 'Web\Admin\DecontaminationController@checkForSampleAlreadyInProcessInDecontamination')->name('check_for_sample_already_process_decontamination');
    
    Route::group(['middleware' => ['role:decontamination,can_view']], function () {
        Route::resource('/dash_decontamination', 'Web\Admin\DashboardDecontaminationController');
        Route::post('/dash_decontamination_bulk', 'Web\Admin\DashboardDecontaminationController@bulkStore')->name('decontamination.send-review.bulk');
    });

    Route::get('/cbnaat/submit/{id}', 'Web\Admin\CbnaatController@cbnaat_submit');

    Route::group(['middleware' => ['role:enroller,can_view']], function () {
        Route::resource('/enroll', 'Web\Admin\EnrollController');
    });

	Route::post('/ajax_enroll_list', 'Web\Admin\EnrollController@ajaxEnrollList');
	
	Route::group(['middleware' => ['role:enrol_nikshay_id,can_view']], function () {
        Route::resource('/enrollwithnikshay', 'Web\Admin\EnrollWithNikshayController');
    });
	Route::get('/changenikshayid', 'Web\Admin\EnrollWithNikshayController@changeNikshayIdList')->name('changenikshayid');
	Route::post('/updatewithnikshayid', 'Web\Admin\EnrollWithNikshayController@updateWithNikshayId');
    Route::post('/enrollwithnikshay/print', 'Web\Admin\EnrollWithNikshayController@enrollPrint');
//  Route::get('enroll/index/{id}', [
//     'as' => 'enroll.index',
//     'uses' => 'Web\Admin\EnrollController@index'
// ]);

    Route::post('/enroll/get_reason_for_rejection', 'Web\Admin\EnrollController@getReasonforRejection');
    Route::group(['middleware' => ['role:pcr,can_view']], function () {
        Route::resource('/PCR', 'Web\Admin\PCRController');
    });

    Route::group(['middleware' => ['role:lpa_interpretation,can_view']], function () {
        Route::resource('/lpa_interpretation', 'Web\Admin\LPAController');        
    });
    //ajax call for final interpretation
    Route::get('/getFinalInterpretation/{linetype}', 'Web\Admin\LPAController@getFinalInterpretation');
	
    Route::group(['middleware' => ['role:culture_inoculation,can_view']], function () {
        Route::resource('/culture_inoculation', 'Web\Admin\CultureInoculationController');
    });
    Route::get('/get_mgit_id/{enroll_id}', 'Web\Admin\CultureInoculationController@getMgitId');
    Route::group(['middleware' => ['role:lc_flagged_mgit,can_view']], function () {
        Route::resource('/lc_flagged_mgit', 'Web\Admin\LCFlaggedMGITController');
    });
    Route::post('/ajax_lc_flagged_mgit_list','Web\Admin\LCFlaggedMGITController@ajaxLCFlaggedMGITList');
	
    Route::group(['middleware' => ['role:lc_flagged_mgit_further,can_view']], function () {
        Route::resource('/further_lc_flagged_mgit', 'Web\Admin\LCFlaggedMGITFurtherController');
    });

    Route::group(['middleware' => ['role:lc_result_review,can_view']], function () {
        Route::resource('/lc_result_review', 'Web\Admin\LCResultReviewController');
    });
	
	Route::get('/check_for_sample_exist_in_storage/{enroll_id}', 'Web\Admin\LCResultReviewController@checkForSampleExistInStorage')->name('check_for_sample_exist_in_storage');
    
	

    Route::group(['middleware' => ['role:lj,can_view']], function () {
        Route::resource('/dashboardlj', 'Web\Admin\LJController');
    });

    Route::group(['middleware' => ['role:lj_review,can_view']], function () {
        Route::resource('/reviewlj', 'Web\Admin\LJReviewController');
    });

    Route::group(['middleware' => ['role:lc_dst_inoculation,can_view']], function () {
        Route::resource('/lc_dst_inoculation', 'Web\Admin\LCDSTInoculationController');
    });

    Route::group(['middleware' => ['role:lj_dst_1st_line,can_view']], function () {
        Route::resource('/lj_dst_ln1', 'Web\Admin\LJDST1Controller');
    });
    
	Route::get('/check_for_inaucolation_date_already_process/{enroll_id}', 'Web\Admin\LJDST1Controller@checkForInaucolationDateAlreadyInProcess')->name('check_for_inaucolation_date_already_process');
   
   Route::group(['middleware' => ['role:Current_Status,can_view']], function () {
        Route::resource('/searchform', 'Web\Admin\SearchformController');
    });

    Route::post('/DNANext', 'Web\Admin\DNAextractionController@DNANext');

    Route::post('/lj_dst_ln1/inoculation', 'Web\Admin\LJDST1Controller@inoculation');
    Route::post('/lj_dst_ln1/reading', 'Web\Admin\LJDST1Controller@reading');
	Route::post('/lj_dst_ln2/reading', 'Web\Admin\LJDST2Controller@reading');
    Route::post('/lj_dst_ln1/readingReview', 'Web\Admin\LJDST1Controller@reading_review');
    Route::get('/lj_dst_ln1/detail/{id}/{week}', 'Web\Admin\LJDST1Controller@detail');
   Route::get('/lj_dst_ln2/detail/{id}/{week}', 'Web\Admin\LJDST2Controller@detail');  

    Route::group(['middleware' => ['role:lj_dst_2st_line,can_view']], function () {
        Route::resource('/lj_dst_ln2', 'Web\Admin\LJDST2Controller');
    });


    Route::get('/district/{state}', 'Web\Admin\PatientController@district_collect')->name('district');

    Route::get('/phi/{state}/{tbu}/{district}', 'Web\Admin\TestRequestController@phi_collect')->name('phi');

    Route::get('/tbunit/{state}/{district}', 'Web\Admin\TestRequestController@tbunit_collect')->name('tbunit');

    Route::get('/pcr', 'Web\Admin\TestController@pcr')->name('pcr');

    Route::get('/Hybridization', 'Web\Admin\TestController@Hybridization')->name('Hybridization');

    Route::get('/culture_inoc', 'Web\Admin\TestController@culture_inoc')->name('culture_inoc');

    Route::get('/culture_inoc_flag', 'Web\Admin\TestController@culture_inoc_flag')->name('culture_inoc_flag');

    Route::get('/', 'Web\Admin\DashboardController@index');

    Route::resource('/hr', 'Web\Admin\HRController');
    Route::post('/hr/yearDesignationFilter', 'Web\Admin\HRController@yearFilter');
    Route::post('/hr/yearOrganizationFilter', 'Web\Admin\HRController@yearOrganizationFilter');
    Route::post('/hr/yearTypeFilter', 'Web\Admin\HRController@yearTypeFilter');
    Route::get('/hr/{id}/delete_hr', 'Web\Admin\HRController@delete_hr');

    Route::resource('/equipment', 'Web\Admin\EquipmentController');
    Route::post('/equipment/downtimeAnalysis', 'Web\Admin\EquipmentController@downtimeAnalysis');
    Route::post('/equipment/downtimeAnalysisDatefilfer', 'Web\Admin\EquipmentController@downtimeAnalysisDatefilfer');
    Route::post('/equipment/freqdowntimeAnalysis', 'Web\Admin\EquipmentController@freqdowntimeAnalysis');
    Route::get('/equipment/{id}/delete_equipment', 'Web\Admin\EquipmentController@delete_equipment');
    Route::post('/equipment/addbreakdown', 'Web\Admin\EquipmentController@addbreakdown');
	Route::post('/equipment/updatebreakdown', 'Web\Admin\EquipmentController@updatebreakdown');

    Route::resource('/user_role', 'Web\Admin\RoleController');


    Route::resource('/barcodes', 'Web\Admin\BarcodeController');
    Route::post('/barcodes_insert{id}', 'Web\Admin\BarcodeInsertController@insert');
    Route::post('/barcodes/print', 'Web\Admin\BarcodeController@printBarcodes');

    Route::post('/enroll/print', 'Web\Admin\EnrollController@enrollPrint');

    Route::post('/test_request/print', 'Web\Admin\TestRequestController@testrequestPrint');

    Route::post('/cbnaat/print', 'Web\Admin\CbnaatController@cbnaatPrint');

    Route::post('/microscopy/print', 'Web\Admin\MicroscopyController@microscopyPrint');

    Route::post('/review_microscopy/print', 'Web\Admin\MicroscopyReviewController@mreviewPrint');
	
    Route::get('/check_for_sample_already_process_mcroscopy_next/{sample_id}/{enroll_id}/{service_id}/{tag?}/{recflag}', 'Web\Admin\ServiceLogController@checkForSampleAlreadyInProcessMicroscopyNext')->name('check_for_sample_already_process_mcroscopy_next');
    
    Route::get('/check_for_sample_already_process_mcroscopy_next_deconta/{sample_id}/{enroll_id}/{service_id}/{tag?}/{recflag}', 'Web\Admin\ServiceLogController@checkForSampleAlreadyInProcessMicroscopyNextDeconta')->name('check_for_sample_already_process_mcroscopy_next_deconta');

    Route::post('/dashboardDecontamination/print', 'Web\Admin\DashboardDecontaminationController@dashdecontPrint');

    Route::post('/Decontamination/print', 'Web\Admin\DecontaminationController@decontaminationPrint');

    Route::post('/DNA/print', 'Web\Admin\DNAextractionController@dnaextractprint');

    Route::post('/pcr/print', 'Web\Admin\PCRController@PCRprint');

    Route::post('/hybrid/print', 'Web\Admin\HybridizationController@Hybridizationprint');

    Route::post('/lpa/print', 'Web\Admin\LPAController@Lpaprint');

    Route::post('/cultureInno/print', 'Web\Admin\CultureInoculationController@cultureInnoprint');

    Route::post('/cultureInno/printBarcode', 'Web\Admin\CultureInoculationController@printBarcode');

    Route::post('/lcflag/print', 'Web\Admin\LCFlaggedMGITController@lcflagprint');

    Route::post('/lcflagfurther/print', 'Web\Admin\LCFlaggedMGITFurtherController@lcflagprint');

    Route::post('/lcflagreview/print', 'Web\Admin\LCResultReviewController@lcflagprint');

    Route::post('/dashboardlj/print', 'Web\Admin\LJController@ljprint');

    Route::post('/ljreview/print', 'Web\Admin\LJReviewController@ljreviewprint');

    Route::post('/lcdstinoculation/print', 'Web\Admin\LCDSTInoculationController@lcdstinoculationprint');
	
	Route::get('/check_for_lcdst_inaucolation_already_process/{enroll_id}', 'Web\Admin\LCDSTInoculationController@checkForLCDSTInaucolationAlreadyInProcess')->name('check_for_lcdst_inaucolation_already_process');
   

    Route::post('/ljdstfirst/print', 'Web\Admin\LJDST1Controller@ljdstfirstprint');

    Route::post('/ljdstsecond/print', 'Web\Admin\LJDST2Controller@ljdstsecondprint');

    Route::post('/ljdstsecond/print', 'Web\Admin\LJDST2Controller@ljdstsecondprint');

    Route::post('/microbiologist/print', 'Web\Admin\MicroController@microbiologistprint');

    Route::post('/hr/print', 'Web\Admin\HRController@hrprint');

    Route::post('/equipment/print', 'Web\Admin\EquipmentController@equipmentprint');

    Route::resource('/laboratory', 'Web\Admin\LaboratoryController');

    Route::resource('/passwordReset', 'Web\Admin\PasswordController');

    Route::post('/laboratory/edit_config', 'Web\Admin\LaboratoryController@edit_config');

    Route::post('/laboratory/view', 'Web\Admin\LaboratoryController@view_form');

    Route::post('/adduser/{id}/updateform', 'Web\Admin\AddUserController@update_form');

    Route::get('/samplePreview/{id}', 'Web\Admin\SampleController@sample_preview');
    Route::group(['middleware' => ['role:report,can_view']], function () {
        Route::get('/report/lqc_indicator', 'Web\Admin\ReportController@lqc_indicator');
        Route::post('/report/lqc_indicator', 'Web\Admin\ReportController@lqc_indicator');		
        Route::get('/report/lqcIndicator_tat', 'Web\Admin\ReportController@lqc_indicator_tat');
        Route::post('/report/lqcIndicator_tat', 'Web\Admin\ReportController@lqc_indicator_tat');
        Route::get('/report/quality_indicator', 'Web\Admin\ReportController@quality_indicator');
        Route::post('/report/quality_indicator', 'Web\Admin\ReportController@quality_indicator');
        Route::get('/report/referral_indicator', 'Web\Admin\ReportController@referral_indicator');
        Route::post('/report/referral_indicator', 'Web\Admin\ReportController@referral_indicator');
        Route::get('/report/cbnaat_indicator', 'Web\Admin\ReportController@cbnaat_indicator');
        Route::post('/report/cbnaat_indicator', 'Web\Admin\ReportController@cbnaat_indicator');
        Route::get('/report/performance_indicator', 'Web\Admin\ReportController@performance_indicator');
        Route::post('/report/performance_indicator', 'Web\Admin\ReportController@performance_indicator');
		Route::get('/report/annexurel', 'Web\Admin\ReportController@annexure15L');
        Route::post('/report/annexurel', 'Web\Admin\ReportController@annexure15L');
        Route::get('/report/cbnaat_monthly_report', 'Web\Admin\ReportController@cbnaat_monthly_report')->name('reports.cbnaat.monthly');
       // Route::post('/report/cbnaat_monthly_report/submit', 'Web\Admin\ReportController@cbnaat_monthly_report_submit');
        Route::get('/report/referral_indicator', 'Web\Admin\ReportController@referral_indicator');
        Route::post('/report/referral_indicator', 'Web\Admin\ReportController@referral_indicator');
        Route::get('/report/result_edit', 'Web\Admin\ReportController@result_edit');
        Route::get('/download_cbnaat_monthly_reports', 'Web\Admin\CbnaatMonthlyReportDownloaderController@excel');

        Route::resource('/report/workload', 'Web\Admin\ReportController');
		Route::get('report/lpa_conta_event', 'Web\Admin\ReportController@lpa_conta_event');
		Route::get('report/test_result_status_nikshay', 'Web\Admin\ReportController@testResultStatusNikshay');
		Route::post('report/test_result_status_nikshay', 'Web\Admin\ReportController@testResultStatusNikshay');
        Route::post('report/lpa_conta_event_submit', 'Web\Admin\ReportController@lpa_conta_event_submit');
    });
    Route::resource('/bioWaste', 'Web\Admin\BioWasteController');
    Route::resource('/bioWaste/print', 'Web\Admin\BioWasteController@biowasteprint');

    Route::resource('/calendar', 'Web\Admin\CalenderController');

    Route::get('/edit_result_micro/{sample}', 'Web\Admin\EditResultController@edit_result_micro');
    Route::get('/editResultCbnaat/{sample}', 'Web\Admin\EditResultController@edit_result_cbnaat');
    Route::get('/edit_result_lc/{sample}', 'Web\Admin\EditResultController@edit_result_lc');
    Route::get('/edit_result_lj/{sample}', 'Web\Admin\EditResultController@edit_result_lj');
    Route::get('/edit_result_lj_dst1/{sample}/{serviceid}', 'Web\Admin\EditResultController@edit_result_lj_dst1');
    Route::get('/edit_result_lj_dst2/{sample}', 'Web\Admin\EditResultController@edit_result_lj_dst2');
    Route::get('/edit_result_lc_dst/{sample}', 'Web\Admin\EditResultController@edit_result_lc_dst');
    Route::get('/editResultLpa/{sample}/{tag}', 'Web\Admin\EditResultController@editResultLpa');
    Route::post('/getcode', 'Web\Admin\FetchBarcodeController@getBarcode');
    Route::post('/getsample', 'Web\Admin\FetchBarcodeController@getsample');
    Route::post('/entercode', 'Web\Admin\FetchBarcodeController@getmanualBarcode');
    Route::get('/printcode/{text}/{ptext}', 'Web\Admin\FetchBarcodeController@printcod');



    // Sample Storage Module =======================
    Route::resource('sample-storage', 'Web\Admin\SampleStorageController');

    // BWM Samples =================================
    Route::resource('bio-waste-sample', 'Web\Admin\BioWasteSampleController');




    //  ===========================================================================
    //  Logistics Routes ==========================================================
    //  ===========================================================================

    Route::group(['prefix' => 'logistics'], function(){


        Route::get('/dashboard', 'Web\Admin\Logistics\DashboardController@index')->name('logistics.dashboard');

        //Request item creation
		Route::get('/item/request-item', 'Web\Admin\Logistics\RequestItemController@index')->name('logistics.request-item');
        
		//stock save
        Route::post('/item/request-item/save', 'Web\Admin\Logistics\RequestItemController@store');

		//ajax call for deatails
        Route::get('/item/request-item/getItemDtls/{id}', 'Web\Admin\Logistics\RequestItemController@getItemDetail');


		//Stock entry
        //Route::get('/item/opening-balance', function(){ return view( 'admin.logistics.opening-balance.create' ); })->name('logistics.item.opening-balance');
        Route::get('/item/opening-balance', 'Web\Admin\Logistics\StockController@create')->name('logistics.item.opening-balance');

        //ajax call for items
        Route::get('/item/getItem/{code}', 'Web\Admin\Logistics\StockController@getItem');

        //ajax call for item category
        Route::get('/item/getItemCategory/{code}', 'Web\Admin\Logistics\StockController@getItemCategory');

        //ajax call for pack size
        Route::get('/item/getPackSize/{itemcode}', 'Web\Admin\Logistics\StockController@getPackSize');

        //ajax call for UOM
        Route::get('/item/getUOM/{itemcode}', 'Web\Admin\Logistics\StockController@getUOM');

        //ajax call for batch
        Route::get('/item/getBatchDetails/{labid}/{itemcode}/{rcvFrmId}', 'Web\Admin\Logistics\StockController@getBatchDetails');


        //stock save
        Route::post('/item/opening-balance/save', 'Web\Admin\Logistics\StockController@store');

//        Route::get('/item/opening-balance', function(){ return view( 'admin.logistics.opening-balance.create' ); })->name('logistics.item.opening-balance');


        // Items -----------------------------------
        Route::get('/item', 'Web\Admin\Logistics\ItemController@index')->name('logistics.item.index');
		Route::get('/item/recievedfromdetails/{item_code}/{labid}', 'Web\Admin\Logistics\ItemController@showReceivedFromDetails')->name('logistics.item.recievedfromdetails.index');
        Route::get('/item/batchdetails/{item_code}/{labid}/{rcvfrmifd}', 'Web\Admin\Logistics\ItemController@showBatchDetails')->name('logistics.item.batchdetails.index');

        // Central Items ---------------------------
        Route::get('/central-item', 'Web\Admin\Logistics\RequisitionController@centralItems')->name('logistics.central-item.index');



        // Requisition Cart ------------------------
        Route::get('requisition/cart', 'Web\Admin\Logistics\RequisitionController@cartIndex')->name('logistics.requisition.cart.index');
        Route::post('requisition/cart', 'Web\Admin\Logistics\RequisitionController@cartAdd')->name('logistics.requisition.cart.add');
        Route::put('requisition/cart/{code}', 'Web\Admin\Logistics\RequisitionController@cartUpdate')->name('logistics.requisition.cart.update');
        Route::delete('requisition/cart/{code}', 'Web\Admin\Logistics\RequisitionController@cartRemove')->name('logistics.requisition.cart.remove');
        Route::delete('requisition/cart', 'Web\Admin\Logistics\RequisitionController@cartClear')->name('logistics.requisition.cart.clear');

        Route::get('requisition', 'Web\Admin\Logistics\RequisitionController@index')->name('logistics.requisition.index');
        Route::post('requisition/generate', 'Web\Admin\Logistics\RequisitionController@generate')->name('logistics.requisition.generate');
        Route::get('requisition/{requisition}', 'Web\Admin\Logistics\RequisitionController@show')->name('logistics.requisition.show');

        //Purchase order
		Route::group(['prefix' => 'purchase_order'], function(){
			Route::get('/', 'Web\Admin\Logistics\PurchaseOrderController@index')->name('logistics.purchase-order.index');
			Route::get('/create', 'Web\Admin\Logistics\PurchaseOrderController@create')->name('logistics.purchase-order.create');
			Route::get('/cart', 'Web\Admin\Logistics\PurchaseOrderController@cartIndex')->name('logistics.purchase-order.cart.index');
            Route::post('/cart', 'Web\Admin\Logistics\PurchaseOrderController@cartAdd')->name('logistics.purchase-order.cart.add');
			Route::put('/cart/{code}', 'Web\Admin\Logistics\PurchaseOrderController@cartUpdate')->name('logistics.purchase-order.cart.update');
            Route::delete('/cart/{code}', 'Web\Admin\Logistics\PurchaseOrderController@cartRemove')->name('logistics.purchase-order.cart.remove');
            Route::delete('/cart', 'Web\Admin\Logistics\PurchaseOrderController@cartClear')->name('logistics.purchase-order.cart.clear');
            Route::post('/generate', 'Web\Admin\Logistics\PurchaseOrderController@generate')->name('logistics.purchase-order.generate');
			Route::get('/{purorder}', 'Web\Admin\Logistics\PurchaseOrderController@show')->name('logistics.purchase-order.show');
		});
		//Delivery Advice
		Route::group(['prefix' => 'delivery_advice'], function(){
			Route::get('/', 'Web\Admin\Logistics\DeliveryAdviceController@index')->name('logistics.delivery-advice.index');
			Route::get('/create/{po_no}/{item_code}', 'Web\Admin\Logistics\DeliveryAdviceController@create')->name('logistics.delivery-advice.create');
		    Route::post('/store', 'Web\Admin\Logistics\DeliveryAdviceController@store')->name('logistics.delivery-advice.store');
		});
		//PO Shipment
		Route::group(['prefix' => 'po_shipment'], function(){
		Route::get('/', 'Web\Admin\Logistics\PurchaseOrderShipmentController@index')->name('logistics.po-shipment.index');
		
        //Route::get('advice/{advice}/download', 'Web\Admin\Logistics\AdviceController@download')->name('logistics.advice.download')->where(['advice' => '[0-9]+']);
        //Route::post('advice/{advice}/upload', 'Web\Admin\Logistics\AdviceController@upload')->name('logistics.advice.upload')->where(['advice' => '[0-9]+']);
        //Route::post('shipment/{advice}/generate', 'Web\Admin\Logistics\ShipmentController@generate')->name('logistics.shipment.generate');
		});
		
        Route::group(['prefix' => 'stock'], function(){ 
		    Route::get('/opening-balance', 'Web\Admin\Logistics\StockController@importStockFile')->name('logistics.stock.opening-balance');
			//stock save
            Route::post('/opening-balance/save', 'Web\Admin\Logistics\StockController@saveStockExcel');
			Route::get('/makeStockFridge/{lab_id}', 'Web\Admin\Logistics\StockController@updateStockFridge');
			Route::get('/makeStockBatchFridge/{lab_id}', 'Web\Admin\Logistics\StockController@updateStockBatchFridge');

            Route::get('/', 'Web\Admin\Logistics\StockController@index')->name('logistics.stock.index');
            Route::post('/', 'Web\Admin\Logistics\StockController@generatePO')->name('logistics.stock.generate-po');
            Route::post('/requisition', 'Web\Admin\Logistics\StockController@requisitionIndex')->name('logistics.stock.requisition.index');
			Route::post('/labwisestockdetails', 'Web\Admin\Logistics\StockController@labWiseStockDetails')->name('logistics.stock.labwisestockdetails');
			
			Route::get('/batchdetails/{item_code}/{labid}/{rcvfrm}', 'Web\Admin\Logistics\StockController@showBatchDetails')->name('logistics.stock.batchdetails.index');
            Route::get('/cart', 'Web\Admin\Logistics\StockController@cartIndex')->name('logistics.stock.cart.index');
            Route::post('/cart', 'Web\Admin\Logistics\StockController@cartAdd')->name('logistics.stock.cart.add');
            Route::delete('/cart/{item}', 'Web\Admin\Logistics\StockController@cartRemove')->name('logistics.stock.cart.remove');
            Route::delete('/cart', 'Web\Admin\Logistics\StockController@cartClear')->name('logistics.stock.cart.clear');
           
        });

        Route::group(['prefix' => 'advice'], function(){ 
			Route::post('/generate', 'Web\Admin\Logistics\AdviceController@generate')->name('logistics.advice.generate');
			Route::get('/{advice}', 'Web\Admin\Logistics\AdviceController@show')->name('logistics.advice.show')->where(['advice' => '[0-9]+']);
			Route::get('/batch/{item_code}/{lab_id}/{sent_to_id}', 'Web\Admin\Logistics\AdviceController@batchIndex')->name('logistics.advice.batch.index');
			Route::post('/{advice}', 'Web\Admin\Logistics\AdviceController@store')->name('logistics.advice.store')->where(['advice' => '[0-9]+']);
			Route::get('/{advice}/download', 'Web\Admin\Logistics\AdviceController@download')->name('logistics.advice.download')->where(['advice' => '[0-9]+']);
			Route::post('/{advice}/upload', 'Web\Admin\Logistics\AdviceController@upload')->name('logistics.advice.upload')->where(['advice' => '[0-9]+']);
			Route::get('/purchase', 'Web\Admin\Logistics\AdviceController@indexPurchase')->name('logistics.advice.purchase.index');
			Route::get('/transfer', 'Web\Admin\Logistics\AdviceController@indexTransfer')->name('logistics.advice.transfer.index');
			Route::get('/{advice}/shipment', 'Web\Admin\Logistics\AdviceController@shipment')->name('logistics.advice.shipment')->where(['advice' => '[0-9]+']);
			Route::post('/{advice}/shipment', 'Web\Admin\Logistics\AdviceController@shipmentGenerate')->name('logistics.advice.shipment.generate')->where(['advice' => '[0-9]+']);
		});


        Route::post('shipment/{shipment}', 'Web\Admin\Logistics\ShipmentController@index')->name('logistics.shipment.show');
        Route::post('shipment/{advice}/generate', 'Web\Admin\Logistics\ShipmentController@generate')->name('logistics.shipment.generate');


        Route::get('receipt', 'Web\Admin\Logistics\ReceiptController@index')->name('logistics.receipt.index');
        Route::get('receipt/{shipment}', 'Web\Admin\Logistics\ReceiptController@show')->name('logistics.receipt.show');
        Route::post('receipt', 'Web\Admin\Logistics\ReceiptController@received')->name('logistics.receipt.received');
        Route::get('received', 'Web\Admin\Logistics\ReceiptController@receivedIndex')->name('logistics.receipt.received.index');
		Route::get('receipt/getbatchdetails/{shipmenthdrid}/{itemcode}', 'Web\Admin\Logistics\ReceiptController@getBatchDetails')->name('logistics.receipt.getbatchdetail');



        Route::group(['prefix' => 'issue'], function(){

            Route::get('/', 'Web\Admin\Logistics\IssueController@index')->name('logistics.issue.index');
            Route::get('/stock', 'Web\Admin\Logistics\IssueController@stock')->name('logistics.issue.stock');

            Route::get('/cart', 'Web\Admin\Logistics\IssueController@cartIndex')->name('logistics.issue.cart.index');
            Route::post('/cart', 'Web\Admin\Logistics\IssueController@cartAdd')->name('logistics.issue.cart.add');
            Route::delete('/cart/{item}', 'Web\Admin\Logistics\IssueController@cartRemove')->name('logistics.issue.cart.remove');
            Route::delete('/cart', 'Web\Admin\Logistics\IssueController@cartClear')->name('logistics.issue.cart.clear');
            Route::get('/batchdetails/{item_code}/{labid}', 'Web\Admin\Logistics\IssueController@showBatchDetails')->name('logistics.issue.batchdetails.index');
			Route::get('/batch/{item_code}/{lab_id}', 'Web\Admin\Logistics\IssueController@batchIndex')->name('logistics.issue.batch.index');
			Route::post('/generate', 'Web\Admin\Logistics\IssueController@generate')->name('logistics.issue.generate');
			
        });
		
		// Report -----------------------------------
		Route::group(['prefix' => 'report'], function(){
          Route::get('/listofitems', 'Web\Admin\Logistics\ReportController@listofitems')->name('logistics.report.listofitems');
          Route::get('/receiptregister', 'Web\Admin\Logistics\ReportController@receiptregister')->name('logistics.report.receiptregister');
		  Route::get('/issueregister', 'Web\Admin\Logistics\ReportController@issueregister')->name('logistics.report.issueregister');
		  Route::get('/stocksheet', 'Web\Admin\Logistics\ReportController@stocksheet')->name('logistics.report.stocksheet');
		  Route::get('/itemdetails', 'Web\Admin\Logistics\ReportController@itemDetails')->name('logistics.report.itemdetails');
		  Route::get('/issueitemdetails', 'Web\Admin\Logistics\ReportController@issueItemDetails')->name('logistics.report.issueitemdetails');
		  Route::get('/getperiod/{period_id}', 'Web\Admin\Logistics\ReportController@getPeriod')->name('logistics.report.getperiod');
			
		});


    });


    //  ===========================================================================
    //  ===========================================================================
    //  ===========================================================================






//    Route::get('/logistics/item-requisition', 'Web\Admin\Logistics\ItemRequisitionController@create');
//    Route::get('/logistics/item-receipt', 'Web\Admin\Logistics\ItemReceiptController@create');
//    Route::get('/logistics/stock-transfer', 'Web\Admin\Logistics\StockTransferController@index');
//    Route::get('/logistics/item-issue', 'Web\Admin\Logistics\ItemIssueController@create');



});


Route::post('/further_lc_flagged_mgit/ict', 'Web\Admin\LCFlaggedMGITFurtherController@ict');
Route::post('/further_lc_flagged_mgit/bhi', 'Web\Admin\LCFlaggedMGITFurtherController@bhi');
Route::post('/further_lc_flagged_mgit/smearculture', 'Web\Admin\LCFlaggedMGITFurtherController@smear_culture');
Route::post('/searchform/getenquiry', 'Web\Admin\SearchformController@getenquiry');
Route::post('/searchform/get_current_status', 'Web\Admin\SearchformController@getstatus');
Route::get('/getequipmentlist', 'Web\Admin\EditResultController@get_eq_list');
Route::get('/viewsamples', 'Web\Admin\BioWasteController@viewSamples');
Route::post('/search/bwmsamples', 'Web\Admin\BioWasteController@search_samples');


Auth::routes();

Route::get('/home', 'HomeController@index');
//Route::get('/form', 'Web\Admin\LpaUserController@index');
//Route::post('/userdata', 'Web\Admin\LpaUserController@userdata');

