<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



class StaffsController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['staffData'] = User::select('id', 'image','email', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
            ->where('school_id', $school_id)
            ->where('status', 1)
            ->whereNotIn('usertype', ['std', 'parent', 'intellisas'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    
        $data['school'] = School::select('username')->where('id', $school_id)->first();
        return view('users.staffs.index', $data);
    }
    

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_title.*' => 'required',
            'staff_first_name.*' => 'required',
            'staff_last_name.*' => 'required',
            'staff_role.*' => 'required',
        ]);
    
        $validator->sometimes('staff_email_phone.*', 'email|unique:users,email', function ($input) {
            return filter_var($input->staff_email_phone, FILTER_VALIDATE_EMAIL);
        });
    
        $validator->sometimes('staff_email_phone.*', 'unique:users,phone', function ($input) {
            return !filter_var($input->staff_email_phone, FILTER_VALIDATE_EMAIL);
        });
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->toArray()], 422);
        }
    
        $errors = [];
        $staffData = [];
    
        foreach ($request->input('staff_title') as $index => $title) {
            $data = [
                'first_name' => $title.' '.$request->input('staff_first_name')[$index],
                'last_name' => $request->input('staff_last_name')[$index],
                'role' => $request->input('staff_role')[$index],
            ];
    
            $emailPhone = $request->input('staff_email_phone')[$index];
            if (filter_var($emailPhone, FILTER_VALIDATE_EMAIL)) {
                if (User::where('email', $emailPhone)->exists()) {
                    $errors['staff_email_phone.' . $index] = 'Already exsiting Email is Present in one of your rows.';
                } else {
                    $data['email'] = $emailPhone;
                }
            } else {
                if (User::where('phone', $emailPhone)->exists()) {
                    $errors['staff_email_phone.' . $index] = 'Already existing Phone is Present in one of your rows';
                } else {
                    $data['phone'] = $emailPhone;
                }
            }
    
            // Generate a random password
            $password = Str::random(12);
            $data['password'] = bcrypt($password);
            $data['school_id'] = auth()->user()->school_id;
            $data['middle_name'] = $password;
            $data['usertype'] = $request->input('staff_role')[$index]; // Set usertype based on staff_role
    
            $staffData[] = $data;
        }
    
        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
    
        // Insert the staff data into the appropriate table columns
        foreach ($staffData as $data) {
            User::create($data);
        }
    
        return response()->json(['success' => true]);
    }

    public function details(Request $request)
    {

        $staff = User::where('id', $request->staff_id)->where('school_id', auth()->user()->school_id)->first();
        $registered = $staff->created_at->diffForHumans();
        $school_name = School::select('username')->where('id', auth()->user()->school_id)->first();

        if ($staff) {
            return response()->json([
                'status' => 200,
                'staff' => $staff,
                'registered' => $registered,
                'school_name' => $school_name,
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'No User Found',
        ]);
    }

    public function getStaffDetails(Request $request)
    {

        $staff = User::find($request->staff_id);
        $school_username = School::select('username')->where('id', auth()->user()->school_id)->first();

        if ($staff) {
            return response()->json([
                'staff' => $staff,
                'school_username' => $school_username,
                'status' => 200,
            ]);
        }

        return response()->json([
            'subjects' => 'staff Not Found',
            'status' => 404,
        ]);
    }

    public function editstaff(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'usertype' => 'required',
            'email' => [
                Rule::unique('users')->ignore($request->userId)->where(function ($query) {
                    return $query->whereNotNull('email');
                }),
            ],
            'phone' => [
                Rule::unique('users')->ignore($request->userId)->where(function ($query) {
                    return $query->whereNotNull('phone');
                }),
            ],
        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        $school = School::select('username')->where('id', auth()->user()->school_id)->first();

        $staff = User::find($request->userId);
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->usertype = $request->usertype;
        
        if ($request->file('image') != null) {
            $destination = public_path('uploads/' . $school->username);
        
            // Create the directory if it doesn't exist
            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }
        
            // Delete the old image if it exists
            if ($staff->image) {
                $existingImagePath = $destination . '/' . $staff->image;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
        
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
        
            $image = Image::make($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 80);
        
            // Save the image in the desired directory
            $image->save($destination . '/' . $filename);
        
            $staff->image = $filename;
        }
        
        
        
        

        $staff->update();

        return response()->json([
            'status' => 200,
            'message' => 'staff Profile Updated Successfully',
        ]);
    }

    public function delete(Request $request)
    {
        $userId = $request->input('user_id');

        try {
            $user = User::findOrFail($userId);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user.'], 500);
        }
    }
}
