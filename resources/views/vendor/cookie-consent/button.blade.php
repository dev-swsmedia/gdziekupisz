<form action="{!! $url !!}" {!! $attributes !!}>
    @csrf
    <button type="submit" class="{!! $basename !!}__link">
        <span class="{!! $basename !!}__label" style="color: white !important;">{!! $label !!}</span>
    </button>
</form>
