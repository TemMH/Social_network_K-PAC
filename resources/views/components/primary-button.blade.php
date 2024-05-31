<button {{ $attributes->merge(['type' => 'submit', 'class' => 'long_button']) }}>
    {{ $slot }}
</button>
