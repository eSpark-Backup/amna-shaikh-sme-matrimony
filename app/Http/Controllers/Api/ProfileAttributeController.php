<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\Language;
use App\Models\FamilyValue;
use App\Models\FamilyStatus;
use App\Models\MaritalStatus;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\Specialisation;
use App\Models\WorkingWith;
use App\Models\Nationality;
use App\Models\GeneralSetting;
use App\Http\Resources\ReligionResource;
use App\Http\Resources\CasteResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\FamilyValueResource;
use App\Http\Resources\FamilyStatusResource;
use App\Http\Resources\MaritalStatusResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\OccupationResource;
use App\Http\Resources\SpecialisationResource;
use App\Http\Resources\WorkingWithResource;
use App\Http\Resources\NationalityResource;
use App\Http\Resources\GeneralSettingsResource;

class ProfileAttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['socialLinks'] ]);
    }

    public function religions()
    {
        $s_data = ReligionResource::collection(Religion::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Religions list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function castes()
    {
        $s_data = CasteResource::collection(Caste::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Castes list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function languages()
    {
        $s_data = LanguageResource::collection(Language::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Lanugages list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function familyValues()
    {
        $s_data = FamilyValueResource::collection(FamilyValue::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Family Value list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function familyStatus()
    {
        $s_data = FamilyStatusResource::collection(FamilyStatus::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Family Status list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function maritalStatus()
    {
        $s_data = MaritalStatusResource::collection(MaritalStatus::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Marital Status list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function educations()
    {
        $s_data = EducationResource::collection(Education::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Education list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function occupations()
    {
        $s_data = OccupationResource::collection(Occupation::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Occupations list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function specialisations()
    {
        $s_data = SpecialisationResource::collection(Specialisation::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['Specialisations list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function workingWith()
    {
        $s_data = WorkingWithResource::collection(WorkingWith::where('status',1)->get());
            return response()->json([
                'status' => 1,
                'message' => array('message' => ['WorkingWith list']),
                'success_data' => array('data' => $s_data)
            ]);
    }
    public function nationality()
    {
        $s_data = NationalityResource::collection(Nationality::where('status',1)->get());
        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Nationality list']),
            'success_data' => array('data' => $s_data)
        ]);
    }
    public function socialLinks()
    {
        $s_data = GeneralSettingsResource::collection(GeneralSetting::where('id',1)->get());

        return response()->json([
            'status' => 1,
            'message' => array('message' => ['Social list']),
            'success_data' => array('data' => $s_data)
        ]);
    }
}
