<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreateBannersEvent;
use App\Events\DeleteBannersEvent;
use App\Events\UpdateBannersEvent;
use App\Models\Banner;
use App\Service\FileStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;



class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $filesSave;

    public function __construct(FileStorage $filesSave)
    {
        $this->filesSave = $filesSave;
    }

    public function index()
    {
        $banners=Banner::all();
        return view('admin.banners.index', compact( "banners"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if(empty($request->hasFile('file') || $request->input('img'))){
            return redirect()->back()->with('message', 'Необходимо добавить изображение!');
        }
        else if($request->alt === NULL || $request->url === NULL){
            return redirect()->back()->with('message','Необходимо заполнить все поля!');
        }
        $banner=new Banner();
        $banner->fill($request->all());
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $img = $this->filesSave->imageSave($image, 'banners');
            if ($img ===0){
                return redirect()->back()->with('message', 'Неверный формат загружаемого изображения!');
            }else {
                $banner->img = $img;
            }
        }else{
            $banner->img = $request->img;
        }
        $banner->save();
        event(new CreateBannersEvent($banner, $request->user()));
        return redirect('admin/banners');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {

        return view('admin.banners.update', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {

        if ($request->file){
            $image = $request->file('file');
            $img = $this->filesSave->imageSave($image, 'banners');
            if ($img ===0){
                return redirect()->back()->with('message', 'Неверный формат загружаемого изображения!');
            }else {
                Banner::where('id', $banner->id)->update([
                    'img' => $img,
                    'url'=>$request->url,
                    'alt'=>$request->alt,
                    'sort'=>$request->sort
                ]);
            }
        }else{
            Banner::where('id', $banner->id)->update([
                'img' => $request->img,
                'url'=>$request->url,
                'alt'=>$request->alt,
                'sort'=>$request->sort
            ]);
        }
        event(new UpdateBannersEvent($banner, $request->user()));
        return redirect('admin/banners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner_id=$banner->id;
        event(new DeleteBannersEvent($banner_id, Auth::user()));
        Banner::destroy($banner->id);

        return redirect('admin/banners');
    }
}
