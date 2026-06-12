@php($ca = random_int(2, 9))
@php($cb = random_int(2, 9))
<div class="captcha-field">
  <label>Security check — what is <b>{{ $ca }} + {{ $cb }}</b>? <span class="req">*</span></label>
  <input type="number" name="captcha" inputmode="numeric" min="0" step="1" placeholder="Type your answer" required autocomplete="off" class="@error('captcha') invalid @enderror">
  <input type="hidden" name="captcha_token" value="{{ encrypt($ca + $cb) }}">
  @error('captcha')<span class="field-err">{{ $message }}</span>@enderror
</div>
