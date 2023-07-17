<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center uppercase tracking-widest']) }}>
    {{ $slot }}
</button>
