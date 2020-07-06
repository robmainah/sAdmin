@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pt-2 pb-1">
                <div class="cont-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2 class="float-left text-primary font-italic">Products</h2>
                            <h5 class="text-right">
                                <a href="{{ route('products.create') }}" class="btn btn-success px-1 py-1"><i class="fa fa-plus"></i> New</a>
                                <a href="#" class="btn btn-primary px-1 py-1"><i class="fa fa-print"></i> Print</a>
                                <a href="" class="btn btn-danger px-1 py-1"><i class="fa fa-trash"></i> Delete</a>
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
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                {{-- <th scope="col"></th> --}}
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price ( <strong>KSH</strong> )</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Created On</th>
                                <th class="actions" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    {{-- <th>
                                        <form action="">
                                            <input type="checkbox" name="prod_ids[]" value="{{ $product->id }}">
                                        </form>
                                    </th> --}}
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ Str::limit($product->title, 25) }}</td>
                                    <td>{{ Str::limit($product->slug, 25) }}</td>
                                    <td>
                                        @if ($product->category)
                                            {{ $product->category->cat_name }}
                                        @else
                                            <span class="text-danger">Deleted</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->created_by }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteProduct">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="cont-pagination mb-1">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        <!-- Modal to confirm deletion -->
        <div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product(s)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                        <form id="delete-form" action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
