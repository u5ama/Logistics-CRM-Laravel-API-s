<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Helpers\LogActivity;
use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewUserResource;
use App\Http\Resources\UserActivitiesResource;
use App\Http\Resources\UserResource;
use App\Models\NewAccount;
use App\Models\Notes;
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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return JsonResponse
     */

    /**
     * Get All Users
     *
     * Check that the Get All Users is working. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be all the users list.
     *
     */

    public function index(Request $request)
    {
        try {
            $users = User::with('userProfile')->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'index','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Add New User
     *
     * Check that the Store New User is working. Add the required fields for user creation. If everything is okay, you'll get a 200 OK response.
     *
     * Also assign Role for the user
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @response 401 scenario="Invalid Email OR Email Already Taken." {"status": "false", "message": "Email already Taken."}
     * @responseField The response of API will be user object.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'user_type' => 'required',
                'roles' => 'required'
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
//            if ($request->user_type !== '1')
//            {
                $name = $request->name;
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
                    'name' => $name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'user_status' => 'NotActive',
                    'user_type' => $request->user_type,
                ]);
                $user->assignRole($request->input('roles'));
                $userRole = $user->roles->all();
                $user->userRole = $userRole;
                $type = Utility::checkUserType($request->user_type);
                LogActivity::addToLog('New User with '.$type.' type Created.', Auth::user()->id);

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
//            }else{
//                return response()->json(['success' => false, 'message' => 'User Not Created. Use another user type.'], 401);
//            }

            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'data' => $user,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_store','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Show the profile for a given user.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Show User
     *
     * Check that the Show User is working. Add the required field if for user data. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @response 401 scenario="User Not Found." {"status": "false", "message": "User Not Found."}
     * @responseField The response of API will be user object with roles and permissions.
     *
     */

    public function show(Request $request)
    {
        try {
            $user = User::with('userProfile')->where('id',$request->id)->first();
            $userRole = $user->roles->all();
            $user->userRole = $userRole;
            $notes = Notes::where('user_id', $user->id)->count();
            $user->notes = $notes;
            $user = new UserResource($user);
            return response()->json([
                'success' => true,
                'data' => $user,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_show','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Update User By SuperAdmin
     *
     * Check that the Update User is working. Add the required fields for user update. If everything is okay, you'll get a 200 OK response.
     *
     * It also updates user profile details
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be user object.
     *
     */

    public function update(Request $request, int $id){
        try {

            $validator_array = [
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'roles' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
//            if(!empty($request->password)){
//                $password = Hash::make($request->password);
//            }else{
//                $password = Arr::except($input,array('password'));
//            }
            $full_name = $request->first_name.' '.$request->middle_name.' '.$request->preferredName.' '.$request->last_name;

            $user = User::where('id',$id)->first();
            $user->name = $full_name;
            $user->email = $request->email;
            $user->save();

            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));

            $profile = UserProfile::where('user_id', $id)->first();
            if (empty($profile)){
                $profile = new UserProfile();
                $profile->user_id = $user->id;
                $profile->title = $request->title;
                $profile->first_name = $request->first_name;
                $profile->middle_name = $request->middle_name;
                $profile->preferredName = $request->preferredName;
                $profile->last_name = $request->last_name;
                $profile->dob = $request->dob;
                $profile->phone = $request->phone;
                $profile->gender = $request->gender;
                $profile->tax_file_number = $request->tax_file_number;
                $profile->emergency_contact_name = $request->emergency_contact_name;
                $profile->emergency_contact_phone = $request->emergency_contact_phone;
                $profile->save();
            }else{
                $profile->user_id = $user->id;
                $profile->title = $request->title;
                $profile->first_name = $request->first_name;
                $profile->middle_name = $request->middle_name;
                $profile->preferredName = $request->preferredName;
                $profile->last_name = $request->last_name;
                $profile->dob = $request->dob;
                $profile->phone = $request->phone;
                $profile->gender = $request->gender;
                $profile->tax_file_number = $request->tax_file_number;
                $profile->emergency_contact_name = $request->emergency_contact_name;
                $profile->emergency_contact_phone = $request->emergency_contact_phone;
                $profile->save();
            }

            LogActivity::addToLog('User updated successfully!.', Auth::user()->id);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'data' => $user,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_update','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Delete User
     *
     * Check that the Delete User is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be messaged that User deleted Successfully!.
     */

    public function destroy($id)
    {
        try {
            $user = User::findorFail($id);
            if ($user) {

                $type = Utility::checkUserType($user->user_type);
                LogActivity::addToLog('User with '.$type.' type Deleted.', Auth::user()->id);
                $user->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Change User Status
     *
     * Check that the Change User Status is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error.
     *
     * @responseField The response of API will be messaged that User deleted Successfully!.
     */

    public function changeStatus(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();

            $user->user_status = $request->status;
            $user->save();

            LogActivity::addToLog('User '.$user->name.' is '.$request->status, Auth::user()->id);

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_changeStatus','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Get All Roles
     *
     * Check that the Roles is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error.
     *
     * @responseField The response of API will be list of all roles!.
     */

    public function userRoles(Request $request)
    {
        try {
            $roles = Role::all();
            return response()->json([
                'success' => true,
                'data' => $roles,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_userRoles','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Get All Logs
     *
     * Check that the Logs is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error.
     *
     * @responseField The response of API will be list of all Logs!.
     */

    public function allLogs(Request $request)
    {
        try {
            $logs = LogActivity::logActivityLists();
            return response()->json([
                'success' => true,
                'data' => $logs,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_allLogs','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Get All User's Activities
     *
     * Check that the User's Activities is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error.
     *
     * @responseField The response of API will be list of all Activities performed by a User!.
     */

    public function allActivities($id)
    {
        try {
            $user = User::find($id);
            $logs = [];
            if (!empty($user->revisions)){
                $logs = $user->revisions;
                if (count($logs) > 0){
                    $logs = UserActivitiesResource::collection($logs);
                }
            }
            return response()->json([
                'success' => true,
                'data' => $logs,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_allLogs','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function change_password(Request $request)
    {
        try {
            $userid = Auth::user()->id;
            $validator_array = [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
            } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
            } else {
                User::where('id', $userid)->update(['password' => Hash::make($request->new_password)]);
                $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
            }

            return response()->json([
                'success' => true,
                'message' => 'User Password Updated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'users_change_password','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function getAllNewRegisteredUsers()
    {
        try {
            $users = NewAccount::where(['user_status' => 'NotActive'])->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'index','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function showNewUser(Request $request)
    {
        try {
            $user = User::with('userProfile','companyInformation','companyAddress','bankDetails','insurances','operatorRecords','complainceChecklist','equipmentChecklist',
            'requirementChecklist','hireChecklist','truckDetails','trailerDetails','plantDetails','checklistFiles')
                ->where('account_id',$request->id)
                ->first();

            if (empty($user)){
                $user = NewAccount::with('companyInformation','companyAddress','bankDetails','insurances','operatorRecords','complainceChecklist','equipmentChecklist',
                    'requirementChecklist','hireChecklist','truckDetails','trailerDetails','plantDetails','checklistFiles')
                    ->where('id',$request->id)
                    ->first();
            }
            $user = new NewUserResource($user);
            return response()->json([
                'success' => true,
                'data' => $user,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'new_users_show','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function updateNewUser(Request $request, $id)
    {
        try {
            $jsonData = $request->input('user');
            $reqData = json_decode($jsonData, true);
            $data = $reqData;

            $user_id = $id;

            DB::beginTransaction();

            $info = UsersCompanyInformation::where('user_id', $user_id)->first();
            if ($info){
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
            }

            $address = UsersCompanyAddress::where('user_id', $user_id)->first();
            if ($address){
                $address->business_number_street = $data['business_number_street'] ?? null;
                $address->business_suburb = $data['business_suburb'] ?? null;
                $address->business_state = $data['business_state'] ?? null;
                $address->business_post_code = $data['business_post_code'] ?? null;
                $info->postal_number_street = $data['postal_number_street'] ?? null;
                $info->postal_suburb = $data['postal_suburb'] ?? null;
                $info->postal_state = $data['postal_state'] ?? null;
                $info->postal_post_code = $data['postal_post_code'] ?? null;
                $address->save();
            }

            $bank = UsersBankDetails::where('user_id', $user_id)->first();
            if ($bank){
                $bank->bsb = $data['bsb'] ?? null;
                $bank->account_number = $data['account_number'] ?? null;
                $bank->account_name = $data['account_name'] ?? null;
                $bank->banking_corporation = $data['banking_corporation'] ?? null;
                $bank->save();
            }

            $insurance = UsersInsurances::where('user_id', $user_id)->first();

            if ($insurance){
                $insurance->work_policy_number = $data['work_policy_number'] ?? null;
                $insurance->work_policy_expiry_date = $data['work_policy_expiry_date'] ?? null;

                $insurance->public_policy_number = $data['public_policy_number'] ?? null;
                $insurance->public_policy_expiry_date = $data['public_policy_expiry_date'] ?? null;

                $insurance->equipment_policy_number = $data['equipment_policy_number'] ?? null;
                $insurance->equipment_policy_expiry_date = $data['equipment_policy_expiry_date'] ?? null;
                $insurance->save();
            }


            if (count($data['operatorDetails'])>0){
                foreach ($data['operatorDetails'] as $opt){
                    UsersOperatorsRecords::updateOrCreate(['user_id' => $user_id],
                        [
                            'given_name' => $opt['opt_given_name'] ?? null,
                            'surname'=> $opt['opt_surname'] ?? null,
                            'mobile'=> $opt['opt_mobile'] ?? null,
                            'ohs_induction_card'=> $opt['opt_hs_card_number'] ?? null,
                            'ohs_induction_issuer'=> $opt['opt_hs_issuer'] ?? null,
                            'driver_license_number'=> $opt['opt_driver_license'] ?? null,
                            'driver_license_expiry'=>  $opt['opt_driver_license_expiry'] ?? null,
                            'operator_license_type'=> $opt['opt_ticket_license'] ?? null,
                            'operator_license_expiry'=> $opt['opt_ticket_license_expiry'] ?? null,
                            'opt_other_card'=> $opt['opt_other_card'] ?? null,
                            'opt_other_card_number'=> $opt['opt_other_card_number'] ?? null,
                            'opt_other_card_issue_date'=> $opt['opt_other_card_issue_date'] ?? null,
                        ]);
                }
            }

            $compliance = UsersComplianceChecklist::where('user_id', $user_id)->first();
            if ($compliance){
                $compliance->compliance_checklist = json_encode($data['complianceChecklist']?? null);
                $compliance->save();
            }

            $equipment = UsersEquipmentChecklist::where('user_id', $user_id)->first();
            if ($equipment){
                $equipment->equipment_checklist = json_encode($data['equipmentChecklist']?? null);
                $equipment->save();
            }

            $requirement = UsersRequirementChecklist::where('user_id', $user_id)->first();
            if ($requirement){
                $requirement->requirement_checklist = json_encode($data['requirementChecklist']?? null);
                $requirement->save();
            }

            $hire = UsersHireChecklist::where('user_id', $user_id)->first();
            if ($hire){
                $hire->hire_checklist = json_encode($data['hireChecklist']?? null);
                $hire->save();
            }

            if (count($data['truckDetails'])>0){
                foreach ($data['truckDetails'] as $t){
                    $truck = UserTrucksDetails::where('user_id', $user_id)->first();
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
                    $trailer = UserTrailerDetails::where('user_id', $user_id)->first();
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
                    $plant = UserPlantDetails::where('user_id', $user_id)->first();
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

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Form Updated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'new_users_update','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

}
