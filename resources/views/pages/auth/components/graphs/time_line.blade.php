@php
if($value > $end) {
    $total = $end;
} else {
    $total = $value;
}

$percent = ($total / $end) * 100;
@endphp

<div class="flex">
    <div class="flex">
        <div class="mr-2 -mt-1 text-gray-600 text-sm">0</div>
    </div>
    <div class="flex-1 relative">
        <div class="w-full h-2 bg-green-500" style="background-image: linear-gradient(to right, #38b1ab, #ecc94b, #f56565);"></div>
        <div class="absolute" style="margin-left: {{$percent}}%;">
            <div class="text-gray-600 text-2xl -ml-3 -mt-1 mdi mdi-arrow-up-bold"><span class="text-gray-700 text-sm">{{$value}}</span></div>
        </div>
    </div>
    <div class="flex">
        <div class="ml-2 -mt-1 text-gray-600 text-sm">{{$end}}</div>
    </div>
</div>