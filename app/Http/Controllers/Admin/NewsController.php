<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreateNewsEvent;
use App\Events\DeleteNewsEvent;
use App\Events\UpdateNewsEvent;
use App\Models\News;
use App\Models\File;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\FileStorage;

class NewsController extends Controller
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
        $news = News::orderBy('datetime', 'desc')->get();
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.news.form', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * $path
     */
    public function store(Request $request)
    {
//        return new JsonResponse($request);
        $saveIm = json_decode($request->saveImages);
        if (empty($saveIm) == false) {
            $news_id = $saveIm[0]->news_id;
            if (News::find($news_id)) {
                News::where('id', $news_id)->update([
                    'title' => $request->title,
                    'preview' => $request->preview,
                    'text' => $request->text,
                    'autor' => $request->user()->id
                ]);
            }
        } else {
            $news = $this->saveNews($request);
            $news_id = $news->id;
        }
        if ($request->file_img) {
            $image = $request->file('file_img');
            $img = $this->filesSave->imageSave($image, 'news');
            if ($img) {
                News::where('id', $news_id)->update([
                    'img' => $img,
                ]);
            }
        } else {
            News::where('id', $news_id)->update([
                'img' => $request->img,
            ]);
        }
        if ($request->files) {
            $files = json_decode($request->input('files'));
            $this->saveFiles($files, $news_id);
        }
        return new JsonResponse($news_id);

    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $users=User::all();
        $files=File::where('news_id', $news->id)->get();
        return view('admin.news.form', compact(['news', 'files']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        News::where( 'id', $news->id)->update([
            'title'=>$request->title,
            'preview'=>$request->preview,
            'text'=>$request->text,
            'autor'=>$request->user()->id
        ]);
        if ($request->file_img) {
            $image = $request->file('file_img');
            $img = $this->filesSave->imageSave($image, 'news');
            if ($img) {
                News::where('id', $news->id)->update([
                    'img' => $img,
                ]);
            }
        } else {
            News::where('id', $news->id)->update([
                'img' => $request->img,
            ]);
        }
        $files = json_decode($request->input('files'));
        $this->saveFiles($files, $news->id);

        event(new UpdateNewsEvent($news, $request->user()));
        return new JsonResponse($news->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news_id = $news->id;
        event(new DeleteNewsEvent($news_id, Auth::user()));
        File::where('news_id', $news->id)->delete();
        News::destroy($news->id);
        return redirect('admin/news');
    }

    public function deleteFile($id){
        $del_id=$id;
        File::destroy($id);
        return new JsonResponse($del_id);
    }

    public function addImg(Request $request){
        $news = $this->saveNews($request);
        if ($request->add_img) {
            $image = $request->file('add_img');
            $img = $this->filesSave->imageSave($image, 'news');
            if ($img){
                $file = new File();
                $file->news_id= $news->id;
                $file->type = 'image';
                $file->link = $img;
                $file->alt = $request->add_img->getClientOriginalName();
                $file->save();
                $res = [
                    'news_id'=> $news->id,
                    'file_id'=>$file->id,
                    'file_name'=>$file->alt,
                ];
                return new JsonResponse($res);
            }
        }
    }
    public function saveFiles($files,  $news_id){
        foreach ($files as  $item) {
            if (is_null($item) or File::where('link', $item->link)->where('news_id', $news_id)->first() !== null) {
                continue;
            } else {
                $file = new File();
                $file->news_id = $news_id;
                $file->type = $item->type;
                $file->alt = $item->alt;
                $file->link = $item->link;
                $file->save();
            }
        }
    }

    public function saveNews($request){
        if (News::find($request->newsId)){
            return News::find($request->newsId);
        }else{
            $news = new News();
            $news->autor = $request->user()->id;
            $news->title= $request->title;
            $news->datetime=time();
            $news->fill($request->all());
            $news->save();
            event(new CreateNewsEvent($news, $request->user()));
            return $news;
        }

    }

}
