<!DOCTYPE html>
<html lang="en">
<head>
  
    <style>

        

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .head{
        width:100%;
        height:300px;
        background-image: -webkit-linear-gradient(top, red 0%, blue 100%);
    }

    .user-profile-section {
    margin-bottom: 100px;
}
.empty-banner {
    height: 200px;
    background-color:rgb(189,42,130);
    opacity: 0.95;
}
.container {
    width: 90%;
    margin: 0 auto;
    position: relative;
    
}
.user-profile-left {
    width: 200px;
    margin-top: -195px;
    margin-top: -135px;
    z-index: 9;
}

.user-profile-image {
    background: #f1f1f1;
    border-radius: 10px;
    width:100%;
}


.user-profile-image .mid {
    width: 100%;
    padding: 10px;
}
.user-profile-image .mid img {
    width: 100%;
    width:90%;
}

.mesg-btn {
    background:  #6c41b6;
    border-radius: 8px;
    margin-top: 10px;
    display: block;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 8px;
    font-size: 10px;
    font-weight: 500;
    color: #fff;
}

.mesg-btn img {
    margin-right: 12px;
}
.profile-photos {
    margin-top: 20px;
}
.profile-photos h4 {
    color: #6e3076;
    font-size: 16px;
    margin-bottom: 12px;
}

h4 {
    font-family: "DM Serif Display", serif;
}
.profile-photos ul {
    padding-top:15px;
}
.profile-photos li {
    padding-top: 5px;
    width: 32%;
    list-style-type: none;
    display: inline-block;
}

.profile-photos li a {
    display: block;
}
.profile-gal {

    width: 100%;
    height: 60px;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 5px;

}


/* Center Section */


.user-profile-center {
    width: calc(100% - 720px);
    width:263px;
    padding: 0 15px;
    z-index: 9;
    position: absolute;
    top:-116px;
    left: 200px;

}
.profile-top-head.flex {
    padding-bottom: 42px;
    align-items: flex-end;
}

.profile-left-titles {
    width: 100%;
}
.profile-actionss {
    width: 45%;
}
.profile-left-titles h2 {
    color: #fff;
    font-size: 25px;
    margin-bottom: 10px;
}
.profile-left-titles h2 span {
    font-size: 12px;
    font-family: "Helvetica";
    color: rgba(255, 255, 255, 0.7);
}
.profile-left-titles span {
    margin-right: 20px;
}
.profile-left-titles span {
    color: #fff;
    font-size: 13px;
    margin-right: 20px;
}
.profile-left-titles span:nth-child(2){
    display:block;
    margin-top:10px;
}

.profile-left-titles span img {
    display: inline-block;
    margin-right: 10px;
    margin-top: -2px;
    width: 10px;
}

.profile-main-body {
    padding: 15px;
    background: #ffffff;
    box-shadow: 0px 0px 23px rgb(0 0 0 / 8%);
}

.profile-main-body h4 {
    color: #6e3076;
    margin-bottom: 20px;
    font-size: 22px;
}
.profile-main-body p {
    color: #1e2b32;
    margin-bottom: 20px;
    opacity: 0.6;
    font-size: 12px;
}


/* Right Section */

.user-profile-right {
    width: 220px;
    padding-top: 50px;
    position: absolute;
    top:0px;
    right: 0px;
}

.basic-row.flex {
    align-items: center;
    justify-content: space-between;
}
.basic-row h4 {
    color: #6e3076;
    font-size: 22px;
    margin-bottom: 20px;
}
.quick-info-row {
    padding-bottom: 20px;
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.3);
}
.quick-info-row span {
    color: #697083;
    font-size: 13px;
    margin-right: 5px;
    background: rgba(187, 198, 202, 0.2);
    padding: 5px;
    margin-bottom: 5px;
    display: inline-block;
}
.quick-info-row span img {
    display: inline-block;
    margin-right: 8px;
    width: 10px;
}

.basic-info-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 10px;
    position: relative;
    background-color: white;
    height:20px;
}
.basic-info-row span {
    color: rgba(30, 43, 50, 0.62);
    font-size: 13px;
    position: absolute;
    left: 0;
}
.basic-info-row h6 {
    font-size: 13px;
    color: rgba(30, 43, 50, 0.62);
    position: absolute;
    right: 0;
}  

.profile-actionss a {
    background: rgba(255, 255, 255, 0.18);
    width: 33.33%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    padding: 10px 5px;
    font-size: 14px;
    border-right: 1px solid rgba(255, 255, 255, 0.3);
}
.profile-actionss a img {
    margin-right: 6px;
    margin-top: -3px;
}

.basic-info.with_line {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.3);
}

  
    </style>
</head>
<body>
    
