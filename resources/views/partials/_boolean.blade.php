<div>
    <label>
        <input type="radio" name="value" value="0" checked/>
        Off
    </label>
</div>
<div>
    <label>
        <input type="radio" name="value" value="1" {{ $setting['value'] ? "checked" : "" }}/>
        On
    </label>
</div>
