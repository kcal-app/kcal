<form class="" method="POST" action="{{ route('journal-entries.store') }}">
    @csrf
    <input type="hidden" name="ingredients[date][0]" id="date" value="{{ now()->format('Y-m-d') }}">
    <input type="hidden" name="ingredients[amount][0]" value="1">
    <input type="hidden" name="ingredients[id][0]" value="{{ $journalable->getKey() }}">
    <input type="hidden" name="ingredients[type][0]" value="{{$journalable::class}}">
    <input type="hidden" name="ingredients[unit][0]" value="serving">
    <x-inputs.select class="px-4 py-1" name="ingredients[meal][0]"
                     :options="Auth::user()->meals_enabled->toArray()"
                     :selectedValue="old('meal')"
                     :hasError="$errors->has('meal')"
                     required>
        <option value=""></option>
    </x-inputs.select>
    <button class="px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-center uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150 cursor-pointer text-white bg-green-800 hover:bg-green-700 active:bg-green-900 focus:border-green-900 ring-green-300" type="submit">
        Log
    </button>
</form>
