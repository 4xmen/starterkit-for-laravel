<nav id="navbar" class="">
    <ul>
        <li>
            <a href="{{ url('/') }}">
                <i class="fa fa-atom"></i>
                {{ config('app.name', 'Laravel') }}
            </a>
        </li>




        <li id="posts-li">
            <a>
                <i class="fa fa-bullhorn"></i>
                {{__('Post')}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.post.index')}}">
                        {{__('Post list')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.post.create')}}">
                        {{__('New Post')}}
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{route('admin.comment.index')}}">
                <i class="fa fa-comments"></i>
                {{__('Comments')}}
            </a>
        </li>
        <li>
            <a href="{{route('admin.logs.index')}}">
                <i class="fa fa-list-alt"></i>
                {{__('Logs')}}
            </a>
        </li>
        <li>
            <a>
                <i class="fa fa-book"></i>
                {{__('Categories')}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.category.index')}}">
                        {{__('Categories list')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.category.create')}}">
                        {{__('New category')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.category.sort')}}">
                        {{__('Categories node')}}
                    </a>
                </li>
            </ul>


        </li>



        <li>
            <a >
                <i class="fa fa-images"></i>
                {{__("Galleries")}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.gallery.all')}}">
                        {{--                           <i class="fa fa-list-alt"></i> --}}
                        {{__("Gallery list")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.gallery.create')}}">
                        {{--                            <i class="fa fa-plus-square"></i>--}}
                        {{__("New gallery")}}
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a >
                <i class="fa fa-file-video"></i>
                {{__("Video clips")}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.clip.index')}}">
                        {{__("Video list")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.clip.create')}}">
                        {{__("New Video")}}
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a >
                <i class="fa fa-atom"></i>
                {{__("Advertise")}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.adv.index')}}">
                        {{__("Advertise list")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.adv.create')}}">
                        {{__("New Advertise")}}
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a href="{{route('admin.menu.index')}}" >
                <i class="fa fa-list-alt"></i>
                {{__("Menus")}}
            </a>
        </li>
        <li>
            <a >
                <i class="fa fa-file-image"></i>
                {{__("Slider")}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.slider.index')}}">
                        {{__("Slider list")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.slider.create')}}">
                        {{__("New Slider")}}
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a >
                <i class="fa fa-vote-yea"></i>
                {{__("Poll")}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.poll.index')}}">
                        {{__("Polls list")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.poll.create')}}">
                        {{__("New Poll")}}
                    </a>
                </li>
            </ul>

        </li>
        <li>
            <a >
                <i class="fa fa-users"></i>
                {{__("Users")}}
            </a>
            <ul>
                <li>
                    <a href="{{route('admin.user.all')}}">
                        {{--                           <i class="fa fa-list-alt"></i> --}}
                        {{__("Users list")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.user.create')}}">
                        {{--                            <i class="fa fa-plus-square"></i>--}}
                        {{__("New user")}}
                    </a>
                </li>
            </ul>

        </li>

        @guest
            <li >
                <a href="{{ route('login') }}"> <i class="fa fas fa-sign-in"></i> {{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li >
                    <a href="{{ route('register') }}"> <i class="fa fas fa-sign-in"></i> {{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fa fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest

    </ul>

</nav>
