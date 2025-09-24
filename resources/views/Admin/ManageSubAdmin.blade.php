@extends('Admin.layout.partials.master')
@section('title', 'Admin - Manage SubAdmin')
@section('content')
    <div class="pc-content">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0">Manage SubAdmin</h4>
                <a href="{{ route('admin.addSubAdmin') }}" class="btn btn-primary rounded text-white">Add Sub Admin</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table text-center">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>image</th>
                                <th>first heading</th>
                                <th>second heading</th>
                                <th>slogan</th>
                                <th>button</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td><img src="" alt="slider img" class="img-thumbnails"></td>

                                <td></td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <a href="update_slider.html" class="btn btn-success rounded">Update</a>
                                    <a href="manage_slider.html"
                                        onclick="return confirm('do you realy want to delete data');"
                                        class="btn btn-danger rounded">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
