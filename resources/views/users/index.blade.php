@extends('app')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/plugins/select2/select2.css')}}">
<link href="{{ asset('plugins/sweetalert/sweet-alert.css') }}" rel="stylesheet">
<style>
    .anchor-pointer
    {
        cursor: pointer;
    }

</style>
@endsection
@section('content')



<div class="page-header">
    <h2 class="header-title">User Table</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
            <a class="breadcrumb-item" href="#">Users</a>

        </nav>
    </div>
    <button class="btn btn-success float-right" data-toggle="modal" data-target="#user_new_modal">Add User</button>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-overflow">
            <table id="users_table" class="table table-hover table-xl">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if(!empty($user->roles))
                            @foreach($user->roles as $v)
                            <span class="badge badge-pill badge-gradient-success">{{ $v->display_name }}</span></label>
                            @endforeach
                            @endif
                        </td>
                        <td class="text-center font-size-18">
                            <a  class="text-gray m-r-15 anchor-pointer"><i class="ti-pencil" data-toggle="modal" data-target="#user_edit_modal" onclick="PopulateModal('<?php echo $user->id ?>')" ></i></a>
                            <a  class="text-gray anchor-pointer"><i class="ti-trash swal-function" onclick=UserDelete('<?php echo $user->id ?>');></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade show" id="user_new_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">New User</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">User Name</label>
                        <input type="text" class="form-control" id="new_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Email</label>
                        <input type="text" class="form-control" id="new_email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" id="new_password">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Confirm Password</label>
                        <input type="password" class="form-control" id="new_confirm_password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Roles</label>
                    <select class="form-control select2" id="new_roles"  multiple="multiple">
                        @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->display_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="text-sm-right">
                            <button class="btn btn-gradient-success" id="insert_account" data-dismiss="modal">Insert Account</button>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
    </div>
</div>



<div class="modal fade show" id="user_edit_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">User Edit</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">User Name</label>
                        <input type="text" class="form-control" id="name" name="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Roles</label>
                    <select class="form-control select2" id="roles" name="roles" multiple="multiple">
                        @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->display_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="text-sm-right">
                            <button class="btn btn-gradient-success" id="update_account" data-id="" data-dismiss="modal">Update Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Wrapper END -->
@endsection

@section('js')

<script src="{{ asset('plugins/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{asset('plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/select2/select2.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweet-alert.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script>

                                $(document).ready(function () {
                                    if (sessionStorage.getItem('update_success') == 'success') {

                                        toastr.success('User has been successfully updated', 'Success Alert', {timeOut: 5000});
                                        sessionStorage.removeItem("update_success");
                                    } else if (sessionStorage.getItem('new_success') == 'success')
                                    {
                                        toastr.success('User has been successfully created', 'Success Alert', {timeOut: 5000});
                                        sessionStorage.removeItem("new_success");
                                    }
                                    var table = $('#users_table').DataTable({

                                        "pageLength": 25,

                                        "responsive": true
                                    });
                                    $(".select2").select2({
                                        dropdownAutoWidth: true,
                                        width: '100%',
                                    });
                                });

                                function PopulateModal(id)
                                {
                                    $.ajax({
                                        url: '/users/' + id + '/edit',
                                        method: 'GET',
                                        success: function (data) {
                                            var selected_array = [];
                                            $("#update_account").attr('data-id', id);
                                            $('#name').val((data['user']['name']));
                                            $('#email').val((data['user']['email']));
                                            $.each(data['userRole'], function (index, selectedRoles) {
                                                selected_array.push(selectedRoles['id']);
                                            });
                                            $('#roles').select2('val', selected_array);




                                        }
                                    })
                                }
                                function UserDelete(id)
                                {

                                    swal({
                                        title: "Are you sure?",
                                        text: "You will not be able to recover this imaginary file!",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "Yes, delete it!",
                                        closeOnConfirm: false
                                    },
                                            function () {
                                                $.ajax({
                                                    url: '/users/' + id,
                                                    method: 'DELETE',
                                                    headers:
                                                            {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                    success: function (data) {
                                                        setTimeout(function () {
                                                            swal({
                                                                title: "Deleted!",
                                                                text: "User has been deleted.",
                                                                type: "success",
                                                                confirmButtonText: "OK"
                                                            },
                                                                    function (isConfirm) {
                                                                        if (isConfirm) {
                                                                            window.location.reload();
                                                                        }
                                                                    });
                                                        }, 1000);


                                                    },
                                                    error: function (e) {
                                                        toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
                                                    }
                                                })


                                            });
                                }

                                $('#update_account').on('click', function (e)
                                {
                                    var id = $(this).attr('data-id');
                                    var name = $('#name').val();
                                    var email = $('#email').val();
                                    var password = $('#password').val();
                                    var confirm_password = $('#confirm-password').val();
                                    var roles = $('#roles').val();
                                    $.ajax({
                                        url: '/users/' + id,
                                        method: 'POST',
                                        data: {'name': name, 'email': email, 'password': password, 'confirm-password': confirm_password, 'roles': roles},
                                        headers:
                                                {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                        success: function (data) {
                                            if (data == 'success')
                                            {
                                                sessionStorage.setItem("update_success", "success");
                                                window.location.reload();
                                            }
                                        },
                                        error: function (e) {
                                            toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
                                        }
                                    })
                                });

                                $('#insert_account').on('click', function (e)
                                {

                                    var name = $('#new_name').val();
                                    var email = $('#new_email').val();
                                    var password = $('#new_password').val();
                                    var confirm_password = $('#new_confirm_password').val();
                                    var roles = $('#new_roles').val();
                                    $.ajax({
                                        url: '/users/create',
                                        method: 'POST',
                                        data: {'name': name, 'email': email, 'password': password, 'confirm-password': confirm_password, 'roles': roles},
                                        headers:
                                                {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                        success: function (data) {
                                            if (data == 'success')
                                            {
                                                sessionStorage.setItem("new_success", "success");
                                                window.location.reload();
                                            }
                                        },
                                        error: function (e) {
                                            toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
                                        }
                                    })
                                });
</script>
@endsection