<!-- <div class="head" style="background-image: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet);"></div> -->
    <section class="user-profile-section">
        <div class="empty-banner" style=""></div>
        <div class="container">
            <div class="user-profile-row flex">
                <div class="user-profile-left">
                    <div class="user-profile-image">
                        <div class="mid">
                            
                            <img src="{{$profile_image}}" alt="image">
                        </div>

                    </div>
                    <!-- <a href="#" class="mesg-btn">Public View</a> -->
                    
                    <div class="profile-photos">
                        <h4>Photos from {{ $member->first_name }} {{ $member->last_name }}:</h4>
                        <ul>

                            @foreach($userimages as $K => $V)
                                @php
                                    $image = checkImage(asset('storage/members/profile-image/' . $V->user_image),'avatar.png',$V->user_image,1);
                                @endphp

                                <li>
                                    <a href="#">
                                        <div class="profile-gal" style="background-image: url('{{$image}}');"></div>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="user-profile-center">
                    <div class="profile-top-head flex">
                        <div class="profile-left-titles">
                            <h2>{{ $member->first_name }} {{ $member->last_name }}. <span>({{$occupation}})</span></h2>
                            <span><img src="{{url('assets/images/location_white.png')}}" alt="">{{ $city }}, {{ $country }}</span>
                            <span><strong>ID:</strong>#B0D773296026</span>
                        </div>
                    </div>
                    <div class="profile-main-body">
                        <h4>Profile Information:</h4>
                        <p>{{ $member->about }}</p>
                        <h4>More Information:</h4>
                        <p>Eros venenatis finibus. Nunc nec facilisis ligula. Donec non quam metus. Fusce semper velit sed purus condimentum, sed consectetur justo ornare. Morbi ut enim egestas, vestibulum turpis ac, sodales nibh. Etiam feugiat non ipsum eu accumsan. Aenean ac est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                        <p>Est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                    </div>
                </div>
                <div class="user-profile-right">
                    <div class="basic-row flex">
                        <h4>Quick Information:</h4>
                    </div>
                    <div class="quick-info-row flex">
                        <span><img src="{{url('assets/images/birthday.png')}}" alt="icon">{{ $age }} year</span>
                        <span><img src="{{url('assets/images/diamond1.png')}}" alt="icon">{{ $marital_status }}</span>
                        <span><img src="{{url('assets/images/map1.png')}}" alt="icon">{{ $nationality }}</span>
                        <span><img src="{{url('assets/images/radio1.png')}}" alt="icon">{{ $caste }}</span>
                        <span><img src="{{url('assets/images/bars1.png')}}" alt="icon">{{ $height }} feet</span>
                        <span><img src="{{url('assets/images/female.png')}}" alt="icon">{{ $gender }}</span>
                    </div>
                    <div class="basic-info with_line">
                        <div class="basic-row flex">
                            <h4>Basic Information:</h4>
                        </div>
                        <div class="basic-info-row" sytle="height:30px;">
                            <span>Full Name</span>
                            <h6>{{ $member->first_name }} {{ $member->last_name }}</h6>
                        </div>
                        <!-- <div class="basic-info-row">
                            <span>Gender</span>
                            <h6>{{ $gender }}</h6>
                        </div> -->
                        <!-- <div class="basic-info-row">
                            <span>Age</span>
                            <h6>{{ $age }}</h6>
                        </div> -->
                        <!-- <div class="basic-info-row">
                            <span>Marital Status</span>
                            <h6>{{ $marital_status }}</h6>
                        </div> -->
                        <div class="basic-info-row">
                            <span>Education</span>
                            <h6>{{ $education }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Family Status</span>
                            <h6>{{ $family_status }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Number of Children</span>
                            <h6>{{ $kids }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>On Behalf</span>
                            <h6>{{ $on_behalf }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Specialisation</span>
                            <h6>{{ $specialisation }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Working</span>
                            <h6>{{ $working }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Religion</span>
                            <h6>{{ $religion }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Mother Language</span>
                            <h6>{{ $mother_language }}</h6>
                        </div>
                        <!-- <div class="basic-info-row">
                            <span>Caste</span>
                            <h6>{{ $caste }}</h6>
                        </div> -->
                        <!-- <div class="basic-info-row">
                            <span>Area</span>
                            <h6>{{ $state }} ,{{ $country }}</h6>
                        </div> -->
                    </div>
                    <div class="basic-info">
                        <div class="basic-row flex">
                            <h4>Partner Expectation:</h4>
                            <!-- <a href="#"><img src="assets/images/edit.png" alt="icon"></a> -->
                        </div>
                        <div class="basic-info-row">
                            <span>Marital Status</span>
                            <h6>{{ $partner_marital_status }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Age</span>
                            <h6>{{ $partner_age }}</h6>
                        </div>
                        
                        <div class="basic-info-row">
                            <span>Country</span>
                            <h6>{{ $partner_prefered_country }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Education</span>
                            <h6>{{ $partner_education }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Height</span>
                            <h6>{{ $partner_height }} feet</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Family Status</span>
                            <h6>{{ $partner_family_status }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Number of Children</span>
                            <h6>{{ $partner_with_children_acceptable }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Religion</span>
                            <h6>{{ $partner_religion }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Mother Language</span>
                            <h6>{{ $partner_mother_language }}</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Caste</span>
                            <h6>{{ $partner_caste }}</h6>
                        </div>
                        <!-- <div class="basic-info-row">
                            <span>Area</span>
                            <h6>{{ $partner_prefered_state }} ,{{ $country }}</h6>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>