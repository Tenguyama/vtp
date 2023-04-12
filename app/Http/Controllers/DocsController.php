<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function index(){
        $docs = Doc::join('attachments','attachments.id','=','docs.file_id')
            ->select('docs.name as docs_name',
                'attachments.name as attachments_name',
                'attachments.extension as attachments_extension',
                'attachments.path as attachments_path',
                'attachments.disk as attachments_disk')
            ->get();

        $links = [];

        foreach ($docs as $doc) {
            $link = '/storage/' . $doc->attachments_disk . '/' . $doc->attachments_path . $doc->attachments_name . '.' . $doc->attachments_extension;
            $file_name = $doc->docs_name . '.' . $doc->attachments_extension;
            $links[] = ['docs_name' => $doc->docs_name, 'link' => $link, 'file_name'=>$file_name];
        }
        //dd($links);
        $index = 1;
        return  view('app.docs', compact('links', 'index'));
    }
}
