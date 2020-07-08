@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid">
        <div class="card mb-3 d-none add_category">
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="addCategory alert alert-info">
                <form method="POST" class="needs-validation" action="{{ route('categories.store') }}" novalidate>
                    @csrf
                    <button type="button" class="close" onclick="newCategory()">
                        <i aria-hidden="true">&times;</i>
                    </button>
                    <div class="row">
                        <div class="col-lg col-md col-sm">
                            <div class="form-group">
                                <label for="Category Name">
                                    <strong>Category Name</strong>
                                </label>
                                <input type="text" class="form-control" placeholder="Category name" name="name" value="" required/>
                                <div class="invalid-feedback"> Enter correct Category Name </div>
                            </div>
                        </div>
                        <div class="col-md col-sm">
                            <div class="form-group">
                                <label for="educationLevel">
                                    <strong>Active Status</strong>
                                </label>
                                <select class="custom-select custom-control mr-sm-2" id="status" name="status" required>
                                    <option value="">Select Active Status</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback"> Select the Category Status </div>
                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <div class="cat-action-btn">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn alert-danger" onclick="clearValidation()">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header pt-2 pb-1">
                <div class="cont-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2 class="float-left text-primary font-italic">Categories</h2>
                            <h5 class="text-right">
                                <button class="btn btn-success px-1 py-1 new_category" onclick="newCategory()"><i class="fa fa-plus"></i> New</button>
                                {{-- <a href="" class="btn btn-success px-1 py-1 new_category"><i class="fa fa-plus"></i> New</a> --}}
                                <a href="#" class="btn btn-primary px-1 py-1"><i class="fa fa-print"></i> Print</a>
                                <a href="javascript:;" class="btn btn-danger px-1 py-1 d-none multiple-delete" onclick="deleteAll()"><i class="fa fa-trash"></i> Delete</a>
                            </h5>
                        </div>
                        <div class="col-sm-6">
                            <form class="form-inline float-right">
                                <label class="sr-only" for="inlineFormInputGroupUsername">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" /> <div class="input-group-prepend">
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
                    <div class="alert alert-success alert-dismissible fade alert_message show" role="alert">
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
                                <th scope="col"></th>
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
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <th>
                                        <div class="form-check tb-check">
                                            <input class="form-check-input cat_checkbox" type="checkbox"
                                            data-id="{{ $category->id }}" onclick="checkCategories()" />
                                            <label class="form-check-label" for="defaultCheck1"></label>
                                        </div>
                                    </th>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $category->cat_code }}</td>
                                    <td>{{ $category->cat_name }}</td>
                                    <td>
                                        @if ($category->active)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>{{ $category->created_by }}</td>
                                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('categories.show', $category->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('categories.destroy', $category->id) }}" id="del_cat{{ $category->id }}"
                                            onclick="deleteCategory({{ $category->id }})" class="btn btn-danger btn-sm single_del">
                                            <i class="fa fa-trash"></i>
                                        </a>
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
    <!-- Modal to confirm deletion -->
    <div class="modal fade" id="delete_category" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
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
                    <form id="delete-category-form" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="multiple_ids" name="multiple_ids">
                        <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                    </form>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function checkCategories() {
            const allCheckboxInputs = document.querySelectorAll(".cat_checkbox")
            for (const el of allCheckboxInputs) {
                if(el.checked == true)
                {
                    document.querySelector(".multiple-delete").classList.remove('d-none')
                    const allBtns = document.querySelectorAll('.single_del')
                    allBtns.forEach((ele) => {
                        ele.classList.add('d-none')
                    })
                    break
                }
                else {
                    document.querySelector(".multiple-delete").classList.add('d-none')
                    const allBtns = document.querySelectorAll('.single_del')
                    allBtns.forEach((ele) => {
                        ele.classList.remove('d-none')
                    })
                }
            }
        }
        function getCheckCategories() {
            const allCheckboxInputs = document.querySelectorAll(".cat_checkbox")
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
        function deleteAll() {
            const form = document.querySelector("#delete-category-form").setAttribute('action', "{{ route('categories.delete-multiple') }}")
            document.querySelector("#multiple_ids").setAttribute('value', getCheckCategories())
            $('#delete_category').modal('show')
        }
        function deleteCategory(category_id) {
            event.preventDefault()
            const href_url = document.querySelector("#del_cat"+category_id).getAttribute('href')
            const form = document.querySelector("#delete-category-form").setAttribute('action', href_url)
            $('#delete_category').modal('show')
        }
        function clearValidation() {
            document.querySelector('form.needs-validation').classList.remove('was-validated')
        }
        function newCategory() {
            // clear validation
            clearValidation()

            document.querySelector('.add_category').classList.toggle('d-none')
        }
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
