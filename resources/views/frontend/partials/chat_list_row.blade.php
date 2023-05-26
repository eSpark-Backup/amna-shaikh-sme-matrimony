<ul>
   
    <li class="">
        <a href="{{ url('user/chats?id=12') }}">
            <div class="single-chat flex">
            	
                <div class="chat-image" style="background-image: url();">
                    <span class="status"></span>
                </div>
                <div class="chat-data">
                    <h5>
                       
                    </h5>
                    <p>{{ $row->message }}</p>
                </div>

                <span class="time">3 min</span>
                <!-- <span class="unread">3</span> -->
                
            </div>
        </a>
    </li>
        
</ul>