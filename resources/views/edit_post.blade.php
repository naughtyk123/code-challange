@include('includes.header')


<div class="container" style="">
    <div class="row" style="">
        <div class="col-3" style="">
            @include('includes.sidebar')
        </div>
        <div class="col-6" style="">

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @foreach($posts as $key)
                                <img id="profile-img-tag" src="{{url('/images')}}/{{$key->imagepath}}"
                                     style="width:100%">
                        </div>
                        <form method="post" action="{{url('/edit_posti')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="image_loc" value="{{$key->imagepath}}">
                            <input type="hidden" name="id" value="{{$key->pid}}">

                            <div class="col-12">
                                <label>Image</label>
                                <input type="file" class="form-control" name="post_image" placeholder=""
                                       id="post_image">
                            </div>
                            <div class="col-12">
                                <label>Description</label>
                                <br>
                                <textarea id="post_des" class="form-controll" name="post_des" rows="4"
                                          style="width:100%;outline: 1px solid blue;">
                                {{$key->description}}
                            </textarea>
                            </div>
                            @endforeach
                            <div class="col-12 mt-3" style="display: flex;justify-content: center">

                                <input type="submit" class="btn btn-primary form-control" value="save"
                                       placeholder="Password">
                            </div>
                        </form>
                    </div>

                </div>
            </div>


        </div>


    </div>

</div>
<script>

    $(function () {
      
        $('.slink').removeClass('active');
        $('.slink_create').addClass('active');


    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            // show it in div
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#post_image").change(function () {
        // read selected image
        readURL(this);
    });


</script>

@include('includes.footer')

