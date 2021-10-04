<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemParameter;
use App\Models\Category;
use App\Models\Photo;
use App\Models\CategoryParameter;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category, Parameter $parameter)
    {
        $parameters = CategoryParameter::where('category_id','=',$category->id)->get();
        $params = [];
            foreach($parameters as $parameter) {
            $params[] = $parameter = Parameter::where('id','=',$parameter->parameter_id)->get();
        }
        return view('item.create',['category' => $category, 'params' => $params]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $item = new Item;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->manufacturer = $request->manufacturer;
        $item->quantity = $request->quantity;
        $item->status = 0;
        if(isset($request->show)) {
            $item->status = 10;
        }
        $item->category_id = $request->category_id;
        $item->discount = $request->discount;
        $category = Category::find($request->category_id);
        $item->save();
        foreach ($category->parameters as $parameter) {
            $item->parameters()->attach($parameter,['data'=>$request->input($parameter->id)]);
        }

        if ($request->has('photos')){
            foreach ($request->file('photos') as $photo) {
                $img = Image::make($photo);
                $fileName = Str::random(5).'.jpg';
                $folderBig = public_path('itemPhotos\big');
                $folderSmall = public_path('itemPhotos\small');
                $img->save($folderBig."/".$fileName,80,'jpg'); //skaičiukas rodo kiek procentų kokybės
                $img->resize(200,null,function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($folderSmall."/".$fileName,80,'jpg'); //skaičiukas rodo kiek procentų kokybės
                $photo = new Photo ();
                $photo->name = $fileName;
                $photo->item_id = $item->id;
                $photo->save();
            }
        }

        return redirect()->route('category.map',[$category->id])->with('success_message', 'Sekmingai įrašytas.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item, Request $request)
    {
        $id = ((($request->id/17)-7)/7); //fake id create
        $item = Item::where("id",'=', $id)->get();
        return view('item.show',['item' => $item[0], 'id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item, Category $category)
    {
        return view('item.edit',['item' => $item, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item, Category $category)
    {
        $item->id = $request->item_id;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->quantity = $request->quantity;
        $item->status = 0;
        if(isset($request->show)) {
            $item->status = 10;
        }
        $item->discount = $request->discount;
        $item->save();
        foreach ($item->parameters as $parameter) {
            $iP =  ItemParameter::where("item_id",'=', $item->id)
            ->where("parameter_id",'=', $parameter->id)->first();
            $iP->data = $request->input($parameter->id);
            $iP->save();
        }
        // return redirect()->route('category.index')->with('success_message', 'Sekmingai pakeistas.');

        $category = Category::find($request->category_id);
        return redirect()->route('category.map',[$category->id])->with('success_message', 'Sekmingai įrašytas.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Item $item)
    {
        foreach ($item->parameters as $parameter) {
            $iP =  ItemParameter::where("item_id",'=', $item->id)
            ->where("parameter_id",'=', $parameter->id)->first();
            $iP->data = $request->input($parameter->id);
            $iP->delete();
        }
        $item->delete();
        return redirect()->back()->with('success_message', 'Prekė sėkmingai pašalinta.');;
    }
}
