<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Helpers\LogActivity;
use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use App\Mail\ApplicationMail;
use App\Mail\ApprovalMail;
use App\Models\NewAccount;
use App\Models\User;
use App\Models\UserPlantDetails;
use App\Models\UserProfile;
use App\Models\UsersBankDetails;
use App\Models\UsersChecklistFiles;
use App\Models\UsersCompanyAddress;
use App\Models\UsersCompanyInformation;
use App\Models\UsersComplianceChecklist;
use App\Models\UsersEquipmentChecklist;
use App\Models\UsersHireChecklist;
use App\Models\UsersInsurances;
use App\Models\UsersOperatorsRecords;
use App\Models\UsersRequirementChecklist;
use App\Models\UserTrailerDetails;
use App\Models\UserTrucksDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating and registering users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Login
     *
     * Check that the login is working. Add the required email and password. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the failed messages.
     *
     * @response 401 scenario="Invalid Email / Password" {"status": "false", "message": "Invalid Email / Password"}
     * @response 401 scenario="Status Not Active" {"status": "false", "message": "User is not Active. Contact Admin."}
     * @responseField The response of API will be user object with Auth Token.
     *
     */

    public function login(Request $request)
    {
        try {
            $validator_array = [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $credentials = $request->only('email', 'password');

            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email / password',
                ]);
            }

            $user = User::where(['email'=> $request->email, 'user_status' => 'active'])->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not Active. Contact Admin.'
                ]);
            }

