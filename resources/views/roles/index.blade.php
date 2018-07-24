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
    <h2 class="header-title">Roles Table</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
            <a class="breadcrumb-item" href="#">Roles</a>

        </nav>
    </div>
    <button class="btn btn-success float-right" data-toggle="modal" data-target="#role_new_modal">Add Role</button>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-overflow">
            <table id="roles_table" class="table table-hover table-xl">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->display_name}}</td>
                        <td>{{$role->description}}</td>
                        <td class="text-center font-size-18">
                            <a  class="text-gray m-r-15 anchor-pointer"><i class="ti-pencil" data-toggle="modal" data-target="#role_edit_modal" onclick="PopulateModal('<?php echo $role->id ?>')" ></i></a>
                            <a  class="text-gray anchor-pointer"><i class="ti-trash swal-function" onclick=RoleDelete('<?php echo $role->id ?>');></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="role_new_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">New Role</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Name</label>
                        <input type="text" class="form-control" id="new_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Display Name</label>
                        <input type="text" class="form-control" id="new_display_name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Description</label>
                        <textarea class="form-control" id="new_description"></textarea>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Permission</label>
                    </div>
                    @foreach($permissions as $permission)
                    <div class="col-md-4">
                        <div class="checkbox insert_role_checkbox">
                            <input id="checkbox{{$permission->id}}" type="checkbox" value="{{$permission->id}}" name="new_permission">
                            <label for="checkbox{{$permission->id}}">{{$permission->name}}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-row m-t-25">
                    <div class="col-sm-12">
                        <div class="text-right">
                            <button class="btn btn-gradient-success" id="insert_role" data-dismiss="modal">Insert Role</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<div class="modal fade show" id="role_edit_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Role Edit</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="control-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Display Name</label>
                        <input type="text" class="form-control" id="display_name" name="display_name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Permission</label>
                    </div>
                </div>

                <div class="row">
                    @foreach($permissions as $permission)
                    <div class="col-md-4">

                        <div class="checkbox role_edit_checkbox">
                            <input id="edit_checkbox{{$permission->id}}" type="checkbox" value="{{$permission->id}}" name="permission">
                            <label for="edit_checkbox{{$permission->id}}">{{$permission->name}}</label>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="form-row m-t-30">
                    <div class="col-sm-12">
                        <div class="text-sm-right">
                            <button class="btn btn-gradient-success" id="update_role" data-id="" data-dismiss="modal">Update Role</button>
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
<script src="{{asset('plugins/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/select2/select2.js')}}"></script>
<script src="{{asset('plugins/sweetalert/sweet-alert.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script>

                                $(document).ready(function () {
                                    if (sessionStorage.getItem('update_success') == 'success') {

                                        toastr.success('Role has been successfully updated', 'Success Alert', {timeOut: 5000});
                                        sessionStorage.removeItem("update_success");
                                    } else if (sessionStorage.getItem('new_success') == 'success')
                                    {
                                        toastr.success('Role has been successfully created', 'Success Alert', {timeOut: 5000});
                                        sessionStorage.removeItem("new_success");
                                    }
                                    var table = $('#roles_table').DataTable({

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
                                        url: '/roles/' + id + '/edit',
                                        method: 'GET',
                                        success: function (data) {
                                            var selected_array = [];
                                            $("#update_role").attr('data-id', id);
                                            $('#name').val((data['role']['name']));
                                            $('#display_name').val((data['role']['display_name']));
                                            $('#description').val((data['role']['description']));
                                            $('.role_edit_checkbox').find('input[type=checkbox]:checked').removeAttr('checked');
                                            var values = data['rolePermissions'];
                                            $(".role_edit_checkbox").find('[value=' + values.join('], [value=') + ']').prop("checked", true);
                                        }
                                    })
                                }
                                function RoleDelete(id)
                                {

                                    swal({
                                        title: "Are you sure?",
                                        text: "You will not be able to recover this record!",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "Yes, delete it!",
                                        closeOnConfirm: false
                                    },
                                            function () {
                                                $.ajax({
                                                    url: '/roles/' + id,
                                                    method: 'DELETE',
                                                    headers:
                                                            {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                    success: function (data) {
                                                        setTimeout(function () {
                                                            swal({
                                                                title: "Deleted!",
                                                                text: "Role has been deleted.",
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

                                $('#update_role').on('click', function (e)
                                {
                                    var id = $(this).attr('data-id');
                                    var name = $('#name').val();
                                    var display_name = $('#display_name').val();
                                    var description = $('#description').val();
                                    var permission = [];
                                    $("input:checkbox[name=permission]:checked").each(function () {
                                        permission.push($(this).val());
                                    });
                                    $.ajax({
                                        url: '/roles/' + id,
                                        method: 'POST',
                                        data: {'name': name, 'display_name': display_name, 'description': description, 'permission': permission},
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

                                $('#insert_role').on('click', function (e)
                                {

                                    var name = $('#new_name').val();
                                    var display_name = $('#new_display_name').val();
                                    var description = $('#new_description').val();
                                    var permission = [];
                                    $("input:checkbox[name=new_permission]:checked").each(function () {
                                        permission.push($(this).val());
                                    });
                                    $.ajax({
                                        url: '/roles/create',
                                        method: 'POST',
                                        data: {'name': name, 'display_name': display_name, 'description': description, 'permission': permission},
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
