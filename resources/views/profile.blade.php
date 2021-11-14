@include('includes.header')
<style>
    .post_p{
        color:#c0bbbb;
    }
    .actiondiv{
        display: flex;justify-content: space-between;
    }
    .post_action{
        display: flex;justify-content: space-between;
        display: none
    }
    .postdiv:hover .post_action{
        display: block;
    }
    #chang_pro{
        position: absolute;
        display:none;
        border-radius: 5px;
        cursor: pointer;
    }
    .prodiv:hover #chang_pro{
        display:block;
    }
    .chang_pro img{
       
        
    }
    #prosave{
        display: none;
    }
</style>

<div class="container" style="">
    <div class="row" style="">
        <div class="col-12" style="">
            <div class="card mb-3">
                <div class="card-body">
                    

                    <div class="row">

                        <div class="col-3 prodiv" >
                            <div id="chang_pro" onclick="change_pro()" style=";background: #3030308c;color:white;padding-right:3px">
                               <center> <span><img id="" src="{{url('site_images')}}/camera.png" style="width:100%;border-radius: 10px; width:30px;height: 30px;padding:3px"> Change</span></center>
                            </div>
                            <div style="height: 180px;width: 180px;overflow: hidden;border-radius: 100%;border-style: dotted;border-color: #00b447;border-width: 5px;">
                            <img id="pro_image" src="{{url('users')}}/{{$u_img->pro_imagepath}}" style="width:100%;border-radius: 10px">
                            </div>
                            <div>
                            <form class="mt-2" method="post" action="{{url('/change_pro')}}"  enctype="multipart/form-data">
                                 {{ csrf_field() }}
                            <input type="file" id="pro_pic" name="pro_pic" hidden>

                            <input type="submit" style="width:180px" class="btn form-control btn-primary" id="prosave" name="" value="Save">
                            
                            </form>
                            </div>
                        </div>
                        <div class="col-9">
                            <h1>{{session()->get('user_name')}}</h1>
                        </div>
                        <img src="">
                    </div>

                </div>
            </div>
        </div>
        <div class="col-3" style="">
        @include('includes.sidebar')
    </div>
        <div class="col-6" style="">
            @if(count($posts) > 0)
                @foreach($posts as $key)
            <div class="card mb-3">
                <div class="card-body postdiv">
                    <div class="actiondiv" style="">
                    <p class="post_p">Posted by: {{session()->get('user_name')}}</p> <p class="post_p">{{$key->created_at}}</p>
                    </div>
                    <div class="post_img">
                        @if($key->imagepath!='')
                    <img src="{{url('/images')}}/{{$key->imagepath}}" style="width:100%;border-radius: 5px">
                    @endif
                    </div>
                    <div class="post_action paction{{$key->pid}} mt-2">
                        <a href="{{ url('edit', $key->pid) }}" type="button " style="width:100px"  value="Edit" class="btn  btn-sm btn-primary">Edit</a>
                        @if($key->status=="draft")
                        <input type="button " style="width:100px" id="active_btn" onclick="activate({{$key->pid}},this,1) " value="Activate" class="btn  btn-sm btn-primary">
                        @else
                        <input type="button " style="width:100px" id="draft_btn"  onclick="activate({{$key->pid}},this,2) " value="Draft" class="btn  btn-sm btn-primary">
                        @endif
                         <a href="{{ url('delete') }}/{{$key->pid}}" type="button " style="width:100px"  value="Edit" class="btn  btn-sm btn-primary">Delete</a>
                        <!-- <input type="button " style="width:100px" value="Disable" class="btn  btn-sm btn-primary"> -->
                    </div>
                    <div class="post_des">
                    <p>{{$key->description}}</p>
                    </div>
                </div>
                
            </div>
                @endforeach
                @else
                <center><h4>You have no posts go to create post to create your post! </h4></center>
            @endif
        </div>
  

    </div>

</div>
<script>


    $(function() {
    // alert('sd');
        $('.slink').removeClass('active');
        $('.slink_profile').addClass('active');
    });

    function activate(id,$this,value){
   
        // post activate and draft function
         $.ajax({
            type:'POST',
            url:'/activate_poste',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":id,
                "value":value,
                
            },
            success:function(data) {

               if(data.status=="true"){
//                    alert('hari');
                   // window.location.href = data.msg;
                   $($this).css('display','none');
                   // alert(value);
                   if(value==1){
                    var vau='draft';
                  // append ativate and draft button acordingly
                    $('.paction'+id).append('<input type="button " style="width:100px" id="draft_btn"  onclick="activate('+id+',this,2) " value="Draft" class="btn  btn-sm btn-primary">');
                    // $('#draft_btn').css('display','block');
                   }else{
                    var valu='active';
                    $('.paction'+id).append('<input type="button " style="width:100px" id="active_btn"  onclick="activate('+id+',this,1) " value="Activate" class="btn  btn-sm btn-primary">');
                   }
               }else{
                   alert('Somthing went wrong');
               }
            }
        });
    }
    function edit(id){

         $.ajax({
            type:'POST',
            url:'/edit',
            data: {
                "_token": "{{ csrf_token() }}",
                "id":id,
               
                
            },
            success:function(data) {

            }
        });
    }
    
function readURL(input) {
//        alert('awa');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#pro_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#pro_pic").change(function(){
//        alert('asd');
        readURL(this);
        // alert($(this).val());
        if($(this).val()!=''){
            $('#prosave').css('display','block');
        }else{
            $('#prosave').css('display','none');

        }
    });
    function change_pro(){

        $("#pro_pic").click();
    }

</script>
@include('includes.footer')