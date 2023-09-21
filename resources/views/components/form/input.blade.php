@props(['name', 'label', 'placeholder' => '...', 'type' => 'text'])

<div>
	<label for="">{{ $label }}
		<input type="{{ $type }}" placeholder="{{ $placeholder }}">
	</label>
</div>
