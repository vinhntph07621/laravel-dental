@component('mail::message')
<h1>Chào {{$mailData['patient_name']}},</h1><br>
<h2>Lịch khám của bạn đã được xác nhận lúc {{ substr($mailData['current_time'], 11)}} ngày {{ Str::limit($mailData['current_time'], 10, null)}}</h2><br>

<strong>Mã lịch hẹn: </strong><h2>#{{$mailData['number_booking']}}</h2> <br>
<strong>Tên khách hàng: </strong>{{$mailData['patient_name']}} <br>
<strong>Thời gian: </strong>{{ substr($mailData['date_time'], 11)}}, ngày {{ Str::limit($mailData['date_time'], 10, null)}}<br>
<strong>Địa chỉ: </strong>Hà Nội <br>
<strong>Dịch vụ: </strong>
@foreach ($mailData['service'] as $services)
    <span>{{$services->name}},</span>
@endforeach

@component('mail::button', ['url' => 'dental-clinic-fpoly.herokuapp.com','color' => 'success'])
Trang chủ
@endcomponent

Cảm ơn,<br>
Dental Fpoly
@endcomponent
