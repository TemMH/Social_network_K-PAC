<button {{ $attributes->merge(['type' => 'button', 'class' => 'long_button']) }}>
    {{ $slot }}
</button>
