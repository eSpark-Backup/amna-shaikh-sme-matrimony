<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Plan;
use App\Models\Country;
use App\Models\City;
use App\Models\Occupation;
use App\Models\UserImage;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $plan = plan::where(['id' => $this->plan_id])->pluck('name')->toArray();
        $country = country::where(['id' => $this->country_id])->pluck('name')->toArray();
        $country_name = '';
        if (!empty($country)) {
            $country_name = implode(', ', $country);
        }
        $city = city::where(['id' => $this->city_id])->pluck('name')->toArray();
        $city_name = '';
        if (!empty($city)) {
            $city_name = implode(', ', $city);
        }
        $occupation = occupation::where(['id' => $this->occupation_id])->pluck('name')->toArray();
        $occupation_name = '';
        if (!empty($occupation)) {
            $occupation_name = implode(', ', $occupation);
        }
        
        $userimages = UserImageResource::collection(UserImage::where('member_id',$this->id)->get() );

        $plan_details = PlanResource::collection(Plan::where('id',$this->plan_id)->get() );

        if (!empty($plan)) {
            $plan_name = implode(', ', $plan);
        }
        $intereststatus = '';
        if (isset($this->interest)) {
            $intereststatus = $this->interest;
        }
        switch ($this->gender) {
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
        return  [
            "id" => $this->id,
            "plan_id" => $this->plan_id,
            "plan_details" => $plan_details,
            'hash_id' => \Hashids::encode($this->id),
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "display_user_name" => \Illuminate\Support\Str::title($this->first_name.' '.substr($this->last_name, 0, 1) ),
            // "display_user_name" => \Illuminate\Support\Str::title($this->first_name.' '.$this->last_name ),
            "mobile" => $this->mobile,
            "code" => $this->code,
            "mobile_verified" => $this->mobile_verified,
            "email" => $this->email,
            "email_verified_at" => $this->email_verified_at,
            "original_password" => $this->original_password,
            "on_behalf_id" => $this->on_behalf_id,
            "gender" => $gender,
            "date_of_birth" => $this->date_of_birth,
          
            "height" => $this->height,
            "kids" => $this->kids,
            
            "about" => $this->about,
            "drinking" => $this->drinking,
            "smoking" => $this->smoking,
            "language_id" => $this->language_id,
            "looking_for_id" => $this->looking_for_id,
            "job_id" => $this->job_id,
            "specialization_id" => $this->specialization_id,
            "marital_status_id" => $this->marital_status_id,
            "working_with_id" => $this->working_with_id,
            "nationality_id" => $this->nationality_id,
            "annual_income" => $this->annual_income,
            "timezone" => $this->timezone,
            "is_approved" => $this->is_approved,
            "status" => $this->status,    
            "profile_image" => $this->profile_image,
            "profile_image_path" => checkImage(asset('storage/members/profile-image/' . $this->profile_image),'image-svgrepo-com.svg',$this->profile_image,1),
            'user_images' => $userimages,
            
            "interst_status" => $this->member_interested_id,
            "member_interested_id" => $intereststatus,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y'),
            "ip_address" => $this->ip_address,
            "social_id" => $this->social_id,
            "social_type" => $this->social_type,
            "firebase_token" => $this->firebase_token,
            "device_id" => $this->device_id,

            "country_id" => $this->country_id,
            "country" => $country_name,
           
            "city_id" => $this->city_id,
            "city" => $city_name,
            "state_id" => $this->state_id,
            "postal_code" => $this->postal_code,
            "education_id" => $this->education_id,
            "occupation_id" => $this->occupation_id,
            "occupation" => $occupation_name,
            "weight" => $this->weight,
            "eye_color" => $this->eye_color,
            "hair_color" => $this->hair_color,
            "complexion" => $this->complexion,
            "blood_group" => $this->blood_group,
            "body_type" => $this->body_type,
            "body_art" => $this->body_art,
            "any_desability" => $this->any_desability,
            "mother_language_id" => $this->mother_language_id,
            "speek_language_id" => $this->speek_language_id,
            "read_language_id" => $this->read_language_id,
            "birthday_country_id" => $this->birthday_country_id,
            "residency_country_id" => $this->residency_country_id,
            "citizenship_country_id" => $this->citizenship_country_id,
            "growup_country_id" => $this->growup_country_id,
            "caste_id" => $this->caste_id,
            "ethniciy" => $this->ethniciy,
            "personal_value" => $this->personal_value,
            "family_value_id" => $this->family_value_id,
            "community_value" => $this->community_value,
            "family_status_id" => $this->family_status_id,
            "manglik" => $this->manglik,
            "star_sign" => $this->star_sign,
            "father_name" => $this->father_name,
            "mother_name" => $this->mother_name,
            "brothers_sisters" => $this->brothers_sisters,
            "home_district" => $this->home_district,
            "family_residence" => $this->family_residence,
            "father_occupation_id" => $this->father_occupation_id,
            "special_circumstances" => $this->special_circumstances,
            "partner_general_requirement" => $this->partner_general_requirement,
            "partner_age" => $this->partner_age,
            "partner_height" => $this->partner_height,
            "partner_weight" => $this->partner_weight,
            "partner_marital_status_id" => $this->partner_marital_status_id,
            "partner_with_children_acceptable" => $this->partner_with_children_acceptable,
            "partner_country_residence_id" => $this->partner_country_residence_id,
            "partner_religion_id" => $this->partner_religion_id,
            "partner_education_id" => $this->partner_education_id,
            "partner_caste_id" => $this->partner_caste_id,
            "partner_profession" => $this->partner_profession,
            "partner_complexion" => $this->partner_complexion,
            "partner_drinking_habits" => $this->partner_drinking_habits,
            "partner_smoking_habits" => $this->partner_smoking_habits,
            "partner_diet" => $this->partner_diet,
            "partner_body_type" => $this->partner_body_type,
            "partner_personal_value" => $this->partner_personal_value,
            "partner_manglik" => $this->partner_manglik,
            "partner_desablity" => $this->partner_desablity,
            "partner_mother_language_id" => $this->partner_mother_language_id,
            "partner_family_value_id" => $this->partner_family_value_id,
            "partner_prefered_status" => $this->partner_prefered_status,
            "partner_prefered_country_id" => $this->partner_prefered_country_id,
            "partner_prefered_state_id" => $this->partner_prefered_state_id,
            "religion_id" => $this->religion_id,
            "immigration_status" => $this->immigration_status,
            "picture_privacy" => $this->picture_privacy
            
        ];
    }
}
