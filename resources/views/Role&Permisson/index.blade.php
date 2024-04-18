@extends('layouts.newapp')
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">

            <div class="bg-light rounded h-100 p-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light rounded h-100 p-4">

                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Create Permisson</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">All Permisson</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <form id="permissonForm" action="{{ route('permisson.create') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Permisson Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" name="permisson">
                                        <span id="error-permisson" style="color: red"></span>


                                    </div>

                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="h-100 bg-light rounded p-4" id="permissonList">


                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>





        </div>
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="bg-light rounded h-100 p-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Role</h6>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($role as $index => $roles)
                                    <button class="nav-link" id="nav-{{ $roles->name }}-tab"
                                        data-roleid="{{ $roles->id }}" data-bs-toggle="tab"
                                        data-bs-target="#nav-{{ $roles->name }}" type="button" role="tab"
                                        aria-controls="nav-{{ $roles->name }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ ucwords($roles->name) }}</button>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content pt-3" id="nav-tabContent">
                            @foreach ($role as $index => $roles)
                                <div class="tab-pane fade " id="nav-{{ $roles->name }}" role="tabpanel"
                                    aria-labelledby="nav-{{ $roles->name }}-tab">
                                    <div class="row">
                                        <div class="col ">
                                            <form id="permissonUpdate">
                                                @csrf
                                                @foreach ($permisson as $permissons)
                                                    <input type="hidden" name="roleid" value="{{ $roles->id }}">
                                                    <label for="">{{ $permissons->name }}</label>
                                                    <!-- Include unique value for each checkbox -->
                                                    <input type="checkbox" name="permissonId[]" class="form-group"
                                                        data-pid="{{ $permissons->id }}" value="{{ $permissons->id }}"  {{ $roles->permissions->contains('id', $permissons->id) ? 'checked' : '' }}>
                                                @endforeach
                                                <div class="mb-3">
                                                    <input type="submit" class="btn btn-primary" value="Update"
                                                        name="update">
                                                    <div class="d-flex justify-content-end">
                                                        <span id="msg" class="text-danger"></span>

                                                    </div>
                                                </div>

                                            </form>

                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>


        </div>


    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            // update permisson of role
            $('form#permissonUpdate').submit(function(event) {
                event.preventDefault();
                // Serialize form data
                var tabId = $(this).closest('.tab-pane').attr('id');
                // console.log(tabId);
                var formData = $(this).serialize();
                // AJAX request
                $('#msg').empty();
                $.ajax({
                    url: "{{ route('permissonUpdateOfRole') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Handle success response here
                        if (response) {
                            $('#msg').text(response.message);
                            setTimeout(function() {
                                $('#msg').text('');
                            }, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response here
                        console.error(xhr.responseText);
                    }
                });
            });




            // end



            $('#pills-profile-tab').on('click', function() {

                // fetch all permisson 
                $.ajax({
                    url: "{{ route('permisson.list') }}",
                    type: 'get',
                    dataType: 'JSON',
                    success: function(response) {
                        $('#permissonList').empty();
                        if (response) {
                            $.each(response, function(index, value) {

                                $('#permissonList').append(
                                    `
                        <div class="d-flex align-items-center border-bottom py-2 permission-container " >
                        <input class="form-check-input m-0" type="checkbox" data-pcheckbox="` + value.id + `">
                                    <div class="w-100 ms-3">
                                        <div class="d-flex w-100 align-items-center justify-content-between">
                                            <span>` + value.name + `</span>
                                            <button id="permissonCross" class="btn btn-sm" data-pid="` + value.id + `"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    </div>


                        `
                                );

                            });


                        }
                    }

                });
                // // end 

            });

            // crete permisson start
            $('#permissonForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('permisson.create') }}",
                    type: 'post',
                    data: formData,
                    dataType: 'JSON',
                    success: function(response) {
                        console.log(response);
                        if (response) {

                            Swal.fire({
                                title: "Good job!",
                                text: response.success,
                                icon: "success"
                            });
                            $('#permissonForm')[0].reset();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        // Display validation errors
                        $.each(errors, function(key, value) {
                            // Assuming you have an element with id 'error-' + key to display errors
                            $('#error-' + key).html(value);
                        });
                    }
                })

            });
            // permison create end 

            // permison delete with cross symbol  
            $(document).on('click', '#permissonCross', function(e) {
                e.preventDefault();
                var $button = $(this); // Store a reference to the button element

                var pid = $button.data('pid');
                $.ajax({
                    url: "{{ route('permisson.delete') }}",
                    type: 'GET',
                    data: {
                        pid: pid
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        $button.closest('.permission-container').remove();
                        Swal.fire({
                            title: "Good job!",
                            text: 'Deleted Successfully !.',
                            icon: "success"
                        });
                    }
                });
            });
        });
    </script>
@endsection
