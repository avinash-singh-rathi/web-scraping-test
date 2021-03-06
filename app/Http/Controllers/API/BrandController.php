<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Brand;
use App\Http\Resources\Brand\{BrandResource, BrandCollection};
use Validator;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->has('search') AND !empty($request->input('search'))) {
        //
        $search = $request->search;
        return new BrandCollection(Brand::where('name','like',"%$search%")->with('website')->paginate(10));
      }
        //Return the pages for the Admin
        return  new BrandCollection(Brand::with('website')->paginate(10));
    }

    /**
     * Display a listing of the resource by the id of the website.
     *
     * @return \Illuminate\Http\Response
     */
    public function website(Request $request,$id)
    {
        //Return the pages for the Admin
        return  new BrandCollection(Brand::where('website_id',$id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //
      //
      $validator=Validator::make($request->all(), [
        'name' => 'required|max:255',
        'url' => 'required|unique:websites',
        'website_id' => 'required|numeric|exists:App\Model\Website,id'
      ]);
      if($validator->fails()){
        return response()->json($validator->errors(), 400);
      }
      $brand=new Brand();
      $brand->name = $request->name;
      $brand->url = $request->url;
      $brand->website_id = $request->website_id;
      $brand->save();
      return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
