@section('breadcrumbs')
<div class="breadcrumbs">
  @php
  $segments = array_filter(explode('/', str_replace(route('voyager.dashboard'), '', Request::url())));
  $url = route('voyager.dashboard');
  @endphp
  @if(count($segments) == 0)
      <a href="{{ route('voyager.dashboard')}}" title="{{ __('voyager::generic.dashboard') }}">{{ __('voyager::generic.dashboard') }}</a>
  @else
      <a href="{{ route('voyager.dashboard')}}" title="{{ __('voyager::generic.dashboard') }}"> {{ __('voyager::generic.dashboard') }}</a>
      @foreach ($segments as $segment)
          @php
          $url .= '/'.$segment;
          $name = ucfirst(urldecode($segment));
          if(!is_numeric($name) && __('hotdesk.crumbs_'.strtolower($name)) != 'hotdesk.crumbs_'.strtolower($name))
            $name = __('hotdesk.crumbs_'.strtolower($name));
          @endphp
          @if ($loop->last)
              <a href="{{ $url }}" title="{{ ucfirst(urldecode($segment)) }}">{{ $name }}</a>
          @else
              <a href="{{ $url }}" title="{{ ucfirst(urldecode($segment)) }}">{{ $name }}</a>
          @endif
      @endforeach
  @endif
</div>
@show
