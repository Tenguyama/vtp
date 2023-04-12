<?php

namespace App\Orchid\Screens\Docs;

use App\Http\Requests\DocRequest;
use App\Http\Requests\GroupRequest;
use App\Models\Doc;
use App\Models\Group;
use App\Orchid\Layouts\CreateOrUpdateDoc;
use App\Orchid\Layouts\CreateOrUpdateGroup;
use App\Orchid\Layouts\Docs\DocsTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DocsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'docs' => Doc::filters()->paginate(15),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Документи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Створити документ')->modal('createDoc')->method('createOrUpdateDoc')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            DocsTable::class,
            Layout::modal('createDoc', CreateOrUpdateDoc::class)->title('Створення документу')->applyButton('Створити'),
            Layout::modal('editDoc', CreateOrUpdateDoc::class)->title('Редагування документу')->applyButton('Зберегти')->async('asyncGetDoc'),
            Layout::modal('deleteDoc', Layout::rows([
                Input::make('doc.id')->type('hidden'),
                Input::make('doc.name')->readonly(),
            ]))->title('Видалення документу')->applyButton('Видалити')->async('asyncGetDoc'),
        ];
    }

    public function asyncGetDoc(Doc $doc): array
    {

        $doc->load('file');
        return [
            'doc' => $doc,
        ];
    }

    public function createOrUpdateDoc(DocRequest $request): void
    {
        $docId = $request->input('doc.id');
        Doc::updateOrCreate([
            'id'=> $docId
        ], array_merge($request->validated()['doc'], [
            'file_id' => array_shift($request->validated()['doc']['file_id'])
        ]));


        is_null($docId) ? Toast::info('Документ успішно створений') : Toast::info('Документ успішно відредагований');
    }

    public function deleteDoc(DocRequest $request){
        $docId = $request->input('doc.id');
        $doc = Doc::find($docId);
        $doc->delete();

        Toast::info('Документ успішно видалений');
    }
}
