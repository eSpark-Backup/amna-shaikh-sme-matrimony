<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Plan;
use App\Models\Country;
use App\Models\City;
use App\Models\Occupation;
use App\Models\UserImage;

class WebMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
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
        $on_behalf = Onbehalf::where(['id' => $this->on_behalf_id])->pluck('name')->toArray();
        $on_behalf_name = '';
        if (!empty($on_behalf)) {
            $on_behalf_name = implode(', ', $on_behalf);
        }

        $marital_status = Onbehalf::where(['id' => $this->marital_status_id])->pluck('name')->toArray();
        $marital_status_name = '';
        if (!empty($marital_status)) {
            $marital_status_name = implode(', ', $marital_status);
        }
        
        $userimages = UserImageResource::collection(UserImage::where('member_id',$this->id)->get() );
        
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
            'hash_id' => \Hashids::encode($this->id),
            
            "display_user_name" => \Illuminate\Support\Str::title($this->first_name.' '.substr($this->last_name, 0, 1) ),
            "on_behalf_id" => $this->on_behalf_id,
            "on_behalf" => $on_behalf_name,
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
            "marital_status" => $marital_status_name,
            "working_with_id" => $this->working_with_id,
            "nationality_id" => $this->nationality_id,
            "annual_income" => $this->annual_income,
            "timezone" => $this->timezone,
           
            "profile_image" => $this->profile_image,
            "profile_image_path" => checkImage(asset('storage/members/profile-image/' . $this->profile_image),'image-svgrepo-com.svg',$this->profile_image),
            'user_images' => $userimages,
            "created_at" => \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at), "UTC")->format('d M, Y'),
            "ip_address" => $this->ip_address,
           
            "country_id" => $this->country_id,
            "country" => $country_name,
           
            "city_id" => $this->city_id,
            "city" => $city_name,
            "state_id" => $this->state_id,
            "postal_code" => $this->postal_code,
            "education_id" => $this->education_id,
            "occupation_id" => $this->occupation_id,
            "occupation" => $this->occupation_name,
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
            
           
            
        ];
    }
}
