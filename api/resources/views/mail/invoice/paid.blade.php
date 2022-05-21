@component('mail::message')
# Introduction

DH Bpk/Ibu {{ name }},
Di Tempat

Berikut kami konfirmasikan pembelian anda di toko kami yaitu,

Mobil : {{ car_name }}
Harga : {{ car_price }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
