<div class="tutor-card group bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1.5 hover:scale-[1.01] transition-all duration-300 overflow-hidden h-full flex flex-col justify-between" style="border: 1px solid #f3f4f6;">
    
    {{-- Card Header --}}
    <div class="p-7 pb-4">
        <div class="flex items-start gap-5">
            {{-- Avatar / Photo --}}
            <div class="flex-shrink-0">
                @if(!empty($ht['photo']))
                    <div class="tutor-photo-wrap tutor-photo-wrap-interactive rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden"
                         style="width:118px;height:118px;flex-shrink:0;background:#ffffff;">
                        <img src="{{ asset($ht['photo']) }}"
                             alt="{{ $ht['name'] }}"
                             class="{{ !empty($ht['sharpen']) ? 'img-sharpen' : '' }} transition-transform duration-500 group-hover:scale-110"
                             style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block;">
                    </div>
                @else
                    <div class="rounded-2xl flex items-center justify-center text-white font-black shadow-lg"
                         style="width:118px;height:118px;font-size:2rem;background-color:{{ $ht['bg'] }};">
                        {{ $ht['initials'] }}
                    </div>
                @endif
            </div>
            {{-- Name & Qualification --}}
            <div class="flex-1 min-w-0 pt-1">
                <h3 class="text-[20px] font-black text-gray-900 leading-tight mb-1.5 text-interactive-hover">{{ $ht['name'] }}</h3>
                <p class="text-[11px] text-blue-600 font-bold leading-snug mb-3 text-interactive-hover">{{ $ht['qualification'] }}</p>
                <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full badge-interactive-hover"
                      style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;">
                    <i class="fas fa-star text-[9px]"></i> {{ $ht['experience'] }}+ Yrs Exp
                </span>
            </div>
        </div>
    </div>

    {{-- Subject Tags --}}
    <div class="px-7 pb-4 flex flex-wrap gap-2">
        @foreach($ht['subject_tags'] as $tag)
        <span class="subject-tag-interactive text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider"
              style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
            {{ $tag }}
        </span>
        @endforeach
    </div>

    {{-- Spacer: pushes bottom section to a consistent position --}}
    <div class="flex-1"></div>

    {{-- Reviews & Stars --}}
    <div class="px-7 py-3.5">
        <div class="flex items-center gap-2">
            <div class="flex text-yellow-400 gap-0.5">
                @php
                    $rVal = $ht['rating'] ?? 4.7;
                    $fullStars = floor($rVal);
                    $hasHalf = ($rVal - $fullStars) >= 0.3;
                @endphp
                @for($j = 1; $j <= 5; $j++)
                    @if($j <= $fullStars)
                        <i class="fas fa-star text-[11px]"></i>
                    @elseif($j == $fullStars + 1 && $hasHalf)
                        <i class="fas fa-star-half-alt text-[11px]"></i>
                    @else
                        <i class="far fa-star text-[11px] text-gray-300"></i>
                    @endif
                @endfor
            </div>
            <span class="text-sm font-black text-gray-900 ml-1">{{ $ht['rating'] ?? 4.7 }}</span>
            <span class="text-xs text-gray-400 font-semibold">({{ isset($ht['review_count']) && $ht['review_count'] > 0 ? $ht['review_count'] : ((($ht['id'] * 7 + 13) % 20) + 15) }} reviews)</span>
        </div>
    </div>

    {{-- Divider --}}
    <div class="mx-7 border-t border-gray-100"></div>

    {{-- Action Buttons --}}
    <div class="px-7 pb-6 pt-3 flex flex-col gap-2.5">
        <a href="https://wa.me/923414133395?text=Hi%2C%20I%20am%20interested%20in%20{{ urlencode($ht['name']) }}"
           target="_blank"
           class="w-full text-center text-[10px] font-black uppercase tracking-widest py-3.5 rounded-xl transition-all hover:bg-blue-700 hover:shadow-lg duration-300 button-interactive-hover"
           style="background:#2563EB;color:#fff;">
            Book Session
        </a>
        <button onclick="openTutorModal({{ $ht['id'] }})"
                class="view-more-btn w-full text-center text-[10px] font-black uppercase tracking-widest py-3.5 rounded-xl transition-all hover:bg-orange-500 hover:text-white hover:border-orange-500 duration-300 button-interactive-hover flex items-center justify-center gap-1.5 cursor-pointer"
                style="background:#fff7ed;color:#ea580c;border:2px solid #ea580c;">
            <i class="fas fa-eye text-[9px]"></i> View More About {{ $ht['name'] }}
        </button>
    </div>

</div>
