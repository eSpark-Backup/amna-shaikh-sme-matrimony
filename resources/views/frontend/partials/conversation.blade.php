@if(isset($chat_user) && !empty($chat_user))
<div class="chat-main">
    <div class="current-chat-head flex">
        <div class="currently-active flex">
            <?php
            $photo_url = '';
            if (!empty($chat_user)) {
                $photo_url = ($chat_user->profile_image) ? asset('storage/members/profile-image/' . $chat_user->profile_image) : asset('images/placeholder.png');
                $sender_photo_url = (auth()->user()->profile_image) ? asset('storage/members/profile-image/' . auth()->user()->profile_image) : asset('images/placeholder.png');
            }
            ?>
            <div class="chat-image {{$chat_user->picture_privacy == 'blur' ? 'blur_img' : ''}}" style="background-image: url({{ $photo_url}});">

            </div>

            <div class="current-active-info">
                @if (!empty($chat_user))
                <h5>{{ getUserName($chat_user->first_name.' '.$chat_user->last_name) }}</h5>

                <!--  <span>online</span> -->
                <p>{{$chat_user->age}} Yrs, {{$chat_user->height}}, {{ isset($chat_user->state->name)? $chat_user->state->name:'---' }}, {{ isset($chat_user->country->name)?$chat_user->country->name:'---' }}</p>
                @endif
            </div>
        </div>
        @if(isset($active_plan) && $active_plan == 1)
        <div class="chat-options">
            <div class="chat-dots"><span></span><span></span><span></span></div>
            <div class="chat-act">
                <ul>
                    <li><a href="#">Delete</a></li>
                </ul>
            </div>
        </div>
        @endif
    </div>

    @if(isset($active_plan) && $active_plan == 0)

    @if (isset($oneHavePlan) && $oneHavePlan == 1)
    <!-- <div class="chat_top_fix_cls">
                        <p>The other member has paid to send you messages, and you both can send unlimited messages. But if you want to unlock the same feature with other members, please upgrade<a class="btn btn-secondary" href="{{ url('plans?redirect_url=').url('user/chats?id=').$requestChatId }}">Upgrade Plan</a></p>
                    </div> -->
    <!-- <div class="chat_top_fix_cls">
                        <a href="{{ url('plans?redirect_url=').url('user/chats?id=').$requestChatId }}">
                            <div class="chat_top_cls">
                                <div class="chat_top_left">
                                    <img src="https://cdn3.iconfinder.com/data/icons/email-133/32/Email_email_envelope_letter_message_fast-256.png">
                                </div>
                                <div class="chat_top_right">
                                    <h4>Unlock <span class="blur-message user-name">Test User</span> Message</h4>
                                    <p>Click to upgrade your membership!</p>
                                </div>
                            </div>
                        </a>
                        
                    </div> -->

    @else
    <!-- <div class="chat_top_fix_cls">
                        <a href="{{ url('plans?redirect_url=').url('user/chats?id=').$requestChatId }}">
                            <div class="chat_top_cls">
                                <div class="chat_top_left">
                                    <img src="https://cdn3.iconfinder.com/data/icons/email-133/32/Email_email_envelope_letter_message_fast-256.png">
                                </div>
                                <div class="chat_top_right">
                                    <h4>Unlock <span class="blur-message user-name">Test User</span> Message</h4>
                                    <p>Click to upgrade your membership!</p>
                                </div>
                            </div>
                        </a>
                           
                    </div> -->
    @endif
    @endif

    <div class="current-chat-body" id="currentChat">
        <div class="d-flex flex-column">
            @if( isset($chat) && !empty($chat) )
            <?php $last_array_index = end($chat); ?>

            @foreach($chat as $I => $K)

            @if( $K->sender_id == auth()->user()->id )
            @if(!empty($K->msg_file))
            <?php
            $img = '';

            $img = ($K->msg_file) ? asset('storage/members/chat/' . $K->msg_file) : asset('images/user-placeholder.jpg');
            ?>
            <div class="sender-sms sender-sms-img generic-append d-flex justify-content-end p-0">
                <a href="{{ $img }}" data-fancybox="gallery">
                    <img class="sender-img" style="width: 14rem" src="{{ $img }}">
                    <!-- <span>{{ $K->d_time }}</span>
                                            @if($K->un_red == 1)
                                                <div class="sms-status"><img src="{{asset('assets/images/ticks.png')}}" alt="icon"></div>
                                            @else
                                                <div class="sms-status"><img src="{{asset('assets/images/s_tick.png')}}" alt="icon"></div>
                                            @endif -->
                </a>

                @if($K->instant_count == 1)
                <img class="instant-msg instant-msg-right" src="{{asset('assets/images/instant-msg.svg') }}">
                @endif
            </div>
            @else
            <div class="sender-sms generic-append">
                <div class="send_msg_cont">
                    <div class="msg_left_cls">
                        <p>{{ $K->message }}</p>
                        <!--  <span>{{ $K->d_time }}</span>
                                                @if($K->un_red == 1)
                                                    <div class="sms-status"><img src="{{asset('assets/images/ticks.png')}}" alt="icon"></div>
                                                @else
                                                    <div class="sms-status"><img src="{{asset('assets/images/s_tick.png')}}" alt="icon"></div>
                                                @endif -->

                        @if($K->instant_count == 1)
                        <img class="instant-msg instant-msg-right" src="{{asset('assets/images/instant-msg.svg') }}">
                        @endif
                    </div>
                    <!-- <div class="msg_right_cls">
                                                <img class="sender-img" src="{{ $sender_photo_url}}">
                                            </div> -->
                </div>
            </div>
            @endif
            @else
            @if(isset($oneHavePlan) && $oneHavePlan == 1)
            @if(!empty($K->msg_file))
            <?php
            $img = '';

            $img = ($K->msg_file) ? asset('storage/members/chat/' . $K->msg_file) : asset('images/user-placeholder.jpg');
            ?>
            <div class="receiving-sms generic-append d-flex justify-content-start">
                <div class="receiving-mesg">
                    <a href="{{ $img }}" data-fancybox="gallery">
                        <img class="receiving-img" style="width: 14rem" src="{{ $img }}"><span></a>

                    @if($K->instant_count == 1)
                    <img class="instant-msg instant-msg-left" src="{{asset('assets/images/instant-msg.svg') }}">
                    @endif
                </div>
            </div>
            @else
            <div class="receiving-sms generic-append d-flex justify-content-start">
                <div class="receiving_msg_cont">
                    <!-- <div class="msg_right_cls">
                                                        <img class="sender-img" src="{{ $photo_url}}">
                                                    </div> -->
                    <div class="receiving-mesg">
                        <p>{{ $K->message }}</p>
                        @if($K->instant_count == 1)
                        <img class="instant-msg instant-msg-left" src="{{asset('assets/images/instant-msg.svg') }}">
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @else
            <div class="receiving-sms generic-append position-relative ">
                <div class="receiving_msg_cont">
                    <!-- <div class="msg_right_cls">
                                                <img class="sender-img" src="{{ $photo_url}}">
                                            </div> -->
                    <div class="receiving-mesg">
                        <div class="blur-message">
                            <p>Please Buy Plan</p>
                            <span>18 Aug, 12:47 PM</span>
                        </div>
                        <div class="upgrade_msg">
                            <div class="upgrade_msg_inner">
                                <div class="profile_lock">
                                    <img src="https://cdn0.iconfinder.com/data/icons/google-material-design-3-0/48/ic_lock_48px-256.png" alt="Lock">
                                </div>
                                <div class="upgrade_plan_msg">
                                    <p>Upgrade your membership to read their message.</p>
                                    <div class="upgrade_plan_btn">
                                        <a href="{{ url('plans?redirect_url=').url('user/chats?id=').$requestChatId }}">Upgrade Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($last_array_index && $last_array_index->message_id == $K->message_id)
            <!-- <div class="uprgrade_plan_msg">
                                            <div class="blur_msg_cls">
                                                <span class="inner_blr_msg">Upgrade</span>
                                                <span>Upgrade your membership to read their message. </span>
                                            </div>
                                            <div class="upgrade_plan_btn">
                                                <a href="{{ url('plans') }}">Uprgrade Plan</a>
                                            </div>
                                        </div> -->
            @endif
            <!-- <div class="generic-append"></div> -->
            @endif
            @endif
            @endforeach
            @else
            <span class="generic-append"></span>
            @endif
        </div>
    </div>
    <!-- if(isset($active_plan) && $active_plan == 1) -->
    <div class="current-chat-footer">
        <div class="typing"></div>
        <form action="" method="post" id="message-form">
            <div class="send-field">
                <!-- <button type="button" class="add_photo"> -->
                <img src="{{asset('assets/images/media.svg') }}" alt="" class="add_photo">
                <!-- </button> -->
                <input type="text" placeholder="type something..." id="message">
                <input type="hidden" name="user_id_receiver" id="user_id_receiver" value="{{ $chat_user_id }}">
                <input type="file" id="file" name="file" style="display: none;">
                <!-- <img class="encrypt-send instant_message" src="{{asset('assets/images/encrypt-msg.svg') }}" alt="Instant"> -->
                <button type="button" id="btn-send" class="sendMsgBtn btn-custom-primary" style="margin:unset;"> <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>

                <!-- <a href="#" class="instant_message"> <i class="fa fa-commenting fa-2x" aria-hidden="true" style="color:red; font-size: 48px"></i>&nbsp;</a> -->

                <!-- <a href="#" class="add_photo"> <i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i>&nbsp;</a> -->

            </div>
        </form>
    </div>

    <!-- <div class="current-chat-footer">
                    <div class="typing"></div>
                    <div class="send-field"> -->
    <!-- <button type="button" class="add_photo"> -->
    <!--  <img src="{{asset('assets/images/media.svg') }}" alt="" data-toggle="modal" class="no_plan"> -->
    <!-- </button> -->
    <!--  <input type="text" placeholder="type something..." id="message">
                        <img class="no_plan" src="{{asset('assets/images/encrypt-msg.svg') }}" alt="Instant" style="    margin-right: 5px;" >
                        <button type="button" class="no_plan"> Send <img src="{{asset('assets/images/send.svg') }}" alt="icon" ></button>
                    </div>
                </div> -->

</div>
@else
<div class="chat-main">
    <div class="chat-head2">
    </div>
    <!-- <div class="data_not_found">
        <center><img width="400px" src="{{ URL::asset('images/Object.png')}}" alt=""></center> 
    </div> -->

    <div class="input-group mb-3">
        <span class="input-group-text"> <img src="{{ URL::asset('images/Vector.png')}}" style="width: 17px; height:15px" alt="">
        </span>
        <input type="text" class="form-control border-0" aria-label="Amount (to the nearest dollar)"  placeholder="Type a message" />
        <span class="input-group-text"><svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.26367 3.15137L2.26367 16.8311L17.4633 9.99122L2.26367 3.15137ZM3.78364 5.50257L13.7599 9.99122L3.78364 14.4799L3.78364 10.9234L10.6235 9.99122L3.78364 9.05905V5.50257Z" fill="#D42F8C" />
            </svg></span>
    </div>

</div>
@endif

<!-- Modal -->
<div class="modal fade" id="no_plan" tabindex="-1" aria-labelledby="no_planLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="no_planLabel">Ops! Something is Went Wrong</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="user_message_popup">Please upgrade your membership to send your message.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>