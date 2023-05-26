@extends('app')
@section('title', 'Story Detail')
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
@endsection
@section('content')
<!-- Events Banner -->
<section class="event_section" style="background-image: url('assets/images/event_bg.png');">
    <div class="events_overlay">
        <div class="container">
            <div class="events_content">
                <h2>{{ $stories->title }}</h2>
            </div>
        </div>
    </div>
</section>
<section class="stories-gallery py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                     {!! $stories->description !!}
                    @if(isset($stories->gallery) && !empty($stories->gallery))
                        <div class="video-content row">
                            @php $gellary = explode(',',$stories->gallery)  @endphp
                            @foreach($gellary as $K => $V)
                                <div class="col-md-3 text-center single_photo">
                                    <a href="{{ getImage($V,'story_detail') }}" data-fancybox="gallery"><img src="{{ getImage($V,'story_detail') }}" alt="image"></a>
                                </div>
                                
                            @endforeach
                        </div>
                    @endif
                </div>
        </div>
    </div>
</section>
@endsection

@section('js')
 <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //toggle the component with class accordion_body
        
    });
</script>
@endsection