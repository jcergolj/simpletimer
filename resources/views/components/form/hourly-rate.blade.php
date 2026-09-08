<div class="grid grid-cols-2 gap-3 w-full">
    <div>
        <input
            type="number"
             id="hourly_rate_amount"
            name="hourly_rate[amount]"
            value="{{ $amount }}"
            placeholder="0.00"
            class="input-field @error('hourly_rate.amount') border-red-500 @enderror"
            style="width: 100%; font-size: 15px;"
             step="any"
             min="0"
             max="100000000"
             aria-label="{{ __('Hourly rate amount') }}"
            {{ $attributes->merge(['class' => '']) }}
        />
    </div>
    <select
        name="hourly_rate[currency]"
        aria-label="{{ __('Hourly rate currency') }}"
        class="input-field @error('hourly_rate.currency') border-red-500 @enderror"
        style="width: 100%; font-size: 15px;"
    >
        @foreach($currencyOptions() as $code => $display)
            <option value="{{ $code }}" {{ $currency === $code ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>
</div>
