<!-- Button trigger modal -->
<button type="button" id="toggle-modal-create" class="btn btn-primary" data-toggle="modal" data-target="#modal-create" hidden>
    Create modal button hidden
</button>

<!-- Modal -->
<div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{-- header --}}
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Event</h5>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" onclick="getAllEvents()">
                    @include('layouts.actions.icon', ['icon' => 'close'])
                </button>
            </div>

            {{-- inputs --}}
            <div class="modal-body">
                <form method="POST" class="w-full max-w-lg" id="createEventForm">
                    @csrf
                    <div class="flex flex-wrap">
                        {{-- Input Title --}}
                        <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Event Name') }}</label>
                            <div class="col-sm-10">
                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <input class="create-event-modal-input form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('Title') }}" required="true" aria-required="true"/>
                                    <span id="title_error" class="error text-danger"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Input URL --}}
                        <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Url') }}</label>
                            <div class="col-sm-10">
                                <div class="form-group{{ $errors->has('url') ? ' has-danger' : '' }}">
                                    <input class="create-event-modal-input form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" id="input-url" type="text" placeholder="{{ __('Url') }}" required="true" aria-required="true"/>
                                    <span id="url_error" class="error text-danger"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Input Select Event --}}
                        <div class="row">
                            <label class="col-sm-6 col-form-label">{{ __('What type of event is?') }}</label>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('url') ? ' has-danger' : '' }}">
                                    <select name="event_type_id" class="form-control">
                                        <option value="" class="form-control" selected hidden>Event type</option>
                                        @foreach ($eventTypes as $eventType)
                                            <option class="p-1 form-control" value="{{ $eventType->id }}">{{ $eventType->type }}</option>
                                        @endforeach
                                    </select>
                                    <span id="event_type_id_error" class="error text-danger"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Input Start Date --}}
                        <div class="row">
                            <label class="col-sm-6 col-form-label">{{ __('Start Date') }}</label>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                    <input class="create-event-modal-input form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="start_date" id="startDate" type="datetime-local" required="true" aria-required="true"/>
                                    <span id="start_date_error" class="error text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            {{-- submit - footer --}}
            <div class="modal-footer" style="justify-content: center !important;">
                        <button id="createSubmitButton" type="submit" class="btn btn-primary">Create Event</button>
                </form>
                    {{-- Cancel Button --}}
                    <button id="createCancelButton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="getAllEvents()">Cancel</button>
            </div>
        </div>
    </div>
</div>

