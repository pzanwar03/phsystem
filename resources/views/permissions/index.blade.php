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
    <h2 class="header-title">Permissions Table</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="ti-home p-r-5"></i>Home</a>
            <a class="breadcrumb-item" href="#">Permissions</a>
        </nav>
    </div>
    <button class="btn btn-success float-right" data-toggle="modal" data-target="#permission_new_modal">Add Permission</button>
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
                    @foreach ($permissions as $permission)
                    <tr>
                        <td>{{$permission->display_name}}</td>
                        <td>{{$permission->description}}</td>
                        <td class="text-center font-size-18">
                            <a  class="text-gray m-r-15 anchor-pointer"><i class="ti-pencil" data-toggle="modal" data-target="#permission_edit_modal" onclick="PopulateModal('<?php echo $permission->id ?>')" ></i></a>
                            <a  class="text-gray anchor-pointer"><i class="ti-trash swal-function" onclick=PermissionDelete('<?php echo $permission->id ?>');></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade show" id="permission_new_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">New Permission</h3>
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
                        <textarea class="form-control" id="new_description" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="text-sm-right">
                            <button class="btn btn-gradient-success" id="insert_permission" data-dismiss="modal">Insert Permission</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade show" id="permission_edit_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Permission Edit</h3>
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
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-12">
                        <div class="text-sm-right">
                            <button class="btn btn-gradient-success" id="update_permission" data-id="" data-dismiss="modal">Update Permission</button>
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

                                        toastr.success('Permission has been successfully updated', 'Success Alert', {timeOut: 5000});
                                        sessionStorage.removeItem("update_success");
                                    } else if (sessionStorage.getItem('new_success') == 'success')
                                    {
                                        toastr.success('Permission has been successfully created', 'Success Alert', {timeOut: 5000});
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
                                        url: '/permissions/' + id + '/edit',
                                        method: 'GET',
                                        success: function (data) {
                                            var selected_array = [];
                                            $("#update_permission").attr('data-id', id);
                                            $('#name').val((data['permission']['name']));
                                            $('#display_name').val((data['permission']['display_name']));
                                            $('#description').val((data['permission']['description']));
                                        }
                                    })
                                }
                                function PermissionDelete(id)
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
                                                    url: '/permissions/' + id,
                                                    method: 'DELETE',
                                                    headers:
                                                            {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                    success: function (data) {
                                                        setTimeout(function () {
                                                            swal({
                                                                title: "Deleted!",
                                                                text: "Permission has been deleted.",
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

                                $('#update_permission').on('click', function (e)
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
                                        url: '/permissions/' + id,
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
                                $('#insert_permission').on('click', function (e)
                                {

                                    var name = $('#new_name').val();
                                    var display_name = $('#new_display_name').val();
                                    var description = $('#new_description').val();
                                    var permission = [];
                                    $("input:checkbox[name=new_permission]:checked").each(function () {
                                        permission.push($(this).val());
                                    });
                                    $.ajax({
                                        url: '/permissions/create',
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
