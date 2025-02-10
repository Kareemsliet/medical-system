<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Services\ImageService;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::first();

        return view('panel.setting.index', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingRequest $request)
    {

        $request->validated();

        $data = $request->only(['name', 'description', 'facebook_link', 'twitter_link']);

        $logo = (new ImageService())->uploadImage($request->file('logo'), "setting");

        $data['logo'] = $logo;

        Setting::create($data);

        return redirect()->route('setting.index')->with('message', "اضافة عنصر ينجاح");
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request, string $id)
    {

        $request->validated();

        $setting = Setting::find($id);

        $data = $request->only(['name', 'description', 'facebook_link', 'twitter_link']);

        if ($request->file("logo")) {

            (new imageService())->destroyImage($setting->logo, "setting");

            $logo = (new ImageService())->uploadImage($request->file('logo'), "setting");

            $data['logo'] = $logo;
        }

        $setting->update($data);

        return redirect()->route('setting.index')->with('message', "تحديث الاعدادات ينجاح");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $setting = Setting::findOrFail($id);

        (new imageService())->destroyImage($setting->logo, "setting");

        $setting->delete();

        return redirect()->route('setting.index')->with('message', "حذف الاعدادات ينجاح");
    }
}
