<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://img.icons8.com/nolan/2x/dental-filling.png?fbclid=IwAR2MNQbUwcKUOWTned3ZgwJLPWcs1MddgLcPonnPVhi2iHoUQcCcpuaEPLQ" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
