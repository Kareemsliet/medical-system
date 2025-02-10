<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Plan;
use Spatie\Permission\Models\Role;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search=$request->query("q","");
        $companies=Company::whereAny(["name","name_manager","phone_manager"],'like',"%$search%")->paginate(10);
        return view("panel.companies.index",compact("companies"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        $request->validated();

        $plan=Plan::find($request->input('plan_id'));

        $adminRole=Role::where('name','=',"admin")->first();

        $companyData=$request->only(['url','phone_manager','name_manager']);

        $companyData['name']=$request->company_name;

        $company=Company::create($companyData);
        
        $company->newPlanSubscription("main",$plan);
        
        $companyEmployee=$company->users()->create($request->only(['email','password']));

        $companyEmployee->employee()->create([
            'name'=>$request->admin_name,
        ]);

        $companyEmployee->assignRole($adminRole);

        return redirect()->route('companies.index')->with('message',"تم اضافة الشركة بنجاح");
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $company=Company::find($id);

        return view("panel.companies.show",compact("company"));
    }

    public function create(){
        return view("panel.companies.create",['plans'=>Plan::all()]);
    }

    public function show(string $id){
        $company=Company::findOrFail($id);

        return view("panel.companies.show",compact("company"));
    }
    public function cancelSupscription($company){
        
        $company=Company::findOrFail($company);

        if(!$company->planSubscription("main")->active()){
            return redirect()->back()->with('message',"الباقة غير  مفعلة");
        }

        $company->planSubscription("main")->cancel(true);

        return redirect()->back()->with("message","تم الغاء الباقة بنجاح");
    }

    public function updateSupscription($company){
        
        $company=Company::findOrFail($company);

        if($company->planSubscription("main")->canceled()){
            $company->planSubscription("main")->update([
                "canceled_at"=>null,
            ]);
        }

        $company->planSubscription("main")->renew();

        return redirect()->back()->with("message","تم تجديد الباقة بنجاح");
    }
}
