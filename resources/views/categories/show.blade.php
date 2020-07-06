@extends('layouts.app')

@section('title', '- Single Product')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pt-2 pb-1">
                <div class="row">
                    <div class="col-sm-3">
                        <h2 class="float-left text-primary font-italic">{{ $category->cat_name }}'s Details</h2>
                    </div>
                    <div class="col-sm-1">
                        <h2><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a></h2>
                    </div>
                    <div class="col-sm-3">
                        <h2><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteCategory">
                            <i class="fa fa-trash"></i> Delete
                        </button></h2>
                        {{-- <h2><a href="{{ route('categories.destroy', $category->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a></h2> --}}
                    </div>
                </div>
                {{-- <h2 class="float-left text-primary font-italic">{{ $category->cat_name }}</h2> --}}
                {{-- <h2 class="ml-5">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                </h2> --}}
            </div>
            <div class="card-body cont-body cont-show">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th scope="col">Category Code</th>
                                <td>{{ $category->cat_code }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Category Name</th>
                                <td>{{ $category->cat_name }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Active</th>
                                <td>
                                    @if ($category->active)
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">No. Of Products</th>
                                <td>{{ $category->products_count }}</td>
                            </tr>
                            <tr>
                                <th rowspan="2">Created</th>
                                <td><strong>Date - </strong>{{ $category->created_at->format('Y-m-d h:i:s') }}</td>
                            </tr>
                            <tr>
                                <td><strong>By - </strong>{{ $category->created_by }}</td>
                            </tr>
                            <tr>
                                <th rowspan="2">Updated</th>
                                <td><strong>Date - </strong>{{ $category->updated_at->format('Y-m-d h:i:s') }}</td>
                            </tr>
                            <tr>
                                <td><strong>By - </strong>{{ $category->updated_by }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to confirm deletion -->
    <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Delete Category(s)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                    </form>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
