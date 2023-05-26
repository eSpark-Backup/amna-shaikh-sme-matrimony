<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id','first_name','last_name','mobile','code','mobile_verified','email','email_verified_at','password','original_password','on_behalf_id','gender','date_of_birth','country_id','state_id','city_id','nationality_id','caste_id','height','martial_status_id','kids','education_id','specialization_id','job_id','working_with_id','about','profile_image','timezone','is_approved','status','last_login','ip_address','social_id','social_type','firebase_token','device_id','marital_status_id','drinking','smoking','star_sign','language_id','occupation_id','annual_income','looking_for_id','postal_code','weight','eye_color','hair_color','complexion','blood_group','body_type','body_art','any_desability','mother_language_id','speek_language_id','read_language_id','birthday_country_id','residency_country_id','immigration_status','religion_id','caste_id','ethniciy','personal_value','family_value_id','community_value','family_status_id','manglik','star_sign','father_name','mother_name','brothers_sisters','home_district','family_residence','father_occupation_id','special_circumstances','partner_general_requirement','partner_age','partner_height','partner_weight','partner_marital_status_id','partner_with_children_acceptable','partner_country_residence_id','partner_religion_id','partner_education_id','partner_caste_id','partner_profession','partner_complexion','partner_drinking_habits','partner_smoking_habits','partner_diet','partner_body_type','partner_personal_value','partner_manglik','partner_desablity','partner_mother_language_id','partner_family_value_id','partner_prefered_status','partner_prefered_country_id','partner_prefered_state_id','citizenship_country_id','growup_country_id','stripe_customer','stripe_payment_method','uuid','picture_privacy','gallery_image','auto_recurring','total_action_pending','terms_conditions'
    ];
    protected $hidden = [
        'password',
    ];
    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }

    

    public function occupation()
    {
        return $this->belongsTo('App\Models\Occupation', 'occupation_id', 'id');

       
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id');
    }public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }
    public function partner_prefered_country()
    {
        return $this->belongsTo('App\Models\Country', 'partner_prefered_country_id');
    }
    public function partner_residence_country()
    {
        return $this->belongsTo('App\Models\Country', 'partner_country_residence_id');
    }
    public function caste()
    {
        return $this->belongsTo('App\Models\Caste', 'caste_id');
    }
    public function partner_caste()
    {
        return $this->belongsTo('App\Models\Caste', 'partner_caste_id');
    }
    public function marital_status()
    {
        return $this->belongsTo('App\Models\MaritalStatus', 'marital_status_id');
    }
    public function partner_marital_status()
    {
        return $this->belongsTo('App\Models\MaritalStatus', 'partner_marital_status_id');
    }
    public function education()
    {
        return $this->belongsTo('App\Models\Education', 'education_id');
    }
    public function partner_education()
    {
        return $this->belongsTo('App\Models\Education', 'partner_education_id');
    }
    public function family_status()
    {
        return $this->belongsTo('App\Models\FamilyStatus', 'family_status_id');
    }
    public function family_value()
    {
        return $this->belongsTo('App\Models\FamilyValue', 'family_value_id');
    }
    public function partner_family_value()
    {
        return $this->belongsTo('App\Models\FamilyValue', 'partner_family_value_id');
    }
    public function partner_family_status()
    {
        return $this->belongsTo('App\Models\FamilyStatus', 'partner_prefered_status');
    }
    public function on_behalf()
    {
        return $this->belongsTo('App\Models\Onbehalf', 'on_behalf_id');
    }
    public function specialisation()
    {
        return $this->belongsTo('App\Models\Specialisation', 'specialization_id');
    }
    public function working()
    {
        return $this->belongsTo('App\Models\WorkingWith', 'working_with_id');
    }
    public function religion()
    {
        return $this->belongsTo('App\Models\Religion', 'religion_id');
    }
    public function partner_religion()
    {
        return $this->belongsTo('App\Models\Religion', 'partner_religion_id');
    }
    public function mother_language()
    {
        return $this->belongsTo('App\Models\Language', 'mother_language_id');
    }
    public function language()
    {
        return $this->belongsTo('App\Models\Language', 'language_id');
    }
    public function partner_mother_language()
    {
        return $this->belongsTo('App\Models\Language', 'partner_mother_language_id');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }
    public function partner_prefered_state()
    {
        return $this->belongsTo('App\Models\State', 'partner_prefered_state_id');
    }
    public function nationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'nationality_id');
    }



    public function user_images()
    {
        return $this->hasMany('App\Models\UserImage', 'member_id');
    }
    
}