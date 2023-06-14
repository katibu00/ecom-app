<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\MonnifyAPISetting;
use App\Models\ReservedAccount;
use App\Models\School;
use App\Models\User;
use App\Models\Wallet;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ParentsController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['parents'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
            ->where('usertype', 'parent')
            ->where('school_id', $school_id)
            ->where('status', 1)
            ->orderBy('first_name')
            ->paginate(15);
        $data['school'] = School::select('username')->where('id', $school_id)->first();
        return view('users.parents.index', $data);
    }
    public function paginate()
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id', auth()->user()->school_id)->get();
        $data['parents'] = User::select('id', 'image', 'first_name', 'middle_name', 'last_name', 'login', 'gender', 'class_id', 'parent_id', 'status', 'address')->where('usertype', 'std')->where('school_id', auth()->user()->school_id)->where('status', 1)->with(['class', 'parent'])->orderBy('gender', 'desc')->orderBy('first_name')->paginate(15);
        $data['school'] = School::select('username')->where('id', auth()->user()->school_id)->first();
        return view('users.parents.table', $data)->render();
    }

    public function create()
    {
        $user['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('usertype', 'std')->where('school_id', auth()->user()->school_id)->where('status', 1)->with(['class'])->orderBy('first_name')->orderBy('last_name')->get();
        return view('users.parents.create', $user);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->first_name = $request->title . ' ' . $request->first_name;
        $user->last_name = $request->last_name;
        $user->usertype = 'parent';

        $login = $request->login;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        if ($fieldType == 'email') {
            $user->email = $request->login;
            $this->validate($request, [
                'login' => 'required|unique:users,email,',
            ]);
        } else {
            $user->phone = $request->login;
            $this->validate($request, [
                'login' => 'required|unique:users,phone,',
            ]);
        }
        $password = Str::random(7, 'abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()');

        $user->school_id = auth()->user()->school_id;
        $user->password = Hash::make($password);
        $user->middle_name = $password;
        $user->save();

        $rowCount = count($request->children);
        if ($rowCount != null) {
            for ($i = 0; $i < $rowCount; $i++) {
                $child = User::find($request->children[$i]);
                $child->parent_id = $user->id;
                $child->update();
            }
        };

        try {
            $accessToken = $this->getAccessToken();

            $monnifyReservedAccount = $this->createMonnifyReservedAccount($user, $accessToken);

            // Save Monnify reserved account details in the reserved_accounts table
            ReservedAccount::create([
                'user_id' => $user->id,
                'school_id' => $user->school_id,
                'customer_email' => $monnifyReservedAccount->customerEmail,
                'customer_name' => $monnifyReservedAccount->customerName,
                'accounts' => json_encode($monnifyReservedAccount->accounts),
            ]);

            // Create a wallet for the user
            Wallet::create([
                'school_id' => auth()->user()->school_id,
                'user_id' => $user->id,
                'balance' => 0,
            ]);

            Toastr::success("Parent Registered Successfully");
            return redirect()->route('users.parents.create');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    private function getAccessToken()
    {
        $monnifyAPISettings = MonnifyAPISetting::select('secret_key', 'public_key')->where('school_id', auth()->user()->school_id)->first();

        $apiKey = $monnifyAPISettings->public_key;
        $secretKey = $monnifyAPISettings->secret_key;

        // Encoding Monnify API_KEY and SECRET KEY
        $encodedKey = base64_encode($apiKey . ':' . $secretKey);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.monnify.com/api/v1/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Basic $encodedKey",
            ),
        ));

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception ("cURL Error: " . $err);
        }

        if ($httpStatus !== 200) {
            throw new \Exception ("Monnify API request failed. Error Response: " . $response);
        }

        $monnifyResponse = json_decode($response);

        if (!$monnifyResponse->requestSuccessful) {
            throw new \Exception ($monnifyResponse->responseMessage);
        }

        return $monnifyResponse->responseBody->accessToken;
    }

    private function createMonnifyReservedAccount(User $user, $accessToken)
    {
        $monnifyAPISettings = MonnifyAPISetting::select('contract_code')->where('school_id', auth()->user()->school_id)->first();
        // Generate account reference and account name
        $accountReference = uniqid('abc', true);
        $accountName = $user->first_name;

        // Other required parameters
        $currencyCode = 'NGN';
        $contractCode = $monnifyAPISettings->contract_code;
        $customerEmail = $user->email;
        $customerName = $user->first_name;
        $getAllAvailableBanks = true;

        $data = [
            'accountReference' => $accountReference,
            'accountName' => $accountName,
            'currencyCode' => $currencyCode,
            'contractCode' => $contractCode,
            'customerEmail' => $customerEmail,
            'customerName' => $customerName,
            'getAllAvailableBanks' => $getAllAvailableBanks,
        ];

        $jsonData = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken,
            ),
        ));

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception ("cURL Error: " . $err);
        }

        if ($httpStatus !== 200) {
            throw new \Exception ("Monnify API request failed. Error Response: " . $response);
        }

        $monnifyResponse = json_decode($response);

        if (!$monnifyResponse->requestSuccessful) {
            throw new \Exception ($monnifyResponse->responseMessage);
        }

        return $monnifyResponse->responseBody;
    }

    public function sort(Request $request)
    {
        $data['school'] = School::select('username')->where('id', auth()->user()->school_id)->first();

        if ($request->sort_parents == 'all') {
            $data['parents'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
                ->where('usertype', 'parent')
                ->where('school_id', auth()->user()->school_id)
                ->orderBy('first_name')
                ->paginate(50000);
        } else {

            $data['parents'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
                ->where('usertype', 'parent')
                ->where('school_id', auth()->user()->school_id)
                ->where('status', $request->sort_parents)
                ->orderBy('first_name')
                ->paginate(50000);
        }

        if ($data['parents']->count() > 0) {
            return view('users.parents.table', $data)->render();
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

        $data['parents'] = User::select('id', 'image', 'first_name', 'phone', 'last_name', 'login', 'usertype', 'status')
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request['query'] . '%')->orWhere('last_name', 'like', '%' . $request['query'] . '%');
            })
            ->where('usertype', 'parent')
            ->where('school_id', $school_id)
            ->orderBy('first_name')
            ->paginate(100000);

        if ($data['parents']->count()) {
            return view('users.parents.table', $data)->render();
        } else {
            return response()->json([
                'status' => 404,
            ]);
        }

    }

    public function details(Request $request)
    {

        $parent = User::where('id', $request->parent_id)->where('school_id', auth()->user()->school_id)->first();
        $registered = $parent->created_at->diffForHumans();
        $school_name = School::select('username')->where('id', auth()->user()->school_id)->first();

        if ($parent) {
            return response()->json([
                'status' => 200,
                'parent' => $parent,
                'registered' => $registered,
                'school_name' => $school_name,
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'No User Found',
        ]);
    }

    public function getParentDetails(Request $request)
    {

        $parent = User::find($request->parent_id);
        $school_username = School::select('username')->where('id', auth()->user()->school_id)->first();

        if ($parent) {
            return response()->json([
                'parent' => $parent,
                'school_username' => $school_username,
                'status' => 200,
            ]);
        }

        return response()->json([
            'subjects' => 'parent Not Found',
            'status' => 404,
        ]);
    }

    public function editParent(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            // 'name'=>'required',
            // 'school_email' => 'required|email',
            // 'address'=>'required',
            // 'school_phone' => 'required',
            // 'website' => 'required',
            // 'session_id' => 'required',
            // 'term' => 'required',
            // 'motto' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        $school = School::select('username')->where('id', auth()->user()->school_id)->first();

        $parent = User::find($request->edit_parent_id);
        $parent->first_name = $request->first_name;
        $parent->last_name = $request->last_name;
        $parent->login = $request->roll_number;

        if ($request->file('image') != null) {
            $destination = 'uploads/' . $school->username . '/' . $parent->image;
            File::delete($destination);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/' . $school->username, $filename);
            $parent->image = $filename;
        }

        $parent->update();

        return response()->json([
            'status' => 200,
            'message' => 'Parent Profile Updated Successfully',
        ]);
    }
}
