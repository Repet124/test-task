@props(['name', 'label', 'placeholder' => '...', 'type' => 'text'])

<div>
	<label for="">{{ $label }}
		<input name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}">
	</label>
</div>
