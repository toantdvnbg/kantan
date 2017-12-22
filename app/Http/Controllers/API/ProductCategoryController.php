<?php

namespace App\Http\Controllers\API;

use App\Entities\ProductCategory;
use App\Http\Controllers\Controller;
use App\Repositories\ProductCategoryRepositoryEloquent;
use Feeds;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $product_category;
    public function __construct(ProductCategoryRepositoryEloquent $product_category)
    {
        $this->product_category = $product_category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_category = $this->product_category->orderBy('ord', 'asc')->findWhere(["parent_id" => 0])->all();
        return response()->json(['status'=>true,'message'=>'Success','data'=>$product_category]);
    }


    public function getSubCategory($id)
    {
        $subCategory = $this->product_category->orderBy('ord', 'asc')->findWhere(["parent_id" => $id])->all();
        return response()->json(['status'=>true,'message'=>'Success','data'=>$subCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->product_category->create($request->only(['title', 'ord', 'parent_id', 'status', 'publish']));
        return response()->json(['status'=>true,'message'=>'Success','data'=>array('message' => 'Success' )]);
    }





























    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rss.create', ['games' => $this->game->pluck('title', 'id')]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = (array) DB::table('news')->pluck('url');
        foreach ($news as $new) {
            $list_news = $new;
        }
        $rss = $this->rss->find($id);
        $feed = Feeds::make($rss->url);
        $items = $feed->get_items();
        foreach ($items as $key => $item) {
            if (in_array($item->get_link(), $list_news)) {//đã có trong database
                unset($items[$key]);
            } else {
                $item->thumbnail = $item->get_thumbnail();
                if (is_null($item->get_thumbnail())) {
                    preg_match('@src="([^"]+)"@', $item->get_content(), $match);
                    $thumbnail = array_pop($match);
                    $thumbnail = str_replace_first('src="', '', $thumbnail);
                    $item->thumbnail = str_replace_last('"', '', $thumbnail);
                };
            }
        }
        return view('admin.rss.show', ['items' => $items, 'rss' => $rss]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.rss.edit', ['rss' => $this->rss->find($id), 'games' => $this->game->pluck('title', 'id')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminStoreNews $request, $id)
    {
        $this->rss->update($request->only(['game_id', 'title', 'url', 'keyword', 'status']), $id);
        return redirect()->route('admin.rss.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->rss->delete($id);
        return redirect()->route('admin.rss.index');
    }
}
