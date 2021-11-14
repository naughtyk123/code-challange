@include('includes.header')
<style>
    body {
        background-image: url('https://media.istockphoto.com/photos/social-network-connecting-people-icon-3d-rendering-picture-id1282448244?b=1&k=20&m=1282448244&s=170667a&w=0&h=nLST2HMKcw0KI82O0axe5Z3L9NEFgdgEtRS-Tg_n_nY=');
        /*background-position: center;*/
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<div class="container" style="">
    <div class="row" style="justify-content: center">

        <div class="col-6" style="">
            {{--<div class="row">--}}
            {{--<div class="col-6" style="">--}}
            {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, adipisci at atque autem, cupiditate delectus dolorum fugiat fugit ipsa minus molestiae nisi optio porro repellat repudiandae soluta voluptate. Molestiae, molestias.</p>--}}
            {{--</div>--}}
            {{--<div class="col-6" style="">--}}
            <div class="card mb-3">
                <div class="card-body">
                    <ul id="errorul">

                    </ul>
                    <div class="row">
                        <div class="col-12">
                            <label>User Name</label>
                            <input type="text" class="form-control" placeholder="User Name" id="username">
                        </div>
                        <div class="col-12">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" id="password">
                        </div>
                        <div class="col-12">
                            <label>Confirme Password</label>
                            <input type="password" class="form-control" name="cf_password"
                                   placeholder="Confirme Password" id="cf_password">
                        </div>
                        <div class="col-12 mt-3" style="display: flex;justify-content: center">

                            <input type="button" class="btn btn-primary" onclick="login()" value="Login"
                                   placeholder="Password">
                        </div>
                    </div>

                </div>
            </div>
            {{--</div>--}}
            {{--</div>--}}

        </div>

    </div>

</div>
<script>
    
    function login() {
// register function
        $.ajax({
            type: 'POST',
            url: '/register_user',
            data: {
                "_token": "{{ csrf_token() }}",
                "username": $('#username').val(),
                "password": $('#password').val(),
                "cf_password": $('#cf_password').val(),
            },
            success: function (data) {

                if (data.status == 0) {
                    $('#errorul').html('');
                    $.each(data.error, function (prefix, val) {
                        $('#errorul').append('<li>' + val[0] + '</li>');
//                        $('span.'+prefix+'_error').text(val[0]);
                    });
                } else {
                    window.location.href = data.msg;
//                    $('#main_form')[0].reset();
//                    alert(data.msg);
                }

            }
        });
    }
</script>

@include('includes.footer')

