<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\{Processlink, Brand, Category};
use App\Http\Resources\Process\{ProcesslinkResource, ProcesslinkCollection};
use Validator;
use App\Jobs\ProcessLinksJob;


class ProcessController extends Controller
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
        return new ProcesslinkCollection(Processlink::where('url','like',"%$search%")->paginate(10));
      }
        //Return the pages for the Admin
        return  new ProcesslinkCollection(Processlink::paginate(10));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $url;
      if($request->category_id != NULL){
        $category = Category::find($request->category_id);
        $url=$category->url;
      }

      if($request->brand_id != NULL){
        $brand = Brand::find($request->brand_id);
        $url=$brand->url;
      }

      $processlink=new Processlink();
      $processlink->url = $url;
      $processlink->website_id = $request->website_id;
      $processlink->brand_id = $request->brand_id;
      $processlink->category_id = $request->category_id;
      $processlink->status = 'pending';
      $processlink->save();
      ProcessLinksJob::dispatch($processlink);
      return new ProcesslinkResource($processlink);
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
