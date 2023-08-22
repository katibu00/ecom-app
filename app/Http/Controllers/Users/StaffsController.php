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
    
    public function paginate()
    {
        $school_id = auth()->user()->school_id;
        $data['staffs'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
            ->where('usertype', '!=', 'std')
            ->where('usertype', '!=', 'parent')
            ->where('usertype', '!=', 'intellisas')
            ->where('school_id', $school_id)
            ->where('status', 1)
            ->orderBy('first_name')
            ->paginate(15);
        $data['school'] = School::select('username')->where('id', auth()->user()->school_id)->first();
        return view('users.staffs.table', $data)->render();
    }

    public function create()
    {

        return view('users.staffs.create');
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
    

    

    public function sort(Request $request)
    {
        $data['school'] = School::select('username')->where('id', auth()->user()->school_id)->first();

        if ($request->sort_staffs == 'all') {
            $data['staffs'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
                ->where('usertype', '!=', 'std')
                ->where('usertype', '!=', 'parent')
                ->where('usertype', '!=', 'intellisas')
                ->where('school_id', auth()->user()->school_id)
                ->orderBy('first_name')
                ->paginate(50000);
        } else {

            $data['staffs'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
                ->where('usertype', '!=', 'std')
                ->where('usertype', '!=', 'parent')
                ->where('usertype', '!=', 'intellisas')
                ->where('school_id', auth()->user()->school_id)
                ->where('status', $request->sort_staffs)
                ->orderBy('first_name')
                ->paginate(50000);
        }

        if ($data['staffs']->count() > 0) {
            return view('users.staffs.table', $data)->render();
        } else {
            return response()->json([
                'status' => 404,
            ]);
        }
    }

    public function search(Request $request)
    {

        $school_id = auth()->user()->school_id;
        $data['school'] = School::select('username')->where('id', $school_id)->first();

        $data['staffs'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request['query'] . '%')->orWhere('last_name', 'like', '%' . $request['query'] . '%');
            })
            ->where('usertype', '!=', 'std')
            ->where('usertype', '!=', 'parent')
            ->where('usertype', '!=', 'intellisas')
            ->where('school_id', $school_id)
            ->orderBy('first_name')
            ->paginate(100000);

        if ($data['staffs']->count()) {
            return view('users.staffs.table', $data)->render();
        } else {
            return response()->json([
                'status' => 404,
            ]);
        }

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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        $school = School::select('username')->where('id', auth()->user()->school_id)->first();

        $staff = User::find($request->edit_staff_id);
        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->usertype = $request->usertype;

        if ($request->file('image') != null) {
            $destination = 'uploads/' . $school->username . '/' . $staff->image;
            File::delete($destination);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            $image = Image::make($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 80);

            $image->save('uploads/' . $school->username . '/' . $filename);

            $staff->image = $filename;
        }

        $staff->update();

        return response()->json([
            'status' => 200,
            'message' => 'staff Profile Updated Successfully',
        ]);
    }
}
