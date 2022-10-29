<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
<img src="{{url('/images/myimage.jpg')}}" class="logo" alt="Cultibot Logo">
@endif
</a>
</td>
</tr>
