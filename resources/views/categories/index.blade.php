@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pt-2 pb-1">
                <div class="cont-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2 class="float-left text-primary font-italic">Categories</h2>
                            <h5 class="text-right">
                                <a href="{{ route('categories.create') }}" class="btn btn-success px-1 py-1"><i class="fa fa-plus"></i> New</a>
                                <a href="#" class="btn btn-primary px-1 py-1"><i class="fa fa-print"></i> Print</a>
                                <a href="#" class="btn btn-danger px-1 py-1"><i class="fa fa-trash"></i> Delete</a>
                            </h5>
                        </div>
                        <div class="col-sm-6">
                            <form class="form-inline float-right">
                                <label class="sr-only" for="inlineFormInputGroupUsername">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="searchField" placeholder="Search" />
                                    <div class="input-group-prepend">
                                        <a class="btn btn-primary btn-sm input-group-text" href="#">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body cont-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Catgory Code</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Active</th>
                                <th scope="col">No. of Products</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Created On</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $category->cat_code }}</td>
                                    <td>{{ $category->cat_name }}</td>
                                    <td>
                                        @if ($category->active)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->products->count() }}</td>
                                    <td>{{ $category->created_by }}</td>
                                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('categories.destroy', $category->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="cont-pagination mb-1">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
