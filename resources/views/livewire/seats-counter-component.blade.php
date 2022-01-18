<div class="form-row p-1">
    <label class="c-main mb-2" for="seats_num">عدد المقاعد</label>
    <div class="d-flex" x-data="{ count: 0 }">
        <button wire:click="increment" type="button" class="btn btn-main px-2">+</button>
        <input class="form-control" type="number" style="width: 60px" step="1" name="seats_num"
            value="{{ $count }}" min="1" max="18" required>
        <button wire:click="decrement" type="button" class="btn btn-main px-2">-</button>
    </div>
    @error('seats_num')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
