@extends('layouts.app')

@section('title', '- New Product')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pt-2 pb-1">
                <h2 class="float-left text-primary font-italic">Add New Product</h2>
            </div>
            <div class="card-body cont-body pr-4 pl-4">
                <form class="needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="title">Product Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Product Title" value="" required>
                            <div class="invalid-feedback"> Enter correct product title </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category">Product Category</label>
                            <select class="custom-select" name="category" required>
                            <option value="">Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            </select>
                            <div class="invalid-feedback"> Choose a Category. </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                </div>
                                <input type="text" class="form-control" name="price" placeholder="Product Price" aria-describedby="inputGroupPrepend" required>
                                <div class="invalid-feedback">
                                    Enter correct product price
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" name="quantity" placeholder="Quantity" required>
                            <div class="invalid-feedback">
                                Enter correct product quantity
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="title">Product Image</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="chooseimage">Choose image...</label>
                                <input type="file" class="custom-file-input" id="image" required>
                                <div class="invalid-feedback">Select Product Image</div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="description">Product Description</label>
                            <textarea name="description" class="form-control" rows="10" placeholder="Product Description" required></textarea>
                            {{-- <input type="text" class="form-control" name="description" placeholder="Product Description" required> --}}
                            <div class="invalid-feedback">
                                Product product description
                            </div>
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
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
        }, false);
    })();
    </script>
@endsection
