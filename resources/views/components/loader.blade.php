@props(['color' => "#fff", 'width' => '100px', 'height' => '100px', 'margin' => '20px', 'scale' => '1'])
<svg version="1.1" id="L9" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"
     enable-background="new 0 0 0 0" xml:space="preserve" viewbox="0 0 100 100"
     style="width: {{ $width }};
        height: {{ $height }};
        margin: {{ $margin }};
        transform: scale({{ $scale }});
        display: inline-block;">
    <path fill="{{ $color }}"
          d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
        <animateTransform
            attributeName="transform"
            attributeType="XML"
            type="rotate"
            dur="1s"
            from="0 50 50"
            to="360 50 50"
            repeatCount="indefinite"/>
    </path>
</svg>
