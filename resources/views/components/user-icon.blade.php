@php
    $user_icon = null;
    if ($user->hasMedia() && $user->getFirstMedia()->hasGeneratedConversion('icon')) {
        $user_icon = $user->getFirstMediaUrl('default', 'icon');
    }
@endphp

@empty($user_icon)
    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </svg>
@else
    <img {{ $attributes->merge([
      'src' => $user_icon,
      'class' => 'rounded-full h-10 w-10 flex items-center justify-center'
      ]) }} />
@endempty
