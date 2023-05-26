<h4 class="setting-head">Settings menu</h4>
<ul class="list-group">
  <a href="{{url('/user/settings')}}"><li class="list-group-item {{ ($active == 'index')? 'active':'' }}" >Payment method connection status.</li></a>
  <a href="{{url('/user/settings/change-password')}}"><li class="list-group-item {{ ($active == 'change_password')? 'active':'' }}" >Change password</li></a>
  <a href="{{url('/user/settings/feedback')}}"><li class="list-group-item {{ ($active == 'feedback')? 'active':'' }}">Feedback</li></a>
  <a href="{{url('/user/settings/close-account')}}"><li class="list-group-item {{ ($active == 'close_account')? 'active':'' }}">Close account</li></a>
</ul>