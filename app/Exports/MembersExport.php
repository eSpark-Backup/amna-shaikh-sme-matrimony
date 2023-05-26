<?php

namespace App\Exports;

use App\Models\Member;
use App\Models\Plan;
use App\Models\UserImage;
use App\Models\Onbehalf;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

use App\Models\Caste;
use App\Models\Education;
use App\Models\FamilyStatus;
use App\Models\FamilyValue;
use App\Models\Language;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\Occupation;
use App\Models\Religion;
use App\Models\Specialisation;
use App\Models\WorkingWith;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Resources\UserImageResource;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MembersExport implements WithMapping,WithHeadings,FromCollection
{

    protected $users;
    protected $mobile;
    protected $email;

    function __construct($users, $mobile,$email) {
        $this->users = $users;
        $this->mobile = $mobile;
        $this->email = $email;
        
    }
    public function collection(){
        return $this->users;
        // return Member::all();
    }
    public function map($member): array
    {
    	$plan_name = '';
    	$caste_name = '';
    	$education_name = '';
    	$familystatus_name = '';
    	$familyvalue_name = '';
    	$language_name = '';
    	$maritalstatus_name = '';
    	$nationality_name = '';
    	$occupation_name = '';
    	$religion_name = '';
    	$specialisation_name = '';
    	$workingwith_name = '';
    	
    	$plan = plan::where(['id' => $member->plan_id])->pluck('name')->toArray();
        
        if (!empty($plan)) {
            $plan_name = implode(', ', $plan);
        }
        $caste = Caste::where(['id' => $member->caste_id])->pluck('name')->toArray();
        if (!empty($caste)) {
            $caste_name = implode(', ', $caste);
        }
        else{
            $caste_name = '';
        }
        $partner_caste = Caste::where(['id' => $member->partner_caste_id])->pluck('name')->toArray();
        if (!empty($partner_caste)) {
            $partner_caste = implode(', ', $partner_caste);
        }
        else{
            $partner_caste = '';
        }

        $nationality = Nationality::where(['id' => $member->nationality_id])->pluck('name')->toArray();
        if (!empty($nationality)) {
            $nationality_name = implode(', ', $nationality);
        }
        $education = Education::where(['id' => $member->education_id])->pluck('name')->toArray();
        if (!empty($education)) {
            $education_name = implode(', ', $education);
        }
        else{
            $education_name ='';
        }
        $partner_education = Education::where(['id' => $member->partner_education_id])->pluck('name')->toArray();
        if (!empty($partner_education)) {
            $partner_education = implode(', ', $partner_education);
        }
        else{
            $partner_education ='';
        }
        $familystatus = FamilyStatus::where(['id' => $member->family_status_id])->pluck('name')->toArray();
        if (!empty($familystatus)) {
            $familystatus_name = implode(', ', $familystatus);
        }
        else{
            $familystatus_name=' ';
        }
        $partner_prefered_status = FamilyStatus::where(['id' => $member->partner_prefered_status])->pluck('name')->toArray();
        if (!empty($partner_prefered_status)) {
            $partner_prefered_status = implode(', ', $partner_prefered_status);
        }
        else{
            $partner_prefered_status=' ';
        }



        $familyvalue = FamilyValue::where(['id' => $member->family_value_id])->pluck('name')->toArray();
        if (!empty($familyvalue)) {
            $familyvalue_name = implode(', ', $familyvalue);
        }
        else{
            $familyvalue_name=' ';
        }
        $partner_family_value = FamilyValue::where(['id' => $member->partner_family_value_id])->pluck('name')->toArray();
        if (!empty($partner_family_value)) {
            $partner_family_value = implode(', ', $partner_family_value);
        }
        else{
            $partner_family_value=' ';
        }
        $partner_personal_value = FamilyValue::where(['id' => $member->partner_personal_value_id])->pluck('name')->toArray();
        if (!empty($partner_personal_value)) {
            $partner_personal_value = implode(', ', $partner_personal_value);
        }
        else{
            $partner_personal_value=' ';
        }

        $language = Language::where(['id' => $member->language_id])->pluck('name')->toArray();
        if (!empty($language)) {
            $language_name = implode(', ', $language);
        }
        else{
            $language_name = ' ';
        }
        $mother_language = Language::where(['id' => $member->mother_language_id])->pluck('name')->toArray();
        if (!empty($mother_language)) {
            $mother_language = implode(', ', $mother_language);
        }
        else{
            $mother_language = ' ';
        }
        $speek_language = Language::where(['id' => $member->speek_language_id])->pluck('name')->toArray();
        if (!empty($speek_language)) {
            $speek_language = implode(', ', $speek_language);
        }
        else{
            $speek_language = ' ';
        }
        $read_language = Language::where(['id' => $member->read_language_id])->pluck('name')->toArray();
        if (!empty($read_language)) {
            $read_language = implode(', ', $read_language);
        }
        else{
            $read_language = ' ';
        }
        $partner_mother_language = Language::where(['id' => $member->partner_mother_language_id])->pluck('name')->toArray();
        if (!empty($partner_mother_language)) {
            $partner_mother_language = implode(', ', $partner_mother_language);
        }
        else{
            $partner_mother_language = ' ';
        }

        $occupation = Occupation::where(['id' => $member->occupation_id])->pluck('name')->toArray();
        if (!empty($occupation)) {
            $occupation_name = implode(', ', $occupation);
        }
        else{
            $occupation_name = '';
        }
        $father_occupation = Occupation::where(['id' => $member->father_occupation_id])->pluck('name')->toArray();
        if (!empty($father_occupation)) {
            $father_occupation = implode(', ', $father_occupation);
        }
        else{
            $father_occupation = '';
        }

        $religion = Religion::where(['id' => $member->religion_id])->pluck('name')->toArray();
        if (!empty($religion)) {
            $religion_ame = implode(', ', $religion);
        }
        else{
            $religion_ame='';
        }

        $partner_religion = Religion::where(['id' => $member->partner_religion_id])->pluck('name')->toArray();
        if (!empty($partner_religion)) {
            $partner_religion = implode(', ', $partner_religion);
        }
        else{
            $religion_ame='';
        }
        $working = WorkingWith::where(['id' => $member->working_with_id])->pluck('name')->toArray();
        if (!empty($working)) {
            $working_name = implode(', ', $working);
        }
        $specialisation = Specialisation::where(['id' => $member->working_with_id])->pluck('name')->toArray();
        if (!empty($specialisation)) {
            $specialisation_name = implode(', ', $specialisation);
        }

      	$userimages = UserImageResource::collection(UserImage::where('member_id',$member->id)->get() );

        switch ($member->gender) {
            case 0:
                $gender = 'Male';
                break;
            case 1:
                $gender = 'Female';
                break;
            case 2:
                $gender = 'Transgender';
                break;
        }
        switch ($member->is_approved) {
            case 0:
                $approved = 'Pending';
                break;
            case 1:
                $approved = 'Approved';
                break;
            case 2:
                $approved = 'Block';
                break;
            case 3:
                $approved = 'Canceled';
                break;
        }
        
        



        $mobile_verified = ($member->mobile_verified == 1) ? 'Yes' : 'No';
        $drinking = ($member->drinking == 1) ? 'Yes' : 'No';
        $smoking = ($member->smoking == 1) ? 'Yes' : 'No';
        $partner_drinking_habits = ($member->partner_drinking_habits == 1) ? 'Yes' : 'No';
        $partner_smoking_habits = ($member->partner_smoking_habits == 1) ? 'Yes' : 'No';
        if($member->is_approved ==0){
            $is_approved='Pending';
        }
        elseif($member->is_approved ==1){
            $is_approved='Approved';
        }
        elseif($member->is_approved ==2){
            $is_approved='Block';
        }
        elseif($member->is_approved ==3){
            $is_approved='Cancel';
        }
        else{
            $is_approved='';
        }
        $partner_desablity = ($member->partner_desablity == 1) ? 'Yes' : 'No';




        $on_behalf = Onbehalf::where(['id' => $member->on_behalf_id])->pluck('name')->toArray();
        $behalf_name = '';
        if (!empty($on_behalf)) {
            $behalf_name = implode(', ', $on_behalf);
        }
        $country = Country::where(['id' => $member->country_id,])->pluck('name')->toArray();
        $country_name = '';
        if (!empty($country)) {
            $country_name = implode(', ', $country);
        }

        $birthday_country = Country::where(['id' => $member->birthday_country_id,])->pluck('name')->toArray();
        if (!empty($birthday_country)) {
            $birthday_country = implode(', ', $birthday_country);
        }
        else{
            $birthday_country = '';
        }
        $residency_country = Country::where(['id' => $member->residency_country_id,])->pluck('name')->toArray();
        if (!empty($residency_country)) {
            $residency_country = implode(', ', $residency_country);
        }
        else{
            $residency_country = '';
        }
        $citizenship_country = Country::where(['id' => $member->citizenship_country_id,])->pluck('name')->toArray();
        if (!empty($citizenship_country)) {
            $citizenship_country = implode(', ', $citizenship_country);
        }
        else{
            $citizenship_country = '';
        }
        $growup_country = Country::where(['id' => $member->growup_country_id,])->pluck('name')->toArray();
        if (!empty($growup_country)) {
            $growup_country = implode(', ', $growup_country);
        }
        else{
            $growup_country = '';
        }
        $partner_prefered_country = Country::where(['id' => $member->partner_prefered_country_id,])->pluck('name')->toArray();
        if (!empty($partner_prefered_country)) {
            $partner_prefered_country = implode(', ', $partner_prefered_country);
        }
        else{
            $partner_prefered_country = '';
        }
        $partner_country_residence = Country::where(['id' => $member->partner_country_residence_id,])->pluck('name')->toArray();
        if (!empty($partner_country_residence)) {
            $partner_country_residence = implode(', ', $partner_country_residence);
        }
        else{
            $partner_country_residence = '';
        }

        $partner_marital_status = MaritalStatus::where(['id' => $member->partner_marital_status_id,])->pluck('name')->toArray();
        if (!empty($partner_marital_status)) {
            $partner_marital_status = implode(', ', $partner_marital_status);
        }
        else{
            $partner_marital_status = '';
        }
        $maritalstatus_name = MaritalStatus::where(['id' => $member->martial_status,])->pluck('name')->toArray();
        if (!empty($maritalstatus_name)) {
            $maritalstatus_name = implode(', ', $maritalstatus_name);
        }
        else{
            $maritalstatus_name = '';
        }


        

        
        $state = State::where(['id' => $member->state_id,])->pluck('name')->toArray();
        $state_name = '';
        if (!empty($state)) {
            $state_name = implode(', ', $state);
        }
        $partner_prefered_state = State::where(['id' => $member->partner_prefered_state_id,])->pluck('name')->toArray();
        if (!empty($partner_prefered_state)) {
            $partner_prefered_state = implode(', ', $partner_prefered_state);
        }
        else{
            $partner_prefered_state = '';
        }
        $city = City::where(['id' => $member->city_id,])->pluck('name')->toArray();
        $city_name = '';
        if (!empty($city)) {
            $city_name = implode(', ', $city);
        }


        if ( ($this->mobile == 1) && ($this->email == 1)){
            return [
                $member->mobile,
                $member->email,
            ];
        }
        elseif ( ($this->mobile == 1) && ($this->email == 0)){
            return [
                $member->mobile,
            ];
        }
        elseif ( ($this->mobile == 0) && ($this->email == 1)){
            return [
                $member->email,
            ];
        }
        else {


            return [
                $member->id,
                $plan_name,
                $member->first_name,
                $member->last_name,
                $member->mobile,
                $member->code,
                $mobile_verified,
                $member->email,
                \Carbon\Carbon::createFromTimeStamp(strtotime($member->email_verified_at), "UTC")->format('d M, Y'),
                $behalf_name,
                $gender,
                \Carbon\Carbon::createFromTimeStamp(strtotime($member->date_of_birth), "UTC")->format('d M, Y'),
                $country_name,
                $state_name,
                $city_name,
                $nationality_name,
                $caste_name,
                $member->height,
                $maritalstatus_name,
                $member->kids,
                $education_name,
                $specialisation_name,
                $member->job_id,
                $workingwith_name,
                $member->about,
                $member->timezone,
                $is_approved,
                $member->status,
                $member->ip_address,
                $drinking,
                $smoking,
                $member->star_sign,
                $language_name,
                $occupation_name,
                $member->annual_income,
                $member->looking_for_id,
                $member->postal_code,
                $member->weight,
                $member->eye_color,
                $member->hair_color,
                $member->complexion,
                $member->blood_group,
                $member->body_type,
                $member->body_art,
                $member->any_desability,
                $mother_language,
                $speek_language,
                $read_language,
                $birthday_country,
                $residency_country,
                $member->immigration_status,
                $religion_name,
                //$member->caste_id,
                $member->ethniciy,
                $member->personal_value,
                $familyvalue_name,
                $member->community_value,
                $familystatus_name,
                $member->manglik,
                ////
                $member->star_sign,
                $member->father_name,
                $member->mother_name,
                $member->brothers_sisters,
                $member->home_district,
                $member->family_residence,
                $father_occupation,
                $member->special_circumstances,
                $member->partner_general_requirement,
                $member->partner_age,
                $member->partner_height,
                $member->partner_weight,
                $partner_marital_status,
                $member->partner_with_children_acceptable,
                $partner_country_residence,
                $partner_religion,
                $partner_education,
                $partner_caste,
                $member->partner_profession,
                $member->partner_complexion,
                $partner_drinking_habits,
                $partner_smoking_habits,
                $member->partner_diet,
                $member->partner_body_type,
                $partner_personal_value,
                $member->partner_manglik,
                $partner_desablity,
                $partner_mother_language,
                $partner_family_value,
                $partner_prefered_status,
                $partner_prefered_country,
                $partner_prefered_state,
                $citizenship_country,
                $growup_country,

                \Carbon\Carbon::createFromTimeStamp(strtotime($member->created_at), "UTC")->format('d M, Y'),
            ];
        }
    }
    public function headings(): array
    {
        if ( ($this->mobile == 1) && ($this->email == 1)){
            return [
                'Mobile','Email'
            ];
        }
        elseif ( ($this->mobile == 1) && ($this->email == 0)){
            return [
                'Mobile'
            ];
        }
        elseif ( ($this->mobile == 0) && ($this->email == 1)){
            return [
                'Email'
            ];
        }
        else {
            return [
                    'id','Plan','First Name','Last Name','Mobile','Code','Mobile Verified','Email','Email Verified At','On Behalf','Gender','Date of Birth','Country','State','City','Nationality','Caste','Height','Martial Status','Kids','Education','Specialization','Job','Working With','About','Timezone','Approved','Status','Ip Address','Drinking','Smoking','Star Sign','Language','Occupation','Annual Income','Looking For','Postal Code','Weight','Eye Color','Hair Color','Complexion','Blood Group','Body Type','Body Art','Any Desability','Mother Language','Speek Language','Read Language','Birthday Country','Residency Country','Immigration Status','Religion','Ethniciy','Personal Value','Family Value','Community Value','Family Status','Manglik','Star Sign','Father Name','Mother Name','Brothers Sisters','Home District','Family Residence','Father Occupation','Special Circumstances','Partner General Requirement','Partner Age','Partner Height','Partner Weight','Partner Marital Status','Partner With Children Acceptable','Partner Country Residence','Partner Religion','Partner Education','Partner Caste','Partner Profession','Partner Complexion','Partner Drinking Habits','Partner Smoking Habits','Partner Diet','Partner Body Type','Partner Personal Value','Partner Manglik','Partner Desablity','Partner Mother Language','Partner Family Value','Partner Prefered Status','Partner Prefered Country','Partner Prefered State','Citizenship Country','Growup Country'
                ];
        }
    }
}
