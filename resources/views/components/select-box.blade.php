<div class="form-group">
    <label class="font-weight-bold {{ $extraLabelClass }}">{{ $placeholder }}</label>
    <select class="js-example-basic-single w-100 {{ $extraClass }}" data-width="100%" name="{{ $name }}" data-endpoint="{{ $endpoint }}" data-field1-id="{{ $field1 }}" data-field2-id="{{ $field2 }}">
        <option value="">Select {{ $removeTextSelection ? "" : $placeholder }}</option>
        @if(!empty($values))
            @foreach($values as $key => $data)
                <option value="{{ $key }}" {{ ($key == $value) ? 'selected' : '' }}>{{ $data }}</option>
            @endforeach
        @endif
        @if(!empty($value) && (strpos($extraClass, 'ajax-endpoint') !== false))
            <option value="{{ $value }}" selected>{{ $optionText }}</option>
        @endif
    </select>
    @error($name)
        <div class="text text-danger">{{ $message }}</div>
    @enderror
</div>
