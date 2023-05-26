
    <div class="notification-sec">
      <div class="notification_wrap">
        <div class="unread_notification noti_space">
          <p>{{$member->body}}</p>
          <div class="time_remove">
            <div class="noti_time">
              <span>{{ date('M d, Y', strtotime($member->created_at))}}</span>
            </div>
            <div class="noti_remove">
              <span>
                <a href="javascript:void(0)" onclick="deleteNotification(this)" data-id="{{ $member->id }}">
                  <img src="{{ asset('assets/images/delete.png') }}">
                </a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>