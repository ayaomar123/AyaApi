<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'status' => $this->status,
            'child' => $this->children
        ];
    }


    public function getChildren($children)
    {
        return collect($children)->map(function ($child) {
            return [
                'id' => $child['id'],
                'name' => $child['name'],
            ];
        });
    }

    public function getParent($parent)
    {
        return collect($parent)->map(function ($child) {
            return [
                'id' => $child['id'],
                'name' => $child['name'],
            ];
        });
    }
}
