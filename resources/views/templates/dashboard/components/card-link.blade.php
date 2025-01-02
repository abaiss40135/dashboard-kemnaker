<div class="card block">
    <img
        class="card-img-top w-full"
        src="{{ $imgSrc }}"
        alt="{{ $title }}"
    >
    <div class="card-body">
        <h5 class="card-title font-medium">{{ $title }}</h5>
        <p class="card-text text-gray-600">{{ $desc }}</p>
        <button
            class="btn btn-primary-light inline-block mt-4"
            {!! $action !!}
        >
            {{ $btnText }}
        </button>
    </div>
</div>
