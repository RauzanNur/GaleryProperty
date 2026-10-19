@props(['disabled' => false])

{{-- Input nomor WhatsApp: hanya angka. Huruf/simbol langsung terhapus saat diketik atau ditempel;
     server tetap memvalidasi lewat User::phoneRules(). --}}
<input
    type="tel"
    inputmode="numeric"
    pattern="[0-9]*"
    minlength="10"
    maxlength="15"
    autocomplete="tel"
    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm']) }}
>