//            $ttl = ($request->remember_me === true) ? env('JWT_REMEMBER_TTL') : env('JWT_TTL');

            $user = Auth::user();
            $user->token = $token;

            LogActivity::addToLog('User logged In Successfully!.',$user->id);

            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'login_attempt','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }


    /**
     * Register
     *
     * Check that the Register is working. Add the required fields for user registration. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @response 401 scenario="Invalid Email OR Email Already Taken." {"status": "false", "message": "Email already Taken."}
     * @responseField The response of API will be user object with Auth Token.
     *
     */

    public function register(Request $request)
    {
        try {
            $jsonData = $request->input('user');
            $reqData = json_decode($jsonData, true);

            $validator_array = [
                'company_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ];
            $validator = Validator::make($reqData, $validator_array);
            if ($validator->fails()) {
                $errors = [['field' => 'validation_error', 'message' => $validator->errors()->first()]];
                return response()->json(['errors' => $errors], 401);
            }
//            if ($reqData['user_type'] !== '1')
//            {

                $user = NewAccount::create([
                    'name' => $reqData['company_name'],
                    'email' => $reqData['email'],
//                    'password' => Hash::make($reqData['password']),
                    'password' => $reqData['password'],
                    'user_status' => 'NotActive',
                ]);

                $type = Utility::checkUserType(5);

//            }else{
//                return response()->json(['success' => false, 'message' => 'User Not Created. Use another user type.'], 401);
//            }
            $workFile = $request->work_cover_file;
            $publicFile = $request->public_policy_file;
            $equipmentFile = $request->equipment_policy_file;

            $data = $reqData;
            $data['work_cover_file_new'] = $workFile;
            $data['public_policy_file_new'] = $publicFile;
            $data['equipment_policy_file_new'] = $equipmentFile;

            //checklist files
            $checkInfoSheetFile = $request->company_info_sheet;
            $data['company_info_sheet'] = $checkInfoSheetFile;

            $checklistCompanyFile = $request->company_checklist;
            $data['company_checklist'] = $checklistCompanyFile;

            $equipmentDetailsFile = $request->equipment_details;
            $data['equipment_details'] = $equipmentDetailsFile;

            $ohsInductionFile = $request->ohs_induction_card;
            $data['ohs_induction_card'] = $ohsInductionFile;

            $driverLicenseFile = $request->driver_license;
            $data['driver_license'] = $driverLicenseFile;

            $operatorTicketFile = $request->operator_ticket;
            $data['operator_ticket'] = $operatorTicketFile;

            $certificateOfBusinessFile = $request->certificate_of_business;
            $data['certificate_of_business'] = $certificateOfBusinessFile;

            $publicLiabilityFile = $request->public_liability_certificate;
            $data['public_liability_certificate'] = $publicLiabilityFile;

            $insuranceCertificateCurrencyFile = $request->insurance_certificate_currency;
            $data['insurance_certificate_currency'] = $insuranceCertificateCurrencyFile;

            $workerCertificateCurrencyFile = $request->worker_certificate_currency;
            $data['worker_certificate_currency'] = $workerCertificateCurrencyFile;

            $vehicleRegistrationFile = $request->vehicle_registration_report;
            $data['vehicle_registration_report'] = $vehicleRegistrationFile;

            $gstRegistrationFile = $request->gst_registration_letter;
            $data['gst_registration_letter'] = $gstRegistrationFile;

            $hazardRiskFile = $request->hazard_risk_assessment;
            $data['hazard_risk_assessment'] = $hazardRiskFile;

            $photosOfPlantFile = $request->photos_of_plant;
            $data['photos_of_plant'] = $photosOfPlantFile;

            $epaPermitsFile = $request->epa_permits;
            $data['epa_permits'] = $epaPermitsFile;

            $pbsPermitsFile = $request->pbs_permits;
            $data['pbs_permits'] = $pbsPermitsFile;

            $response = $this->storeUserData($data, $user);
            if ($response){

                Mail::to($user->email)->send(new ApplicationMail($user));
                LogActivity::addToLog('New User Created.',$user->id);

                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully!',
                    'data' => $user,
                    'type' => 'bearer',
                ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'register_attempt','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function changeNewUserStatus(Request $request, $id)
    {
        try{
            $account = NewAccount::where('id', $id)->first();
            $account->user_status = $request->status;
            $account->save();
            if ($account->status == 'active'){
                $name = $account->name;
                $splitName = explode(' ', $name);
                $middle_name = $last_name = null;
                $first_name = $splitName[0];

                if (count($splitName) == 2){
                    $last_name = !empty($splitName[1]) ? $splitName[1] : '';
                }
                elseif (count($splitName) == 3){
                    $middle_name = !empty($splitName[1]) ? $splitName[1] : '';
                    $last_name = !empty($splitName[2]) ? $splitName[2] : '';
                }

                $preferredName = !empty($splitName[0]) ? $splitName[0] : '';

                $user = User::create([
                    'name' => $account->name,
                    'email' => $account->email,
                    'password' => Hash::make($account->password),
                    'user_status' => 'NotActive',
                    'account_id' => $account->id,
                ]);

                $user->assignRole('Drivers Role');
                $userRole = $user->roles->all();
                $user->userRole = $userRole;
                $type = Utility::checkUserType(5);

//                LogActivity::addToLog('New User with '.$type.' type Created.', Auth::user()->id);

                $profile = UserProfile::where('user_id', $user->id)->first();
                if (empty($profile)) {
                    $profile = new UserProfile();
                    $profile->user_id = $user->id;
                    $profile->first_name = $first_name;
                    $profile->middle_name = $middle_name;
                    $profile->preferredName = $preferredName;
                    $profile->last_name = $last_name;
                    $profile->save();
                }

            $token = JWTAuth::fromUser($user);
            $user->token = $token;
            LogActivity::addToLog('New User Created.',$user->id);

            Mail::to($account->email)->send(new ApprovalMail($user));

            return response()->json([
                'success' => true,
                'message' => 'User status updakted successfully!',
                'data' => $user,
                'type' => 'bearer',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'new_user_status','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

/**
 * Logout
 *
 * Check that the Logout is working. Add Token for User Authentication. If everything is okay, you'll get a 200 OK response.
 *
 * Otherwise, the request will fail with an error, and a response listing the errors.
 *
 * @response 401 scenario="Invalid Token."{"status": "false", "message": "Token is not set, please retry action or login"}
 * @responseField The response of API will be {"status": "true", "message": "User Logout Successfully!"}.
 *
 */

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (! isset($token) ) {
            return response()->json([
                'success' => false,
                'message' => 'Token is not set, please retry action or login.'
            ]);
        }
        try {
            $user = JWTAuth::toUser($token);
            LogActivity::addToLog('User logged out Successfully!.',$user->id);
            JWTAuth::setToken($token)->invalidate(true);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

        } catch (JWTException $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'logout_attempt','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Forgot Password
     *
     * Check that the Forgot Password is working. Add the required field i.e. for the password recovery. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the errors.
     *
     * @response 401 scenario="Invalid Email. Email Not Found." {"status": "false", "message": "Invalid Email. Email Not Found."}
     * @responseField The response of API will be message 'Reset link is send successfully, Please check your inbox.'.
     *
     */

    public function forgotPassword(Request $request)
    {
        try {
            $validator_array = [
                'email' => 'required|string|email|max:255',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email. Email Not Found.'
                ]);
            }
            LogActivity::addToLog('Forgot Password!.',$user->id);
            $token = Password::getRepository()->create($user);
            $array = [
                'name'                   => $user->name,
                'actionUrl'              => route('reset-password', [$token]),
                'mail_title'             => "Password Reset",
                'reset_password_subject' => "Reset your password",
                'main_title_text'        => "Password Reset",
            ];
//            Mail::to($request->input('email'))->send(new ResetPasswordEmail($array));
            return response()->json([
                'success' => false,
                'message' => 'Reset link is send successfully, please check your inbox.'
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'forgot_password_attempt','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Reset Password
     *
     * Check that the Reset Password is working. Add the required field for password change. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @response 401 scenario="New Password is Required." {"status": "false", "message": "New Password is Required."}
     * @responseField The response of API will be message 'Password Reset Successfully!'.
     *
     */

    public function resetPassword(Request $request)
    {
        try {
            $validator_array = [
                'token' => 'required',
                'new_password' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $new_password = $request->input('new_password');
            $tokens = DB::table('password_resets')->select('email', 'token')->get();

            if(count($tokens) > 0){
                foreach($tokens as $token){
                    if(Hash::check($request->input('token'), $token->token)){
                        $user = User::where('email', $token->email)->first();
                        if($user){
                            $user->password = bcrypt($new_password);
                            $user->update();
                            DB::table('password_resets')->where('email', $user->email)->delete();
                            LogActivity::addToLog('Password Reset Successfully!.',$user->id);
                            return response()->json([
                                'success' => true,
                                'message' => "Password Reset Successfully!",
                            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
                        } else{
                            return response()->json([
                                'success' => false,
                                'message' => 'Invalid Email. Email Not Found.',
                            ], 403);
                        }
                    }
                }
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'reset_password_attempt','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function storeUserData($data, $user)
    {
            DB::beginTransaction();

            $info = new UsersCompanyInformation();
            $info->user_id = $user['id'];
            $info->company_name = $data['company_name'];
            $info->trading_name = $data['trading_name'] ?? null;
            $info->corporate_trustee = $data['corporate_trustee'] ?? null;
            $info->abn = $data['abn'] ?? null;
            $info->acn = $data['acn'] ?? null;
            $info->company_director = $data['company_director'] ?? null;
            $info->email = $data['email'] ?? null;
            $info->main_contact_person = $data['contact_person'] ?? null;
            $info->mobile = $data['mobile'] ?? null;
            $info->phone = $data['phone'] ?? null;
            $info->about_us_description = $data['about_us'] ?? null;
            $info->TaxCheck = json_encode($data['TaxCheck']?? null);
            $info->infoCheck = json_encode($data['infoCheck']?? null);
            $info->save();

            $address = new UsersCompanyAddress();
            $address->user_id = $user['id'];
            $address->business_number_street = $data['business_number_street'] ?? null;
            $address->business_suburb = $data['business_suburb'] ?? null;
            $address->business_state = $data['business_state'] ?? null;
            $address->business_post_code = $data['business_post_code'] ?? null;
            $info->postal_number_street = $data['postal_number_street'] ?? null;
            $info->postal_suburb = $data['postal_suburb'] ?? null;
            $info->postal_state = $data['postal_state'] ?? null;
            $info->postal_post_code = $data['postal_post_code'] ?? null;
            $address->save();

            $bank = new UsersBankDetails();
            $bank->user_id = $user['id'];
            $bank->bsb = $data['bsb'] ?? null;
            $bank->account_number = $data['account_number'] ?? null;
            $bank->account_name = $data['account_name'] ?? null;
            $bank->banking_corporation = $data['banking_corporation'] ?? null;
            $bank->save();

            $insurance = new UsersInsurances();
            $insurance->user_id = $user['id'];

            $wk_path = '';
            $work_cover_file = $data['work_cover_file_new'] ?? null;
            if ($work_cover_file !== null && $work_cover_file->isValid()) {
                $file = $work_cover_file;
                $wk_path = $file->store('public/company/work_cover_file');
                $name = $file->getClientOriginalName();
            }

            $insurance->work_policy_number = $data['work_policy_number'] ?? null;
            $insurance->work_policy_expiry_date = $data['work_policy_expiry_date'] ?? null;
            $insurance->work_cover_file = $wk_path;

            $pb_path = '';
            $public_policy_file = $data['public_policy_file_new'] ?? null;
            if ($public_policy_file !== null && $public_policy_file->isValid()) {
                $file = $public_policy_file;
                $pb_path = $file->store('public/company/public_policy_file');
                $name = $file->getClientOriginalName();
            }

            $insurance->public_policy_number = $data['public_policy_number'] ?? null;
            $insurance->public_policy_expiry_date = $data['public_policy_expiry_date'] ?? null;
            $insurance->public_policy_file = $pb_path;

            $eq_path = '';
            $equipment_policy_file = $data['equipment_policy_file_new'] ?? null;
            if ($equipment_policy_file !== null && $equipment_policy_file->isValid()) {
                $file = $equipment_policy_file;
                $eq_path = $file->store('public/company/equipment_policy_file');
                $name = $file->getClientOriginalName();
            }

            $insurance->equipment_policy_number = $data['equipment_policy_number'] ?? null;
            $insurance->equipment_policy_expiry_date = $data['equipment_policy_expiry_date'] ?? null;
            $insurance->equipment_policy_file = $eq_path;
            $insurance->save();

            if (count($data['operatorDetails'])>0){
               foreach ($data['operatorDetails'] as $opt){
                   $operator = new UsersOperatorsRecords();
                   $operator->user_id = $user['id'];
                   $operator->given_name = $opt['opt_given_name'];
                   $operator->surname = $opt['opt_surname'];
                   $operator->mobile = $opt['opt_mobile'];
                   $operator->ohs_induction_card = $opt['opt_hs_card_number'];
                   $operator->ohs_induction_issuer = $opt['opt_hs_issuer'];
                   $operator->driver_license_number = $opt['opt_driver_license'];
                   $operator->driver_license_expiry = $opt['opt_driver_license_expiry'];
                   $operator->operator_license_type = $opt['opt_ticket_license'];
                   $operator->operator_license_expiry = $opt['opt_ticket_license_expiry'];
                   $operator->opt_other_card = $opt['opt_other_card'];
                   $operator->opt_other_card_number = $opt['opt_other_card_number'];
                   $operator->opt_other_card_issue_date = $opt['opt_other_card_issue_date'];
                   $operator->save();
               }
            }

                $compliance = new UsersComplianceChecklist();
                $compliance->user_id = $user['id'];
                $compliance->compliance_checklist = json_encode($data['complianceChecklist']?? null);
                $compliance->save();

                $equipment = new UsersEquipmentChecklist();
                $equipment->user_id = $user['id'];
                $equipment->equipment_checklist = json_encode($data['equipmentChecklist']?? null);
                $equipment->save();

                $requirement = new UsersRequirementChecklist();
                $requirement->user_id = $user['id'];
                $requirement->requirement_checklist = json_encode($data['requirementChecklist']?? null);
                $requirement->save();

                $hire = new UsersHireChecklist();
                $hire->user_id = $user['id'];
                $hire->hire_checklist = json_encode($data['hireChecklist']?? null);
                $hire->save();

            if (count($data['truckDetails'])>0){
                foreach ($data['truckDetails'] as $t){
                    $truck = new UserTrucksDetails();
                    $truck->user_id = $user['id'];
                    $truck->type = $t['truck_type'];
                    $truck->make = $t['truck_make'];
                    $truck->model = $t['truck_model'];
                    $truck->year = $t['truck_year'];
                    $truck->body_type = $t['truck_body_type'];
                    $truck->truck_reg = $t['truck_truck_reg'];
                    $truck->trailer_reg = $t['truck_trailer_reg'];
                    $truck->capacity = $t['truck_capacity'];
                    $truck->tare_gross = $t['truck_tare_gross'];
                    $truck->suspension = $t['truck_suspension'];
                    $truck->style = $t['truck_style'];
                    $truck->truck_checks = json_encode($t['truck_selectedChecklist']);
                    $truck->save();
                }
            }

            if (count($data['trailerDetails'])>0){
                foreach ($data['trailerDetails'] as $tr){
                    $trailer = new UserTrailerDetails();
                    $trailer->user_id = $user['id'];
                    $trailer->manufacturer = $tr['trailer_manufacturer'];
                    $trailer->year = $tr['trailer_year'];
                    $trailer->body_type = $tr['trailer_body_type'];
                    $trailer->capacity = $tr['trailer_capacity'];
                    $trailer->tare_gross = $tr['trailer_tare_gross'];
                    $trailer->suspension = $tr['trailer_suspension'];
                    $trailer->trailer_checks = json_encode($tr['trailer_selectedChecklist']);
                    $trailer->save();
                }
            }

            if (count($data['plantDetails'])>0){
                foreach ($data['plantDetails'] as $p){
                    $plant = new UserPlantDetails();
                    $plant->user_id = $user['id'];
                    $plant->type = $p['plant_type'];
                    $plant->machine_size = $p['plant_machine_size'];
                    $plant->make = $p['plant_make'];
                    $plant->model = $p['plant_model'];
                    $plant->year = $p['plant_year'];
                    $plant->bucket_types = $p['plant_bucket_types'];
                    $plant->plant_checks = json_encode($p['plant_selectedChecklist']);
                    $plant->save();
                }
            }

        $checkInfoSheetFile = $data['company_info_sheet'] ?? null;
        $checklistCompanyFile = $data['company_checklist'] ?? null;
        $equipmentDetailsFile = $data['equipment_details'] ?? null;
        $ohsInductionFile = $data['ohs_induction_card'] ?? null;
        $driverLicenseFile = $data['driver_license'] ?? null;
        $operatorTicketFile = $data['operator_ticket'] ?? null;
        $certificateOfBusinessFile = $data['certificate_of_business'] ?? null;
        $publicLiabilityFile = $data['public_liability_certificate'] ?? null;
        $insuranceCertificateCurrencyFile = $data['insurance_certificate_currency'] ?? null;
        $workerCertificateCurrencyFile = $data['worker_certificate_currency'] ?? null;
        $vehicleRegistrationFile = $data['vehicle_registration_report'] ?? null;
        $gstRegistrationFile = $data['gst_registration_letter'] ?? null;
        $hazardRiskFile = $data['hazard_risk_assessment'] ?? null;
        $photosOfPlantFile = $data['photos_of_plant'] ?? null;
        $epaPermitsFile = $data['epa_permits'] ?? null;
        $pbsPermitsFile = $data['pbs_permits'] ?? null;

        if ($checkInfoSheetFile !== null && $checkInfoSheetFile->isValid()) {
            $file = $checkInfoSheetFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'company_info_sheet';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($checklistCompanyFile !== null && $checklistCompanyFile->isValid()) {
            $file = $checklistCompanyFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'company_checklist';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($equipmentDetailsFile !== null && $equipmentDetailsFile->isValid()) {
            $file = $equipmentDetailsFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'equipment_details';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($ohsInductionFile !== null && $ohsInductionFile->isValid()) {
            $file = $ohsInductionFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'ohs_induction_card';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($driverLicenseFile !== null && $driverLicenseFile->isValid()) {
            $file = $driverLicenseFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'driver_license';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($operatorTicketFile !== null && $operatorTicketFile->isValid()) {
            $file = $operatorTicketFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'operator_ticket';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($certificateOfBusinessFile !== null && $certificateOfBusinessFile->isValid()) {
            $file = $certificateOfBusinessFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'certificate_of_business';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($publicLiabilityFile !== null && $publicLiabilityFile->isValid()) {
            $file = $publicLiabilityFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'public_liability_certificate';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($insuranceCertificateCurrencyFile !== null && $insuranceCertificateCurrencyFile->isValid()) {
            $file = $insuranceCertificateCurrencyFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'insurance_certificate_currency';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($workerCertificateCurrencyFile !== null && $workerCertificateCurrencyFile->isValid()) {
            $file = $workerCertificateCurrencyFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'worker_certificate_currency';
        }
        if ($vehicleRegistrationFile !== null && $vehicleRegistrationFile->isValid()) {
            $file = $vehicleRegistrationFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'vehicle_registration_report';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($gstRegistrationFile !== null && $gstRegistrationFile->isValid()) {
            $file = $gstRegistrationFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'gst_registration_letter';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($hazardRiskFile !== null && $hazardRiskFile->isValid()) {
            $file = $hazardRiskFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'hazard_risk_assessment';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($photosOfPlantFile !== null && $photosOfPlantFile->isValid()) {
            $file = $photosOfPlantFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'photos_of_plant';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($epaPermitsFile !== null && $epaPermitsFile->isValid()) {
            $file = $epaPermitsFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'epa_permits';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
        if ($pbsPermitsFile !== null && $pbsPermitsFile->isValid()) {
            $file = $pbsPermitsFile;
            $eq_path = $file->store('public/user/company/checklist/files');
            $name = $file->getClientOriginalName();

            $key = 'pbs_permits';

            $fa = new UsersChecklistFiles();
            $fa->user_id = $user['id'];
            $fa->file_name = $name;
            $fa->file_key = $key;
            $fa->file_path = $eq_path;
            $fa->save();
        }
            DB::commit();
            return true;
        }
}
