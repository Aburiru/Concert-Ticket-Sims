<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-white text-text font-poppins font-bold uppercase text-sm rounded-xl border-2 border-border shadow-bento hover:-translate-y-0.5 hover:shadow-bento-hover active:translate-y-[2px] active:shadow-none transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed focus:outline-none focus:ring-4 focus:ring-yellow']) }}>
    {{ $slot }}
</button>
