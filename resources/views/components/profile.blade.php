<div class="row" style="color: black;">
    <div style="display: inline-block" class="ml-3">
        <img src="{{ asset('/images/'.$resource->p_image) }}"
            alt="Photo Profile" class="rounded-circle"
            width="50px" height="50px">
    </div>
    <div style="line-height: 1.3" class="col-8">
        <p style="font-size: 18px; padding: 0;">
            {{ $resource->name }}
        </p>
        <p style="font-size: 80%; padding: 0;color:#6c757d">
            {{ $resource->p_username }}
        </p>
    </div>
</div>