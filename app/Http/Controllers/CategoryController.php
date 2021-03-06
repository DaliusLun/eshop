<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Item;
use App\Models\CategoryParameter;

class CategoryController extends Controller
{
    public function __construct()
    {
        session_start();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('category_id')->get();
        $chain = [];
        $chain[] = $categories;
        $_SESSION['chain'] = [];
        
        return view('category.index',['categories'=> $categories,'chain'=>$_SESSION['chain']]);
    }

    public function favorites()
    {
        $items = [];
        foreach ($_SESSION['heart'] as $favorite) {
            $items[] = Item::where('id', '=', $favorite)->get()->first();
        }
        return view('category.favorites',['items'=> $items]);
    }
        public function basket()
    {
        $items = [];
        $uniqueID = [];
        $uniqueItems = [];

        if(isset($_SESSION['basket'])){
            sort($_SESSION['basket']);
            foreach ($_SESSION['basket'] as $basket) {
                $items[] = Item::where('id', '=', $basket)->get()->first();
                if ( ! in_array($basket, $uniqueID)) {
                    $uniqueID[] = $basket;
                    $uniqueItems[] = Item::where('id', '=', $basket)->get()->first();
                }
            }
        }
        return view('category.basket',['items'=> $items,'uniqueItems'=> $uniqueItems]);
    }

    public function updateBasket()
    {
        $validator = [];
        $quantity = [];
        foreach ($_POST as $key => $value) {
            if(str_contains($key, 'quantity')) {
                $quantity[$key] = $value;
            }
        }
        $qu = array_keys($quantity);
        for ($i=0; $i < count($qu); $i++) { 
            $id = str_replace("quantity","",$qu[$i]);
            $item = Item::where('id', '=', $id)->get()->first();
            if($item->quantity < $quantity[$qu[$i]]) {
                $validator[] = "Vir??ytas prek??s ".$item->name." likutis. Likutis sand??lyje: ".$item->quantity;
            } else {
                $_SESSION['basket'] = \array_diff($_SESSION['basket'], [$id]);
                for ($a=0; $a < $_POST['quantity'.$id]; $a++) { 
                    $_SESSION['basket'][] = $id;
                }
            }
        }
        if($validator !== []){
            return redirect()->back()->withErrors([$validator]);
        } else {
            return redirect()->back()->with('success_message', 'Krep??elis atnaujintas.');
        }
    }



    // public function updateBasket()
    // {
    //     $validator = [];
    //     $quantity = [];
    //     foreach ($_POST as $key => $value) {
    //         if(str_contains($key, 'quantity')) {
    //             $quantity[$key] = $value;
    //         }
    //     }
    //     $qu = array_keys($quantity);
    //     for ($i=0; $i < count($quantity); $i++) { 
    //         $id = str_replace("quantity","",$qu[$i]);
    //         $item = Item::where('id', '=', $id)->get()->first();
    //         if($item->quantity < $quantity[$qu[$i]]) {
    //             $validator[] = "Vir??ytas prek??s ".$item->name." likutis. ";
    //         }
    //     }

    //     if($validator !== []){
    //         return redirect()->back()->withErrors([$validator,"Krep??elio atnaujinimas nutrauktas"]);
    //     }

    //     unset($_SESSION['basket']);
    //     foreach($_POST as $key => $quantity) {
    //         if (strpos($key, 'quantity') === 0) {
    //             $id = str_replace('quantity',"",$key);
    //             for ($i=0; $i < $quantity; $i++) { 
    //                 $_SESSION['basket'][] = $id;
    //             }
    //         }
    //     }
        
    //     $items = [];
    //     $uniqueID = [];
    //     $uniqueItems = [];
    //     if(isset($_SESSION['basket'])){
    //         foreach ($_SESSION['basket'] as $basket) {
    //             $items[] = Item::where('id', '=', $basket)->get()->first();
    //             if ( ! in_array($basket, $uniqueID)) {
    //                 $uniqueID[] = $basket;
    //                 $uniqueItems[] = Item::where('id', '=', $basket)->get()->first();
    //             }
    //         }
    //     }

    //     return redirect()->back()->with('success_message', 'Krep??elis atnaujintas.');;
    // }

    public function map(Category $category)
    {
        $_SESSION['chain'][] = $category;
        $tmpSs= [];
        foreach($_SESSION['chain'] as $ssCat) {
            $tmpSs[] = $ssCat;
                if($ssCat->id == $category->id) {
                    break;
            }
        }
        $_SESSION['chain'] = $tmpSs;
        $categories = Category::where('category_id','=',$category->id)->get();
        // $items = Item::where('category_id', '=', $category->id)->where('status', '=', 10)->get();
        $items = Item::where('category_id', '=', $category->id)->orderBy("status", "desc")->get();
 
        return view('category.index',['categories'=> $categories,'items'=> $items,'chain'=>$_SESSION['chain']]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($categoryId)
    {
        $parameters = Parameter::all();
        return view('category.create',['categoryId'=> $categoryId, 'parameters'=> $parameters]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        if($request->category_id != 0) {
            $category->category_id = $request->category_id;
        }
        $category->save();

        if ($request->filled('parameters')) {
            foreach ($request->parameters as $parameter) {
                $category->parameters()->attach($parameter);
            }
        }

        if ($request->category_id =="0") {
            return redirect()->route('category.index')->with('success_message', 'Kategorija s??kmingai ??ra??yta.');
        } else {
            return redirect()->route('category.map',$request->category_id)->with('success_message', 'Kategorija s??kmingai ??ra??yta.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parameters = Parameter::all();
        $categories = Category::where('id', '!=', $category->id)->get();
        $categoryParameters = CategoryParameter::where('category_id', '=', $category->id)->get();
        $ctParams = [];

        foreach ($categoryParameters as $ctParam) {
            $ctParams[] = $ctParam->parameter_id;
        }

        return view('category.edit',['category'=> $category, 'parameters'=> $parameters, 'categories'=> $categories, 'ctParams'=> $ctParams]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        // dd($request);
        $category->category_id = $request->category_id;
        $category->save();
        foreach ($category->parameters as $parameter) {
            $iP =  CategoryParameter::where('category_id', '=', $category->id)
            ->where("parameter_id",'=', $parameter->id)->first();
            // $iP->data = $request->input($parameter->id);
            $iP->delete();
        }
        if ($request->filled('parameters')) {
            foreach ($request->parameters as $parameter) {
                $category->parameters()->attach($parameter);
            }
        }

        if($request->category_id == null) {
            return redirect()->route('category.index')->with('success_message', 'Kategorija s??kmingai atnaujinta.');
        }
        else {
            return redirect()->route('category.map',$request->category_id)->with('success_message', 'Kategorija s??kmingai atnaujinta.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $items = Item::where('category_id', '=', $category->id)->get();
        if (count($items)>0) {
            return redirect()->back()->withErrors("Pa??alinti negalima, nes kategorijoje yra preki??.");
        }

        CategoryParameter::where('category_id', '=', $category->id)->delete();

        // $categoryParameters = CategoryParameter::where('category_id', '=', $category->id)->get();

        // foreach ($category->parameters as $parameter) {
        //     $iP =  CategoryParameter::where('category_id', '=', $category->id)
        //     ->where("parameter_id",'=', $parameter->id)->first();
        //     $iP->delete();
        // }

        $category->delete();
        return redirect()->back()->with('success_message', 'Kategorija s??kmingai pa??alinta.');
    }
}
