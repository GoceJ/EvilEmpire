<?php

    // Show your page >>> change folder
    public function index(Post $model)
    {
        return view('pages.folder.index', ['model' => $model->paginate(15)]);
    }

    // View specific item
    public function show($id)
    {
        return view('pages.folder.show', ['model' => Post::where('id', $id)->first()]);
    }

    // View edit specific item
    public function edit($id)
    {
        return view('pages.folder.edit', ['model' => Post::where('id', $id)->first()]);
    }

    // Update that item Also set the proper Request
    // public function update(Request $request, $id)
    public function update(Request $request,  Event $event)
    {
        if (!$event->update($request->validated()))
            return back()->withStatus(__('Edit Failed During The Process.'));

        // Event::where('id', $id )->update($request->except(['_token', '_method']));

        return back()->withStatus(__('Edit has been successfully applied.'));
    }

    // Delete Method >>> dont forget to include the >>> @include('layouts.actions.deleteJS') >>> in your blade index file
    public function destroy(Event $event)
    {
        if (!$event->update($request->validated()))
            return back()->withStatus(__('Delete Failed During The Process.'));

        return back()->withStatus(__('The item has been successfully deleted.'));
        // Post::where('id', $id)->delete();
    }

?>