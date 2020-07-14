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
                                <a href="{{ route('products.export.excel') }}" class="btn btn-primary px-1 py-1"><i class="fa fa-print"></i> Export to CSV</a>
                                <a href="{{ route('products.export.pdf') }}" target="_blank" class="btn btn-primary px-1 py-1"><i class="fa fa-print"></i> Export to PDF</a>
                                <a href="javascript:;" class="btn btn-danger px-1 py-1 delete_btn disabled" onclick="deleteProducts()"><i class="fa fa-trash"></i> Delete</a>
                            </h5>
                        </div>
                        <div class="col-sm-6">
                            <form class="form-inline float-right">
                                <label class="sr-only" for="inlineFormInputGroupUsername">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" />
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
                                <th scope="col">
                                    <div class="form-check tb-check">
                                        <input class="form-check-input check_all_boxes" type="checkbox"
                                         onclick="checkAllProducts()" />
                                        <label class="form-check-label" for="defaultCheck1"></label>
                                    </div>
                                </th>
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
                            @foreach ($products as $key => $product)
                                <tr>
                                    <th>
                                        <div class="form-check tb-check">
                                            <input class="form-check-input prod_checkbox" onclick="checkedBox()" type="checkbox"
                                            data-id="{{ $product->id }}"/>
                                            <label class="form-check-label" for="defaultCheck1"></label>
                                        </div>
                                    </th>
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
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </a>
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
        <div class="modal fade" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
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
                    <div class="modal-footer prod_selected d-none">
                        <form id="delete-product-form" action="" method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" id="multiple_ids" name="multiple_ids">
                            <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                        </form>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="modal-footer not_selected_prod pr-5">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function checkedBox() {
            const allCheckboxInputs = document.querySelectorAll(".prod_checkbox")
            for (const el of allCheckboxInputs) {
                if(el.checked == true) {
                    document.querySelector(".delete_btn").classList.remove('disabled')
                    break
                }
                document.querySelector(".delete_btn").classList.add('disabled')
            }
        }
        function checkAllProducts() {
            const allCheckboxInputs = document.querySelectorAll(".prod_checkbox")

            if(document.querySelector(".check_all_boxes").checked === true) {
                allCheckboxInputs.forEach((el) => {
                    el.checked = true
                })
                return checkedBox()
            }
            allCheckboxInputs.forEach((el) => {
                el.checked = false
            })
            document.querySelector(".delete_btn").classList.add('disabled')
        }
        function getCheckedCategories() {
            const allCheckboxInputs = document.querySelectorAll(".prod_checkbox")
            let allCheckedCategories = []
            allCheckboxInputs.forEach((el) => {
                if(el.checked === true)
                {
                    const data_id = el.getAttribute('data-id')
                    allCheckedCategories.push(data_id)
                }
            })
            return allCheckedCategories
        }
        function deleteProducts() {
            if(getCheckedCategories().length < 1 ) {
                document.querySelector(".prod_selected").classList.add('d-none')
                document.querySelector(".not_selected_prod").classList.remove('d-none')

                const modal_header_content = "<span class='text-danger'><i class='fa fa-warning text-danger'></i> No Product Selected !!</span>"
                document.querySelector("#delete_product .modal-header h5").innerHTML = modal_header_content

                const modal_body_content = "<i class='fa fa-warning text-danger'></i> You must select at least one Product!!!"
                document.querySelector("#delete_product .modal-body").innerHTML = modal_body_content
                return $('#delete_product').modal('show')
            }
            else if(getCheckedCategories().length > 1) {
                const form = document.querySelector("#delete-product-form")
                                .setAttribute('action', "{{ route('products.delete-multiple') }}")
            } else {
                const url_link = window.location + "/" + getCheckedCategories()

                const form = document.querySelector("#delete-product-form")
                                .setAttribute('action', url_link)
            }
            document.querySelector(".prod_selected").classList.remove('d-none')
            document.querySelector(".not_selected_prod").classList.add('d-none')

            document.querySelector("#multiple_ids").setAttribute('value', getCheckedCategories())

            const modal_header_content = "Delete Product(s)"
            document.querySelector("#delete_product .modal-header h5").innerHTML = modal_header_content

            const modal_body_content = "Are you sure you want delete these products !!!"
            document.querySelector("#delete_product .modal-body").innerHTML = modal_body_content

            $('#delete_product').modal('show')
        }
    </script>
@endsection
