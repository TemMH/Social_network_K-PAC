<button {{ $attributes->merge(['type' => 'submit', 'class' => 'statements_type_btn']) }}>
    {{ $slot }}
</button>
