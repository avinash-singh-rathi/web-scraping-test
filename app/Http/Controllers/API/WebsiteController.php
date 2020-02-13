<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Website;
use App\Http\Resources\Website\{WebsiteResource, WebsiteCollection};
use Validator;

class WebsiteController extends Controller
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
        return new WebsiteCollection(Website::where('name','like',"%$search%")->paginate(10));
      }
        //Return the pages for the Admin
        return  new WebsiteCollection(Website::paginate(10));
    }

    /**
     * Display all listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        //Return the pages for the Admin
        return  new WebsiteCollection(Website::all());
    }

    /*
    Check the name of the website in the configuration
    */
    public function checkConfig($name){
      return config('crawl.'.$name) ? TRUE : FALSE;
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
        $validator=Validator::make($request->all(), [
          'name' => 'required|unique:websites|max:255',
          'url' => 'required',
        ]);
        $validator->after(function ($validator) use($request) {
            if (!$this->checkConfig($request->name)) {
                $validator->errors()->add('name', 'Did not find the configuration for this website!');
            }
        });
        if($validator->fails()){
          return response()->json($validator->errors(), 400);
        }
        $website=new Website();
        $website->name = $request->name;
        $website->url = $request->url;
        $website->save();
        return new WebsiteResource($website);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return new WebsiteResource($website);
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
