@extends('./../layouts.newapp')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="bg-light rounded h-100 p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="m-0">Basic Table</h6>
                    <div><input type="search" name="searchData" id="searchData" placeholder="search"></div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tabledata">


                    </tbody>
                </table>
                <div class="pagination">

                </div>
            </div>
        </div>

    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing data -->
                    <!-- Replace these with your actual form fields -->
                    <form action="{{ route('user.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="" id="editId">
                        <input type="text" id="editName" class="form-control mb-3" placeholder="Name">
                        <input type="email" id="editEmail" class="form-control" placeholder="Email" disabled>

                </div>


                <button type="button" class="btn btn-primary" id="updateUser">Update</button>

                </form>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // filter code start 
            $('#searchData').on('input', function() {
                var searchData = $(this).val();
                $.ajax({
                    url: "{{ route('search.data') }}", // Replace this with your actual search endpoint
                    method: 'GET',
                    data: {
                        searchData: searchData
                    },

                    success: function(response) {
                        $('#tabledata').empty();
                        console.log(response);
                        if (response) {
                            $.each(response, function(index, value) {

                                $('#tabledata').append(`<tr><th>` + value.id +
                                    `</th><th>` + value
                                    .name + `</th><th>` + value.email +
                                    `</th><th><button class="btn btn-outline-primary" id="edit-btn" data-id="` +
                                    value.id +
                                    `">Edit</button><button class="btn btn-outline-danger ms-4 delete-btn"  data-did="` +
                                    value.id + `">Delete</button></th></tr>`);

                            });
                        } else
                        {
                            loadTableData(currentPage);
                        }


                    }


                });
            });




            // filter code end
            var currentPage = 1;
            var itemsPerPage = 10;
            loadTableData(currentPage);

            function loadTableData(page) {
                $.ajax({
                    type: 'get',
                    url: '{{ route('user.list') }}',
                    data: {
                        page: page,
                        itemsPerPage: itemsPerPage
                    },
                    dataType: 'JSON',

                    success: function(response) {
                        console.log(response);
                        $('#tabledata').empty();
                        $.each(response.data, function(key, value) {

                            $('#tabledata').append(`<tr><th>` + value.id + `</th><th>` + value
                                .name + `</th><th>` + value.email +
                                `</th><th><button class="btn btn-outline-primary" id="edit-btn" data-id="` +
                                value.id +
                                `">Edit</button><button class="btn btn-outline-danger ms-4 delete-btn"  data-did="` +
                                value.id + `">Delete</button></th></tr>`);
                        });
                        $('.pagination').empty();
                        var currentPage = response.current_page;
                        var pagination = '<ul class="pagination">';
                        var totalPages = response.last_page;
                        var visiblePages = 5;
                        var half = Math.floor(visiblePages / 2);
                        console.log("half is " + half);
                        console.log(Math.max(1, currentPage - half));
                        console.log(Math.min(totalPages,
                            currentPage + half));
                        // Previous button
                        pagination +=
                            `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" data-page="${currentPage - 1}" href="#">Previous</a></li>`;


                        for (var i = Math.max(1, currentPage - half); i <= Math.min(totalPages,
                                currentPage + half); i++) {
                            pagination +=
                                `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" data-page="${i}" href="#">${i}</a></li>`;
                        }
                        // Next button
                        pagination +=
                            `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" data-page="${currentPage + 1}" href="#">Next</a></li>`;
                        pagination += '</ul>';
                        $('.pagination').append(pagination);

                    }
                });

            }
            $(document).on('click', '.page-link', function(e) {



                e.preventDefault();
                var pageno = parseInt($(this).attr('data-page'));
                loadTableData(pageno);


            });


            // Attach click event listener to the edit button
            $(document).on('click', '#edit-btn', function() {
                var id = $(this).data('id');

                // AJAX call to fetch data for the corresponding entry
                $.ajax({
                    url: "{{ route('user.edit') }}", // Replace with your endpoint for fetching entry data
                    method: 'GET',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Populate modal fields with fetched data
                        $('#editName').val(response.name);
                        $('#editEmail').val(response.email);
                        $('#editId').val(response.id);

                        // Show the modal
                        $('#editModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            });



            $('#updateUser').on('click', function() {

                var id = $('#editId').val();
                var newName = $('#editName').val();
                $.ajax({
                    url: "{{ route('user.update') }}", // Replace with your endpoint for updating user details
                    method: 'POST',
                    data: {
                        id: id,
                        name: newName,
                        _token: '{{ csrf_token() }}'

                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        $('#editModal').modal('hide');
                        Swal.fire({
                            title: "Good job!",
                            text: response.message,
                            icon: "success"
                        });





                    }
                });

            });
            $(document).on('click', '.delete-btn', function() {
                // Your delete button logic here
                var id = $(this).data('did');
                $.ajax({
                    url: "{{ route('user.delete') }}", // Replace 'delete.php' with the actual URL endpoint for deleting data
                    type: 'get', // Assuming you are using POST method, change as needed
                    data: {
                        id: id
                    }, // Data to be sent to the server
                    success: function(response) {
                        // If deletion is successful, you may want to remove the corresponding row from the table
                        // For example:
                        if (response) {
                            $(this).closest('tr').remove(); // Removes the row from the table
                            Swal.fire({
                                title: "Good job!",
                                text: response.msg,
                                icon: "success"
                            });
                        }


                    },

                });

            });
        });
    </script>


@endsection
