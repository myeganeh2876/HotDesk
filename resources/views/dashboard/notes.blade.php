<div class="notes @if(!Request::is('admin')) hid @endif">
    <button type="button" class="closenotes"></button>
    <h3>{{__('voyager::hotdesk.notes')}}</h3>
    <div class="textbox">
        <textarea id="note_text" placeholder="{{__('voyager::hotdesk.notes_text')}}"></textarea>
        <input type="hidden" name="status" value="red"/>
        <div class="bottom">
            <div class="notestatus">
                <span>{{__('voyager::hotdesk.notes_status')}}</span>
                <ul>
                    <li class="red active" data-id="red"></li>
                    <li class="yellow" data-id="yellow"></li>
                    <li class="green" data-id="green"></li>
                </ul>
            </div>
            <button disabled>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.006" viewBox="0 0 24 20.006">
                    <g transform="translate(24 -0.026) rotate(180)">
                        <path d="M-.986,1.971h-1.5A.986.986,0,0,1-3.473.986.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986.986.986,0,0,1-.986,1.971Z"
                              transform="translate(0 -1.529) rotate(-180)" fill="#52c0ef"/>
                        <path d="M-3.473.986A.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986a.986.986,0,0,1-.986.986h-1.5A.986.986,0,0,1-3.473.986Z"
                              transform="translate(0 -11.542) rotate(-180)" fill="#52c0ef"/>
                        <path d="M-22.475,9.128-5.452.116A.986.986,0,0,1-4.005.987V5.008h3A1,1,0,0,1,0,5.957.986.986,0,0,1-.986,6.979h-3.02v.515A1.127,1.127,0,0,1-5,8.614l-8.113.936a.452.452,0,0,0,0,.9L-5,11.384a1.126,1.126,0,0,1,1,1.119v2.518h3A1,1,0,0,1,0,15.971a.986.986,0,0,1-.985,1.022h-3.02v2.182A.815.815,0,0,1-4.945,20c-.519-.06,1.494.942-17.53-9.129a.986.986,0,0,1,0-1.742Z"
                              transform="translate(1.001 -0.026) rotate(-180)" fill="#52c0ef"/>
                    </g>
                </svg>
            </button>
        </div>
    </div>
    <div class="notelist">
        <div class="notestatus">
            <span>{{__('voyager::hotdesk.notes_list')}}</span>
            <ul>
                <li class="red active" data-id="red"></li>
                <li class="yellow" data-id="yellow"></li>
                <li class="green" data-id="green"></li>
            </ul>
        </div>
        <div class="list mCustomScrollbar" data-mcs-theme="dark">
            @foreach(Auth::user()->notes()->get() as $note)
                @php
                    $user = $note->user()->first();
                    if($note->user()->exists()){
                      if (\Illuminate\Support\Str::startsWith($user->avatar, 'http://') || \Illuminate\Support\Str::startsWith($user->avatar, 'https://')) {
                          $user_avatar = $user->avatar;
                      } else {
                          $user_avatar = Voyager::image($user->avatar);
                      }
                    }else{
                      $user_avatar = Voyager::image("users/default.png");
                    }
                @endphp

                <div class="item {{$note->status}}">
                    <div class="avatar">
                        <img src="{{$user_avatar}}" onerror="this.className='none'"
                             alt="{{$note->user()->exists() ? $user->name : ''}}"
                             title="{{$note->user()->exists() ? $user->name : ''}}"/>
                        <span>{{$note->user()->exists() ? strtoupper(substr($user->name, 0, 1)) : ''}}</span>
                    </div>
                    <div class="notedata">
                        <p>{{$note->content}}</p>

                        <div class="action">
                            @if($note->user_id == Auth::user()->id)
                                <button type="button" class="deletenote" data-id="{{$note->id}}">
                                    <span>{{__('voyager::hotdesk.notes_delete')}}</span></button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
