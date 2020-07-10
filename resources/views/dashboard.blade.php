@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="ad-dash">
            <div class="card p-3">
                <div class="card-body cont-body">
                    <section class="row justify-content-between pl-3 ad-summary pr-3">
                        <div class="col-sm-3">
                            <a class="text-white bg-success" href="{{ route('categories.index') }}">Customers</a>
                            <h2>10</h2>
                        </div>
                        <div class="col-sm-3">
                            <a class="text-white" href="{{ route('products.index') }}">Daily visitors</a>
                            <h2>10</h2>
                        </div>
                        <div class="col-sm-3">
                            <a class="text-white bg-info" href="{{ route('categories.index') }}">Sales</a>
                            <h2>10</h2>
                        </div>
                        <div class="col-sm-3">
                            <a class="text-white" href="{{ route('categories.index') }}"><i class="fa fa-cart-plus"></i> Orders</a>
                            <h2>10</h2>
                        </div>
                    </section>
                </div>
                <span style="padding-left: 1rem;padding-right: 1rem;">
                    <hr />
                </span>
                <!-- <doughnutPieGraph></doughnutPieGraph> -->
                <!-- &nbsp; -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-body text-center">
                            <h5>
                                <strong>Sales</strong>
                            </h5>
                            <lineGraph v-if="salesloaded" :product-sales="productSales"></lineGraph>
                        </div>
                    </div>
                </div>
                <!-- horizontal graph showing sales of products -->
                &nbsp;
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 1rem 0">
                                <h5>
                                    <strong>Products Sales</strong>
                                </h5>
                                <horizontalBarGraph v-if="productsloaded" :product-data="productData"></horizontalBarGraph>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div class="card">
                            <div class="card-body" style="padding: 1rem 0">
                                <h5>
                                    <strong>Daily Visitors vs Conversions</strong>
                                </h5>
                                <barGraph></barGraph>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
