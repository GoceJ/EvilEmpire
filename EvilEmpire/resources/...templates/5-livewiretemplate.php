<?php

    public function addColumns()
    {
        // columns from DB
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('desc', function (Post $model) {
                // Returns only " n " words if its description or etc
                return Str::words($model->desc, 1); 
            })
            ->addColumn('actions', function(Post $model) {
                // Actions for > edit > delete > show method
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


?>