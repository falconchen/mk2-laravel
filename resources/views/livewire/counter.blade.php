<div class="w-100 flex flex-col  align-center text-center text-2xl">
    <h1 class="h1">{{ $count }}</h1>
    <h2>{{ $timeNow }}</h2>
    @php
        echo now();
    @endphp
    <button wire:click="increment">+</button>

    <button wire:click="decrement">-</button>

    <button wire:click.throttle="$refresh" wire:confirm="Are you sure you want to refresh this post?"> Refresh </button>
</div>
