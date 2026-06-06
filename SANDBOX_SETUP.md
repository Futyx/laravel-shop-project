# Zarinpal Sandbox Setup Guide

## Enable Sandbox Mode

To enable Zarinpal sandbox mode for testing, add these to your `.env` file:

```env
ZARINPAL_SANDBOX=true
ZARINPAL_MERCHANT_ID=your_test_merchant_id
ZARINPAL_SANDBOX_MERCHANT_ID=your_sandbox_merchant_id  # Optional, uses ZARINPAL_MERCHANT_ID if not set
ZARINPAL_CALLBACK_URL=http://127.0.0.1:8000/payment/callback
```

## Important Notes

1. **Boolean Value**: The `ZARINPAL_SANDBOX` must be set to `true` (string) in `.env`, not `1` or `yes`
2. **Merchant ID**: For sandbox testing, you can use any test merchant ID from Zarinpal sandbox panel
3. **Callback URL**: Make sure the callback URL is accessible and matches your local/production environment
4. **Clear Config Cache**: After changing `.env`, run:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

## Testing

1. Set `ZARINPAL_SANDBOX=true` in `.env`
2. Clear config cache
3. Make a test payment
4. The system will use sandbox endpoints automatically

## Disable Sandbox

To switch back to production mode:
```env
ZARINPAL_SANDBOX=false
```

Then clear config cache again.


