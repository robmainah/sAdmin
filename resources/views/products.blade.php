@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-hd pt-2 pb-1">
                <div class="pd-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <div>
                                <h4 class="float-left">Products</h4>
                            </div>

                            <h5 class="text-right">
                                <button type="button" class="btn btn-success px-1 py-1" @click="openAddProd">
                                    <i class="fa fa-plus"></i> New
                                </button>
                                <button type="button" class="btn btn-primary px-1 py-1">
                                    <font-awesome-icon icon="print" />Print
                                </button>
                                <button type="button" class="btn btn-danger px-1 py-1" @click="deleteProduct()">
                                    <font-awesome-icon icon="trash" />Delete
                                </button>
                            </h5>
                        </div>
                        <div class="col-sm-7">
                            <form class="form-inline">
                                <label class="sr-only" for="inlineFormInputGroupUsername">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="searchField" placeholder="Search" />
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <!-- <a class="btn btn-primary" href="javascript:;"> -->
                                            <font-awesome-icon icon="search" />
                                            <!-- </a> -->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <transition name="moveOut">
                    <div class="alert alert-dismissible fade show" :class="alertClass" v-show="dispMes">
                        <!-- <p ref="displayMessage" class="card-text"></p> -->
                        <p ref="displayMessage"></p>
                        <button type="button" class="close" aria-label="Close" @click="dispMes = !dispMes">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </transition>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
