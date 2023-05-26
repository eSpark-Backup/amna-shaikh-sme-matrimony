<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Member extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id','first_name','last_name','mobile','code','mobile_verified','email','email_verified_at','password','original_password','on_behalf_id','gender','date_of_birth','country_id','state_id','city_id','nationality_id','caste_id','height','height_inches','martial_status_id','kids','education_id','specialization_id','job_id','working_with_id','about','profile_image','timezone','is_approved','status','last_login','ip_address','social_id','social_type','firebase_token','device_id','marital_status_id','drinking','smoking','language_id','occupation_id','annual_income','looking_for_id','postal_code','weight','eye_color','hair_color','complexion','blood_group','body_type','body_art','any_desability','mother_language_id','speek_language_id','read_language_id','birthday_country_id','residency_country_id','immigration_status','religion_id','ethniciy','personal_value','family_value_id','community_value','family_status_id','manglik','star_sign','father_name','mother_name','brothers_sisters','home_district','family_residence','father_occupation_id','special_circumstances','partner_general_requirement','partner_age','partner_height','partner_weight','partner_marital_status_id','partner_with_children_acceptable','partner_country_residence_id','partner_religion_id','partner_education_id','partner_caste_id','partner_profession','partner_complexion','partner_drinking_habits','partner_smoking_habits','partner_diet','partner_body_type','partner_personal_value','partner_manglik','partner_desablity','partner_mother_language_id','partner_family_value_id','partner_prefered_status','partner_prefered_country_id','partner_prefered_state_id','citizenship_country_id','growup_country_id','reason_termination','stripe_customer','stripe_payment_method','uuid','terms_conditions'
    ];

    /**;;
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function boot()
    {
      parent::boot();
      static::deleting(function($model)
      {

        /*
        ** Delete user's files
        */

        $path = 'storage/users/'.$model->id;
        if (\File::exists(public_path() . '/' . $path))
        {
          \File::deleteDirectory(public_path() . '/' . $path);
        }

      });
    }

    // ************************** //
    //        Relationships       //
    // ************************** //

    public function plan()
    {
        return $this->belongsTo(Models\Plan::class, 'plan_id');
    }

    public function user_images()
    {
        return $this->belongsTo(Models\UserImage::class, 'member_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'user_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function accountSettings()
    {
        return $this->hasOne('App\Models\AccountSetting', 'user_id');
    }

    // ************************** //
    //  Append Extra Attributes   //
    // ************************** //

    protected $appends = ['profile_image_path','hash_id'];

    public function getProfileImagePathAttribute()
    {
        return $this->attributes['profile_image_path'] = checkImage(asset('storage/members/profile-image/' . $this->profile_image),NULL,$this->profile_image);
    }

    public function getHashIdAttribute()
    {
        return $this->attributes['hash_id'] = \Hashids::encode($this->id);
    }

}
