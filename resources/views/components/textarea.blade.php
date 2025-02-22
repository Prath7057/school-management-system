@props(['name', 'id' => null, 'value' => '', 'rows' => 2, 'required' => false])

<textarea id="{{ $id ?? $name }}" 
          name="{{ $name }}" 
          rows="{{ $rows }}"
          {{ $attributes->merge(['class' => 'block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}
          @if($required) required @endif>{{ old($name, $value) }}</textarea>
