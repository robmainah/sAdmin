<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Customer\ReviewRequest;
use App\Http\Resources\Customer\ReviewResource;
use App\Http\Controllers\Controller;
use App\Models\Customer\Review;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    public function index(Product $product)
    {
        // $review = Review::latest()->get();
        $review = $product->reviews->take(3);

        return ReviewResource::collection($review);
    }

    public function store(ReviewRequest $request, Product $product)
    {
        $review = new Review;

        $request['body'] = $request->message;
        unset($request['message']);

        $review->body = $request->body;
        $review->code = Review::generateReviewCode();
        $review->customer()->associate($request->user());

        $product->reviews()->save($review);

        return new ReviewResource($review);
    }

    public function show(Product $product, Review $review)
    {
        return new ReviewResource($review);
    }

    public function update(ReviewRequest $request, Product $product, Review $review)
    {
        $this->authorize('owner', $review);

        $review->body = $request->get('body', $request->body);
        $review->save();

        return new ReviewResource($review);
    }

    public function destroy(Product $product, Review $review)
    {
        $this->authorize('owner', $review);

        $review->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
