@extends('layouts.newapp')
@section('title','Createuser')
@section('content')
<div class="container-fluid pt-4 px-4">
<div class="row-g-4">

    <div class="col-lg-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4 text-center">Create User</h6>
            <form action="{{route('postUser')}}" method="post" id="myForm" >
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" class="form-control" 
                         id="name" name="name">
                        <span id="error-name"></span>
                    
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email"
                       name="email">
                    
                    <span id="error-email"></span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span id="error-password"></span>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
    
        $('#myForm').submit(function(e){
            e.preventDefault();
            var email = $('#email').val(); // Assuming your email input field has an id of 'email'
    
           // Email validation regular expression
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            // Check if the email matches the pattern
            if (!emailPattern.test(email)) {
                // Display error message for invalid email
                $('#error-email').html('Please enter a valid email address.');
                return; // Stop form submission
            }
            var formData=$(this).serialize();
            $.ajax({
                type:'POST',
                url:$(this).attr('action'),
                data:formData,
                success:function(response){
                           Swal.fire({
                                title: "Good job!",
                                text: response.success,
                                icon: "success"
                                });
                    $('#myForm')[0].reset();
                }, error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    // Display validation errors
                    $.each(errors, function (key, value) {
                        // Assuming you have an element with id 'error-' + key to display errors
                        $('#error-' + key).html(value);
                    });
                }
            })

        });
    
    });
</script>

@endsection
