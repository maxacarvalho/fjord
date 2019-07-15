<?php

namespace AwStudio\Fjord\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AwStudio\Fjord\Models\Content;

class ContentController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        $update = [];
        foreach(config('translatable.locales') as $locale) {
            $update[$locale] = [
                'data' => collect($request->$locale)->except('data')->toArray()
            ];
        }
        $content->update($update);


        return $content;
    }

    public function store(Request $request)
    {
        $data = [];
        foreach(config('fjord-content.' . $request->type) as $field) {
            $data[$field['id']] = array_key_exists('default', $field)
                ? $field['default']
                : NULL;
        }
        $content = Content::create(
            array_merge(
                $request->all(),
                [
                    'data' => $data,
                    'link' => 'a'
                ]
            )
        );
        $content->save();

        return $content;
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id)->delete();
    }
}