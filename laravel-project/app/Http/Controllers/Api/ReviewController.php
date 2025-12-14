<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Store new review
     */
    public function store(Request $request)
    {
        //check ถ้ามี user review product ไปแล้ว
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id, $request->user()->id);

        if ($review) {
            //ถ้า user รีวิวแล้ว
            return response()->json(([
                'error' => 'You have already reviewed this product.'
            ]));
        } else {
            //ถ้า user ยังไม่ได้รีวิวให้สร้าง รีวิวใหม่
            Review::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'rating' => $request->rating
            ]);
            //response กลับว่า สร้างรีวิวสําเร็จ
            return response()->json(([
                'message' => 'Your review has been added and will be published soon.'
            ]));
        }
    }

    /**
     * Update review
     */
    public function update(Request $request)
    {
        //check ถ้ามี user review product ไปแล้ว
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id, $request->user()->id);

        if ($review) {
            //สำหรับการupdate Review ของ user
            $review->update([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'rating' => $request->rating,
                'approved' => 0
            ]);
            //response คุณได้ทำการอัพเดตการรีวิวของคุณแล้ว
            return response()->json(([
                'message' => 'Your review has been updated and will be published soon.'
            ]));
        } else {
            return response()->json(([
                'error' => 'Something went wrong try again later.'
            ]));
        }
    }

    /**
     * Delete review
     */
    public function delete(Request $request)
    {
        //check ถ้ามี user review product ไปแล้ว
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id, $request->user()->id);

        //เช็คสำหรับuserทีมี่การ review แล้ว และจะทำการลบ
        if ($review) {
            $review->delete();
            return response()->json(([
                'message' => 'Your review has been deleted successfully.'
            ]));
        } else {
            return response()->json(([
                'error' => 'Something went wrong try again later.'
            ]));
        }
    }



    /**
     * สำหรับเช็คว่า user review product ไปหรือยัง
     */
    public function checkIfUserAlreadyReviewedTheProduct($productId, $userId)
    {
        //สำหรับ where หา product_id และ user_id
        $review = Review::where([
            'product_id' => $productId,
            'user_id' => $userId
        ])->first();

        return $review;
    }
}
