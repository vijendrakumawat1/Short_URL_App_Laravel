<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyDashboardController extends Controller
{
    public function create()
    {
        return view('company.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:companies,email',
            'name'  => 'required|unique:companies,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'ERROR',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();
        if ($request->role === 'SuperAdmin' && empty($request->company_id)) {
            abort(403, 'SuperAdmin can’t invite an Admin in a new company.');
        }
        $company        = new Company();
        $company->name  = $request->name;
        $company->email = $request->email;
        $company->save();

        return redirect()->route('company.index')
            ->with('success', 'company sent successfully.');
    }
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'SuperAdmin') {
            $companies = Company::all();
        } else {
            $companies = Company::where('id', $user->company_id)->get();
        }
        return view('company.index', ['companies' => $companies]);
    }
}
