@extends('app')
@section('title', 'Member Detail')
@section('style')
<link type="text/css" rel="stylesheet" href="{{ asset('assets/lightgellary/css/lightgallery.css') }}" />
@endsection
@section('content')
<!-- Profile Page -->
<section class="user-profile-section prersonal-prof">
    <div class="empty-banner"></div>
    <div class="container">
        <div class="user-profile-row flex">
            <div class="user-profile-left">
                <?php $photo_url = checkImage(asset('storage/members/profile-image/' . $member->profile_image),'',$member->profile_image,1);  ?>
                <div class="user-profile-image"><img src="{{$photo_url }}" alt="image"></div>
                <a href="{{url('user/picture-privacy')}}" class="btn-custom-primary"><span>Picture Privacy</span></a>
                @if(isset($user_images) && count($user_images) > 0)
                    <div class="profile-photos">
                        <h4>Photos:</h4>
                        <ul id="lightgallery">
                            @foreach($user_images as $K => $V)
                            <?php 
                                            $photo_url = ($V->user_image) ? asset('storage/members/profile-image/'.$V->user_image) : asset('images/user-placeholder.jpg');
                                        ?>
                            <li data-src="{{$photo_url}}">

                                <a href="{{$photo_url}}">
                                    <img src="{{$photo_url}}" class="profile-gal" />
                                    <!--  <div class="profile-gal" style="background-image: url({{$photo_url}});"></div> -->
                                </a>
                            </li>

                            @endforeach

                        </ul>
                    </div>
                @endif
            </div>
            <div class="user-profile-center">
                <div class="profile-top-head flex">
                    <div class="profile-left-titles">
                        <h2>{{ $member['first_name'].' '.$member['last_name'] }}.
                            <span>({{(isset( $member->occupation->name))?  $member->occupation->name:'---' }})</span>
                            &nbsp; <span>Member#: ID{{ $member->id }}</span>
                            <a href="{{url('user/edit-profile')}}"><span><img
                                        src="{{ asset('assets/images/edit.png') }}" alt="icon">Edit Profile</span></a>

                        </h2>
                        
                        <span><img src="{{ asset('assets/images/location_white.png') }}"
                                alt="">{{ isset($member->city->name)?$member->city->name:'---' }},
                            {{ isset($member->country->name)?$member->country->name:'---' }}</span>
                    </div>

                </div>

                <div class="profile-main-body">
                    <h4>Account Basic Information:</h4>
                    @include('../../../admin.message')
                    <div class="table-responsive">            
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Member ID</th>
                                    <td colspan="3">#{{ $member->id }}</td>
                                    
                                </tr>
                                <tr>
                                    <th>Full Name</th>
                                    <td>{{$member['first_name'].' '.$member['last_name'] }}</td>
                                    <th>Date Of Birth</th>
                                    <td>{{ $member['date_of_birth']}}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>
                                        <?php
                                            if( $member['gender'] == 1){
                                                echo 'Female';
                                            }elseif( $member['gender'] == 0){
                                                echo 'Male';
                                            }else{
                                                echo 'Others';
                                            }
                                        ?>
                                    </td>
                                    <th>Age</th>
                                    <?php
                                        $from = new DateTime($member['date_of_birth']);
                                        $to   = new DateTime('today');
                                        $age = $from->diff($to)->y;
                                    ?>
                                    <td>{{$age}} Year</td>
                                </tr>
                                <tr>

                                    <th>Martial Status</th>
                                    <td>{{ isset($member->marital_status->name)? $member->marital_status->name:'---' }}</td>
                                    <th>Height</th>
                                    <td>{{ (isset($member['height']) && !empty($member['height']) )?$member['height']:'---' }}</td>
                                </tr>
                                <tr>
                                    <th>Looking For</th>
                                    <td>{{ isset($member->on_behalf->name)?$member->on_behalf->name:'---' }}</td>
                                    <th>Caste</th>
                                    <td>{{ isset($member->caste->name)? $member->caste->name:'---' }}</td>
                                </tr>
                                <tr>
                                    <th>Religion</th>
                                    <td>{{ isset($member->religion->name)? $member->religion->name:'---' }}</td>
                                    <th>Education</th>
                                    <td>{{ isset($member->education->name)? $member->education->name:'---' }}</td>
                                </tr>
                                <tr>
                                    
                                    <th>Occupation</th>
                                    <td>{{ isset($member->occupation->name)? $member->occupation->name:'---' }}</td>
                                    <th>City</th>
                                    <td>{{ isset($member->city->name)? $member->city->name:'---' }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ isset($member->state->name)? $member->state->name:'---' }}</td>
                                    <th>Country</th>
                                    <td colspan="3">{{ isset($member->country->name)?$member->country->name:'---' }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <h4>Introduction (About your family) </h4>
                    {{ $member['about'] }}
                </div>
            </div>
            <div class="user-profile-right">
                
                <div class="basic-info with_line">
                    <div class="basic-row flex">
                        <h5>Additional Personal Details:</h5>
                    </div>
                    <div class="basic-info-row">
                        <span>Nationality</span>
                        <h6>{{ isset($member->nationality->name)? $member->nationality->name:'---' }}</h6>
                    </div>
                    <div class="basic-info-row">
                        <span>Family Value</span>
                        <h6>{{ isset($member->family_value->name)? $member->family_value->name:'---' }}</h6>
                    </div>
                    <div class="basic-info-row">
                        <span>Language</span>
                        <h6>{{ isset($member->language->name)? $member->language->name:'---' }}</h6>
                    </div>
                    
                    <div class="basic-info-row">
                        <span>Star</span>
                        <h6>{{ isset($member->start_sign)?$member->start_sign:'---' }}</h6>
                    </div>
                    <div class="basic-info-row">
                        <span>Drinking</span>
                        <h6>{{ ($member->drinking == 0)?'No':'Yes' }}</h6>
                    </div>
                    <div class="basic-info-row">
                        <span>Smoking</span>
                        <h6>{{ ($member->smoking == 0)?'No':'Yes' }}</h6>
                    </div>
                </div>
                <div class="basic-info">
                    <div class="basic-row flex">
                        <h5>Education & Career:</h5>
                    </div>
                    <div class="basic-info-row">
                        <span>Specialization</span>
                        <h6>{{ isset($member->specialisation->name)? $member->specialisation->name:'---' }}</h6>
                    </div>
                    <div class="basic-info-row">
                        <span>Working With</span>
                        <h6>{{ isset($member->working->name)? $member->working->name:'---' }}</h6>
                    </div>
                    <div class="basic-info-row">
                        <span>Annual Income</span>
                        <h6>{{ isset($member->annual_income)? $member->annual_income:'---' }}</h6>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{ asset('assets/lightgellary/lightgallery.min.js') }}"></script>

<!-- lightgallery plugins -->
<script src="{{ asset('assets/lightgellary/plugins/thumbnail/lg-thumbnail.min.js') }}"></script>


<script type="text/javascript">
    lightGallery(document.getElementById('lightgallery'), {
        thumbnail: true,
    });
</script>
@endsection