{{-- Calendar --}}
<div id="calendar" class="border-left border-bottom border-right">
    <div id="menu" style="outline: 2px solid white">
        <span id="menu-navi" class="d-flex flex-nowrap align-items-center justify-content-between p-2">
            <div class="flex flex-nowrap ">
                {{-- Last --}}
                <button type="button" style="background-color: blueviolet" class="btn btn-sm move-day m-2" data-action="move-prev" id="prev">
                    @include('layouts.actions.icon', ['icon' => 'keyboard_arrow_left'])
                </button>

                {{-- Current --}}
                <button type="button" style="background-color: blueviolet" class="btn btn-sm move-today m-2" data-action="move-today" id="today">TODAY</button>

                {{-- Next --}}
                <button type="button" style="background-color: blueviolet" class="btn btn-sm move-day m-2" data-action="move-next" id="next">
                    @include('layouts.actions.icon', ['icon' => 'keyboard_arrow_right'])
                </button>
            </div>
            <span style="color: orange; font-weight: bolder; font-size: 17px;" id="renderRange" class="render-range cursor-default uppercase"></span>
        </span>
    </div>
</div>