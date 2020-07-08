@extends('layouts.app')

@section('title', '- New Product')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pt-2 pb-1">
                <h2 class="float-left text-primary font-italic">Add New Product</h2>
            </div>
            <div class="card-body cont-body pr-4 pl-4">
                <form action="{{ route('products.store') }}" method="post"
                enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="title">Product Title</label>
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" id="title" placeholder="Product Title"
                            value="{{ old('title') }}" required>
                            @if ($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category">Product Category</label>
                            <select class="custom-select {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->cat_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                </div>
                                <input type="text" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price" placeholder="Product Price"
                                value="{{ old('price') }}" aria-describedby="inputGroupPrepend" required>
                                @if ($errors->has('price'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('price') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="stock">Stock Quantity</label>
                            <input type="text" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" name="stock" placeholder="Stock Quantity"
                            value="{{ old('stock') }}" required>
                            @if ($errors->has('stock'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('stock') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="title">Product Image</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="chooseimage">Choose image...</label>
                                <input type="file" onchange="imageUpload(event)"
                                class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image"
                                value="{{ old('image') }}" required>
                                @if ($errors->has('image'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('image') }}
                                    </div>
                                @endif
                            </div>
                            <img class="form-group mt-3 ml-3" id="show_image" style="display:none" src="#" alt width="200px" height="200px" />
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="description">Product Description</label>
                            <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="10" placeholder="Product Description"
                            required>{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group offset-3 col-md-4">
                            <button class="btn btn-primary col-md-12" type="submit">Add Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function imageUpload(event) {
            let output = document.querySelector("#show_image")
            output.style.display = "block"

            let reader = new FileReader()
            reader.onload = function(e) {
                output.src = reader.result
            }
            reader.readAsDataURL(event.target.files[0])
        }

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        // (function() {
        //     'use strict';
        //     window.addEventListener('load', function() {
        //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
        //     var forms = document.getElementsByClassName('needs-validation');
        //     // Loop over them and prevent submission
        //     var validation = Array.prototype.filter.call(forms, function(form) {
        //         form.addEventListener('submit', function(event) {
        //             if (form.checkValidity() === false) {
        //                 event.preventDefault();
        //                 event.stopPropagation();
        //             }
        //             form.classList.add('was-validated');
        //         }, false);
        //     });
        //     }, false);
        // })();
    </script>
@endsection
