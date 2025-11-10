<div {{ $attributes(['class' => 'border border-gray-200 p-6 rounded-xl']) }}>
<main class="max-w-6xl mx-auto mt-10 lg:mt-20 space-y-6">
<article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10">
<section class="col-span-8 col-start-5 mt-10 space-y-6 shadow p-5 rounded">
    {{ $slot }}
</section>
</article>
</main>
</div>
