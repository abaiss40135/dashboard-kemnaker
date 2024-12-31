<div class="box pull-up">
    <div class="box-body py-12 cursor-pointer" {!! $attrs !!}>
        <div class="flex justify-between items-center h-full gap-x-4">
            <div class="bs-5 ps-10 border-secondary h-full">
                <h2 class="my-0 fw-700 text-2xl text-dark">{{ $title }}</h2>
            </div>
            <div class="icon ">
                <i class="fa-solid {{ $icon }} {{ $bg }} me-0 fs-32 rounded-3"></i>
            </div>
        </div>
    </div>
</div>