@php
    $id = $getId();
    $statePath = $getStatePath();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$id"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$statePath"
>
    <div
        x-data="{ 
            state: $wire.entangle('{{ $statePath }}'),
            rating: 0,
            hoverRating: 0,
            ratings: Array.from({length: {{ $getMaxRating() }}}, (_, i) => i + 1),
            rate(rating) {
                this.rating = rating;
                this.state = rating;
            },
            clearRating() {
                this.rating = 0;
                this.state = null;
            }
        }"
        class="flex items-center"
    >
        <template x-for="rating in ratings">
            <button 
                type="button"
                @click="rate(rating)"
                @mouseover="hoverRating = rating"
                @mouseleave="hoverRating = 0"
                :aria-label="`Rate ${rating} stars out of {{ $getMaxRating() }}`"
                class="focus:outline-none"
                :disabled="@json($isDisabled)"
            >
                <svg class="w-8 h-8 transition-colors duration-200 ease-in-out" 
                    :class="{
                        'text-yellow-400': rating <= (state || hoverRating),
                        'text-gray-300': rating > (state || hoverRating)
                    }"
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    fill="currentColor"
                >
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                </svg>
            </button>
        </template>
        <button 
            x-show="state !== null && !@json($isDisabled)"
            @click="clearRating"
            class="ml-2 text-sm text-gray-500 hover:text-gray-700 focus:outline-none"
        >
            Clear
        </button>
    </div>
</x-dynamic-component>