@extends('layouts.app')

@section('title', '- Single Product')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="float-left text-primary font-italic">{{ $product->title }}</h2>
            </div>
            <div class="card-body cont-show">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th scope="col">Image</th>
                                <td class="p-1"><img src="{{ asset('storage/'.$product->image) }}"></td>
                            </tr>
                            <tr>
                                <th scope="col">Product Code</th>
                                <td>{{ $product->prod_code }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Category</th>
                                <td>
                                    @if ($product->category)
                                        {{ $product->category->cat_name }}
                                    @else
                                        <span class="text-danger">Deleted</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">Title</th>
                                <td>{{ $product->title }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Slug</th>
                                <td>{{ $product->slug }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Price</th>
                                <td><strong>KSH. </strong>{{ number_format($product->price) }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Quantity</th>
                                <td>{{ $product->title }}</td>
                            </tr>
                            <tr>
                                <th scope="col">Description</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th rowspan="2">Created</th>
                                <td><strong>Date - </strong>{{ $product->created_at->format('Y-m-d h:i:s') }}</td>
                            </tr>
                            <tr>
                                <td><strong>By - </strong>{{ $product->created_by }}</td>
                            </tr>
                            <tr>
                                <th rowspan="2">Updated</th>
                                <td><strong>Date - </strong>{{ $product->updated_at->format('Y-m-d h:i:s') }}</td>
                            </tr>
                            <tr>
                                <td><strong>By - </strong>{{ $product->updated_by }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
