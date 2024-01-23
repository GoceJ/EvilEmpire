<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class PostTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    public function setUp(): void
    {
        // $this->showCheckBox()
        //     ->showPerPage()
        //     ->showSearchInput()
        //     ->showExportOption('download', ['excel', 'csv']);
    }

    public function datasource(): ?Builder
    {
        return Post::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns()
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('desc', function (Post $model) {
                return Str::words($model->desc, 1); //Gets the first 'n' words
            })
            ->addColumn('actions', function(Post $model) {
                return view('layouts.actions.action', [
                    'e' => route('post.edit', ['post' => $model->id]),
                    'd' => route('post.destroy', ['post' => $model->id]),
                    'v' => route('post.show', ['post' => $model->id])
                ]);
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->sortable(),

            Column::add()
                ->title('Title')
                ->field('title')
                ->sortable(),

            Column::add()
                ->title('Description')
                ->field('desc'),

            Column::add()
                ->title('Actions')
                ->field('actions')
                
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Post Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    // public function actions(): array
    // {
    //    return [
    //        Button::add('edit')
    //            ->caption('Edit')
    //            ->class('btn btn-warning btn-link')
    //            ->route('post.edit', ['post' => 'id']),

    //        Button::add('destroy')
    //            ->caption('Delete')
    //            ->class('btn btn-danger btn-link')
    //            ->route('post.destroy', ['post' => 'id'])
    //            ->method('delete')
    //     ];
    // }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Post Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [
           
           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($post) => $post->id === 1)
                ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid Post Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Post::query()
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
    */
}
