<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $fields = [
        'tag' => '',
        'title' => '',
        'subtitle' => '',
        'meta_description' => '',
        'page_image' => '',
        'layout' => 'blog.layouts.index',
        'sort' => 0,
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tag.index')->withTags($tags);
    }

    /**
     * 显示创建表单
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $filedKey => $value) {
            $data[$filedKey] = old($filedKey, $value);
        }

        return view('admin.tag.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {

        $tag = new Tag();
        foreach (array_keys($this->fields) as $key) {
            $tag->$key = $request->get($key);
        }
        $tag->save();

        return redirect('/admin/tag')->with('success', '标签');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        // dd($tag);
        $data = ['id' => $tag->id];
        foreach (array_keys($this->fields) as $key) {
            $data[$key] = old($key, $tag->$key);
        }

        // $tag->save();

        return view('admin.tag.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, $id)
    {
        //
        $tag = Tag::findOrFail($id);
        unset($this->fields['tag']);
        foreach (array_keys($this->fields) as $key) {
            $tag->$key = $request->get($key);
        }

        $tag->save();
        return redirect("/admin/tag/$id/edit")->with('success', '修改已保存.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect("/admin/tag")->with('success','「' . $tag->tag . '」标签删除成功');
    }
}
