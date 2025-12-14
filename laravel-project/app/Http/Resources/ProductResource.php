<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'qty' => $this->qty,
            'price' => $this->price,
            'desc' => $this->desc,
            'category' => $this->category,
            'brand' => $this->brand,
            'colors' => $this->colors,
            'sizes' => $this->sizes,
            'reviews' => $this->reviews,
            'status' => $this->status,
            'thumbnail' => asset($this->thumbnail),
            'first_image' => $this->first_image ? asset($this->first_image) : null,
            'second_image' => $this->second_image ? asset($this->second_image) : null,
            'third_image' => $this->third_image ? asset($this->third_image) : null,
        ];
    }
}
