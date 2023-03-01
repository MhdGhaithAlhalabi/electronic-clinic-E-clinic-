<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id'=>$this->id,
            'body'=>$this->body

            ];
//        if($this->anonymous == 1){
//            $gg = 'anonymous' ;
//            return[ 'name'=> $gg] ;
//        }
        //return parent::toArray($request);



    }
}
