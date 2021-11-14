@include('includes.header')
<style>
    .post_p {
        color: #c0bbbb;
    }

    .actiondiv {
        display: flex;
        justify-content: space-between;
    }

    .post_action {
        display: flex;
        justify-content: space-between;
        display: none
    }

    .postdiv:hover .post_action {
        display: block;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-3">
            @include('includes.sidebar')
        </div>


        <div class="col-6" style="">
            @if(count($posts) > 0)
                @foreach($posts as $key)
                    <div class="card mb-3">
                        <div class="card-body postdiv">
                            <div class="actiondiv" style="">
                                <p class="post_p">Posted by: @if($key->pro_imagepath!='')<img
                                            src="{{url('/users')}}/{{$key->pro_imagepath}}"
                                            style="width:25px;height:25px;border-radius: 200px">@endif {{$key->username}}
                                </p>
                                <p class="post_p">{{$key->created_at}}</p>
                            </div>
                            <div class="post_img">
                                @if($key->imagepath!='')
                                    <img src="{{url('/images')}}/{{$key->imagepath}}"
                                         style="width:100%;border-radius: 5px">
                                @endif
                            </div>

                            <div class="post_des">
                                <p>{{$key->description}}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            @else
                <center><h4>There are no activated posts! </h4></center>
            @endif
        </div>

        <div class="col-3">

        </div>
    </div>

</div>
<script type="text/javascript">
    $(function () {
        $('.slink').removeClass('active');
        $('.slink_home').addClass('active');
    });
</script>

@include('includes.footer')

