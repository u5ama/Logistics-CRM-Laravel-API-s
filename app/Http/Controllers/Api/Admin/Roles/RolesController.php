<?php

namespace App\Http\Controllers\Api\Admin\Roles;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Roles
     *
     * Check that All Roles are showing.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a list of all roles with permissions!.
     *
     */

    public function index()
    {
        $roles = Role::orderBy('id','DESC')->get();
        return response()->json([
            'success' => true,
            'data' => $roles,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */

    /**
     * Create Role for Permission
     *
     * Check that Create Role is working. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function create()
    {
        $permissions = Permission::all();
        return response()->json([
            'success' => true,
            'data' => $permissions,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Store Role for Permission
     *
     * Check that Store Role is working. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function store(Request $request)
    {
        try {
            $validator_array = [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $role = Role::create(['name' => $request->get('name')]);
            $role->syncPermissions($request->get('permission'));

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'roles_store','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Show Role with Permission Assigned
     *
     * Check that Show Role is working. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message with role details for specific ID!.
     *
     */

    public function show(Request $request)
    {
        $role = Role::where('id', $request->id)->first();
        if ($role){
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            $permissions = Permission::all();

            $data = array();
            $data['role'] = $role;
            $data['permissions'] = $permissions;
            return response()->json([
                'success' => true,
                'data' => $data,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Role Found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return void
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Update Role with permissions
     *
     * Check that Update Role is working. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     */

    public function update($id, Request $request)
    {
        try {
            $validator_array = [
                'name' => 'required',
                'permission' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            Role::where('id', $id)->update(['name' => $request->get('name')]);

            $role = Role::where('id', $id)->first();
            $role->syncPermissions($request->get('permission'));

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'roles_update','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */

    /**
     * Delete Role with Permission
     *
     * Check that Delete Role is working. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $role = Role::findorFail($id);
            if ($role)
            {
                LogActivity::addToLog('User Role Deleted.', Auth::user()->id);
                $role->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Role deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'role_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
